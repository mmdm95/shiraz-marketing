<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HForm\Form;
use Home\AbstractController\AbstractController;
use HPayment\Payment;
use HPayment\PaymentClasses\PaymentZarinPal;
use HPayment\PaymentException;
use HPayment\PaymentFactory;
use HSMS\rohamSMS;
use HSMS\SMSException;

include_once 'AbstractController.class.php';

class UserController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if (!is_ajax()) {
            $this->_checker();

            // Extra js
            $this->data['js'][] = $this->asset->script('be/js/admin.user.main.js');
        }
    }

    public function dashboardAction()
    {
        $this->data['todayDate'] = jDateTime::date('l d F Y') . ' - ' . date('d F');

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'داشبورد');

        $this->_render_page('pages/fe/User/dashboard');
    }

    public function editUserAction()
    {
        $model = new Model();
        $userModel = new UserModel();

        if (!$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $this->data['identity']->id])) {
            $this->error->show_404();
        }

        $this->data['uTrueValues'] = $model->select_it(null, self::TBL_USER, ['mobile', 'image'], 'id=:id', ['id' => $this->data['identity']->id])[0];
        $this->data['marketers'] = $userModel->getUsers('r.id=:role', ['role' => AUTH_ROLE_MARKETER]);
        $this->data['provinces'] = $model->select_it(null, self::TBL_PROVINCE, ['id', 'name']);

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userEditUser');
        $form->setFieldsName([
            'image', 'mobile', 'subset_of', 'first_name', 'last_name', 'father_name', 'n_code',
            'birth_certificate_code', 'birth_certificate_code_place', 'birth_date', 'province',
            'city', 'address', 'postal_code', 'credit_card_number', 'gender', 'military_status',
            'question1', 'question2', 'question3', 'question4', 'question5', 'question6', 'question7', 'description'
        ])->setMethod('post', ['image' => 'file'], ['image']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['mobile', 'subset_of'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->validatePersianMobile('mobile')
                    ->validatePersianName('first_name', 'نام باید از حروف فارسی باشند.')
                    ->validatePersianName('last_name', 'نام خانوادگی باید از حروف فارسی باشند.');

                if (convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile'] &&
                    $model->is_exist(self::TBL_USER, 'mobile=:mob', ['mob' => $values['mobile']])) {
                    $form->setError('کاربر با این نام کاربری (موبایل) وجود دارد!');
                }

                $marketers = array_column($this->data['marketers'], 'id');
                $marketers[] = -1;
                if (!in_array($values['subset_of'], $marketers)) {
                    $form->setError('معرف انتخاب شده نامعتبر است.');
                }

                if (!empty($values['n_code'])) {
                    $form->validateNationalCode('n_code');
                }
                if (!empty($values['birth_date'] && $values['birth_date'] > time())) {
                    $form->validateDate('birth_date', date('Y-m-d', $values['birth_date']), 'تاریخ تولد نامعتبر است.', 'Y-m-d');
                }
                if (!empty($values['province']) && $values['province'] != -1) {
                    if (!in_array($values['province'], array_column($this->data['provinces'], 'id'))) {
                        $form->setError('استان انتخاب شده نامعتبر است.');
                    } else {
                        if (!empty($values['city']) && $values['city'] != -1) {
                            if (!$model->is_exist(self::TBL_CITY, 'id=:id AND province_id=:pId',
                                ['id' => $values['city'], 'pId' => $values['province']])) {
                                $form->setError('شهر انتخاب شده نامعتبر است.');
                            }
                        }
                    }
                }
                if ($values['gender'] != -1 && !in_array($values['gender'], [GENDER_MALE, GENDER_FEMALE])) {
                    $form->setError('جنسیت انتخاب شده نامعتبر است.');
                }
                if ($values['military_status'] != -1 && ($values['gender'] != -1 && $values['gender'] == GENDER_MALE) &&
                    !in_array($values['military_status'], array_keys(MILITARY_STATUS))) {
                    $form->setError('وضعیت سربازی انتخاب شده نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $model->transactionBegin();

                // upload image
                $res4 = true;
                $img = isset($values['image']['name']) && !empty($values['image']['name']) ? $values['image']['name'] : $this->data['uTrueValues']['image'];
                $imageExt = pathinfo($img, PATHINFO_EXTENSION);
                $imageName = convertNumbersToPersian($values['mobile'], true);
                $image = PROFILE_IMAGE_DIR . $imageName . '.' . $imageExt;

                $res2 = true;
                if (convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile']) {
                    $res2 = unlink(realpath($values['image']));
                }
                $this->data['_updatedColumns'] = [
                    'subset_of' => $values['subset_of'],
                    'mobile' => convertNumbersToPersian($values['mobile'], true),
                    'first_name' => $values['first_name'],
                    'last_name' => $values['last_name'],
                    'province' => $values['province'] != -1 ? $model->select_it(null, self::TBL_PROVINCE, ['name'], 'id=:id', ['id' => $values['province']])[0]['name'] : '',
                    'city' => $values['city'] != -1 && $values['province'] != -1 ? $model->select_it(null, self::TBL_CITY, ['name'], 'id=:id AND province_id=:pId', ['id' => $values['city'], 'pId' => $values['province']])[0]['name'] : '',
                    'n_code' => convertNumbersToPersian($values['n_code'], true),
                    'address' => $values['address'],
                    'postal_code' => $values['postal_code'],
                    'image' => $image,
                    'credit_card_number' => $values['credit_card_number'],
                    'father_name' => $values['father_name'],
                    'gender' => $values['gender'] != -1 ? $values['gender'] : '',
                    'military_status' => $values['military_status'] != -1 ? $values['military_status'] : '',
                    'birth_certificate_code' => $values['birth_certificate_code'],
                    'birth_certificate_code_place' => $values['birth_certificate_code_place'],
                    'birth_date' => $values['birth_date'] < time() ? $values['birth_date'] : null,
                    'question1' => $values['question1'],
                    'question2' => $values['question2'],
                    'question3' => $values['question3'],
                    'question4' => $values['question4'],
                    'question5' => $values['question5'],
                    'question6' => $values['question6'],
                    'question7' => $values['question7'],
                    'description' => $values['description'],
                ];
                $res = $model->update_it(self::TBL_USER, $this->data['_updatedColumns'], 'id=:id', ['id' => $this->data['identity']->id]);
                if ((!isset($values['image']['name']) || !empty($values['image']['name'])) && $res &&
                    convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile']) {
                    $res4 = copy($values['image'], $image);
                }

                if ($res && $res2 && $res4) {
                    if (isset($values['image']['name']) && !empty($values['image']['name'])) {
                        $res5 = $this->_uploadUserImage('image', $image, $imageName, $this->data['identity']->id);
                        if ($res5) {
                            $model->transactionComplete();
                        } else {
                            $model->transactionRollback();
                            $form->setError('خطا در انجام عملیات!');
                        }
                    } else {
                        $model->transactionComplete();
                    }
                } else {
                    $model->transactionRollback();
                    $form->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->auth->storeIdentity($this->data['_updatedColumns']);
                $this->data['identity'] = $this->auth->getIdentity();
                unset($this->data['_updatedColumns']);
                $this->data['success'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors'] = $form->getError();
                $this->data['uValues'] = $form->getValues();
            }
        }

        $this->data['uTrueValues'] = $userModel->getSingleUser('u.id=:id', ['id' => $this->data['identity']->id]);
        $this->_isInfoFlagOK($this->data['identity']->id);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش حساب کاربری');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page('pages/fe/User/profile/editUser');
    }

    public function changePasswordAction()
    {
        $model = new Model();

        if (!$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $this->data['identity']->id])) {
            $this->error->show_404();
        }

        $this->data['errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userChangePassword');
        $form->setFieldsName(['password', 're_password'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['password', 're_password'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->isLengthInRange('password', 8, PHP_INT_MAX, 'تعداد کلمه عبور باید حداقل ۸ کاراکتر باشد.')
                    ->validatePassword('password', 2, 'کلمه عبور باید شامل حروف و اعداد باشد.');

                if ($values['password'] != $values['re_password']) {
                    $form->setError('کلمه عبور با تکرار آن مغایرت دارد.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_USER, [
                    'password' => password_hash($values['password'], PASSWORD_DEFAULT),
                ], 'id=:id', ['id' => $this->data['identity']->id]);

                if (!$res) {
                    $form->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['success'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors'] = $form->getError();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'تغییر رمز عبور');

        $this->_render_page('pages/fe/User/Profile/changePassword');
    }

    public function userProfileAction()
    {
        $model = new Model();
        $userModel = new UserModel();

        if (!$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $this->data['identity']->id])) {
            $this->error->show_404();
        }

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userUpgradeUser');
        $form->setFieldsName(['upgrade'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function () use ($model, $form) {
                if ($model->is_exist(self::TBL_USER_ROLE, 'user_id=:uId AND role_id=:rId',
                    ['uId' => $this->data['identity']->id, 'rId' => AUTH_ROLE_MARKETER])) {
                    $form->setError('شما هم اکنون بازاریاب هستید.');
                    return;
                }
                $res = $model->update_it(self::TBL_USER, [
                    'flag_marketer_request' => 1
                ], 'id=:id', ['id' => $this->data['identity']->id]);

                if ($res) {
                    $this->auth->storeIdentity([
                        'flag_marketer_request' => 1,
                    ]);
                    $this->data['identity'] = $this->auth->getIdentity();
                } else {
                    $form->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['success'] = 'درخواست برای بازاریاب شدن با موفقیت ثبت شد.';
            } else {
                $this->data['errors'] = $form->getError();
            }
        }

        $this->data['user'] = $userModel->getSingleUser('u.id=:id', ['id' => $this->data['identity']->id]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده اطلاعات کاربر');

        $this->_render_page('pages/fe/User/profile/userProfile');
    }

    //-----

    public function manageOrdersAction()
    {
        $orderModel = new OrderModel();
        $this->data['orders'] = $orderModel->getOrders('o.user_id=:uId', ['uId' => $this->data['identity']->id]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سفارش‌های من');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/fe/User/manageOrder');
    }

    public function viewOrderAction($param)
    {
        $model = new Model();
        $orderModel = new OrderModel();

        if (!isset($param[0]) || !is_numeric($param[0]) ||
            !$model->is_exist(self::TBL_ORDER, 'id=:id AND user_id=:uId', ['id' => $param[0], 'uId' => $this->data['identity']->id])) {
            $this->error->show_404();
        }

        $this->data['param'] = $param;

        $this->data['order'] = $orderModel->getSingleOrder('o.id=:id', ['id' => $param[0]]);
        $this->data['order']['products'] = $orderModel->getOrderProducts('order_code=:code', ['code' => $this->data['order']['order_code']]);

        // Select gateway table if gateway code is one of the bank payment gateway's code
        foreach ($this->gatewayTables as $table => $codeArr) {
            if (array_search($this->data['order']['method_code'], $codeArr) !== false) {
                $gatewayTable = $table;
                break;
            }
        }
        if (isset($gatewayTable)) {
            $successCode = $this->gatewaySuccessCode[$gatewayTable];
            if ($model->is_exist($gatewayTable, 'order_code=:code AND status=:s',
                ['code' => $this->data['order']['order_code'], 's' => $successCode])) {
                $this->data['order']['payment_info'] = $model->select_it(null, $gatewayTable, ['payment_code'],
                    'order_code=:code AND status=:s', ['code' => $this->data['order']['order_code'], 's' => $successCode],
                    null, 'payment_date DESC');
            } else {
                $this->data['order']['payment_info'] = $model->select_it(null, $gatewayTable, ['payment_code'],
                    'order_code=:code', ['code' => $this->data['order']['order_code']], null, 'payment_date DESC');
            }
            if (count($this->data['order']['payment_info'])) {
                $this->data['order']['payment_info'] = $this->data['order']['payment_info'][0];
            } else {
                unset($this->data['order']['payment_info']);
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سفارش‌های من', 'جزئیات سفارش به کد ' . $this->data['order']['order_code']);

        $this->_render_page('pages/fe/User/viewOrder');
    }

    //-----

    public function returnOrderAction()
    {
        $model = new Model();
        $this->data['orderCodes'] = $model->select_it(null, self::TBL_ORDER, 'order_code',
            'user_id=:uId', ['uId' => $this->data['identity']->id]);

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userReturnOrder');
        $form->setFieldsName(['order_code', 'description'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['description'], 'وارد کردن توضیحات ضروری می‌باشد.');
                if (!in_array($values['order_code'], array_column($this->data['orderCodes'], 'id'))) {
                    $form->setError('کد سفارش انتخاب شده نامعتبر است.');
                    return;
                }
                if ($model->is_exist(self::TBL_RETURN_ORDER, 'order_code=:code', ['code' => $values['order_code']])) {
                    $form->setError('درخواست مرجوعی سفارش قبلا ثبت شده است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_RETURN_ORDER, [
                    'order_code' => $values['order_code'],
                    'description' => $values['description'],
                    'created_at' => time(),
                ]);

                if (!$res) {
                    $form->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['success'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors'] = $form->getError();
                $this->data['roValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مرجوع سفارش');

        $this->_render_page('pages/fe/User/returnOrder');
    }

    public function manageReturnOrderAction()
    {
        $orderModel = new OrderModel();
        $this->data['orders'] = $orderModel->getReturnOrders();

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سفارش‌های مرجوعی');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/fe/User/manageReturnOrder');
    }

    public function viewReturnOrderAction($param)
    {
        $model = new Model();
        $orderModel = new OrderModel();

        if (!isset($param[0]) || is_numeric($param[0]) ||
            !$model->is_exist(self::TBL_RETURN_ORDER, 'order_code=:code', ['code' => $param[0]])) {
            $this->error->show_404();
        }

        $this->data['param'] = $param;

        $this->data['order'] = $orderModel->getSingleReturnOrder('o.user_id=:uId AND ro.order_code=:code', [
            'uId' => $this->data['identity']->id, 'code' => $param[0]]);

        if (!count($this->data['order'])) {
            $this->error->show_404();
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده سفارش‌ مرجوعی');

        $this->_render_page('pages/fe/User/viewReturnOrder');
    }

    //-----

    public function userDepositAction()
    {
        $model = new Model();
        $orderModel = new OrderModel();

        $this->data['deposit_errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_deposit'] = $form->csrfToken('userChargeAccount');
        $form->setFieldsName(['price'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->validate('numeric', 'price', 'قیمت افزایش حساب باید از نوع عدد باشد.')
                    ->isInRange('price', 1000, PHP_INT_MAX, 'قیمت باید عددی بیشتر از ۱۰۰۰ تومان باشد.');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $this->_chargeAccountProcess((int)$values['price']);
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['deposit_success'] = 'حساب شما با موفقیت شارژ شد.';
            } else {
                $this->data['deposit_errors'] = $form->getError();
                $this->data['dValues'] = $form->getValues();
            }
        }

        $this->data['user'] = [];
        $this->data['user']['balance'] = $model->select_it(null, self::TBL_USER_ACCOUNT, 'account_balance',
            'user_id=:id', ['id' => $this->data['identity']->id]);
        $this->data['user']['balance'] = count($this->data['user']['balance']) ? $this->data['user']['balance'][0]['account_balance'] : 0;
        // Calculate account income
        $idPaySum = $model->select_it(null, self::PAYMENT_TABLE_IDPAY, ['SUM(price) AS sum'],
            'user_id=:uId AND exportation_type=:et', ['uId' => $this->data['identity']->id, 'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT])[0]['sum'];
        $mabnaSum = $model->select_it(null, self::PAYMENT_TABLE_MABNA, ['SUM(price) AS sum'],
            'user_id=:uId AND exportation_type=:et', ['uId' => $this->data['identity']->id, 'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT])[0]['sum'];
        $zarinpalSum = $model->select_it(null, self::PAYMENT_TABLE_ZARINPAL, ['SUM(price) AS sum'],
            'user_id=:uId AND exportation_type=:et', ['uId' => $this->data['identity']->id, 'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT])[0]['sum'];
        $this->data['user']['total_income'] = $idPaySum + $mabnaSum + $zarinpalSum;
        // Calculate account outcome
        $this->data['user']['total_outcome'] = $model->select_it(null, self::TBL_USER_ACCOUNT_BUY, ['SUM(price) AS sum'],
            'user_id=:uId', ['uId' => $this->data['identity']->id])[0]['sum'];
        // Deposit transactions
        $this->data['user']['transactions'] = $orderModel->getUserDeposit('ud.user_id=:uId', ['uId' => $this->data['identity']->id]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'کیف پول');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');


        $this->_render_page('pages/fe/User/userDeposit');
    }

    public function depositResultAction()
    {
        $this->load->library('HPayment/vendor/autoload');

        try {
            $model = new Model();
            $idpay = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_IDPAY);
            $postVars = $idpay->handle_request()->get_result();

            // Check for factor first and If factor exists
            if (isset($postVars['order_id']) && isset($postVars['status']) &&
                $model->is_exist(self::PAYMENT_TABLE_IDPAY, 'order_code=:oc', ['oc' => $postVars['order_id']])) {
                // Set order_code to global data
                $this->data['order_code'] = $postVars['order_id'];
                // Select order payment according to gateway id result
                $orderPayment = $model->select_it(null, self::PAYMENT_TABLE_IDPAY, [
                    'payment_id', 'status'
                ], 'order_code=:oc AND payment_id=:pId', ['oc' => $postVars['order_id'], 'pId' => $postVars['id']]);
                // If there is a record in gateway table(only one record is acceptable)
                if (count($orderPayment) == 1) {
                    // Select order payment
                    $orderPayment = $orderPayment[0];
                    // Check for returned amount
                    if ((intval($orderPayment['price']) * 10) == $postVars['amount']) {
                        // If all are ok send advice to bank gateway
                        // This means ready to transfer money to our bank account
                        $advice = $idpay->send_advice([
                            'id' => $postVars['id'],
                            'order_id' => $postVars['order_id']
                        ]);

                        // Check for error
                        if (!isset($advice['error_code'])) {
                            $status = $advice['status'];

                            // Check for status if it's just OK/100 [100 => OK, 101 => Duplicate, etc.]
                            if ($status == Payment::PAYMENT_STATUS_OK_IDPAY) {
                                $model->transactionBegin();
                                // Store extra info from bank's gateway result
                                $res1 = $model->update_it(self::PAYMENT_TABLE_IDPAY, [
                                    'payment_code' => $advice['payment']['track_id'],
                                    'status' => $status,
                                ], 'order_code=:oc', ['oc' => $this->data['order_code']]);
                                $res2 = $model->insert_it(self::TBL_USER_ACCOUNT_DEPOSIT, [
                                    'deposit_code' => $this->data['order_code'],
                                    'user_id' => $this->data['identity']->id,
                                    'deposit_price' => $orderPayment['price'],
                                    'description' => 'شارژ حساب کاربری',
                                    'deposit_type' => DEPOSIT_TYPE_SELF,
                                    'deposit_date' => time(),
                                ]);
                                $res3 = $model->update_it(self::TBL_USER_ACCOUNT, [],
                                    'user_id=:uId', ['uId' => $this->data['identity']->id], [
                                        'account_balance' => 'account_balance+' . (int)$orderPayment['price'],
                                    ]);
                                $success = $idpay->get_message($status, Payment::PAYMENT_STATUS_VERIFY_IDPAY);
                                $traceNumber = $advice['payment']['track_id'];

                                $this->data['ref_id'] = $traceNumber;
                                $this->data['have_ref_id'] = true;

                                if ($res1 && $res2 && $res3) {
                                    $model->transactionComplete();
                                    // Set success parameters
                                    $this->data['success'] = $success;
                                    $this->data['is_success'] = true;

                                    // Send sms to user if is login
                                    if ($this->auth->isLoggedIn()) {
                                        // Send SMS code goes here
                                        $this->load->library('HSMS/rohamSMS');
                                        $sms = new rohamSMS();
                                        try {
                                            $balance = $model->select_it(null, self::TBL_USER_ACCOUNT, 'account_balance',
                                                'user_id=:uId', ['uId' => $this->data['identity']->id])[0]['account_balance'];
                                            $body = $this->setting['sms']['chargeAccountBalanceMsg'];
                                            $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['identity']->mobile, $body);
                                            $body = str_replace(SMS_REPLACEMENT_CHARS['balance'], convertNumbersToPersian(number_format($balance)), $body);
                                            $is_sent = $sms->set_numbers($this->data['identity']->mobile)->body($body)->send();
                                        } catch (SMSException $e) {
                                            die($e->getMessage());
                                        }
                                    }
                                } else {
                                    $model->transactionRollback();
                                    $this->data['error'] = 'عملیات پرداخت انجام شد. خطا در ثبت تراکنش، با پشتیبانی جهت ثبت تراکنش تماس حاصل فرمایید.';
                                    $this->data['is_success'] = false;
                                }
                            }
                        } else {
                            $this->data['error'] = $idpay->get_message($advice['error_code'], Payment::PAYMENT_STATUS_VERIFY_IDPAY);
                            $this->data['is_success'] = false;
                            $this->data['ref_id'] = $postVars['track_id'];
                            $this->data['have_ref_id'] = true;
                        }
                    } else {
                        $this->data['error'] = 'فاکتور نامعتبر است!';
                        $this->data['is_success'] = false;
                        $this->data['ref_id'] = $postVars['track_id'];
                        $this->data['have_ref_id'] = true;
                    }
                } else {
                    $this->data['error'] = 'فاکتور نامعتبر است!';
                    $this->data['is_success'] = false;
                    $this->data['ref_id'] = $postVars['track_id'];
                    $this->data['have_ref_id'] = true;
                }

                // Store current result from bank gateway
                $model->update_it(self::PAYMENT_TABLE_IDPAY, [
                    'status' => isset($status) ? $status : $postVars['status'],
                    'track_id' => $postVars['track_id'],
                    'msg' => isset($status) ? $idpay->get_message($status, Payment::PAYMENT_STATUS_VERIFY_IDPAY) : $idpay->get_message($postVars['status'], Payment::PAYMENT_STATUS_VERIFY_IDPAY),
                    'mask_card_number' => $postVars['card_no'],
                    'payment_date' => time(),
                ], 'order_code=:oc', ['oc' => $this->data['order_code']]);
            } else {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } catch (PaymentException $e) {
            die($e);
        }

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'نتیجه افزایش اعتبار');

        $this->_render_page(['pages/fe/User/pay-result']);
    }

    //-----

    protected function _chargeAccountProcess($price)
    {
        $commonModel = new CommonModel();
        $code = $commonModel->generate_random_unique_code(self::PAYMENT_TABLE_IDPAY, 'order_code',
            'DEP-', 6, 15, 10, CommonModel::DIGITS);
        // Fill parameters variable to pass between gateway connection functions
        $parameters = [
            'price' => $price,
            'order_code' => 'DEP-' . $code,
            'backUrl' => base_url('user/depositResult'),
            'exportation' => FACTOR_EXPORTATION_TYPE_DEPOSIT,
        ];

        // Call one of the [_*_connection] functions
        // Here we call IDPay
        $res = call_user_func_array($this->gatewayFunctions[self::PAYMENT_TABLE_IDPAY], $parameters);
        return $res;
    }

    //-----

    protected function _checker($returnBoolean = false)
    {
        if (!$this->auth->isLoggedIn()) {
            if ((bool)$returnBoolean) return false;
            $this->redirect(base_url('login?back_url=' . URITracker::get_last_uri()));
        }

        return true;
    }

    //-----

    protected function _render_page($pages, $loadHeaderAndFooter = true)
    {
        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/user/admin-header-part', $this->data);
            $this->load->view('templates/fe/user/admin-js-part', $this->data);
        }

        $allPages = is_string($pages) ? [$pages] : (is_array($pages) ? $pages : []);
        foreach ($allPages as $page) {
            $this->load->view($page, $this->data);
        }

        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/user/admin-footer-part', $this->data);
        }
    }
}