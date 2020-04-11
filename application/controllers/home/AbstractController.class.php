<?php

namespace Home\AbstractController;

defined('BASE_PATH') OR exit('No direct script access allowed');

use AbstractPaymentController;
use CommonModel;
use CookieModel;
use Exception;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HForm\Form;
use HPayment\Payment;
use HPayment\PaymentClasses\PaymentMabna;
use HPayment\PaymentException;
use HPayment\PaymentFactory;
use HSMS\rohamSMS;
use HSMS\SMSException;
use Model;


include_once CONTROLLER_PATH . 'AbstractPaymentController.class.php';

abstract class AbstractController extends AbstractPaymentController
{
    //-----
    protected $couponPastDays = 365 * 24 * 60 * 60; // 1 year
    //-----
    protected $haveCartAccess = false;
    protected $haveShoppingSideCardAccess = false;
    protected $cartCookieName = 'cart__products_items_roham';
    //-----
    protected $messageSession = 'message_redirect_session';
    // Flash message configuration
    const FLASH_MESSAGE_TYPE_INFO = 'info';
    const FLASH_MESSAGE_TYPE_WARNING = 'warning';
    const FLASH_MESSAGE_TYPE_DANGER = 'danger';
    const FLASH_MESSAGE_TYPE_SUCCESS = 'success';
    //---->
    const FLASH_MESSAGE_ICON_INFO = 'la la-info-circle';
    const FLASH_MESSAGE_ICON_WARNING = 'la la-exclamation-circle';
    const FLASH_MESSAGE_ICON_DANGER = 'la la-times-circle';
    const FLASH_MESSAGE_ICON_SUCCESS = 'la la-check-circle';

    public function __construct()
    {
        parent::__construct();

        $this->load->library('HAuthentication/Auth');
        try {
            $this->auth = new Auth();
            $_SESSION['home_panel_namespace'] = 'home_new_hva_ms_rhm_7472';
            $this->auth->setNamespace($_SESSION['home_panel_namespace'])->setExpiration(365 * 24 * 60 * 60);
        } catch (HAException $e) {
            echo $e;
        }

        // Load file helper .e.g: read_json, etc.
        $this->load->helper('file');

        // Read settings once
        $this->setting = read_json(CORE_PATH . 'config.json');
        if (empty($this->setting)) {
            $this->setting = [];
        }
        $this->data['setting'] = $this->setting;

        // Read identity and store in data to pass in views
        $this->data['auth'] = $this->auth;
        $this->data['identity'] = $this->auth->getIdentity();

        if (!is_ajax()) {
            // Config(s)
            $this->data['favIcon'] = !empty($this->setting['main']['favIcon']) ? base_url($this->setting['main']['favIcon']) : '';
            $this->data['logo'] = $this->setting['main']['logo'] ?? '';
        }

        if (!is_ajax()) {
            $categoryModel = new \CategoryModel();
            $this->data['menuNavigation'] = $categoryModel->getCategories('c.publish=:pub', ['pub' => 1]);

            // Cart items
            $this->data['cart_items'] = $this->fetchCardItemsAction();
        }

        // Cancel reserved items from reserved table
        $this->_cancel_reserved_items();
    }

    public function loginAction()
    {
        $this->_shared();

        if ($this->auth->isLoggedIn()) {
            $this->error->show_404();
        }

        $this->_login(['captcha' => ACTION]);

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ورود');

        $this->_render_page([
            'pages/fe/login',
        ]);
    }

    public function registerAction()
    {
        if ($this->auth->isLoggedIn()) {
            $this->error->show_404();
        }

        $this->_register(['captcha' => ACTION]);

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ثبت نام');

        $this->_render_page([
            'pages/fe/register',
        ]);
    }

    public function logoutAction()
    {
        if ($this->auth->isLoggedIn()) {
            $this->auth->logout();
            if ($_GET['back_url']) {
                $this->redirect($_GET['back_url']);
            } else {
                $this->redirect(base_url('index'));
            }
        } else {
            $this->error->show_404();
        }
    }

    //-----

    public function forgetPasswordAction($param)
    {
        if ($this->auth->isLoggedIn()) {
            $this->error->show_404();
        }

        $this->_shared();

        $model = new Model();

        $step = !isset($param[0]) || $param[0] != 'step' || !isset($param[1]) || !in_array($param[1], [1, 2, 3, 4]) ? 1 : $param[1];
        $this->data['step'] = $step;

        $this->data['errors'] = [];

        switch ($step) {
            case 1:
                // Form submission
                $this->load->library('HForm/Form');
                $form = new Form();
                $this->data['form_token'] = $form->csrfToken('userForgetPasswordStep1');
                $form->setFieldsName(['username'])
                    ->setMethod('post');
                try {
                    $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                        foreach ($values as &$value) {
                            if (is_string($value)) {
                                $value = trim($value);
                            }
                        }

                        $form->isRequired(['username'], 'فیلدهای ضروری را خالی نگذارید.');
                        if (!$model->is_exist(self::TBL_USER, 'mobile=:username', ['username' => $values['username']])) {
                            $form->setError('کاربری با این نام شماره موبایل وجود ندارد!');
                            return;
                        }
                    })->afterCheckCallback(function ($values) use ($model, $form) {
                        $this->data['code'] = generateRandomString(6, GRS_NUMBER);
                        $this->data['_username'] = convertNumbersToPersian($values['username'], true);

                        $res = $model->update_it(self::TBL_USER, [
                            'forgotten_password_code' => $this->data['code'],
                            'forgotten_password_time' => time(),
                        ], 'mobile=:username', ['username' => $values['username']]);

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
                        $this->session->set('username_forget_password_sess', $this->data['_username']);

                        // Send SMS code goes here
                        $this->load->library('HSMS/rohamSMS');
                        $sms = new rohamSMS();
                        try {
                            $body = $this->setting['sms']['forgetPasswordCodeMsg'];
                            $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['_username'], $body);
                            $body = str_replace(SMS_REPLACEMENT_CHARS['code'], $this->data['code'], $body);
                            $is_sent = $sms->set_numbers($this->data['_username'])->body($body)->send();

                            $this->session->setFlash($this->messageSession, [
                                'type' => self::FLASH_MESSAGE_TYPE_INFO,
                                'icon' => self::FLASH_MESSAGE_ICON_INFO,
                                'message' => 'پیامک فراموشی کلمه عبور برای شماره شما ارسال شد.',
                            ]);
                        } catch (SMSException $e) {
                            die($e->getMessage());
                        }

                        // Unset data
                        unset($this->data['code']);

                        $this->redirect(base_url('forgetPassword/step/2'));
                    } else {
                        $this->data['errors'] = $form->getError();
                        $this->data['fpValues'] = $form->getValues();
                    }
                }
                break;
            case 2:
                $username = $this->session->get('username_forget_password_sess');
                if (empty($username)) {
                    $this->session->setFlash($this->messageSession, [
                        'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                        'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                        'message' => ' شماره موبایل وارد نشده است!',
                    ]);
                    $this->redirect(base_url('forgetPassword/step/1'));
                }

                // Form submission
                $this->load->library('HForm/Form');
                $form = new Form();
                $this->data['form_token'] = $form->csrfToken('userForgetPasswordStep2');
                $form->setFieldsName(['code'])
                    ->setMethod('post');
                try {
                    $form->beforeCheckCallback(function (&$values) use ($model, $form, $username) {
                        foreach ($values as &$value) {
                            if (is_string($value)) {
                                $value = trim($value);
                            }
                        }

                        $form->isRequired(['code'], 'فیلدهای ضروری را خالی نگذارید.');
                        if (!$model->is_exist(self::TBL_USER, 'mobile=:username ', ['username' => $username])) {
                            $this->session->setFlash($this->messageSession, [
                                'type' => self::FLASH_MESSAGE_TYPE_DANGER,
                                'icon' => self::FLASH_MESSAGE_ICON_DANGER,
                                'message' => 'این شماره موبایل وجود ندارد.',
                            ]);
                            $this->redirect(base_url('forgetPassword/step/1'));
                        }
                        $code = $model->select_it(null, self::TBL_USER, 'forgotten_password_code',
                            'mobile=:username', ['username' => $username])[0]['forgotten_password_code'];
                        if ($values['code'] != $code) {
                            $form->setError('کد وارد شده نادرست است.');
                        }
                    })->afterCheckCallback(function () use ($model, $form, $username) {
                        $res = $model->update_it(self::TBL_USER, [
                            'active' => 1,
                            'activation_code' => '',
                        ], 'mobile=:username', ['username' => $username]);

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
                        $this->session->set('username_forget_password_sess_success', 'OK_STEP2');

                        $this->redirect(base_url('forgetPassword/step/3'));
                    } else {
                        $this->data['errors'] = $form->getError();
                        $this->data['fpValues'] = $form->getValues();
                    }
                }
                break;
            case 3:
                $Ok = $this->session->get('username_forget_password_sess_success');
                if ($Ok != 'OK_STEP2') {
                    $this->session->setFlash($this->messageSession, [
                        'type' => self::FLASH_MESSAGE_TYPE_DANGER,
                        'icon' => self::FLASH_MESSAGE_ICON_DANGER,
                        'message' => 'مراحل به درستی انجام نشده‌اند.',
                    ]);
                    $this->redirect(base_url('forgetPassword/step/1'));
                }
                $username = $this->session->get('username_forget_password_sess');
                if (empty($username)) {
                    $this->session->setFlash($this->messageSession, [
                        'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                        'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                        'message' => ' شماره موبایل وارد نشده است!',
                    ]);
                    $this->redirect(base_url('forgetPassword/step/1'));
                }

                // Form submission
                $this->load->library('HForm/Form');
                $form = new Form();
                $this->data['form_token'] = $form->csrfToken('userForgetPasswordStep3');
                $form->setFieldsName(['password', 're_password'])
                    ->setMethod('post');
                try {
                    $form->beforeCheckCallback(function (&$values) use ($model, $form, $username) {
                        foreach ($values as &$value) {
                            if (is_string($value)) {
                                $value = trim($value);
                            }
                        }

                        $form->isRequired(['password', 're_password'], 'فیلدهای ضروری را خالی نگذارید.');
                        $form->isLengthInRange('password', 8, PHP_INT_MAX, 'تعداد کلمه عبور باید حداقل ۸ کاراکتر باشد.')
                            ->validatePassword('password', 2, 'کلمه عبور باید شامل حروف و اعداد باشد.');

                        if ($values['password'] != $values['re_password']) {
                            $form->setError('کلمه عبور با تکرار آن مغایرت دارد.');
                        }
                    })->afterCheckCallback(function ($values) use ($model, $form, $username) {
                        $res = $model->update_it(self::TBL_USER, [
                            'password' => password_hash(trim($values['password']), PASSWORD_DEFAULT),
                        ], 'mobile=:username', ['username' => $username]);

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
                        $this->session->set('username_forget_password_sess_success', 'OK_STEP3');

                        // Unset data
                        $this->session->remove('username_forget_password_sess');

                        $this->redirect(base_url('forgetPassword/step/4'));
                    } else {
                        $this->data['errors'] = $form->getError();
                        $this->data['fpValues'] = $form->getValues();
                    }
                }
                break;
            case 4:
                $Ok = $this->session->get('username_forget_password_sess_success');
                if ($Ok != 'OK_STEP3') {
                    $this->session->setFlash($this->messageSession, [
                        'type' => self::FLASH_MESSAGE_TYPE_DANGER,
                        'icon' => self::FLASH_MESSAGE_ICON_DANGER,
                        'message' => 'مراحل به درستی انجام نشده‌اند.',
                    ]);
                    $this->redirect(base_url('forgetPassword/step/1'));
                }
                break;
        }

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'فراموشی کلمه عبور');

        $this->_render_page([
            'pages/fe/forget-password',
        ]);
    }

    public function activationAction($param)
    {
        if ($this->auth->isLoggedIn()) {
            $this->error->show_404();
        }

        $this->_shared();

        $model = new Model();

        $step = !isset($param[0]) || $param[0] != 'step' || !isset($param[1]) || !in_array($param[1], [1, 2, 3]) ? 1 : $param[1];
        $this->data['step'] = $step;

        $this->data['errors'] = [];

        switch ($step) {
            case 1:
                // Form submission
                $this->load->library('HForm/Form');
                $form = new Form();
                $this->data['form_token'] = $form->csrfToken('userActivationStep1');
                $form->setFieldsName(['username'])
                    ->setMethod('post');
                try {
                    $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                        foreach ($values as &$value) {
                            if (is_string($value)) {
                                $value = trim($value);
                            }
                        }
                        $form->isRequired(['username'], 'فیلدهای ضروری را خالی نگذارید.');
                        if (!$model->is_exist(self::TBL_USER, 'mobile=:username', ['username' => $values['username']])) {
                            $form->setError('کاربری با این نام شماره موبایل وجود ندارد!');
                            return;
                        }
                        if ($model->is_exist(self::TBL_USER, 'mobile=:username AND active=:active', ['username' => $values['username'], 'active' => 1])) {
                            $form->setError('این حساب کاربری، فعال است.');
                            return;
                        }
                    })->afterCheckCallback(function ($values) use ($model, $form) {
                        $this->data['code'] = generateRandomString(6, GRS_NUMBER);
                        $this->data['_username'] = convertNumbersToPersian($values['username'], true);

                        $res = $model->update_it(self::TBL_USER, [
                            'activation_code' => $this->data['code'],
                            'activation_code_time' => time(),
                        ], 'mobile=:username', ['username' => $values['username']]);

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
                        $this->session->set('username_validation_sess', $this->data['_username']);

                        // Send SMS code goes here
                        $this->load->library('HSMS/rohamSMS');
                        $sms = new rohamSMS();
                        try {
                            $body = $this->setting['sms']['activationCodeMsg'];
                            $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['_username'], $body);
                            $body = str_replace(SMS_REPLACEMENT_CHARS['code'], $this->data['code'], $body);
                            $is_sent = $sms->set_numbers($this->data['_username'])->body($body)->send();

                            $this->session->setFlash($this->messageSession, [
                                'type' => self::FLASH_MESSAGE_TYPE_INFO,
                                'icon' => self::FLASH_MESSAGE_ICON_INFO,
                                'message' => 'پیامک فعالسازی حساب کاربری برای شماره شما ارسال شد.',
                            ]);
                        } catch (SMSException $e) {
                            die($e->getMessage());
                        }

                        // Unset data
                        unset($this->data['code']);

                        $this->redirect(base_url('activation/step/2'));
                    } else {
                        $this->data['errors'] = $form->getError();
                        $this->data['acValues'] = $form->getValues();
                    }
                }
                break;
            case 2:
                $username = $this->session->get('username_validation_sess');
                if (empty($username)) {
                    $this->session->setFlash($this->messageSession, [
                        'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                        'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                        'message' => ' شماره موبایل وارد نشده است!',
                    ]);
                    $this->redirect(base_url('activation/step/1'));
                }

                // Form submission
                $this->load->library('HForm/Form');
                $form = new Form();
                $this->data['form_token'] = $form->csrfToken('userActivationStep2');
                $form->setFieldsName(['code'])
                    ->setMethod('post');
                try {
                    $form->beforeCheckCallback(function (&$values) use ($model, $form, $username) {
                        foreach ($values as &$value) {
                            if (is_string($value)) {
                                $value = trim($value);
                            }
                        }

                        $form->isRequired(['code'], 'فیلدهای ضروری را خالی نگذارید.');
                        if (!$model->is_exist(self::TBL_USER, 'mobile=:username AND active=:active', ['username' => $username, 'active' => 0])) {
                            $this->session->setFlash($this->messageSession, [
                                'type' => self::FLASH_MESSAGE_TYPE_DANGER,
                                'icon' => self::FLASH_MESSAGE_ICON_DANGER,
                                'message' => 'پارامترهای ورودی دستکاری شده‌اند!',
                            ]);
                            $this->redirect(base_url('activation/step/1'));
                        }

                        $code = $model->select_it(null, self::TBL_USER, 'activation_code',
                            'mobile=:username', ['username' => $username])[0]['activation_code'];
                        if ($values['code'] != $code) {
                            $form->setError('کد وارد شده نادرست است.');
                        }
                    })->afterCheckCallback(function () use ($model, $form, $username) {
                        $res = $model->update_it(self::TBL_USER, [
                            'active' => 1,
                            'activation_code' => '',
                        ], 'mobile=:username', ['username' => $username]);

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
                        $this->session->set('username_validation_sess_success', 'OK');

                        $this->redirect(base_url('activation/step/3'));
                    } else {
                        $this->data['errors'] = $form->getError();
                        $this->data['acValues'] = $form->getValues();
                    }
                }
                break;
            case 3:
                $Ok = $this->session->get('username_validation_sess_success');
                if ($Ok == 'OK') {
                    $username = $this->session->get('username_validation_sess');
                    $userId = $model->select_it(null, self::TBL_USER, 'id',
                        'mobile=:username', ['username' => $username])[0]['id'];
                    try {
                        $this->auth->loginWithID($userId);
                    } catch (HAException $e) {
                    }

                    // Unset data
                    $this->session->remove('username_validation_sess');

                    sleep(2);
                    $this->redirect(base_url('user/dashboard'), 'در حال انجام عملیات ورود. لطفا صبر کنید...', 1);
                } else {
                    $this->redirect(base_url('activation/step/1'));
                }
                break;
        }

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'فعالسازی اکانت کاربری');

        $this->_render_page([
            'pages/fe/activation',
        ]);
    }

    //-------------------------------
    //----------- Captcha -----------
    //-------------------------------

    public function captchaAction($param)
    {
        if (isset($param[0])) {
            createCaptcha((string)$param[0]);
        } else {
            createCaptcha();
        }
    }

    //-------------------------------
    //------ Register & Login -------
    //-------------------------------

    protected function _register($param)
    {
        $this->data['registerErrors'] = [];
        $this->data['registerValues'] = [];

        if ($this->auth->isLoggedIn()) {
            return;
        }

        $model = new Model();

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_register'] = $form->csrfToken('register');
        $form->setFieldsName(['username', 'password', 're_password', 'rules', 'registerCaptcha'])
            ->setMethod('post', [], ['rules']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form, $param) {
                $values['username'] = trim(convertNumbersToPersian($values['username'], true));

                if (!$form->isChecked('rules')) {
                    $form->setError('برای ادامه فرایند ثبت نام، می‌بایست قوانین سایت را بپذیرید.');
                    return;
                }

                $form->isRequired(['username', 'password', 're_password', 'registerCaptcha'], 'فیلدهای ضروری را خالی نگذارید.');
                if ($model->is_exist(self::TBL_USER, 'mobile=:username', ['username' => $values['username']])) {
                    $form->setError('این شماره موبایل وجود دارد، لطفا دوباره تلاش کنید.');
                    return;
                }
                $form->validatePersianMobile('username');
                $form->isLengthInRange('password', 8, PHP_INT_MAX, 'تعداد کلمه عبور باید حداقل ۸ کاراکتر باشد.')
                    ->validatePassword('password', 2, 'کلمه عبور باید شامل حروف و اعداد باشد.');

                if ($values['password'] != $values['re_password']) {
                    $form->setError('کلمه عبور با تکرار آن مغایرت دارد.');
                }

                $config = getConfig('config');
                if (!isset($config['captcha_session_name']) ||
                    !isset($_SESSION[$config['captcha_session_name']][$param['captcha']]) ||
                    !isset($param['captcha']) ||
                    encryption_decryption(ED_DECRYPT, $_SESSION[$config['captcha_session_name']][$param['captcha']]) != strtolower($values['registerCaptcha'])) {
                    $form->setError('کد وارد شده با کد تصویر مغایرت دارد. دوباره تلاش کنید.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $this->data['code'] = generateRandomString(6, GRS_NUMBER);
                $this->data['_username'] = convertNumbersToPersian($values['username'], true);

                $userModel = new \UserModel();
                $model->transactionBegin();
                $res = $model->insert_it(self::TBL_USER, [
                    'user_code' => $userModel->getNewUserCode(),
                    'mobile' => convertNumbersToPersian(trim($values['username']), true),
                    'password' => password_hash(trim($values['password']), PASSWORD_DEFAULT),
                    'image' => PROFILE_DEFAULT_IMAGE,
                    'active' => 0,
                    'activation_code' => $this->data['code'],
                    'activation_code_time' => time(),
                    'ip_address' => get_client_ip_env(),
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

                if ($res && $res2 && $res3) {
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
                $this->session->set('username_validation_sess', $this->data['_username']);

                // Send SMS code goes here
                $this->load->library('HSMS/rohamSMS');
                $sms = new rohamSMS();
                try {
                    $body = $this->setting['sms']['activationCodeMsg'];
                    $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['_username'], $body);
                    $body = str_replace(SMS_REPLACEMENT_CHARS['code'], $this->data['code'], $body);
                    $is_sent = $sms->set_numbers($this->data['_username'])->body($body)->send();

                    $this->session->setFlash($this->messageSession, [
                        'type' => self::FLASH_MESSAGE_TYPE_INFO,
                        'icon' => self::FLASH_MESSAGE_ICON_INFO,
                        'message' => 'پیامک فعالسازی حساب کاربری برای شماره شما ارسال شد.',
                    ]);
                } catch (SMSException $e) {
                    die($e->getMessage());
                }

                // Unset data
                unset($this->data['code']);

                $message = 'در حال پردازش عملیات ثبت نام';
                $delay = 1;
                $this->redirect(base_url('activation/step/2'), $message, $delay);
            } else {
                $this->data['registerErrors'] = $form->getError();
                $this->data['registerValues'] = $form->getValues();
            }
        }
    }

    protected function _login($param)
    {
        $this->data['loginErrors'] = [];
        $this->data['loginValues'] = [];

        if ($this->auth->isLoggedIn()) {
            return;
        }

        $model = new Model();
        //-----
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_login'] = $form->csrfToken('login');
        $form->setFieldsName(['username', 'password', 'remember', 'loginCaptcha'])
            ->setMethod('post', [], ['remember']);
        try {
            $form->afterCheckCallback(function (&$values) use ($model, $form, $param) {
                $values['username'] = convertNumbersToPersian($values['username'], true);

                $config = getConfig('config');
                if (!isset($config['captcha_session_name']) ||
                    !isset($_SESSION[$config['captcha_session_name']][$param['captcha']]) ||
                    !isset($param['captcha']) ||
                    encryption_decryption(ED_DECRYPT, $_SESSION[$config['captcha_session_name']][$param['captcha']]) != strtolower($values['loginCaptcha'])) {
                    $form->setError('کد وارد شده با کد تصویر مغایرت دارد. دوباره تلاش کنید.');
                }
                // If there is no captcha error
                if (!count($form->getError())) {
                    $login = $this->auth->login($values['username'], $values['password'], $form->isChecked('remember'),
                        false, 'active=:active', ['active' => 1]);
                    if (is_array($login)) {
                        $form->setError($login['err']);
                    }
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $message = 'در حال پردازش عملیات ورود';
                $delay = 1;

                if (isset($_GET['back_url'])) {
                    $this->redirect($_GET['back_url'], $message, $delay);
                }
                $this->redirect(base_url('user/dashboard'), $message, $delay);
            } else {
                $this->data['loginErrors'] = $form->getError();
                $this->data['loginValues'] = $form->getValues();
            }
        }
    }

    //-----

    public function cartAction()
    {
        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $this->data['updated_items_in_cart'] = $cartItems['deleted'];
        $this->data['items'] = $cartItems['items'];
        //-----
        $totals = $this->_get_total_amounts($this->data['items']);
        $this->data['totalAmount'] = $totals['total_amount'];
        $this->data['totalDiscountedAmount'] = $totals['total_discount'];

        $this->data['cart_content'] = $this->load->view('templates/fe/cart/main-cart', $this->data, true);

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سبد خرید');

        // Extra js
        $this->data['js'][] = $this->asset->script('fe/js/checkoutJs.js');

        $this->_render_page(['pages/fe/cart']);
    }

    public function addToCartAction()
    {
        if (!is_ajax()) {
            $this->error->access_denied();
        }

        $cookieModel = new CookieModel();
        $model = new Model();

        $type = self::AJAX_TYPE_SUCCESS;
        $msg = 'محصول با موفقیت به سبد اضافه شد.';

        $id = $_POST['postedId'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
        if (!isset($id) || !is_numeric($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }
        if (!$model->is_exist(self::TBL_PRODUCT, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'این محصول وجود ندارد.');
        }
        if (!$model->it_count(self::TBL_PRODUCT, 'id=:id AND stock_count>:sc AND available=:av', ['id' => $id, 'sc' => 0, 'av' => 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'محصول ناموجود است.');
        }

        // read
        $saved_cart_items = $this->_read_cart_cookie();

        // check if the item is in the array, if it is, do not add
        if (array_key_exists($id, $saved_cart_items)) {
            $stockCount = $model->select_it(null, self::TBL_PRODUCT, 'stock_count',
                'id=:id', ['id' => $id]);
            if (count($stockCount)) {
                $stockCount = convertNumbersToPersian($stockCount[0]['stock_count'], true);
                if (isset($quantity)) {
                    if ($saved_cart_items[$id]['quantity'] + $quantity > $stockCount) {
                        $type = self::AJAX_TYPE_WARNING;
                        $msg = 'تعداد محصول مورد نظر از تعداد در انبار بیشتر است!';
                    } else {
                        // make quantity a minimum of 1
                        $quantity = !is_numeric($quantity) || $quantity <= 0 ? 1 : $quantity;
                        $saved_cart_items[$id]['quantity'] = $quantity;
                        $type = self::AJAX_TYPE_INFO;
                        $msg = 'تعداد محصول در سبد تغییر کرد.';
                    }
                } else {
                    if ($saved_cart_items[$id]['quantity'] + 1 > $stockCount) {
                        $type = self::AJAX_TYPE_WARNING;
                        $msg = 'محصول به تعداد حداکثر خود رسیده است!';
                    } else {
                        $saved_cart_items[$id]['quantity'] += 1;
                        $type = self::AJAX_TYPE_INFO;
                        $msg = 'تعداد محصول در سبد افزایش یافت.';
                    }
                }
            } else {
                $type = self::AJAX_TYPE_ERROR;
                $msg = 'خطا در افزودن محصول به سبد!!';
            }

            $cart_items = $saved_cart_items;
        } else {
            $cart_items[$id] = [];
            if (isset($quantity)) {
                // make quantity a minimum of 1
                $quantity = !is_numeric($quantity) || $quantity <= 0 ? 1 : $quantity;
                $cart_items[$id]['quantity'] = $quantity;
            } else {
                // add new item on array
                $cart_items[$id]['quantity'] = 1;
            }

            // Merge two arrays
            $tmp_cart_items = [];
            foreach ($cart_items as $id => $item) {
                $tmp_cart_items[$id] = $item;
            }
            foreach ($saved_cart_items as $id => $item) {
                $tmp_cart_items[$id] = $item;
            }
            $cart_items = $tmp_cart_items;
        }

        $cart_items_count = count($cart_items);

        // put item to cookie
        $json = json_encode($cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);

        message($type, 200, [$msg, $cart_items_count]);
    }

    public function updateCartAction()
    {
        if (!is_ajax() && $this->haveCartAccess !== true) {
//            $this->error->access_denied();
            return false;
        }

        $cookieModel = new CookieModel();
        $model = new Model();

        $id = $_POST['postedId'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        if (!isset($id) || !is_numeric($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }
        if (!$model->is_exist(self::TBL_PRODUCT, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'این محصول وجود ندارد.');
        }
        if (!$model->it_count(self::TBL_PRODUCT, 'id=:id AND stock_count>:sc AND available=:av', ['id' => $id, 'sc' => 0, 'av' => 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'محصول ناموجود است.');
        }

        // make quantity a minimum of 1
        $quantity = !is_numeric($quantity) || $quantity <= 0 ? 1 : $quantity;

        // read cookie
        $saved_cart_items = $this->_read_cart_cookie();

        if (!isset($saved_cart_items[$id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'چنین محصولی در سبد خرید وجود ندارد!');
        }

        // delete cookie value
        $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

        // add the item with updated quantity
        $stockCount = $model->select_it(null, self::TBL_PRODUCT, 'stock_count',
            'id=:id', ['id' => $id]);
        if (count($stockCount)) {
            $stockCount = convertNumbersToPersian($stockCount[0]['stock_count'], true);
            if ($quantity > $stockCount) {
                message(self::AJAX_TYPE_WARNING, 200, 'محصول به تعداد حداکثر خود رسیده است!');
            } else {
                $saved_cart_items[$id]['quantity'] = $quantity;
            }
        }

        // enter new value
        $json = json_encode($saved_cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);

        if ($this->haveCartAccess === true) {
            return true;
        }
        message(self::AJAX_TYPE_SUCCESS, 200, 'سبد خرید بروزرسانی شد.');
    }

    public function removeFromCartAction()
    {
        if (!is_ajax() && $this->haveCartAccess !== true) {
            $this->error->access_denied();
        }

        $cookieModel = new CookieModel();

        $id = $_POST['postedId'] ?? null;
        if (!isset($id) || !is_numeric($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        // read
        $saved_cart_items = $this->_read_cart_cookie();

        // remove the item from the array
        unset($saved_cart_items[$id]);

        // delete cookie value
        unset($_COOKIE[$this->cartCookieName]);

        // empty value and expiration one hour before
        $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

        // enter new value
        $json = json_encode($saved_cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);
        $_COOKIE[$this->cartCookieName] = $json;

        $cart_items_count = count($saved_cart_items);

        if ($this->haveCartAccess === true) {
            $this->haveCartAccess = false;
            return $saved_cart_items;
        } else {
            message(self::AJAX_TYPE_INFO, 200, ['محصول از سبد خرید حذف شد.', $cart_items_count]);
            exit;
        }
    }

    public function removeAllFromCartAction()
    {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');

        $cookieModel = new CookieModel();

        // read
        $saved_cart_items = $this->_read_cart_cookie();

        // remove values
        unset($saved_cart_items);
        $saved_cart_items = array();

        // delete cookie value
        unset($_COOKIE[$this->cartCookieName]);

        // empty value and expiration one hour before
        $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

        // enter empty value
        $json = json_encode($saved_cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);
        $_COOKIE[$this->cartCookieName] = $json;
    }

    public function fetchUpdatedCartAction()
    {
        if (!is_ajax()) {
            $this->error->access_denied();
        }

        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $data['items'] = $cartItems['items'];
        //-----
        $totals = $this->_get_total_amounts($data['items']);
        $data['totalAmount'] = $totals['total_amount'];
        $data['totalDiscountedAmount'] = $totals['total_discount'];
        $data['auth'] = $this->auth;
        $data['setting'] = $this->setting;

        message(self::AJAX_TYPE_SUCCESS, 200, $this->load->view('templates/fe/cart/main-cart', $data, true));
    }

    public function fetchCardItemsAction()
    {
        $saved_cart_items = $this->_read_cart_cookie();
        $data['auth'] = $this->data['auth'];
        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $data['items'] = $cartItems['items'];
        //-----
        $totals = $this->_get_total_amounts($data['items']);
        $data['totalAmount'] = $totals['total_discount'];

        $cart_items_count = count($saved_cart_items);

        if (!is_ajax()) {
            return [$this->load->view('templates/fe/cart/cart-items', $data, true), convertNumbersToPersian($cart_items_count)];
        } else {
            message(self::AJAX_TYPE_SUCCESS, 200, [$this->load->view('templates/fe/cart/cart-items', $data, true), convertNumbersToPersian($cart_items_count)]);
            exit;
        }
    }

    //------------------------------
    //-------- Cart actions --------
    //------------ AND -------------
    //------ Shopping process ------
    //------------------------------

    public function shoppingAction()
    {
        // reset shopping session
        $this->session->remove('shopping_page_session');

        if (!$this->auth->isLoggedIn()) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'لطفا ابتدا به حساب کابری خود وارد شوید.',
            ]);
            $this->redirect(base_url('login?back_url=' . base_url('shopping')));
        }

        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $this->data['updated_items_in_cart'] = $cartItems['deleted'];
        $this->data['items'] = $cartItems['items'];
        $this->data['has_product_type'] = $cartItems['has_product_type'];
        //-----
        if (!count($this->data['items'])) {
            $this->redirect(base_url('cart'));
        }
        //-----

        // Submit form for next step
        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('shopping');
        $form->setFieldsName(['receiver_province', 'receiver_city', 'receiver_address', 'receiver_postal_code',
            'receiver_name', 'receiver_mobile', 'coupon_code'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                //-----
                $form->isRequired(['receiver_province', 'receiver_city', 'receiver_address',
                    'receiver_postal_code', 'receiver_name', 'receiver_mobile'], 'اطلاعات ضروری را تکمیل نمایید.');
                //-----
                $this->data['_shopping_arr'] = [];
                //-----
                $form->validatePersianName('receiver_name', 'نام گیرنده باید از حروف فارسی باشد.');
                $form->validatePersianMobile('receiver_mobile', 'شماره تماس گیرنده نامعتبر است.');
                $isValidCoupon = $this->_validate_coupon($values['coupon_code']);
                if (!empty($values['coupon_code']) && $isValidCoupon['status']) {
                    $this->data['_shopping_arr']['coupon_code']['code'] = $values['coupon_code'];
                    $this->data['_shopping_arr']['coupon_code']['price'] = $isValidCoupon['price'];
                } else {
                    $this->data['_shopping_arr']['coupon_code'] = null;
                }
            })->afterCheckCallback(function (&$values) use ($form) {
                $this->data['_shopping_arr']['receiver_name'] = $values['receiver_name'];
                $this->data['_shopping_arr']['receiver_mobile'] = $values['receiver_mobile'];
                $this->data['_shopping_arr']['receiver_province'] = $values['receiver_province'];
                $this->data['_shopping_arr']['receiver_city'] = $values['receiver_city'];
                $this->data['_shopping_arr']['receiver_address'] = $values['receiver_address'];
                $this->data['_shopping_arr']['receiver_postal_code'] = $values['receiver_postal_code'];

            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->session->set('shopping_page_session', $this->data['_shopping_arr']);
                $this->redirect(base_url('prepareToPay'));
            } else {
                $this->data['errors'] = $form->getError();
                $this->data['values'] = $form->getValues();
            }
        }

        //-----
        $totals = $this->_get_total_amounts($this->data['items']);
        $this->data['totalAmount'] = $totals['total_amount'];
        $this->data['totalDiscountedAmount'] = $totals['total_discount'];
        $this->data['sideCard'] = $this->load->view('templates/fe/cart/side-shopping-card', $this->data, true);

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'اطلاعات ارسال');

        // Extra js
        $this->data['js'][] = $this->asset->script('fe/js/shoppingJs.js');

        $this->_render_page(['pages/fe/shopping']);
    }

    public function prepareToPayAction()
    {
        // check information
        if (!$this->session->has('shopping_page_session')) {
            $this->redirect(base_url('shopping'));
        }

        if (!$this->auth->isLoggedIn()) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'لطفا ابتدا به حساب کابری خود وارد شوید.',
            ]);
            $this->redirect(base_url('login?back_url=' . base_url('prepareToPay')));
        }

        // Get previous stored data from session
        $prevData = $this->session->get('shopping_page_session');
        if (!isset($prevData['receiver_name']) || !isset($prevData['receiver_mobile']) ||
            !isset($prevData['receiver_province']) || !isset($prevData['receiver_city']) ||
            !isset($prevData['receiver_address']) || !isset($prevData['receiver_postal_code']) ||
            empty($prevData['receiver_name']) || empty($prevData['receiver_mobile']) ||
            empty($prevData['receiver_province']) || empty($prevData['receiver_city']) ||
            empty($prevData['receiver_address']) || empty($prevData['receiver_postal_code'])) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'اطلاعات مورد نیاز جهت ثبت سفارش را وارد کنید.',
            ]);
            $this->redirect(base_url('shopping'));
        }

        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $this->data['updated_items_in_cart'] = $cartItems['deleted'];
        $this->data['items'] = $cartItems['items'];
        $this->data['has_product_type'] = $cartItems['has_product_type'];
        //-----
        if (!count($this->data['items'])) {
            $this->redirect(base_url('cart'));
        }
        //-----
        $totals = $this->_get_total_amounts($this->data['items']);
        $this->data['totalAmount'] = $totals['total_amount'];
        $this->data['totalDiscountedAmount'] = $totals['total_discount'];
        $this->data['sideCard'] = $this->load->view('templates/fe/cart/side-shopping-card', $this->data, true);
        //-----

        // Submit form for next step
        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('prepareToPay');
        $form->setFieldsName(['payment_radio'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function ($values) use ($form) {
                // Check for payment method's code
                $arr = array_merge($this->gatewayTables[self::PAYMENT_TABLE_IDPAY],
                    $this->gatewayTables[self::PAYMENT_TABLE_MABNA],
                    $this->gatewayTables[self::PAYMENT_TABLE_ZARINPAL],
                    [PAYMENT_METHOD_WALLET, PAYMENT_METHOD_IN_PLACE, PAYMENT_METHOD_RECEIPT]);
                if (!in_array($values['payment_radio'], $arr)) {
                    $form->setError('شیوه پرداخت انتخاب شده، نامعتبر است.');
                }
                if (in_array($values['payment_radio'], $this->gatewayTables[self::PAYMENT_TABLE_MABNA])) {
                    $form->setError('اتصال به درگاه پرداخت با مشکل روبرو شده است.');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $formValues = $form->getValues();
        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                if ($formValues['payment_radio'] == PAYMENT_METHOD_RECEIPT) {
                    $this->session->set('payment_page_session', 'receipt_value');
                    $this->redirect(base_url('paymentReceipt'));
                }
                $status = $this->_gateway_processor($prevData, $formValues['payment_radio']);
                if (!$status) {
                    if ($formValues['payment_radio'] == PAYMENT_METHOD_WALLET) {
                        $this->data['errors'][] = 'کیف پول شما فاقد اعتبار لازم جهت انجام تراکنش است.';
                    } else {
                        $this->data['errors'][] = 'خطا در انجام عملیات پرداخت! لطفا مجددا تلاش نمایید.';
                    }
                }
            } else {
                $this->data['errors'] = $form->getError();
            }
        }

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'آماده پرداخت');

        // Extra js
        $this->data['js'][] = $this->asset->script('fe/js/prepareToPayJs.js');

        $this->_render_page(['pages/fe/payment']);
    }

    public function paymentReceiptAction()
    {
        // check information
        if (!$this->session->has('shopping_page_session')) {
            $this->redirect(base_url('shopping'));
        }
        if (!$this->session->has('payment_page_session')) {
            $this->redirect(base_url('prepareToPay'));
        }

        // Get previous stored data from session
        $prevData = $this->session->get('shopping_page_session');
        if (!isset($prevData['receiver_name']) || !isset($prevData['receiver_mobile']) ||
            !isset($prevData['receiver_province']) || !isset($prevData['receiver_city']) ||
            !isset($prevData['receiver_address']) || !isset($prevData['receiver_postal_code']) ||
            empty($prevData['receiver_name']) || empty($prevData['receiver_mobile']) ||
            empty($prevData['receiver_province']) || empty($prevData['receiver_city']) ||
            empty($prevData['receiver_address']) || empty($prevData['receiver_postal_code'])) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'اطلاعات مورد نیاز جهت ثبت سفارش را وارد کنید.',
            ]);
            $this->redirect(base_url('shopping'));
        }
        $sure = $this->session->get('payment_page_session');
        if ($sure != 'receipt_value') {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'پارمترهای ارسال شده دستکاری شده‌اند! لطفا مراحل را دوباره طی کنید.',
            ]);
            $this->redirect(base_url('prepareToPay'));
        }

        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $this->data['updated_items_in_cart'] = $cartItems['deleted'];
        $this->data['items'] = $cartItems['items'];
        $this->data['has_product_type'] = $cartItems['has_product_type'];
        //-----
        if (!count($this->data['items'])) {
            $this->redirect(base_url('cart'));
        }
        //-----
        $totals = $this->_get_total_amounts($this->data['items']);
        $this->data['totalAmount'] = $totals['total_amount'];
        $this->data['totalDiscountedAmount'] = $totals['total_discount'];
        $this->data['sideCard'] = $this->load->view('templates/fe/cart/side-shopping-card', $this->data, true);
        //-----

        // Submit form for next step
        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('paymentReceipt');
        $form->setFieldsName(['receipt_code', 'receipt_date'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function ($values) use ($form) {
                $form->validateDate('receipt_date', date('Y-m-d H:i:s', $values['receipt_date']), 'تاریخ رسید نامعتبر است.', 'Y-m-d H:i:s');
            })->afterCheckCallback(function ($values) use ($form, &$prevData) {
                $prevData['receipt_code'] = $values['receipt_code'];
                $prevData['receipt_date'] = $values['receipt_date'];
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->session->set('shopping_page_session', $prevData);
                $status = $this->_gateway_processor($prevData, PAYMENT_METHOD_RECEIPT);
                if (!$status) {
                    $this->data['errors'][] = 'خطا در انجام عملیات ثبت رسید! لطفا مجددا تلاش نمایید.';
                    $this->data['values'] = $form->getValues();
                }
            } else {
                $this->data['errors'] = $form->getError();
                $this->data['values'] = $form->getValues();
            }
        }

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'پرداخت از طریق رسید بانکی');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page(['pages/fe/payment-receipt']);
    }

    public function payResultAction($param)
    {
        if (!$this->auth->isLoggedIn() || !isset($param[0]) || !in_array($param[0], array_keys($this->paymentResultParam))) {
            $this->error->show_404();
        }
        //-----
        call_user_func_array($this->paymentResultParam[$param[0]], []);
        //-----
        if (!isset($this->data['order_code'])) $this->error->show_404();

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'نتیجه تراکنش');

        $this->_render_page(['pages/fe/pay-result']);
    }

    //-----

    public function shoppingSideCardAction()
    {
        if (is_ajax() && ($this->haveShoppingSideCardAccess !== true) || !$this->auth->isLoggedIn()) {
            message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
        }
        if (!is_ajax() && ($this->haveShoppingSideCardAccess !== true) || !$this->auth->isLoggedIn()) {
            $this->error->access_denied();
        }

        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $data['items'] = $cartItems['items'];
        $data['has_product_type'] = $cartItems['has_product_type'];
        //-----
        //-----
        if (!count($data['items'])) {
            message(self::AJAX_TYPE_ERROR, 200, 'در سبد خرید شما محصولی وجود ندارد!');
        }
        //-----
        $totals = $this->_get_total_amounts($data['items']);
        $data['totalAmount'] = $totals['total_amount'];
        $data['totalDiscountedAmount'] = $totals['total_discount'];

        if ($this->haveShoppingSideCardAccess) {
            $this->haveShoppingSideCardAccess = false;
            return $this->load->view('templates/fe/cart/side-shopping-card', $data, true);
        } else {
            message('success', 200, ['', $this->load->view('templates/fe/cart/side-shopping-card', $data, true)]);
        }
    }

    public function checkCouponCodeAction()
    {
        if (is_ajax() && !$this->auth->isLoggedIn()) {
            message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
        }
        if (!is_ajax() && !$this->auth->isLoggedIn()) {
            $this->error->access_denied();
        }

        $model = new Model();

        $code = $_POST['postedCode'] ?? null;
        if (!isset($code)) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }
        // If coupon is not exists
        if (!$model->is_exist(self::TBL_COUPON, 'coupon_code=:code AND expire_time>=:expire', ['code' => $code, 'expire' => time()])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کد تخفیف وارد شده نامعتبر می‌باشد. دوباره امتحان نمایید.');
        }
        // If coupon is used before
        if ($model->is_exist(self::TBL_ORDER, 'user_id=:uId AND coupon_code=:cc AND payment_date<:pd AND payment_status IN(:ps, :ps2)',
            ['uId' => $this->data['identity']->id, 'cc' => $code, 'pd' => time() - $this->couponPastDays,
                'ps' => OWN_PAYMENT_STATUS_SUCCESSFUL, 'ps2' => OWN_PAYMENT_STATUS_WAIT])) {
            message('warning', 200, 'شما از این کد تخفیف قبلا استفاده نموده‌اید! کد تخفیف دیگری را امتحان نمایید.');
        }

        // Get previous stored data from session
        $prevData = $this->session->get('shopping_page_session');
        if (isset($prevData['receiver_name'])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کد تخفیف را در مرحله اطلاعات ارسال وارد کنید.');
        }

        // Select current coupon
        $coupon = $model->select_it(null, 'coupons', '*', 'coupon_code=:cc', ['cc' => $code])[0];
        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $data['items'] = $cartItems['items'];
        $data['has_product_type'] = $cartItems['has_product_type'];
        //-----
        //-----
        if (!count($data['items'])) {
            message(self::AJAX_TYPE_ERROR, 200, 'در سبد خرید شما محصولی وجود ندارد!');
        }
        //-----
        $totals = $this->_get_total_amounts($data['items']);
        $data['totalAmount'] = $totals['total_amount'];
        $data['totalDiscountedAmount'] = $totals['total_discount'];

        if ($coupon['min_price'] != '' && $data['totalDiscountedAmount'] >= $coupon['min_price']) {
            if ($data['totalDiscountedAmount'] - $coupon['price'] > 0) {
                $data['totalDiscountedAmount'] = $data['totalDiscountedAmount'] - $coupon['price'];
            } else {
                message(self::AJAX_TYPE_ERROR, 200, 'این کد تخفیف دچار نقص فنی شده است!');
            }

            if ($coupon['max_price'] == '' || ($coupon['max_price'] != '' && $data['totalDiscountedAmount'] <= $coupon['max_price'])) {
                $data['auth'] = $this->auth;
                message(self::AJAX_TYPE_SUCCESS, 200, ['کد تخفیف اعمال شد.', $this->load->view('templates/fe/cart/side-shopping-card', $data, true)]);
            } else {
                message(self::AJAX_TYPE_ERROR, 200, 'قیمت کالا‌ها از حداکثر قیمت برای اعمال این کد تخفیف، بیشتر است!');
            }
        } else {
            message(self::AJAX_TYPE_ERROR, 200, 'قیمت کالا‌ها از حداقل قیمت برای اعمال این کد تخفیف، کمتر است!');
        }
    }

    //----->

    private function _read_cart_cookie()
    {
        $cookieModel = new CookieModel();
        $cookie = $cookieModel->is_cookie_set($this->cartCookieName, true, true);
        $cookie = $cookie ? $cookie : "";
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);

        // if $saved_cart_items is null, prevent null error
        if (!$saved_cart_items) {
            $saved_cart_items = array();
        }

        return $saved_cart_items;
    }

    protected function _fetch_cart_items($cookie_items = null)
    {
        //-----
        $model = new Model();
        //-----
        $cartItems = $this->_check_cart_items_again($cookie_items);
        $tmpItems = $cartItems['items'];
        $saved_cart_items = $this->_read_cart_cookie();
        //-----
        $items = [];
        $hasProductType = false;
        //-----
        foreach ($tmpItems as $info) {
            $res = $info;
            if ($hasProductType !== true && $res['product_type'] == PRODUCT_TYPE_ITEM) {
                $hasProductType = true;
            }
            $res['quantity'] = $res['quantity'] > $res['stock_count'] ? $res['stock_count'] : $res['quantity'];
            $discount = $res['discount_until'] > time() ? convertNumbersToPersian($res['discount_price'], true) : 0;
            $res['discount_percentage'] = floor(((convertNumbersToPersian($res['price'], true) - $discount) / convertNumbersToPersian($res['price'], true)) * 100);

            $items[] = $res;
        }

        return [
            'deleted' => $cartItems['deleted'],
            'items' => $items,
            'has_product_type' => $hasProductType,
        ];
    }

    private function _check_cart_items_again($cookie_items = null)
    {
        $delete_items_array = [];
        $main_items_array = [];
        //-----
        $saved_cart_items = is_null($cookie_items) ? $this->_read_cart_cookie() : $cookie_items;

        // Check if we have any item in cart
        if (!count($saved_cart_items)) {
            return [
                'deleted' => $delete_items_array,
                'items' => $main_items_array
            ];
        }
        //-----
        $model = new \ProductModel();
        //-----
        foreach ($saved_cart_items as $id => $eachItem) {
            $mainItem = $model->getProducts('p.id=:id AND p.stock_count>:sc AND p.available=:av', ['id' => $id, 'sc' => 0, 'av' => 1]);
            $this->haveCartAccess = true;
            if (!count($mainItem) ||
                (count($mainItem) && $mainItem[0]['available'] == 0)) {
                $_POST['postedId'] = $id;
                if (count($mainItem)) {
                    $delete_items_array[] = $mainItem[0];
                }
                $this->removeFromCartAction();
                //-----
                unset($_POST['postedId']);
            }
            if (count($mainItem) && ($mainItem[0]['stock_count'] < $eachItem['quantity'] || $eachItem['quantity'] > $mainItem[0]['max_cart_count'])) {
                $_POST['postedId'] = $id;
                $_POST['quantity'] = $eachItem['quantity'] < $mainItem[0]['max_cart_count'] ? $mainItem[0]['stock_count'] : $mainItem[0]['max_cart_count'];
                if ($this->updateCartAction() === true) {
                    $delete_items_array[] = $mainItem[0];
                }
                //-----
                unset($_POST['postedId']);
                unset($_POST['quantity']);
            }
            if (count($mainItem)) {
                $mainItem[0]['quantity'] = $eachItem['quantity'];
                $main_items_array[] = $mainItem[0];
            }
            $this->haveCartAccess = false;
        }
        return [
            'deleted' => $delete_items_array,
            'items' => $main_items_array
        ];
    }

    //-----

    private function _validate_coupon($code)
    {
        if (empty($code)) return ['status' => false, 'price' => 0];

        $model = new Model();

        // If coupon is not exists
        if ($model->is_exist(self::TBL_COUPON, 'coupon_code=:code AND expire_time>=:expire', ['code' => $code, 'expire' => time()])) {
            // If coupon is used before
            if ($model->is_exist(self::TBL_ORDER, 'user_id=:uId AND coupon_code=:cc AND payment_date<:pd AND payment_status IN(:ps, :ps2)',
                ['uId' => $this->data['identity']->id, 'cc' => $code, 'pd' => time() - $this->couponPastDays,
                    'ps' => OWN_PAYMENT_STATUS_SUCCESSFUL, 'ps2' => OWN_PAYMENT_STATUS_WAIT])) {
                return ['status' => false, 'price' => 0];
            }
            // Select current coupon
            $coupon = $model->select_it(null, self::TBL_COUPON, '*', 'coupon_code=:cc', ['cc' => $code])[0];
            // Check cart and cart items
            $cartItems = $this->_fetch_cart_items();
            $data['items'] = $cartItems['items'];
            //-----
            //-----
            if (!count($data['items'])) {
                return ['status' => false, 'price' => 0];
            }
            //-----
            $data['totalAmount'] = 0;
            $data['totalDiscountedAmount'] = 0;
            foreach ($data['items'] as $item) {
                $data['totalAmount'] += $item['price'] * $item['quantity'];
                $data['totalDiscountedAmount'] += $item['discount_price'] * $item['quantity'];
            }

            if ($coupon['min_price'] != '' && $data['totalDiscountedAmount'] >= $coupon['min_price']) {
                if ($data['totalDiscountedAmount'] - $coupon['price'] > 0) {
                    $data['totalDiscountedAmount'] = $data['totalDiscountedAmount'] - $coupon['price'];
                } else {
                    return ['status' => false, 'price' => 0];
                }

                if ($coupon['max_price'] != '' && $data['totalDiscountedAmount'] <= $coupon['max_price']) {
                    return ['status' => true, 'price' => $coupon['price']];
                } else if ($coupon['max_price'] == '') {
                    return ['status' => true, 'price' => $coupon['price']];
                } else {
                    return ['status' => false, 'price' => 0];
                }
            } else {
                return ['status' => false, 'price' => 0];
            }
        }
        return ['status' => false, 'price' => 0];
    }

    //-----

    private function _get_total_amounts($items)
    {
        $totalAmount = 0;
        $totalDiscountedAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
            $totalDiscountedAmount += $item['discount_price'] * $item['quantity'];
        }

        return [
            'total_amount' => $totalAmount,
            'total_discount' => $totalDiscountedAmount,
        ];
    }

    //------------------------
    //---- Gateway actions ---
    //------------------------

    private function _gateway_processor($prev, $paymentMethod, $hasLimited = false)
    {
        $model = new Model();
        $orderModel = new \OrderModel();

        $gatewayCode = '';
        // Select gateway table if gateway code is one of the bank payment gateway's code
        foreach ($this->gatewayTables as $table => $codeArr) {
            if (array_search($paymentMethod, $codeArr) !== false) {
                $gatewayCode = $paymentMethod;
                $paymentMethod = PAYMENT_METHOD_GATEWAY;
                $gatewayTable = $table;
                break;
            }
        }

        // Create transaction
        $model->transactionBegin();
        // Create factor code
        $common = new CommonModel();
        $orderCode = $common->generate_random_unique_code(self::TBL_ORDER, 'order_code', ORDER_CODE_PREFIX, 6,
            15, 10, CommonModel::DIGITS);
        $orderCode = ORDER_CODE_PREFIX . $orderCode;
        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $items = $cartItems['items'];
        // Insert factor information to factors table
        $res1 = $model->insert_it(self::TBL_ORDER, [
            'order_code' => $orderCode,
            'user_id' => $this->data['identity']->id,
            'first_name' => $this->data['identity']->first_name,
            'last_name' => $this->data['identity']->last_name,
            'mobile' => $this->data['identity']->mobile,
            'receipt_code' => $prev['receipt_code'] ?? '',
            'receipt_date' => $prev['receipt_date'] ?? null,
            'method_code' => $gatewayCode,
            'payment_method' => $paymentMethod,
            'payment_title' => PAYMENT_METHODS[$paymentMethod],
            'payment_status' => OWN_PAYMENT_STATUS_NOT_PAYED,
            'send_status' => $orderModel->getStatusId(SEND_STATUS_IN_QUEUE),
            'receiver_name' => $prev['receiver_name'],
            'receiver_phone' => $prev['receiver_mobile'],
            'province' => $prev['receiver_province'],
            'city' => $prev['receiver_city'],
            'postal_code' => $prev['receiver_postal_code'],
            'address' => $prev['receiver_address'],
            'order_date' => time()
        ]);
        // Calculate price of product(s) and store in factors_item
        $totalAmount = 0;
        $totalDiscountedAmount = 0;
        $hasProductType = false;
        foreach ($items as $item) {
            try {
                $productTotalPrice = $item['price'] * $item['quantity'];
                // Add to total amount and total discounted amount variable
                $totalAmount += $productTotalPrice;
                $totalDiscountedAmount += $item['discount_price'] * $item['quantity'];
                // Insert each product information to factors_item table
                $model->insert_it(self::TBL_ORDER_ITEM, [
                    'order_code' => $orderCode,
                    'product_id' => $item['id'],
                    'product_count' => $item['quantity'],
                    'product_unit_price' => $item['price'],
                    'product_price' => $productTotalPrice,
                ]);
                $model->update_it(self::TBL_PRODUCT, [], 'id=:id', ['id' => $item['id']], [
                    'stock_count' => 'stock_count-' . (int)$item['quantity'],
                    'sold_count' => 'sold_count+' . (int)$item['quantity'],
                ]);
                if (!$hasProductType && $item['product_type'] == PRODUCT_TYPE_ITEM) {
                    $hasProductType = true;
                }
            } catch (Exception $e) {
                continue;
            }
        }
        $discountPrice = $totalAmount - $totalDiscountedAmount;

        // Coupon check
        $couponCode = '';
        $couponTitle = '';
        $couponAmount = '';
        $isValidCoupon = $this->_validate_coupon($prev['coupon_code']['code'] ?? '');
        if (!empty($prev['coupon_code']['code']) && $isValidCoupon['status'] === true) {
            $theCoupon = $model->select_it(null, self::TBL_COUPON, ['coupon_code', 'title', 'price'],
                'coupon_code=:code AND expire_time>=:expire', ['code' => $prev['coupon_code']['code'], 'expire' => time()])[0];
            $couponCode = $theCoupon['coupon_code'];
            $couponTitle = $theCoupon['title'];
            $couponAmount = $theCoupon['price'];

            // Discount coupon price
            $totalDiscountedAmount -= convertNumbersToPersian($theCoupon['price'], true);
        }

        // Add shipping price to total amounts
        $shippingPrice = 0;
        if ($hasProductType) {
            if (!isset($this->data['setting']['cart']['shipping_free_price']) ||
                empty($this->data['setting']['cart']['shipping_free_price']) ||
                $totalDiscountedAmount < (int)$this->data['setting']['cart']['shipping_free_price']) {
                if ($this->data['identity']->city == SHIRAZ_CITY) {
                    if (isset($this->data['setting']['cart']['shipping_price']['area1']) &&
                        !empty($this->data['setting']['cart']['shipping_price']['area1'])) {
                        $totalDiscountedAmount += (int)$this->data['setting']['cart']['shipping_price']['area1'];
                        $shippingPrice = (int)$this->data['setting']['cart']['shipping_price']['area1'];
                    }
                } else {
                    if (isset($this->data['setting']['cart']['shipping_price']['area2']) &&
                        !empty($this->data['setting']['cart']['shipping_price']['area2'])) {
                        $totalDiscountedAmount += (int)$this->data['setting']['cart']['shipping_price']['area2'];
                        $shippingPrice = (int)$this->data['setting']['cart']['shipping_price']['area2'];
                    }
                }
            }
        }
        $totalAmount += $shippingPrice;
        $totalDiscountedAmount += $shippingPrice;

        // Update factor information in factors table
        $res2 = $model->update_it(self::TBL_ORDER, [
            'amount' => $totalAmount,
            'shipping_price' => $shippingPrice,
            'final_price' => $totalDiscountedAmount,
            'coupon_code' => $couponCode,
            'coupon_title' => $couponTitle,
            'coupon_amount' => $couponAmount,
            'discount_price' => $discountPrice,
        ], 'order_code=:oc', ['oc' => $orderCode]);

        // Insert factor code to reserved factors codes
        $reserved = $model->insert_it(self::TBL_ORDER_RESERVED, [
            'order_code' => $orderCode,
            'expire_time' => time(),
        ]);
        //-----

        if (!$res1 || !$res2 || !$reserved) {
            $model->transactionRollback();
            return false;
        } else {
            // If any gateway exists (if method code is one of the bank payment gateways)
            if (isset($gatewayTable)) {
                // Make transaction complete
                $model->transactionComplete();

                // Fill parameters variable to pass between gateway connection functions
                $parameters = [
                    'price' => $discountPrice,
                    'order_code' => $orderCode,
                    'backUrl' => base_url('payResult/' . array_search($gatewayTable, $this->paymentParamTable)),
                    'exportation' => FACTOR_EXPORTATION_TYPE_BUY,
                ];

                if ($hasLimited === true) {
                    return $parameters;
                }

                // Call one of the [_*_connection] functions
                $res = call_user_func_array($this->gatewayFunctions[$gatewayTable], $parameters);
                if (!$res) {
                    $model->delete_it(self::TBL_ORDER, 'order_code=:oc', ['oc' => $orderCode]);
                    return false;
                }
            } else {
                $param = '';
                if ($paymentMethod == PAYMENT_METHOD_WALLET) {
                    $param = self::PAYMENT_RESULT_PARAM_WALLET;
                    $account = $model->select_it(null, self::TBL_USER_ACCOUNT, ['account_balance'],
                        'user_id=:uId', ['uId' => $this->data['identity']->id]);
                    if (count($account)) {
                        $account = $account[0];
                        if ((int)$totalDiscountedAmount <= (int)$account['account_balance']) {
                            // Make transaction complete
                            $model->transactionComplete();
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } elseif ($paymentMethod == PAYMENT_METHOD_IN_PLACE) {
                    // Make transaction complete
                    $model->transactionComplete();
                    $param = self::PAYMENT_RESULT_PARAM_IN_PLACE;
                } elseif ($paymentMethod == PAYMENT_METHOD_RECEIPT) {
                    // Make transaction complete
                    $model->transactionComplete();
                    $param = self::PAYMENT_RESULT_PARAM_RECEIPT;
                }

                if (empty($param)) return false;

                $sessName = $param . '_session';
                $this->session->set($sessName, $orderCode);
                $this->redirect(base_url('payResult/' . $param), 'لطفا صبر کنید...در حال نهایی‌سازی ثبت سفارش', 1);
            }
            return true;
        }
    }

    // Gateway connection functions

    protected function _idpay_connection($parameters)
    {
        if (!$this->auth->isLoggedIn()) return false;
        //-----
        $this->load->library('HPayment/vendor/autoload');
        try {
            $model = new Model();
            $idpay = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_IDPAY, '2b4846e8-5fc3-4ef9-b7e8-905ccbb8c46f');
            //-----
            $redirectMessage = 'انتقال به درگاه پرداخت ...';
            $wait = 1;
            //-----
            $payRes = $idpay->create_request([
                'order_id' => $parameters['order_code'],
                'amount' => $parameters['price'] * 10,
                'callback' => $parameters['backUrl']])->get_result();
            // Handle result of payment gateway
            if ((!isset($payRes['error_code']) || $idpay->get_message($payRes['error_code'], Payment::PAYMENT_STATUS_REQUEST_IDPAY) === false) && isset($payRes['id']) && isset($payRes['link'])) {
                // Insert new payment in DB
                $res = $model->insert_it(self::PAYMENT_TABLE_IDPAY, [
                    'order_code' => $parameters['order_code'],
                    'user_id' => $this->data['identity']->id,
                    'price' => $parameters['price'],
                    'payment_id' => $payRes['id'],
                    'payment_link' => $payRes['link'],
                    'exportation_type' => $parameters['exportation'],
                ]);

                if ($res) {
                    // Delete cart items
                    $this->removeAllFromCartAction();

                    // Send user to idpay for transaction
                    $this->redirect($payRes['link'], $redirectMessage, $wait);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PaymentException $e) {
            return false;
        }
    }

    public function _mabna_connectionAction()
    {
        if (is_ajax() && !$this->auth->isLoggedIn()) {
            message(self::AJAX_TYPE_ERROR, 403, 'دسترسی غیر مجاز');
        }
        if (!is_ajax() && !$this->auth->isLoggedIn()) {
            $this->error->access_denied();
        }
        //-----
        $code = $_POST['paymentCode'] ?? '';
        if (empty($code) || !in_array($code, $this->gatewayTables[self::PAYMENT_TABLE_MABNA])) {
            message(self::AJAX_TYPE_ERROR, 200, 'پارامتر ارسال شده نامعتبر است!');
        }
        //-----
        $prevData = $this->session->get('shopping_page_session');
        $parameters = $this->_gateway_processor($prevData, $code, true);
        if ($parameters == false) {
            message(self::AJAX_TYPE_ERROR, 200, 'خطا در ثبت سفارش! لطفا مجددا تلاش نمایید.');
        }
        //-----
        $this->load->library('HPayment/vendor/autoload');
        try {
            $model = new Model();
            $mabna = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_MABNA);
            //-----
            $payRes = $mabna->get_token([
                'invoiceID' => $parameters['order_code'],
                'Amount' => $parameters['price'] * 10,
                'callbackURL' => $parameters['backUrl'],
                'terminalID' => '69005147'])->get_result();

            // Handle result of payment gateway
            if (isset($payRes['Status']) && isset($payRes['AccessToken']) && $payRes['Status'] == 0) {
                // Insert new payment in DB
                $res = $model->insert_it(self::PAYMENT_TABLE_MABNA, [
                    'order_code' => $parameters['order_code'],
                    'user_id' => $this->data['identity']->id,
                    'price' => $parameters['price'],
                    'exportation_type' => $parameters['exportation'],
                ]);
                // Required information
                $token = $payRes['AccessToken'];
                $terminal = '69005147';
                $url = $mabna->urls[PaymentMabna::PAYMENT_URL_PAYMENT_MABNA];

                if ($res) {
                    // Delete cart items
                    $this->removeAllFromCartAction();

                    // Send user to mabna for transaction
                    message(self::AJAX_TYPE_SUCCESS, 200, ['', $url, $terminal, $token]);
                } else {
                    message(self::AJAX_TYPE_ERROR, 200, 'مشکل در ایجاد ارتباط با درگاه بانک');
                }
            } else {
                message(self::AJAX_TYPE_ERROR, 200, 'مشکل در ایجاد ارتباط با درگاه بانک');
            }
        } catch (PaymentException $e) {
            message(self::AJAX_TYPE_ERROR, 200, 'مشکل در ایجاد ارتباط با درگاه بانک');
        }
    }

    protected function _zarinpal_connection($parameters)
    {
        if (!$this->auth->isLoggedIn()) return false;
        //-----
        $this->load->library('HPayment/vendor/autoload');
        try {
            $model = new Model();
            $zarinpal = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_ZARINPAL);
            //-----
            $redirectMessage = 'انتقال به درگاه پرداخت ...';
            $wait = 1;
            //-----
            $payRes = $zarinpal->create_request([
                'Amount' => $parameters['price'],
                'Description' => '',
                'CallbackURL' => base_url('paymentResult/' . self::PAYMENT_RESULT_PARAM_ZARINPAL)])->get_result();
            if ($payRes->Status == Payment::PAYMENT_STATUS_OK_ZARINPAL) {
                // Insert new payment in DB
                $res = $model->insert_it(self::PAYMENT_TABLE_ZARINPAL, [
                    'authority' => 'zarinpal-' . $payRes->Authority,
                    'order_code' => $parameters['order_code'],
                    'user_id' => $this->data['identity']->id,
                    'price' => $parameters['price'],
                    'exportation_type' => FACTOR_EXPORTATION_TYPE_BUY,
                ]);

                if ($res) {
                    // Send user to zarinpal for transaction
                    $this->redirect($zarinpal->urls[Payment::PAYMENT_URL_PAYMENT_ZARINPAL] . $payRes->Authority, $redirectMessage, $wait);
                    return true;
                } else {
//                    $error = 'عملیات انجام تراکنش با خطا روبرو شد! لطفا مجددا تلاش نمایید.';
                    return false;
                }
            } else {
                return false;
            }
        } catch (PaymentException $e) {
            return false;
        }
    }

    // Gateway get result functions

    protected function _idpay_result()
    {
        $this->load->library('HPayment/vendor/autoload');

        try {
            $model = new Model();
            $idpay = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_IDPAY, '2b4846e8-5fc3-4ef9-b7e8-905ccbb8c46f');
            $postVars = $idpay->handle_request()->get_result();

            // Check for factor first and If factor exists
            if (isset($postVars['order_id']) && isset($postVars['status']) &&
                $model->is_exist(self::TBL_ORDER, 'order_code=:oc', ['oc' => $postVars['order_id']])) {
                // Set order_code to global data
                $this->data['order_code'] = $postVars['order_id'];
                // Select order
                $order = $model->select_it(null, self::TBL_ORDER, [
                    'order_code', 'final_price', 'payment_status'
                ], 'order_code=:oc', ['oc' => $postVars['order_id']])[0];
                // Select order payment according to gateway id result
                $orderPayment = $model->select_it(null, self::PAYMENT_TABLE_IDPAY, [
                    'payment_id', 'status'
                ], 'order_code=:oc AND payment_id=:pId', ['oc' => $postVars['order_id'], 'pId' => $postVars['id']]);
                // If there is a record in gateway table(only one record is acceptable)
                if (count($orderPayment) == 1) {
                    // Select order payment
                    $orderPayment = $orderPayment[0];
                    // Check if factor was advice before
                    if ($order['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED &&
                        !in_array($orderPayment['status'], [Payment::PAYMENT_STATUS_OK_IDPAY, Payment::PAYMENT_STATUS_DUPLICATE_IDPAY]) &&
                        $postVars['status'] == Payment::PAYMENT_STATUS_WAIT_IDPAY) {
                        // Check for returned amount
                        if ((intval($order['final_price']) * 10) == $postVars['amount']) {
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
                                    // Transaction
                                    $model->transactionBegin();
                                    // Store extra info from bank's gateway result
                                    $res1 = $model->update_it(self::TBL_ORDER, [
                                        'payment_status' => OWN_PAYMENT_STATUS_SUCCESSFUL
                                    ], 'order_code=:oc', ['oc' => $order['order_code']]);
                                    $res2 = $model->update_it(self::PAYMENT_TABLE_IDPAY, [
                                        'payment_code' => $advice['payment']['track_id'],
                                        'status' => $status,
                                    ], 'order_code=:oc', ['oc' => $order['order_code']]);
                                    $success = $idpay->get_message($status, Payment::PAYMENT_STATUS_VERIFY_IDPAY);
                                    $traceNumber = $advice['payment']['track_id'];

                                    $this->data['ref_id'] = $traceNumber;
                                    $this->data['have_ref_id'] = true;
                                    if ($res1 && $res2) {
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
                                                $body = $this->setting['sms']['activationCodeMsg'];
                                                $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['identity']->mobile, $body);
                                                $body = str_replace(SMS_REPLACEMENT_CHARS['orderCode'], $order['order_code'], $body);
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
                } else {
                    $this->data['error'] = 'فاکتور نامعتبر است!';
                    $this->data['is_success'] = false;
                    $this->data['ref_id'] = $postVars['track_id'];
                    $this->data['have_ref_id'] = true;
                }

                // Store current result from bank gateway
                if (!isset($status)) {
                    $updateColumns = [
                        'payment_status' => OWN_PAYMENT_STATUS_FAILED,
                        'payment_date' => $postVars['date'],
                    ];
                } else {
                    $updateColumns = [
                        'payment_date' => $postVars['date'],
                    ];
                }
                $model->update_it(self::TBL_ORDER, $updateColumns, 'order_code=:oc', ['oc' => $order['order_code']]);
                $model->update_it(self::PAYMENT_TABLE_IDPAY, [
                    'status' => isset($status) ? $status : $postVars['status'],
                    'track_id' => $postVars['track_id'],
                    'msg' => isset($status) ? $idpay->get_message($status, Payment::PAYMENT_STATUS_VERIFY_IDPAY) : $idpay->get_message($postVars['status'], Payment::PAYMENT_STATUS_VERIFY_IDPAY),
                    'mask_card_number' => $postVars['card_no'],
                    'payment_date' => time(),
                ], 'order_code=:oc', ['oc' => $order['order_code']]);

                // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                if (isset($success)) {
                    $model->delete_it(self::TBL_ORDER_RESERVED, 'order_code=:oc', ['oc' => $order['order_code']]);
                }
            } else {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } catch (PaymentException $e) {
            die($e);
        }
    }

    protected function _mabna_result()
    {
        $this->load->library('HPayment/vendor/autoload');

        try {
            $model = new Model();
            $mabna = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_MABNA);
            $postVars = $mabna->handle_request()->get_result();
            $terminal = '69005147';

            // Check for factor first and If factor exists
            if (isset($postVars['respcode']) && isset($postVars['respmsg']) && isset($postVars['amount']) &&
                isset($postVars['payload']) && isset($postVars['terminalid']) && isset($postVars['tracenumber']) &&
                isset($postVars['rrn']) && isset($postVars['datePaid']) && isset($postVars['digitalreceipt']) &&
                isset($postVars['datePaid']) && isset($postVars['issuerbank']) && isset($postVars['payid']) &&
                isset($postVars['cardnumber']) && isset($postVars['invoiceid']) &&
                $postVars['respcode'] == 0 && $postVars['terminalid'] == $terminal &&
                $model->is_exist(self::TBL_ORDER, 'order_code=:oc', ['oc' => $postVars['invoiceid']]) &&
                !$model->is_exist(self::PAYMENT_TABLE_MABNA, 'digitalreceipt=:dr', ['dr' => $postVars['digitalreceipt']])) {
                // Set order_code to global data
                $this->data['order_code'] = $postVars['invoiceid'];
                // Select order
                $order = $model->select_it(null, self::TBL_ORDER, [
                    'order_code', 'final_price', 'payment_status'
                ], 'order_code=:oc', ['oc' => $postVars['invoiceid']])[0];
                // Select order payment according to gateway id result
                $orderPayment = $model->select_it(null, self::PAYMENT_TABLE_MABNA, [
                    'status'
                ], 'order_code=:oc', ['oc' => $postVars['order_id']]);
                // If there is a record in gateway table(only one record is acceptable)
                if (count($orderPayment) == 1) {
                    // Select order payment
                    $orderPayment = $orderPayment[0];
                    // Check if factor was advice before
                    if ($order['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED &&
                        !in_array($orderPayment['status'], [Payment::PAYMENT_STATUS_OK_MABNA, Payment::PAYMENT_STATUS_DUPLICATE_MABNA])) {
                        // Check for returned amount
                        if ((intval($order['final_price']) * 10) == $postVars['amount']) {
                            // If all are ok send advice to bank gateway
                            // This means ready to transfer money to our bank account
                            $advice = $mabna->send_advice([
                                'digitalreceipt' => $postVars['digitalreceipt'],
                                'Tid' => $terminal,
                            ]);

                            // Check for error
                            if (isset($advice['Status']) &&
                                ($advice['Status'] == Payment::PAYMENT_ADVICE_OK_MABNA || $advice['Status'] == Payment::PAYMENT_ADVICE_DUPLICATE_MABNA)) {
                                $status = $advice['Status'];

                                // Check for status if it's just OK/100 [100 => OK, 101 => Duplicate, etc.]
                                if ($status == Payment::PAYMENT_ADVICE_OK_MABNA) {
                                    if ($advice['ReturnId'] == (intval($order['final_price']) * 10)) {
                                        // Transaction
                                        $model->transactionBegin();
                                        // Store extra info from bank's gateway result
                                        $res1 = $model->update_it(self::TBL_ORDER, [
                                            'payment_status' => OWN_PAYMENT_STATUS_SUCCESSFUL
                                        ], 'order_code=:oc', ['oc' => $order['order_code']]);
                                        $res2 = $model->update_it(self::PAYMENT_TABLE_MABNA, [
                                            'payment_code' => $postVars['tracenumber'] ?: '',
                                            'status' => $status,
                                        ], 'order_code=:oc', ['oc' => $order['order_code']]);
                                        $success = $advice['Message'];
                                        $traceNumber = $postVars['tracenumber'];

                                        $this->data['ref_id'] = $traceNumber;
                                        $this->data['have_ref_id'] = true;
                                        if ($res1 && $res2) {
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
                                                    $body = $this->setting['sms']['activationCodeMsg'];
                                                    $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['identity']->mobile, $body);
                                                    $body = str_replace(SMS_REPLACEMENT_CHARS['orderCode'], $order['order_code'], $body);
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
                                    } else {
                                        $this->data['error'] = $mabna->get_message($advice['ReturnId'], Payment::PAYMENT_STATUS_VERIFY_MABNA);
                                        $this->data['is_success'] = false;
                                        $this->data['ref_id'] = $postVars['tracenumber'] ?: $postVars['payid'];
                                        $this->data['have_ref_id'] = true;
                                    }
                                }
                            } else {
                                $this->data['error'] = $mabna->get_message($advice['ReturnId'], Payment::PAYMENT_STATUS_VERIFY_MABNA);
                                $this->data['is_success'] = false;
                                $this->data['ref_id'] = $postVars['tracenumber'] ?: $postVars['payid'];
                                $this->data['have_ref_id'] = true;
                            }
                        } else {
                            $this->data['error'] = 'فاکتور نامعتبر است!';
                            $this->data['is_success'] = false;
                            $this->data['ref_id'] = $postVars['tracenumber'] ?: $postVars['payid'];
                            $this->data['have_ref_id'] = true;
                        }
                    } else {
                        $this->data['error'] = 'فاکتور نامعتبر است!';
                        $this->data['is_success'] = false;
                        $this->data['ref_id'] = $postVars['tracenumber'] ?: $postVars['payid'];
                        $this->data['have_ref_id'] = true;
                    }
                } else {
                    $this->data['error'] = 'فاکتور نامعتبر است!';
                    $this->data['is_success'] = false;
                    $this->data['ref_id'] = $postVars['tracenumber'] ?: $postVars['payid'];
                    $this->data['have_ref_id'] = true;
                }

                // Store current result from bank gateway
                if (!isset($status)) {
                    $updateColumns = [
                        'payment_status' => OWN_PAYMENT_STATUS_FAILED,
                        'payment_date' => is_numeric($postVars['datePaid']) ? $postVars['datePaid'] : time(),
                    ];
                } else {
                    $updateColumns = [
                        'payment_date' => is_numeric($postVars['datePaid']) ? $postVars['datePaid'] : time(),
                    ];
                }
                $model->update_it(self::TBL_ORDER, $updateColumns, 'order_code=:oc', ['oc' => $order['order_code']]);
                $model->update_it(self::PAYMENT_TABLE_MABNA, [
                    'status' => isset($status) ? $status : $postVars['respcode'],
                    'payment_id' => $postVars['payid'],
                    'digitalreceipt' => $postVars['digitalreceipt'],
                    'rrn' => $postVars['rrn'] ?: '',
                    'msg' => isset($status) ? $advice['Message'] : $postVars['respmsg'],
                    'bank_name' => $postVars['issuerbank'],
                    'mask_card_number' => $postVars['cardnumber'],
                    'payment_date' => time(),
                ], 'order_code=:oc', ['oc' => $order['order_code']]);

                // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                if (isset($success)) {
                    $model->delete_it(self::TBL_ORDER_RESERVED, 'order_code=:oc', ['oc' => $order['order_code']]);
                }
            } else {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } catch (PaymentException $e) {
            die($e);
        }
    }

    protected function _zarinpal_result()
    {
        $this->load->library('HPayment/vendor/autoload');

        try {
            $model = new Model();
            $zarinpal = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_ZARINPAL);
            $getVars = $zarinpal->handle_request()->get_result();
            if (!isset($getVars[Payment::PAYMENT_RETURNED_AUTHORITY_ZARINPAL]) || !isset($getVars[Payment::PAYMENT_RETURNED_STATUS_ZARINPAL])) {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
                return;
            }

            $authority = $getVars[Payment::PAYMENT_RETURNED_AUTHORITY_ZARINPAL];
            // Get payment with current authority
            $curPay = $model->select_it(null, self::PAYMENT_TABLE_ZARINPAL, '*',
                'authority=:auth', ['auth' => 'zarinpal-' . $authority]);

            if (count($curPay)) {
                $curPay = $curPay[0];
                $curFactor = $model->select_it(null, self::TBL_ORDER, '*',
                    'user_id=:uId AND order_code=:oc', ['uId' => $curPay['user_id'], 'oc' => $curPay['order_code']]);
                if (count($curFactor)) {
                    $curFactor = $curFactor[0];
                    // Set order_code to global data
                    $this->data['order_code'] = $curPay['order_code'];
                    if ($curPay['status'] != Payment::PAYMENT_TRANSACTION_SUCCESS_ZARINPAL) {
                        $res = $zarinpal->verify_request($curPay['amount']);
                        if (intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_SUCCESS_ZARINPAL || // Successful transaction
                            intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_DUPLICATE_ZARINPAL) { // Duplicated transaction
                            $this->data['is_success'] = true;
                            $this->data['have_ref_id'] = true;

                            if (intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_SUCCESS_ZARINPAL) {
                                $this->data['ref_id'] = $res->RefID;

                                $model->transactionBegin();
                                // Update payment status and refID for success
                                $res1 = $model->update_it(self::PAYMENT_TABLE_ZARINPAL, [
                                    'payment_code' => $this->data['ref_id'],
                                    'status' => $zarinpal->status,
                                    'payment_date' => time(),
                                ], 'authority=:auth', ['auth' => 'zarinpal-' . $authority]);
                                $res2 = $model->update_it(self::TBL_ORDER, [
                                    'payment_status' => OWN_PAYMENT_STATUS_SUCCESSFUL,
                                    'payment_date' => time(),
                                ], 'order_code=:oc', ['oc' => $curPay['order_code']]);
                                if ($res1 && $res2) {
                                    $model->transactionComplete();
                                } else {
                                    $model->transactionRollback();
                                    $this->data['error'] = 'عملیات پرداخت انجام شد. خطا در ثبت تراکنش، با پشتیبانی جهت ثبت تراکنش تماس حاصل فرمایید.';
                                    $this->data['is_success'] = false;
                                }
                            }
                        } else if (intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_CANCELED_ZARINPAL) { // Transaction was canceled
                            $this->data['is_success'] = false;
                            $this->data['have_ref_id'] = false;
                            $this->data['error'] = $res;
                        } else { // Failed transaction
                            $this->data['is_success'] = false;
                            $this->data['have_ref_id'] = true;
                            $this->data['ref_id'] = $res->RefID;

                            // Update payment status and refID for fail
                            $model->update_it(self::PAYMENT_TABLE_ZARINPAL, [
                                'payment_code' => $this->data['ref_id'],
                                'status' => $zarinpal->status,
                                'payment_date' => time(),
                            ], 'authority=:auth', ['auth' => 'zarinpal-' . $authority]);
                            $model->update_it(self::TBL_ORDER, [
                                'payment_status' => OWN_PAYMENT_STATUS_FAILED,
                                'payment_date' => time(),
                            ],
                                'order_code=:oc', ['oc' => $curPay['order_code']]);
                            $this->data['error'] = $zarinpal->get_message($zarinpal->status);
                        }

                        // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                        if ($this->data['is_success']) {
                            $model->delete_it(self::TBL_ORDER_RESERVED, 'order_code=:oc', ['oc' => $curPay['order_code']]);
                        }
                    } else {
                        $this->data['is_success'] = true;
                        $this->data['have_ref_id'] = true;
                        $this->data['ref_id'] = $curPay['payment_code'];
                    }
                } else {
                    $this->data['error'] = 'تراکنش نامعتبر است!';
                    $this->data['is_success'] = false;
                    $this->data['have_ref_id'] = false;
                }
            } else {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } catch (PaymentException $e) {
            die($e);
        }
    }

    protected function _wallet_result()
    {
        $sessName = self::PAYMENT_RESULT_PARAM_WALLET . '_session';
        $theSess = $this->session->get($sessName);
        $model = new Model();
        $this->data['have_ref_id'] = false;
        if (!empty($theSess)) {
            $orderCode = $theSess;

            if ($model->is_exist(self::TBL_ORDER, 'order_code=:oc', ['oc' => $orderCode])) {
                $account = $model->select_it(null, self::TBL_USER_ACCOUNT, ['account_balance'],
                    'user_id=:uId', ['uId' => $this->data['identity']->id]);
                if (count($account)) {
                    $account = $account[0];
                    $orderPrice = $model->select_it(null, self::TBL_ORDER, ['final_price'],
                        'order_code=:oc', ['oc' => $orderCode])[0];
                    if ((int)$orderPrice['final_price'] <= (int)$account['account_balance']) {
                        $model->transactionBegin();
                        //-----
                        $res = $model->update_it(self::TBL_ORDER, [
                            'payment_status' => OWN_PAYMENT_STATUS_SUCCESSFUL,
                            'payment_date' => time(),
                        ], 'order_code=:oc', ['oc' => $orderCode]);
                        $res2 = $model->update_it(self::TBL_USER_ACCOUNT, [],
                            'user_id=:uId', ['uId' => $this->data['identity']->id], [
                                'account_balance' => 'account_balance-' . (int)$orderPrice['final_price'],
                            ]);
                        $res3 = $model->insert_it(self::TBL_USER_ACCOUNT_BUY, [
                            'order_code' => $orderCode,
                            'user_id' => $this->data['identity']->id,
                            'price' => (int)$orderPrice['final_price'],
                            'payment_date' => time(),
                        ]);
                        //-----
                        if ($res && $res2 && $res3) {
                            $model->transactionComplete();
                            //-----
                            $this->data['order_code'] = $orderCode;
                            $this->data['is_success'] = true;

                            // Delete cart items
                            $this->removeAllFromCartAction();
                            // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                            $model->delete_it(self::TBL_ORDER_RESERVED, 'order_code=:oc', ['oc' => $orderCode]);
                        } else {
                            $model->transactionRollback();
                            //-----
                            $this->data['error'] = 'عملیات با خطا مواجه شد! لطفا مجددا تلاش نمایید.';
                            $this->data['is_success'] = false;
                        }
                    } else {
                        $this->data['error'] = 'موجودی کیف پول شما کافی نیست.';
                        $this->data['is_success'] = false;
                    }
                } else {
                    $this->data['error'] = 'کیف پول برای این حساب کاربری فعال نمی‌باشد.';
                    $this->data['is_success'] = false;
                }
            } else {
                $this->data['error'] = 'فاکتور نامعتبر است!';
                $this->data['is_success'] = false;
            }
        } else {
            $this->data['error'] = 'ورودی نامعتبر است!';
            $this->data['is_success'] = false;
        }
        //-----
        $this->session->remove($sessName);
    }

    protected function _in_place_result()
    {
        $sessName = self::PAYMENT_RESULT_PARAM_IN_PLACE . '_session';
        $theSess = $this->session->get($sessName);
        $model = new Model();
        $this->data['have_ref_id'] = false;
        if (!empty($theSess)) {
            $orderCode = $theSess;

            if ($model->is_exist(self::TBL_ORDER, 'order_code=:oc', ['oc' => $orderCode])) {
                $model->transactionBegin();
                //-----
                $res = $model->update_it(self::TBL_ORDER, [
                    'payment_status' => OWN_PAYMENT_STATUS_WAIT,
                    'payment_date' => time(),
                ], 'order_code=:oc', ['oc' => $orderCode]);

                if ($res) {
                    $model->transactionComplete();
                    //-----
                    $this->data['order_code'] = $orderCode;
                    $this->data['is_success'] = true;

                    // Delete cart items
                    $this->removeAllFromCartAction();
                    // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                    $model->delete_it(self::TBL_ORDER_RESERVED, 'order_code=:oc', ['oc' => $orderCode]);
                } else {
                    $model->transactionRollback();
                    //-----
                    $this->data['error'] = 'عملیات با خطا مواجه شد! لطفا مجددا تلاش نمایید.';
                    $this->data['is_success'] = false;
                }
            } else {
                $this->data['error'] = 'فاکتور نامعتبر است!';
                $this->data['is_success'] = false;
            }
        } else {
            $this->data['error'] = 'ورودی نامعتبر است!';
            $this->data['is_success'] = false;
        }
        //-----
        $this->session->remove($sessName);
    }

    protected function _receipt_result()
    {
        $sessName = self::PAYMENT_RESULT_PARAM_RECEIPT . '_session';
        $theSess = $this->session->get($sessName);
        $model = new Model();
        $this->data['have_ref_id'] = false;
        if (!empty($theSess)) {
            $orderCode = $theSess;

            if ($model->is_exist(self::TBL_ORDER, 'order_code=:oc', ['oc' => $orderCode])) {
                $model->transactionBegin();
                //-----
                $res = $model->update_it(self::TBL_ORDER, [
                    'payment_status' => OWN_PAYMENT_STATUS_WAIT_VERIFY,
                    'payment_date' => time(),
                ], 'order_code=:oc', ['oc' => $orderCode]);

                if ($res) {
                    $model->transactionComplete();
                    //-----
                    $this->data['order_code'] = $orderCode;
                    $this->data['is_success'] = true;

                    // Delete cart items
                    $this->removeAllFromCartAction();
                    // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                    $model->delete_it(self::TBL_ORDER_RESERVED, 'order_code=:oc', ['oc' => $orderCode]);
                } else {
                    $model->transactionRollback();
                    //-----
                    $this->data['error'] = 'عملیات با خطا مواجه شد! لطفا مجددا تلاش نمایید.';
                    $this->data['is_success'] = false;
                }
            } else {
                $this->data['error'] = 'فاکتور نامعتبر است!';
                $this->data['is_success'] = false;
            }
        } else {
            $this->data['error'] = 'ورودی نامعتبر است!';
            $this->data['is_success'] = false;
        }
        //-----
        $this->session->remove($sessName);
    }

    //-----

    protected function _cancel_reserved_items()
    {
        // Remove not payed items from reserved factors and return item(s) count to stock
        $model = new Model();
        $orderModel = new \OrderModel();
        $reservedTime = time() - OWN_WAIT_TIME;
        $previouslyReserved = $model->select_it(null, self::TBL_ORDER_RESERVED, '*', 'expire_time<=:et', ['et' => $reservedTime]);
        if (count($previouslyReserved)) {
            foreach ($previouslyReserved as $reserved) {
                $orderStatus = $model->select_it(null, self::TBL_ORDER, 'payment_status', 'order_code=:oc', ['oc' => $reserved['order_code']]);
                $items = $model->select_it(null, self::TBL_ORDER_ITEM, ['product_id', 'product_count'], 'order_code=:oc', ['oc' => $reserved['order_code']]);
                foreach ($items as $k => $item) {
                    try {
                        $res = $model->update_it(self::TBL_PRODUCT, [], 'id=:id', ['id' => $item['product_id']], [
                            'stock_count' => 'stock_count+' . (int)$item['product_count'],
                            'sold_count' => 'sold_count-' . (int)$item['product_count'],
                        ]);
                    } catch (Exception $e) {
                    }
                }
                if (count($orderStatus) && $orderStatus[0]['payment_status'] == OWN_PAYMENT_STATUS_WAIT) {
                    $model->update_it(self::TBL_ORDER, [
                        'payment_status' => OWN_PAYMENT_STATUS_FAILED,
                        'send_status' => $orderModel->getStatusId(SEND_STATUS_CANCELED),
                    ], 'order_code=:oc', ['oc' => $reserved['order_code']]);
                } else if ($orderStatus[0]['payment_status'] == OWN_PAYMENT_STATUS_FAILED) {
                    $model->update_it(self::TBL_ORDER, [
                        'send_status' => $orderModel->getStatusId(SEND_STATUS_CANCELED),
                    ], 'order_code=:oc', ['oc' => $reserved['order_code']]);
                }
            }
            $model->delete_it(self::TBL_ORDER_RESERVED, 'expire_time<=:et', ['et' => $reservedTime]);
        }
        //-----
    }

    //-----

    protected function _view_count($table, $id)
    {
        $model = new Model();
        $cookieModel = new CookieModel();
        $name = $table == self::TBL_PRODUCT ? 'product' : ($table == self::TBL_BLOG ? 'blog' : 'default');
        $cookieName = 'view-' . $name . '-' . $id;
        if ($cookieModel->is_cookie_set($cookieName)) {
            $prevCookie = $cookieModel->is_cookie_set($cookieName, true, true);
            $prevCookie = stripslashes($prevCookie);
            $prevCookie = json_decode($prevCookie, true);
            if ($prevCookie == get_client_ip_server()) {
                return;
            };
        }
        //-----
        $cookieModel->set_cookie($cookieName, json_encode(get_client_ip_server()),
            time() + 30 * 24 * 60 * 60, '/', null, null, true, \CookieModel::COOKIE_ENCRYPT_DECRYPT);
        //-----
        $model->update_it($table, [], 'id=:id', ['id' => $id], [
            'view_count' => 'view_count+1'
        ]);
    }

    //-----

    protected function _shared()
    {
        $this->data['flash_message'] = $this->session->getFlash($this->messageSession);
    }

    //-----

    protected function _render_page($pages, $loadHeaderAndFooter = true)
    {
        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/home-header-part', $this->data);
        }

        $allPages = is_string($pages) ? [$pages] : (is_array($pages) ? $pages : []);
        foreach ($allPages as $page) {
            $this->load->view($page, $this->data);
        }

        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/home-js-part', $this->data);
            $this->load->view('templates/fe/home-end-part', $this->data);
        }
    }
}