<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use Home\AbstractController\AbstractController;
use HForm\Form;


include_once 'AbstractController.class.php';

class HomeController extends AbstractController
{
    public function indexAction()
    {
        $this->_shared();

        $model = new Model();


        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'صفحه اصلی');

        $this->_render_page([
            'pages/fe/index',
        ]);
    }

    public function pagesAction($param)
    {
        $model = new Model();

        if (!isset($param[0]) || !$model->is_exist('static_pages', 'url_name=:url', ['url' => $param[0]])) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'صفحه درخواست شده وجود ندارد!',
            ]);
            $this->redirect(base_url('index'));
        }
        //-----
        $this->data['param'] = $param;
        $this->data['page'] = $model->select_it(null, 'static_pages', ['title', 'body'], 'url_name=:url', ['url' => $param[0]])[0];
        //-----

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), $this->data['page']['title'] ?? '');

        $this->_render_page('pages/fe/page-static');
    }

    public function faqAction()
    {
        $model = new Model();
        $this->data['faq'] = $model->select_it(null, 'faq');

        if (!count($this->data['faq'])) {
            $this->error->show_404();
        }

        $this->data['page_image'] = $this->setting['pages']['faq']['topImage'] ?? '';
        $this->data['page_title'] = 'سؤالات متداول پرسیده شده';
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سؤالات متداول');

        $this->_render_page([
            'pages/fe/faq',
        ]);
    }

    public function contactUsAction()
    {
        $this->_shared();
        $this->_contactSubmit();

        $this->data['page_image'] = $this->setting['pages']['contactUs']['topImage'] ?? '';
        $this->data['page_title'] = 'تماس با ما';
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'تماس با ما');

        $this->_render_page([
            'pages/fe/contact',
        ]);
    }

    public function complaintAction()
    {
        $this->_shared();
        $this->_complaintSubmit();

        $this->data['page_image'] = $this->setting['pages']['complaint']['topImage'] ?? '';
        $this->data['page_title'] = 'ثبت شکایت';
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ثبت شکایت');

        $this->_render_page([
            'pages/fe/complaint',
        ]);
    }

    public function comingSoonAction()
    {
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'به زودی');

        $this->load->view('templates/fe/coming-soon');
    }

    //-----

    protected function _contactSubmit()
    {
        //-----
        $model = new Model();
        $this->data['contactErrors'] = [];
        $this->data['contactValues'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_contact'] = $form->csrfToken('contactForm');
        $form->setFieldsName([
            'title', 'first_name', 'last_name', 'mobile', 'email', 'body', 'contactCaptcha',
        ])->setMethod('post');
        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['title', 'first_name', 'mobile', 'body', 'contactCaptcha'], 'فیلدهای اجباری را خالی نگذارید.');
                $form->validatePersianName('name', 'نام باید حروف فارسی باشد.')
                    ->validate('numeric', 'mobile', 'شماره باید از نوع عدد باشد.')
                    ->validatePersianMobile('mobile');

                $config = getConfig('config');
                if (!isset($config['captcha_session_name']) ||
                    !isset($_SESSION[$config['captcha_session_name']][$param['captcha']]) ||
                    !isset($param['captcha']) ||
                    encryption_decryption(ED_DECRYPT, $_SESSION[$config['captcha_session_name']][ACTION]) != strtolower($values['contactCaptcha'])) {
                    $form->setError('کد وارد شده با کد تصویر مغایرت دارد. دوباره تلاش کنید.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_CONTACT_US, [
                    'user_code' => $this->auth->isLoggedIn() ? $this->data['identity']->user_code : null,
                    'first_name' => trim($values['first_name']),
                    'last_name' => trim($values['last_name']),
                    'mobile' => trim($values['mobile']),
                    'email' => trim($values['email']),
                    'body' => trim($values['body']),
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
                $this->data['contactSuccess'] = 'پیام شما با موفقیت ارسال شد.';
            } else {
                $this->data['contactErrors'] = $form->getError();
                $this->data['contactValues'] = $form->getValues();
            }
        }
    }

    protected function _complaintSubmit()
    {
        //-----
        $model = new Model();
        $this->data['complaintErrors'] = [];
        $this->data['complaintValues'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_complaint'] = $form->csrfToken('complaintForm');
        $form->setFieldsName([
            'title', 'first_name', 'last_name', 'mobile', 'email', 'body', 'complaintCaptcha',
        ])->setMethod('post');
        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['title', 'first_name', 'mobile', 'body', 'complaintCaptcha'], 'فیلدهای اجباری را خالی نگذارید.');
                $form->validatePersianName('name', 'نام باید حروف فارسی باشد.')
                    ->validate('numeric', 'mobile', 'شماره باید از نوع عدد باشد.')
                    ->validatePersianMobile('mobile');

                $config = getConfig('config');
                if (!isset($config['captcha_session_name']) ||
                    !isset($_SESSION[$config['captcha_session_name']][$param['captcha']]) ||
                    !isset($param['captcha']) ||
                    encryption_decryption(ED_DECRYPT, $_SESSION[$config['captcha_session_name']][ACTION]) != strtolower($values['complaintCaptcha'])) {
                    $form->setError('کد وارد شده با کد تصویر مغایرت دارد. دوباره تلاش کنید.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_COMPLAINT, [
                    'first_name' => trim($values['first_name']),
                    'last_name' => trim($values['last_name']),
                    'mobile' => trim($values['mobile']),
                    'email' => trim($values['email']),
                    'body' => trim($values['body']),
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
                $this->data['complaintSuccess'] = 'پیام شما با موفقیت ارسال شد.';
            } else {
                $this->data['complaintErrors'] = $form->getError();
                $this->data['complaintValues'] = $form->getValues();
            }
        }
    }
}