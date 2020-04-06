<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HForm\Form;
use Home\AbstractController\AbstractController;
use HPayment\Payment;
use HPayment\PaymentClasses\PaymentZarinPal;
use HPayment\PaymentException;
use HPayment\PaymentFactory;

include_once 'AbstractController.class.php';

class UserController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

//        $this->_checker();

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/admin.user.main.js');
    }

    public function dashboardAction()
    {
        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'داشبورد');
        $this->data['todayDate'] = jDateTime::date('l d F Y') . ' - ' . date('d F');

        $model = new Model();

        $this->_render_page('pages/fe/User/dashboard');
    }

    public function editUserAction($param)
    {
        $model = new Model();
        $userModel = new UserModel();

        if (!isset($param[0]) || !is_numeric($param[0]) || $param[0] != $this->data['identity']->id ||
            !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->error->show_404();
        }

        $this->data['uTrueValues'] = $model->select_it(null, self::TBL_USER, ['mobile'], 'id=:id', ['id' => $param[0]])[0];
        $this->data['marketers'] = $userModel->getUsers('r.id=:role', ['role' => AUTH_ROLE_MARKETER]);
        $this->data['provinces'] = $model->select_it(null, self::TBL_PROVINCE, ['id', 'name']);

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userEditUser');
        $form->setFieldsName([
            'image', 'mobile', 'subset_of', 'first_name', 'last_name', 'father_name', 'n_code',
            'birth_certificate_code', 'birth_certificate_code_place', 'birth_date', 'province',
            'city', 'address', 'postal_code', 'credit_card_number', 'gender', 'military_status',
            'question1', 'question2', 'question3', 'question4', 'question5', 'question6', 'question7', 'description'
        ])->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                $values = array_map('trim', $values);
                $form->isRequired(['mobile', 'subset_of'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->validatePersianMobile('mobile')
                    ->validatePersianName(['first_name', 'last_name'], 'نام و نام خانوادگی باید از حروف فارسی باشند.');

                if (convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile'] &&
                    $model->is_exist(self::TBL_USER, 'mobile=:mob', ['mob' => $values['mobile']])) {
                    $form->setError('کاربر با این نام کاربری (موبایل) وجود دارد!');
                }

                // Validate image
                if (empty($values['image'])) {
                    $values['image'] = PROFILE_DEFAULT_IMAGE;
                }

                $marketers = $this->data['marketers'];
                $marketers[] = -1;
                if (!in_array($values['icon'], $marketers)) {
                    $form->setError('معرف انتخاب شده نامعتبر است.');
                }

                if (!empty($values['n_code'])) {
                    $form->validateNationalCode('n_code');
                }
                if (!empty($values['birth_date'] && $values['birth_date'] < time())) {
                    $form->validateDate('birth_date', 'Y-m-d', 'تاریخ تولد نامعتبر است.', 'Y-m-d');
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
                $img = isset($values['image']['name']) ? $values['image']['name'] : $values['image'];
                $imageExt = pathinfo($img, PATHINFO_EXTENSION);
                $imageName = convertNumbersToPersian($values['mobile'], true);
                $image = PROFILE_IMAGE_DIR . $imageName . '.' . $imageExt;

                $res2 = true;
                if (convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile']) {
                    $res2 = unlink(realpath($values['image']));
                }
                $res = $model->update_it(self::TBL_USER, [
                    'subset_of' => $values['subset_of'],
                    'mobile' => convertNumbersToPersian($values['mobile'], true),
                    'first_name' => $values['first_name'],
                    'last_name' => $values['last_name'],
                    'province' => $values['province'] != -1 ? $model->select_it(null, self::TBL_PROVINCE, ['name'], 'id=:id', ['id' => $values['province']])[0]['name'] : '',
                    'city' => $values['city'] != -1 && $values['province'] != -1 ? $model->select_it(null, self::TBL_CITY, ['name'], 'id=:id AND province_id=:pId', ['id' => $values['city'], 'pId' => $values['province']])[0]['name'] : '',
                    'n_code' => convertNumbersToPersian($values['n_code'], true),
                    'address' => $values['address'],
                    'postal_code' => $values['postal_code'],
                    'image' => $values['image'],
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
                ], 'id=:id', ['id' => $this->data['param'][0]]);
                if (!isset($values['image']['name']) && $res &&
                    convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile']) {
                    $res4 = copy($values['image'], $image);
                }

                if ($res && $res2 && $res4) {
                    if (isset($values['image']['name'])) {
                        $res5 = $this->_uploadUserImage('image', $image, $imageName, $this->data['param'][0]);
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
                $this->data['success'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors'] = $form->getError();
                $this->data['uValues'] = $form->getValues();
            }
        }

        $this->data['uTrueValues'] = $userModel->getSingleUser('u.id=:id', ['id' => $param[0]]);
        $this->_isInfoFlagOK($param[0]);
        $this->_isBuyFlagOK($param[0]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش حساب کاربری');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page('pages/fe/User/profile/editUser');
    }

    public function changePasswordAction($param)
    {
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || $param[0] != $this->data['identity']->id ||
            !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->error->show_404();
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userChangePassword');
        $form->setFieldsName(['password', 're_password'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                $values = array_map('trim', $values);
                $form->isRequired(['password', 're_password'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->isLengthInRange('password', 9, PHP_INT_MAX, 'تعداد کلمه عبور باید حداقل ۹ کاراکتر باشد.')
                    ->validatePassword('password', 2, 'کلمه عبور باید شامل حروف و اعداد باشد.');

                if ($values['password'] != $values['re_password']) {
                    $form->setError('کلمه عبور با تکرار آن مغایرت دارد.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_USER, [
                    'password' => password_hash($values['password'], PASSWORD_DEFAULT),
                ], 'id=:id', ['id' => $this->data['param'][0]]);

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

    public function userProfileAction($param)
    {
        $model = new Model();
        $userModel = new UserModel();

        if (!isset($param[0]) || !is_numeric($param[0]) || $param[0] != $this->data['identity']->id ||
            !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->error->show_404();
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('userUpgradeUser');
        $form->setFieldsName(['upgrade'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function () use ($model, $form) {
                if ($model->is_exist(self::TBL_USER_ROLE, 'user_id=:uId AND role_id=:rId',
                    ['uId' => $this->data['param'][0], 'rId' => AUTH_ROLE_USER])) {
                    $form->setError('شما هم اکنون بازاریاب هستید.');
                    return;
                }
                $res = $model->update_it(self::TBL_USER, [
                    'flag_marketer_request' => 1
                ]);

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

        $this->data['user'] = $userModel->getSingleUser('u.id=:id', ['id' => $param[0]]);

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

        $this->data['order'] = $orderModel->getSingleOrder('id=:id', ['id' => $param[0]]);
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
                $values = array_map('trim', $values);
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

    public function userDepositAction($param)
    {

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'کیف پول');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');
        $this->data['css'][] = $this->asset->css('be/css/efm.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/forms/tags/tagsinput.min.js');
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');
        $this->data['js'][] = $this->asset->script('be/js/propertyJs.js');
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->_render_page('pages/fe/User/userDeposit');
    }

    //-----

    protected function _checker($returnBoolean = false)
    {
        if (!$this->auth->isLoggedIn()) {
            if ((bool)$returnBoolean) return false;
            $this->error->show_404();
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