<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use Admin\AbstractController\AbstractController;
use Apfelbox\FileDownload\FileDownload;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HForm\Form;
use HPayment\PaymentFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use voku\helper\AntiXSS;

include_once 'AbstractController.class.php';

class UserController extends AbstractController
{
    public function manageUserAction()
    {
        $userModel = new UserModel();
        $this->data['users'] = $userModel->getUsers('r.id=:rId', ['rId' => AUTH_ROLE_USER]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده کاربران');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/User/manageUser');
    }

    public function addUserAction()
    {
        $model = new Model();
        $userModel = new UserModel();

        $this->data['marketers'] = $userModel->getUsers('r.id=:role', ['role' => AUTH_ROLE_MARKETER]);

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addUser');
        $form->setFieldsName([
            'image', 'mobile', 'subset_of', 'password', 're_password', 'first_name', 'last_name', 'n_code'])
            ->setMethod('post', [
                'image' => 'file'
            ], ['image']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['mobile', 'subset_of', 'password', 're_password'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->validatePersianMobile('mobile')
                    ->validatePersianName('first_name', 'نام باید از حروف فارسی باشند.')
                    ->validatePersianName('last_name', 'نام خانوادگی باید از حروف فارسی باشند.')
                    ->isLengthInRange('password', 8, PHP_INT_MAX, 'تعداد کلمه عبور باید حداقل ۸ کاراکتر باشد.')
                    ->validatePassword('password', 2, 'کلمه عبور باید شامل حروف و اعداد باشد.');

                if ($values['password'] != $values['re_password']) {
                    $form->setError('کلمه عبور با تکرار آن مغایرت دارد.');
                }

                if ($model->is_exist(self::TBL_USER, 'mobile=:mob', ['mob' => $values['mobile']])) {
                    $form->setError('کاربر با این نام کاربری (موبایل) وجود دارد!');
                }

                // Validate image
                if (!isset($values['image']['name']) || empty($values['image']['name'])) {
                    $values['image'] = PROFILE_DEFAULT_IMAGE;
                }

                $marketers = array_column($this->data['marketers'], 'id');
                $marketers[] = -1;
                if (!in_array($values['subset_of'], $marketers)) {
                    $form->setError('معرف انتخاب شده نامعتبر است.');
                }

                if (!empty($values['n_code'])) {
                    $form->validateNationalCode('n_code');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $userModel = new UserModel();
                $model->transactionBegin();

                // upload image
                $res4 = true;
                $img = isset($values['image']['name']) && !empty($values['image']['name']) ? $values['image']['name'] : $values['image'];
                $imageExt = pathinfo($img, PATHINFO_EXTENSION);
                $imageName = convertNumbersToPersian($values['mobile'], true);
                $image = PROFILE_IMAGE_DIR . $imageName . '.' . $imageExt;

                $res = $model->insert_it(self::TBL_USER, [
                    'user_code' => $userModel->getNewUserCode(),
                    'subset_of' => $values['subset_of'],
                    'mobile' => convertNumbersToPersian($values['mobile'], true),
                    'password' => password_hash($values['password'], PASSWORD_DEFAULT),
                    'first_name' => $values['first_name'],
                    'last_name' => $values['last_name'],
                    'n_code' => $values['n_code'],
                    'image' => $image,
                    'ip_address' => get_client_ip_env(),
                    'active' => 1,
                    'created_at' => time(),
                ], [], true);
                $res3 = $model->insert_it(self::TBL_USER_ROLE, [
                    'user_id' => $res,
                    'role_id' => AUTH_ROLE_USER,
                ]);
                $res2 = $model->insert_it(self::TBL_USER_ACCOUNT, [
                    'user_id' => $res,
                    'account_balance' => 0,
                ]);

                if ((!isset($values['image']['name']) || empty($values['image']['name'])) && $res && $res3) {
                    $res4 = copy($values['image'], $image);
                }

                if ($res && $res2 && $res3 && $res4) {
                    if (isset($values['image']['name']) && !empty($values['image']['name'])) {
                        $res5 = $this->_uploadUserImage('image', $image, $imageName, $res);
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

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن کاربر جدید');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page([
            'pages/be/User/addUser',
        ]);
    }

    public function editUserAction($param)
    {
        $model = new Model();
        $userModel = new UserModel();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/user/manageUser'));
        }

        $this->data['uTrueValues'] = $model->select_it(null, self::TBL_USER, ['mobile', 'image'], 'id=:id', ['id' => $param[0]])[0];
        $this->data['marketers'] = $userModel->getUsers('r.id=:role', ['role' => AUTH_ROLE_MARKETER]);
        $this->data['provinces'] = $model->select_it(null, self::TBL_PROVINCE, ['id', 'name']);

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editUser');
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

                // Validate image
                if (empty($values['image'])) {
                    $values['image'] = PROFILE_DEFAULT_IMAGE;
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
                ], 'id=:id', ['id' => $this->data['param'][0]]);
                if ((!isset($values['image']['name']) || empty($values['image']['name'])) && $res &&
                    convertNumbersToPersian($values['mobile'], true) != $this->data['uTrueValues']['mobile']) {
                    $res4 = copy($values['image'], $image);
                }

                if ($res && $res2 && $res4) {
                    if (isset($values['image']['name']) && !empty($values['image']['name'])) {
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

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش کاربر');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page([
            'pages/be/User/editUser',
        ]);
    }

    public function deleteUserAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }

        try {
            if (!$this->auth->isAllow('user', AUTH_ACCESS_DELETE)) {
                message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_USER;

        try {
            if (!isset($id) || $id == $this->data['identity']->id) {
                message(self::AJAX_TYPE_ERROR, 200, 'کاربر نامعتبر است.');
            }
            if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
                message(self::AJAX_TYPE_ERROR, 200, 'کاربر وجود ندارد.');
            }

            $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
            if ($res) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'کاربر با موفقیت حذف شد.');
            }

            message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
        } catch (Exception $e) {
            message(self::AJAX_TYPE_ERROR, 200, 'امکان حذف کاربر وجود ندارد.');
        }
    }

    public function activeDeactiveAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }

        try {
            if (!$this->auth->isAllow('user', AUTH_ACCESS_UPDATE)) {
                message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();

        $id = $_POST['postedId'];
        $stat = $_POST['stat'];
        $table = self::TBL_USER;
        if (!isset($id) || !isset($stat) || !in_array($stat, [0, 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کاربر وجود ندارد.');
        }

        $res = $model->update_it($table, ['active' => $stat], 'id=:id', ['id' => $id]);
        if ($res) {
            if ($stat == 1) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'کاربر فعال شد.');
            } else {
                message(self::AJAX_TYPE_WARNING, 200, 'کاربر غیر فعال شد.');
            }
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageMarketerAction()
    {
        $userModel = new UserModel();
        $this->data['marketers'] = $userModel->getUsers('r.id=:rId', ['rId' => AUTH_ROLE_MARKETER]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده بازاریابان');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/User/manageMarketer');
    }

    public function inOurTeamAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }

        try {
            if (!$this->auth->isAllow('user', AUTH_ACCESS_UPDATE)) {
                message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();

        $id = $_POST['postedId'];
        $stat = $_POST['stat'];
        $table = self::TBL_USER;
        if (!isset($id) || !isset($stat) || !in_array($stat, [0, 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کاربر وجود ندارد.');
        }

        $res = $model->update_it($table, ['is_in_team' => $stat], 'id=:id', ['id' => $id]);
        if ($res) {
            if ($stat == 1) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'کاربر در تیم ما قرار گرفت.');
            } else {
                message(self::AJAX_TYPE_WARNING, 200, 'کاربر از تیم ما خارج شد.');
            }
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    public function deleteMarketerAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }

        try {
            if (!$this->auth->isAllow('user', AUTH_ACCESS_DELETE)) {
                message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();
        $userModel = new UserModel();

        $id = @$_POST['postedId'];
        $table = self::TBL_USER;

        try {
            if (!isset($id) || $id == $this->data['identity']->id) {
                message(self::AJAX_TYPE_ERROR, 200, 'کاربر نامعتبر است.');
            }
            if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
                message(self::AJAX_TYPE_ERROR, 200, 'کاربر وجود ندارد.');
            }

            $res = $userModel->changeToUser($id);
            if ($res) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'کاربر از لیست بازاریابان حذف شد.');
            }

            message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
        } catch (Exception $e) {
            message(self::AJAX_TYPE_ERROR, 200, 'امکان حذف کاربر از لیست بازاریابان وجود ندارد.');
        }
    }

    public function deleteMarketerRequestAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }

        try {
            if (!$this->auth->isAllow('user', AUTH_ACCESS_DELETE)) {
                message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_USER;

        if (!isset($id) || $id == $this->data['identity']->id) {
            message(self::AJAX_TYPE_ERROR, 200, 'کاربر نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کاربر وجود ندارد.');
        }

        $res = $model->update_it($table, [
            'flag_marketer_request' => 0
        ], 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'کاربر از لیست درخواست‌ها حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    public function acceptMarketerAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }

        try {
            if (!$this->auth->isAllow('user', AUTH_ACCESS_UPDATE)) {
                message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();
        $userModel = new UserModel();

        $id = $_POST['postedId'];
        $stat = $_POST['stat'];
        $table = self::TBL_USER;
        if (!isset($id) || !isset($stat) || !in_array($stat, [0, 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کاربر وجود ندارد.');
        }

        if ($stat == 1) {
            $res = $userModel->changeToMarketer($id);
        } else {
            $res = $userModel->changeToUser($id);
        }
        if ($res) {
            if ($stat == 1) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'کاربر به بازاریاب تبدیل شد.');
            } else {
                message(self::AJAX_TYPE_WARNING, 200, 'کاربر از لیست بازاریابان خارج شد.');
            }
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function userProfileAction($param)
    {
        $model = new Model();
        $userModel = new UserModel();
        $orderModel = new OrderModel();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/user/manageUser'));
        }

        $this->data['user'] = $userModel->getSingleUser('u.id=:id', ['id' => $param[0]]);
        $this->data['user']['subsets'] = $model->select_it(null, self::TBL_USER, [
            'id', 'first_name', 'last_name', 'mobile', 'active', 'created_at'
        ], 'subset_of=:sub', ['sub' => $this->data['user']['user_code']]);
        $this->data['user']['orders'] = $orderModel->getOrders('o.user_id=:id', ['id' => $param[0]]);

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('upgradeUser');
        $form->setFieldsName(['upgrade'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function () use ($model, $form) {
                if ($model->is_exist(self::TBL_USER_ROLE, 'user_id=:uId AND role_id=:rId',
                    ['uId' => $this->data['param'][0], 'rId' => AUTH_ROLE_USER])) {
                    $form->setError('کاربر هم اکنون بازاریاب است.');
                    return;
                }
                $res = $model->insert_it(self::TBL_USER_ROLE, [
                    'user_id' => $this->data['param'][0],
                    'role_id' => AUTH_ROLE_USER,
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
                $this->data['success'] = 'کاربر با موفقیت به بازاریاب تغییر یافت';
            } else {
                $this->data['errors'] = $form->getError();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده کاربر');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/User/userProfile');
    }

    public function userDepositAction($param)
    {
        $model = new Model();
        $orderModel = new OrderModel();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/user/manageUser'));
        }

        $this->data['param'] = $param;

        $this->data['deposit_errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_deposit'] = $form->csrfToken('chargeAccount');
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
                $commonModel = new CommonModel();
                $code = $commonModel->generate_random_unique_code(self::TBL_USER_ACCOUNT_DEPOSIT, 'deposit_code',
                    'DEP-', 6, 15, 10, CommonModel::DIGITS);

                $model->transactionBegin();

                $res2 = $model->update_it(self::TBL_USER_ACCOUNT, [],
                    'user_id=:id', ['id' => $this->data['param'][0]], [
                        'account_balance' => 'account_balance+' . (int)$values['price']
                    ]);
                $res = $model->insert_it(self::TBL_USER_ACCOUNT_DEPOSIT, [
                    'deposit_code' => 'DEP-' . $code,
                    'user_id' => $this->data['param'][0],
                    'payer_id' => $this->data['identity']->id,
                    'deposit_price' => (int)$values['price'],
                    'description' => 'افزایش موجودی حساب',
                    'deposit_type' => DEPOSIT_TYPE_OTHER,
                    'deposit_date' => time(),
                ]);

                if ($res && $res2) {
                    $model->transactionComplete();
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
                $this->data['deposit_success'] = 'حساب کاربر با موفقیت شارژ شد.';
            } else {
                $this->data['deposit_errors'] = $form->getError();
                $this->data['dValues'] = $form->getValues();
            }
        }

        $this->data['user'] = $model->select_it(null, self::TBL_USER, ['first_name', 'last_name', 'mobile'], 'id=:id', ['id' => $param[0]])[0];
        $this->data['user']['balance'] = $model->select_it(null, self::TBL_USER_ACCOUNT, 'account_balance',
            'user_id=:id', ['id' => $param[0]]);
        $this->data['user']['balance'] = count($this->data['user']['balance']) ? $this->data['user']['balance'][0]['account_balance'] : 0;
        // Calculate account income
        $idPaySum = $model->select_it(null, self::PAYMENT_TABLE_IDPAY, ['SUM(price) AS sum'],
            'user_id=:uId AND exportation_type=:et', ['uId' => $param[0], 'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT])[0]['sum'];
        $mabnaSum = $model->select_it(null, self::PAYMENT_TABLE_MABNA, ['SUM(price) AS sum'],
            'user_id=:uId AND exportation_type=:et', ['uId' => $param[0], 'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT])[0]['sum'];
        $zarinpalSum = $model->select_it(null, self::PAYMENT_TABLE_ZARINPAL, ['SUM(price) AS sum'],
            'user_id=:uId AND exportation_type=:et', ['uId' => $param[0], 'et' => FACTOR_EXPORTATION_TYPE_DEPOSIT])[0]['sum'];
        $this->data['user']['total_income'] = $idPaySum + $mabnaSum + $zarinpalSum;
        // Calculate account outcome
        $this->data['user']['total_outcome'] = $model->select_it(null, self::TBL_USER_ACCOUNT_BUY, ['SUM(price) AS sum'],
            'user_id=:uId', ['uId' => $param[0]])[0]['sum'];
        // Deposit transactions
        $this->data['user']['transactions'] = $orderModel->getUserDeposit('ud.user_id=:uId', ['uId' => $param[0]]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده کیف پول کاربر');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/User/userDeposit');
    }

    public function changePasswordAction($param)
    {
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/user/manageUser'));
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('changePassword');
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

        $this->_render_page('pages/be/User/changePassword');
    }

    public function userUpgradeAction()
    {
        $userModel = new UserModel();
        $this->data['requests'] = $userModel->getUsers('r.id=:rId AND flag_marketer_request=:req',
            ['rId' => AUTH_ROLE_USER, 'req' => 1]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده کاربران');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/User/userUpgrade');

    }
}
