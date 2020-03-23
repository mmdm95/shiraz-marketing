<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HForm\Form;
use Home\AbstractController\AbstractController;


include_once 'AbstractController.class.php';

class HomeController extends AbstractController
{
    public function indexAction()
    {
        $model = new Model();

        // Newsletter submission
        $this->_newsletter();

        // Register & Login actions
        $this->_register(['captcha' => ACTION]);
        $this->_login(['captcha' => ACTION]);

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'صفحه اصلی');

        $this->_render_page([
            'pages/fe/index',
        ]);
    }

    public function shoppingAction()
    {
        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'اطلاعات ارسال');

        // Extra js
//        $this->data['js'][] = $this->asset->script('fe/js/checkoutJs.js');

        $this->_render_page(['pages/fe/shopping']);
    }

    public function prepareToPayAction()
    {
        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'آماده پرداخت');

        // Extra js
//        $this->data['js'][] = $this->asset->script('fe/js/checkoutJs.js');

        $this->_render_page(['pages/fe/payment']);
    }

    public function payResultAction()
    {
        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'نتیجه تراکنش');

        // Extra js
//        $this->data['js'][] = $this->asset->script('fe/js/checkoutJs.js');

        $this->_render_page(['pages/fe/pay-result']);
    }

    public function pagesAction($param)
    {
//        $model = new Model();
//
//        if(!isset($param[0]) || !$model->is_exist('static_pages', 'url_name=:url', ['url' => $param[0]])) {
//            $_SESSION['home-static-page'] = 'صفحه درخواست شده وجود ندارد!';
//            $this->redirect(base_url('index'));
//        }
        //-----
//        $this->data['param'] = $param;
//        $this->data['page'] = $model->select_it(null, 'static_pages', ['title', 'body'], 'url_name=:url', ['url' => $param[0]])[0];
        //-----

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), $this->data['page']['title'] ?? '');

        $this->_render_page('pages/fe/page-static');
    }

    public function faqAction()
    {
//        $model = new Model();
//        $this->data['faq'] = $model->select_it(null, 'faq');

        $this->data['page_image'] = 'fe/images/tmp/pagesHeader.jpg';
        $this->data['page_title'] = 'سؤالات متداول پرسیده شده';
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سؤالات متداول');

        $this->_render_page([
            'pages/fe/faq',
        ]);
    }

    public function contactUsAction()
    {
//        $this->_contactSubmit();

        $this->data['page_image'] = 'fe/images/tmp/pagesHeader.jpg';
        $this->data['page_title'] = 'تماس با ما';
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'تماس با ما');

        $this->_render_page([
            'pages/fe/contact',
        ]);
    }

    public function complaintAction()
    {
//        $this->_contactSubmit();

        $this->data['page_image'] = 'fe/images/tmp/pagesHeader.jpg';
        $this->data['page_title'] = 'ثبت شکایت';
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ثبت شکایت');

        $this->_render_page([
            'pages/fe/complaint',
        ]);
    }

    public function comingSoonAction()
    {
        $this->load->view('templates/fe/coming-soon');
    }

    protected function _contactSubmit()
    {
        //-----
        $model = new Model();
        $this->data['contactErrors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_contact'] = $form->csrfToken('contactForm');
        $form->setFieldsName([
            'subject', 'name', 'mobile', 'message',
        ])->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($model, $form) {
                $form->isRequired(['subject', 'name', 'phone', 'message'], 'تمام فیلدها اجباری هستند.');
                $form->validatePersianName('name', 'نام باید حروف فارسی باشد.')
                    ->validate('numeric', 'phone', 'شماره باید از نوع عدد باشد.');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it('contact_us', [
                    'full_name' => trim($values['name']),
                    'phone' => trim($values['phone']),
                    'subject' => trim($values['subject']),
                    'body' => trim($values['message']),
                    'status' => 0,
                    'sent_at' => time(),
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
                $this->data['contactSuccess'] = 'پیام با موفقیت ارسال شد.';
            } else {
                $this->data['contactErrors'] = $form->getError();
            }
        }
    }

    protected function _newsletter()
    {
        $model = new Model();
        $this->data['newsletterErrors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_newsletter']  = $form->csrfToken('addNewletter');
        $form->setFieldsName(['newsletter-mobile'])->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($model, $form) {
                $form->isRequired(['newsletter-mobile'], 'فیلد موبایل اجباری می‌باشد.')
                    ->validatePersianMobile('newsletter-mobile');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = true;
                if (!$model->is_exist('newsletters', 'mobile=:mobile', ['mobile' => $values['newsletter-mobile']])) {
                    $res = $model->insert_it('newsletters', [
                        'mobile' => trim($values['newsletter-mobile']),
                    ]);
                }

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
                $this->data['newsletterSuccess'] = 'موبایل شما با موفقیت ثبت شد.';
            } else {
                $this->data['newsletterErrors'] = $form->getError();
            }
        }
    }
}