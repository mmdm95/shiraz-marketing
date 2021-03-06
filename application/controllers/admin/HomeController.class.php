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

class HomeController extends AbstractController
{
    public function indexAction()
    {
        if (!$this->auth->isLoggedIn()) {
            $this->redirect(base_url('admin/login'));
        }
        $this->data['todayDate'] = jDateTime::date('l d F Y') . ' - ' . date('d F');

        $model = new Model();
        $userModel = new UserModel();
        $orderModel = new OrderModel();

        $this->data['unreadContacts'] = $model->it_count(self::TBL_CONTACT_US, 'status=:status', ['status' => 0]);
        //-----
        $this->data['staticPageCount'] = $model->it_count(self::TBL_STATIC_PAGES);
        $this->data['categoryCount'] = $model->it_count(self::TBL_STATIC_PAGES);
        //-----
        $this->data['userAllCount'] = $userModel->getUsersCount('r.id NOT IN (:r1,:r2)', ['r1' => AUTH_ROLE_SUPER_USER, 'r2' => AUTH_ROLE_ADMIN]);
        $this->data['userCount'] = $userModel->getUsersCount('r.id=:role', ['role' => AUTH_ROLE_USER]);
        $this->data['marketerCount'] = $userModel->getUsersCount('r.id=:role', ['role' => AUTH_ROLE_MARKETER]);
        $this->data['adminUserCount'] = $userModel->getUsersCount('r.id IN (:r1, :r2, :r3, :r4)', ['r1' => AUTH_ROLE_WRITER, 'r2' => AUTH_ROLE_PRODUCT_ADMIN, 'r3' => AUTH_ROLE_USER_ADMIN, 'r4' => AUTH_ROLE_ORDER_ADMIN]);
        $this->data['userAllDeactiveCount'] = $userModel->getUsersCount('r.id!=:role AND r.id IN (:role1,:role2) AND u.active=:active',
            ['role' => AUTH_ROLE_SUPER_USER, 'role1' => AUTH_ROLE_USER, 'role2' => AUTH_ROLE_MARKETER, 'active' => 0]);
        //-----
        $this->data['productCount'] = $model->it_count(self::TBL_PRODUCT, 'product_type=:pt', ['pt' => PRODUCT_TYPE_ITEM]);
        $this->data['serviceCount'] = $model->it_count(self::TBL_PRODUCT, 'product_type=:pt', ['pt' => PRODUCT_TYPE_SERVICE]);
        //-----
        $this->data['status'] = $model->select_it(null, self::TBL_SEND_STATUS, [
            'id', 'name', 'badge', 'priority'
        ], null, [], null, ['priority DESC']);
        $this->data['status'] = array_group_by('priority', $this->data['status'], ['id', 'name', 'badge']);
        //-----
        $this->data['orderCount'] = $orderModel->getOrdersCount();
        $this->data['todayOrderCount'] = $orderModel->getOrdersCount('order_date>:od', ['od' => strtotime('today')]);
        $this->data['totalPaid'] = $model->select_it(null, self::TBL_ORDER, 'SUM(final_price) AS sum', 'payment_status=:ps', ['ps' => OWN_PAYMENT_STATUS_SUCCESSFUL]);
        $this->data['totalPaid'] = count($this->data['totalPaid']) ? $this->data['totalPaid'][0]['sum'] : 0;
        //-----
        $this->data['statusCount' . SEND_STATUS_IN_QUEUE] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_IN_QUEUE]);
        $this->data['statusCount' . SEND_STATUS_UNVERIFIED] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_UNVERIFIED]);
        $this->data['statusCount' . SEND_STATUS_PREPARATION] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_PREPARATION]);
        $this->data['statusCount' . SEND_STATUS_OUT_OF_WAREHOUSE] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_OUT_OF_WAREHOUSE]);
        $this->data['statusCount' . SEND_STATUS_DELIVERED_TO_POST] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_DELIVERED_TO_POST]);
        $this->data['statusCount' . SEND_STATUS_DELIVERED_TO_CUSTOMER] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_DELIVERED_TO_CUSTOMER]);
        $this->data['statusCount' . SEND_STATUS_REFERRED] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_REFERRED]);
        $this->data['statusCount' . SEND_STATUS_CANCELED] = $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_CANCELED]);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'داشبورد');

        $this->_render_page('pages/be/index');
    }

    //-----

    public function manageStaticPageAction()
    {
        if (!$this->auth->isAllow('static_page', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['pages'] = $model->select_it(null, 'static_pages');

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مدیریت مطالب ثابت');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/StaticPage/manageStaticPage');
    }

    public function addStaticPageAction()
    {
        if (!$this->auth->isAllow('static_page', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['errors'] = [];
        $this->data['spValues'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addStaticPage');
        $form->setFieldsName(['title', 'url_name', 'body'])
            ->xssOption('body', ['style', 'href', 'src', 'target', 'class'], ['video'])
            ->setMethod('post');

        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['title', 'url_name', 'body'], 'فیلدهای ضروری را خالی نگذارید.');

                if ($model->is_exist(self::TBL_STATIC_PAGES, 'url_name=:url', ['url' => trim($values['url_name'])])) {
                    $form->setError('این آدرس وجود دارد. لطفا دوباره تلاش کنید.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_STATIC_PAGES, [
                    'title' => $values['title'],
                    'body' => $values['body'],
                    'url_name' => trim($values['url_name'])
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
                $this->data['spValues'] = $form->getValues();
            }
        }

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن مطالب ثابت');

        $this->_render_page([
            'pages/be/StaticPage/addStaticPage',
            'templates/be/browser-tiny-func'
        ]);
    }

    public function editStaticPageAction($param)
    {
        if (!$this->auth->isAllow('static_page', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_STATIC_PAGES, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/manageStaticPage'));
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];
        $this->data['spValues'] = [];

        $this->data['spValues'] = $model->select_it(null, self::TBL_STATIC_PAGES, ['url_name'], 'id=:id', ['id' => $param[0]])[0];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editStaticPage');
        $form->setFieldsName(['title', 'url_name', 'body'])
            ->xssOption('body', ['style', 'href', 'src', 'target', 'class'], ['video'])
            ->setMethod('post');

        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['title', 'url_name'], 'فیلدهای ضروری را خالی نگذارید.');

                if ($this->data['spValues']['url_name'] != $values['url_name']) {
                    if ($model->is_exist(self::TBL_STATIC_PAGES, 'url_name=:url', ['url' => $values['url_name']])) {
                        $form->setError('این آدرس وجود دارد. لطفا دوباره تلاش کنید.');
                    }
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_STATIC_PAGES, [
                    'title' => $values['title'],
                    'body' => $values['body'],
                    'url_name' => trim($values['url_name'])
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

        $this->data['spTrueValues'] = $model->select_it(null, self::TBL_STATIC_PAGES, '*', 'id=:id', ['id' => $param[0]])[0];

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش مطالب ثابت');

        $this->_render_page([
            'pages/be/StaticPage/editStaticPage',
            'templates/be/browser-tiny-func'
        ]);
    }

    public function deleteStaticPageAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('static_page', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('static_page', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_STATIC_PAGES;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه نوشته نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'نوشته وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'نوشته با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageFAQAction()
    {
        if (!$this->auth->isAllow('faq', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['faqValues'] = $model->select_it(null, self::TBL_FAQ, '*',
            null, null, null, ['id DESC']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مدیریت سؤالات متداول');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/FAQ/manageFAQ');
    }

    public function addFAQAction()
    {
        if (!$this->auth->isAllow('faq', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addFAQ');
        $form->setFieldsName(['answer', 'question'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($model, $form) {
                $form->isRequired(['answer', 'question'], 'فیلدهای ضروری را خالی نگذارید.');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_FAQ, [
                    'answer' => trim($values['answer']),
                    'question' => trim($values['question']),
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
                $this->data['faqValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن سؤال');

        $this->_render_page('pages/be/FAQ/addFAQ');
    }

    public function editFAQAction($param)
    {
        if (!$this->auth->isAllow('faq', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_FAQ, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/manageFAQ'));
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editFAQ');
        $form->setFieldsName(['question', 'answer'])->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($model, $form) {
                $form->isRequired(['question', 'answer'], 'فیلدهای ضروری را خالی نگذارید.');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_FAQ, [
                    'answer' => trim($values['answer']),
                    'question' => trim($values['question']),
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
                $this->data['faqValues'] = $form->getValues();
            }
        }

        $this->data['faqCurValues'] = $model->select_it(null, self::TBL_FAQ, '*', 'id=:id', ['id' => $param[0]])[0];

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش سؤال');

        $this->_render_page('pages/be/FAQ/editFAQ');
    }

    public function deleteFAQAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('faq', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('faq', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_FAQ;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه پیام نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'سوال وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'سوال با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageSliderAction()
    {
        if (!$this->auth->isAllow('slider', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['slideValues'] = $model->select_it(null, self::TBL_MAIN_SLIDER, '*',
            null, null, null, ['id DESC']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مدیریت اسلاید‌ها');

        $this->data['js'][] = $this->asset->script('be/js/plugins/media/fancybox.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Slider/manageSlider');
    }

    public function addSlideAction()
    {
        if (!$this->auth->isAllow('slider', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addSlide');
        $form->setFieldsName(['image', 'url'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['image', 'url'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_MAIN_SLIDER, [
                    'image' => trim($values['image']),
                    'link' => trim($values['url']),
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
                $this->data['slideValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن اسلاید جدید');

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload(false);
        $this->data['upload']['allow_create_folder'] = allow_create_folder(false);
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/efm.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->_render_page([
            'pages/be/Slider/addSlide',
            'templates/be/efm',
        ]);
    }

    public function editSlideAction($param)
    {
        if (!$this->auth->isAllow('slider', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_MAIN_SLIDER, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/manageSlider'));
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editSlide');
        $form->setFieldsName(['image', 'url'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['image', 'url'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_MAIN_SLIDER, [
                    'image' => trim($values['image']),
                    'link' => trim($values['url']),
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
                $this->data['slideValues'] = $form->getValues();
            }
        }

        $this->data['slideTrueValues'] = $model->select_it(null, self::TBL_MAIN_SLIDER, '*', 'id=:id', ['id' => $param[0]])[0];

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش اسلاید');

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload(false);
        $this->data['upload']['allow_create_folder'] = allow_create_folder(false);
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/efm.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->_render_page([
            'pages/be/Slider/editSlide',
            'templates/be/efm',
        ]);
    }

    public function deleteSlideAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('slider', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('slider', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_MAIN_SLIDER;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه اسلاید نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'اسلاید وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'اسلاید با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageContactUsAction()
    {
        if (!$this->auth->isAllow('contact', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['cuValues'] = $model->select_it(null, self::TBL_CONTACT_US, [
            'id', 'user_code', 'first_name', 'last_name', 'title', 'status', 'created_at',
        ], null, null, null, ['created_at DESC']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ارتباط با ما');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/ContactUs/manageContactUs');
    }

    public function viewContactAction($param)
    {
        if (!$this->auth->isAllow('contact', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_CONTACT_US, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/manageContactUs'));
        }

        $this->data['contact'] = $model->select_it(null, self::TBL_CONTACT_US, '*', 'id =:id', ['id' => $param[0]])[0];
        if ($this->data['contact']['status'] == 0) {
            $model->update_it(self::TBL_CONTACT_US, ['status' => 1], 'id=:id', ['id' => $param[0]]);
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده پیام');

        $this->_render_page('pages/be/ContactUs/viewContact');
    }

    public function deleteContactAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('contact', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('contact', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_CONTACT_US;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه پیام نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'پیام وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'پیام با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageComplaintsAction()
    {
        if (!$this->auth->isAllow('complaint', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['comValues'] = $model->select_it(null, self::TBL_COMPLAINT, [
            'id', 'first_name', 'last_name', 'title', 'status', 'created_at',
        ], null, null, null, ['created_at DESC']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'شکایات');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Complaint/manageComplaint');
    }

    public function viewComplaintAction($param)
    {
        if (!$this->auth->isAllow('complaint', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_COMPLAINT, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/manageComplaint'));
        }

        $this->data['complaint'] = $model->select_it(null, self::TBL_COMPLAINT, '*', 'id =:id', ['id' => $param[0]])[0];
        if ($this->data['complaint']['status'] == 0) {
            $model->update_it(self::TBL_COMPLAINT, ['status' => 1], 'id=:id', ['id' => $param[0]]);
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده شکایت');

        $this->_render_page('pages/be/Complaint/viewComplaint');
    }

    public function deleteComplaintAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('complaint', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('complaint', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_COMPLAINT;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه شکایت نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'شکایت وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'شکایت با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function settingAction()
    {
        try {
            if (!$this->auth->isAllow('setting', AUTH_ACCESS_READ)) {
                $this->error->access_denied();
            }
        } catch (HAException $e) {
            echo $e;
        }

        $this->load->library('HForm/Form');

        $this->data['setting'] = [];

        // Main panel setting form submit
        $formMain = new Form();
        $this->data['errors_main'] = [];
        $this->data['form_token_main'] = $formMain->csrfToken('settingMain');
        $formMain->setFieldsName(['fav', 'logo', 'title', 'showMenuIcon', 'desc', 'keywords'])
            ->setDefaults('showMenuIcon', 0)
            ->setMethod('post');
        try {
            $formMain->beforeCheckCallback(function ($values) use ($formMain) {
                $formMain->isRequired(['logo', 'title'], 'فیلدهای ضروری را خالی نگذارید.');
                if (!file_exists($values['fav'])) {
                    $formMain->setError('تصویر انتخاب شده برای بالای صفحات، نامعتبر است!');
                }
                if (!file_exists($values['logo'])) {
                    $formMain->setError('تصویر انتخاب شده برای لوگو نامعتبر است!');
                }
            })->afterCheckCallback(function ($values) use ($formMain) {
                $this->data['setting']['main']['favIcon'] = $values['fav'];
                $this->data['setting']['main']['logo'] = $values['logo'];
                $this->data['setting']['main']['title'] = $values['title'];
                $this->data['setting']['main']['showMenuIcon'] = $formMain->isChecked('showMenuIcon') ? 1 : 0;
                $this->data['setting']['main']['description'] = $values['desc'];
                $this->data['setting']['main']['keywords'] = $values['keywords'];

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

                if (!$res) {
                    $formMain->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $formMain->checkForm()->isSuccess();
        if ($formMain->isSubmit()) {
            if ($res) {
                $this->data['success_main'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_main'] = $formMain->getError();
                $this->data['values_main'] = $formMain->getValues();
            }
        }

        // Images panel setting form submit
        $formImages = new Form();
        $this->data['errors_images'] = [];
        $this->data['form_token_images'] = $formImages->csrfToken('settingImages');
        $formImages->setFieldsName(['imgProduct', 'imgBlog', 'imgFAQ', 'imgContact', 'imgComplaint'])
            ->setMethod('post');
        try {
            $formImages->beforeCheckCallback(function (&$values) use ($formImages) {
                if ($values['imgProduct'] != '' && !file_exists($values['imgProduct'])) {
                    $values['imgProduct'] = '';
                }
                if ($values['imgBlog'] != '' && !file_exists($values['imgBlog'])) {
                    $values['imgBlog'] = '';
                }
                if ($values['imgFAQ'] != '' && !file_exists($values['imgFAQ'])) {
                    $values['imgFAQ'] = '';
                }
                if ($values['imgContact'] != '' && !file_exists($values['imgContact'])) {
                    $values['imgContact'] = '';
                }
                if ($values['imgComplaint'] != '' && !file_exists($values['imgComplaint'])) {
                    $values['imgComplaint'] = '';
                }
            })->afterCheckCallback(function ($values) use ($formImages) {
                $this->data['setting']['pages']['product']['topImage'] = $values['imgProduct'];
                $this->data['setting']['pages']['blog']['topImage'] = $values['imgBlog'];
                $this->data['setting']['pages']['faq']['topImage'] = $values['imgFAQ'];
                $this->data['setting']['pages']['contactUs']['topImage'] = $values['imgContact'];
                $this->data['setting']['pages']['complaint']['topImage'] = $values['imgComplaint'];

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

                if (!$res) {
                    $formImages->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $formImages->checkForm()->isSuccess();
        if ($formImages->isSubmit()) {
            if ($res) {
                $this->data['success_images'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_images'] = $formImages->getError();
                $this->data['values_images'] = $formImages->getValues();
            }
        }

        // Index panel setting form submit
        $formIndex = new Form();
        $this->data['errors_index'] = [];
        $this->data['form_token_index'] = $formIndex->csrfToken('settingIndexPage');
        $formIndex->setFieldsName(['indexPagePanel', 'showOurTeam'])
            ->setDefaults('showOurTeam', 0)
            ->setMethod('post', [], ['showOurTeam']);
        try {
            $formIndex->afterCheckCallback(function () use ($formIndex) {
                $this->data['setting']['pages']['index']['showOurTeam'] = $formIndex->isChecked('showOurTeam') ? 1 : 0;
                //-----

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

                if (!$res) {
                    $formIndex->setError('خطا در انجام عملیات!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $formIndex->checkForm()->isSuccess();
        if ($formIndex->isSubmit()) {
            if ($res) {
                $this->data['success_index'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_index'] = $formIndex->getError();
            }
        }

        // SMS panel setting form submit
        $form = new Form();
        $this->data['errors_sms'] = [];
        $this->data['form_token_sms'] = $form->csrfToken('settingSMS');
        $form->setFieldsName([
            'smsActivation', 'smsForgetPassword', 'smsProductReg', 'smsStatus', 'smsChargeAccount'
        ])->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($form) {
                $form->isRequired(['smsActivation', 'smsForgetPassword', 'smsProductReg', 'smsStatus'], 'فیلدهای مربوط به پیامک همگی اجباری هستند.');
            })->afterCheckCallback(function ($values) use ($form) {
                $this->data['setting']['sms']['activationCodeMsg'] = trim($values['smsActivation']);
                $this->data['setting']['sms']['forgetPasswordCodeMsg'] = trim($values['smsForgetPassword']);
                $this->data['setting']['sms']['productRegistrationMsg'] = trim($values['smsProductReg']);
                $this->data['setting']['sms']['changeStatusMsg'] = trim($values['smsStatus']);
                $this->data['setting']['sms']['chargeAccountBalanceMsg'] = trim($values['smsChargeAccount']);

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

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
                $this->data['success_sms'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_sms'] = $form->getError();
                $this->data['values_sms'] = $form->getValues();
            }
        }

        // Cart panel setting form submit
        $form = new Form();
        $this->data['errors_cart'] = [];
        $this->data['form_token_cart'] = $form->csrfToken('settingCart');
        $form->setFieldsName([
            'cart_priceArea1', 'cart_priceArea2', 'cart_priceFree', 'cart_desc'
        ])->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($form) {
                $form->validate('numeric', 'cart_priceArea2', 'قیمت در مناطق خارج از شیراز باید از نوع عدد باشد.');
                $form->validate('numeric', 'cart_priceFree', 'حداقل قیمت رایگان شدن هزینه ارسال باید از نوع عدد باشد.');
            })->afterCheckCallback(function ($values) use ($form) {
                $this->data['setting']['cart']['shipping_price']['area1'] = is_numeric($values['cart_priceArea1']) ? abs((int)$values['cart_priceArea1']) : $values['cart_priceArea1'];
                $this->data['setting']['cart']['shipping_price']['area2'] = abs((int)$values['cart_priceArea2']);
                $this->data['setting']['cart']['description'] = trim($values['cart_desc']);
                $this->data['setting']['cart']['shipping_free_price'] = abs((int)$values['cart_priceFree']);

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

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
                $this->data['success_cart'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_cart'] = $form->getError();
                $this->data['values_cart'] = $form->getValues();
            }
        }

        // Payment panel setting form submit
        $form = new Form();
        $this->data['errors_payment'] = [];
        $this->data['form_token_payment'] = $form->csrfToken('settingPayment');
        $form->setFieldsName([
            'bankImg1', 'bankText1', 'bankEnable1',
            'bankImg2', 'bankText2', 'bankEnable2',
            'bankImg3', 'bankText3', 'bankEnable3',
            'walletImg', 'walletText', 'walletEnable',
            'receiptImg', 'receiptText', 'receiptEnable',
            'inPlaceImg', 'inPlaceText', 'inPlaceEnable',
        ])->setDefaults('bankEnable1', 0)
            ->setDefaults('bankEnable2', 0)
            ->setDefaults('bankEnable3', 0)
            ->setDefaults('walletEnable', 0)
            ->setDefaults('receiptEnable', 0)
            ->setDefaults('inPlaceEnable', 0)
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($form) {
                $form->isRequired(['bankText1', 'bankText2', 'bankText3', 'walletText', 'receiptText', 'inPlaceText'], 'تمام متون اجباری می‌باشند.');
                if ($values['bankImg1'] != '' && !file_exists($values['bankImg1'])) {
                    $values['bankImg1'] = '';
                }
                if ($values['bankImg2'] != '' && !file_exists($values['bankImg2'])) {
                    $values['bankImg2'] = '';
                }
                if ($values['bankImg3'] != '' && !file_exists($values['bankImg3'])) {
                    $values['bankImg3'] = '';
                }
                if ($values['walletImg'] != '' && !file_exists($values['walletImg'])) {
                    $values['walletImg'] = '';
                }
                if ($values['receiptImg'] != '' && !file_exists($values['receiptImg'])) {
                    $values['receiptImg'] = '';
                }
                if ($values['inPlaceImg'] != '' && !file_exists($values['inPlaceImg'])) {
                    $values['inPlaceImg'] = '';
                }
            })->afterCheckCallback(function ($values) use ($form) {
                $this->data['setting']['payment']['bank_1']['text'] = $values['bankText1'];
                $this->data['setting']['payment']['bank_1']['image'] = $values['bankImg1'];
                $this->data['setting']['payment']['bank_1']['enable'] = $form->isChecked('bankEnable1') ? 1 : 0;
                $this->data['setting']['payment']['bank_2']['text'] = $values['bankText2'];
                $this->data['setting']['payment']['bank_2']['image'] = $values['bankImg2'];
                $this->data['setting']['payment']['bank_2']['enable'] = $form->isChecked('bankEnable2') ? 1 : 0;
                $this->data['setting']['payment']['bank_3']['text'] = $values['bankText3'];
                $this->data['setting']['payment']['bank_3']['image'] = $values['bankImg3'];
                $this->data['setting']['payment']['bank_3']['enable'] = $form->isChecked('bankEnable3') ? 1 : 0;
                $this->data['setting']['payment']['wallet']['text'] = $values['walletText'];
                $this->data['setting']['payment']['wallet']['image'] = $values['walletImg'];
                $this->data['setting']['payment']['wallet']['enable'] = $form->isChecked('walletEnable') ? 1 : 0;
                $this->data['setting']['payment']['receipt']['text'] = $values['receiptText'];
                $this->data['setting']['payment']['receipt']['image'] = $values['receiptImg'];
                $this->data['setting']['payment']['receipt']['enable'] = $form->isChecked('receiptEnable') ? 1 : 0;
                $this->data['setting']['payment']['in_place']['text'] = $values['inPlaceText'];
                $this->data['setting']['payment']['in_place']['image'] = $values['inPlaceImg'];
                $this->data['setting']['payment']['in_place']['enable'] = $form->isChecked('inPlaceEnable') ? 1 : 0;

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

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
                $this->data['success_payment'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_payment'] = $form->getError();
                $this->data['values_payment'] = $form->getValues();
            }
        }

        // Contact panel setting form submit
        $form = new Form();
        $this->data['errors_contact'] = [];
        $this->data['form_token_contact'] = $form->csrfToken('settingContact');
        $form->setFieldsName([
            'contact_desc', 'contact_mobile',
        ])->setMethod('post');
        try {
            $form->afterCheckCallback(function ($values) use ($form) {
                $this->data['setting']['contact']['description'] = $values['contact_desc'];
                $this->data['setting']['contact']['mobiles'] = $values['contact_mobile'];

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

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
                $this->data['success_contact'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_contact'] = $form->getError();
                $this->data['values_contact'] = $form->getValues();
            }
        }

        // Footer panel setting form submit
        $form = new Form();
        $this->data['errors_footer'] = [];
        $this->data['form_token_footer'] = $form->csrfToken('settingFooter');
        $form->setFieldsName([
            'footer_1_title', 'footer_1_text', 'footer_1_link',
            'namad1', 'namad2', 'namad3',
            'telegram', 'instagram', 'whatsapp',
        ])->xssExcludeVariables(['namad1', 'namad2', 'namad3'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function ($values) use ($form) {
                $sec1 = array_map(function ($val1, $val2) {
                    return ['text' => $val1, 'link' => $val2];
                }, $values['footer_1_text'][0], $values['footer_1_link'][0]);
                $sec2 = array_map(function ($val1, $val2) {
                    return ['text' => $val1, 'link' => $val2];
                }, $values['footer_1_text'][1], $values['footer_1_link'][1]);

                $this->data['setting']['footer']['sections']['section_1']['title'] = $values['footer_1_title'][0];
                $this->data['setting']['footer']['sections']['section_1']['links'] = $sec1;

                $this->data['setting']['footer']['sections']['section_2']['title'] = $values['footer_1_title'][1];
                $this->data['setting']['footer']['sections']['section_2']['links'] = $sec2;

                $this->data['setting']['footer']['namad']['namad1'] = htmlentities(trim($values['namad1']));
                $this->data['setting']['footer']['namad']['namad2'] = htmlentities(trim($values['namad2']));
                $this->data['setting']['footer']['namad']['namad3'] = htmlentities(trim($values['namad3']));

                $this->data['setting']['footer']['socials']['telegram'] = $values['telegram'];
                $this->data['setting']['footer']['socials']['instagram'] = $values['instagram'];
                $this->data['setting']['footer']['socials']['whatsapp'] = $values['whatsapp'];

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

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
                $this->data['success_footer'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_footer'] = $form->getError();
                $this->data['values_footer'] = $form->getValues();
            }
        }

        // Other panel setting form submit
        $form = new Form();
        $this->data['errors_other'] = [];
        $this->data['form_token_other'] = $form->csrfToken('settingOther');
        $form->setFieldsName([
            'productEachPage', 'blogEachPage'
        ])->setMethod('post');
        try {
            $form->afterCheckCallback(function ($values) use ($form) {
                $pep = (int)$values['productEachPage'];
                $pep = $pep >= 0 || $pep <= 96 ? $pep : 0;
                //-----
                $bep = (int)$values['blogEachPage'];
                $bep = $bep >= 0 || $bep <= 96 ? $bep : 0;
                //-----
                $this->data['setting']['pages']['product']['itemsEachPage'] = $pep;
                $this->data['setting']['pages']['blog']['itemsEachPage'] = $bep;

                $this->setting = array_merge_recursive_distinct($this->setting, $this->data['setting']);
                $res = write_json(CORE_PATH . 'config.json', $this->setting);

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
                $this->data['success_other'] = 'عملیات با موفقیت انجام شد.';
            } else {
                $this->data['errors_other'] = $form->getError();
                $this->data['values_other'] = $form->getValues();
            }
        }

//        $this->data['setting'] = read_json(CORE_PATH . 'config.json');
        $this->data['setting'] = $this->setting;

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload(false);
        $this->data['upload']['allow_create_folder'] = allow_create_folder(false);
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/efm.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/forms/tags/tagsinput.min.js');
//        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        // Base configuration
        // Extra header information
        $this->data['title'] = titleMaker(' - ', set_value($this->setting['main']['title'] ?? ''), 'پنل مدیریت', 'تنظیمات');

        $this->_render_page([
//            'templates/be/browser-tiny-func',
            'pages/be/setting',
            'templates/be/efm'
        ]);
    }

    //-----

    public function guideAction()
    {
        // Extra header information
        $this->data['title'] = titleMaker(' - ', set_value($this->setting['main']['title'] ?? ''), 'پنل مدیریت', 'راهنمای اندازه تصاویر');

        $this->_render_page([
            'pages/be/guide',
        ]);
    }

    //-----

    public function fileUploadAction($params)
    {
        if (!$this->auth->isAllow('file', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        if (!$this->auth->isLoggedIn()) {
            $this->redirect(base_url('admin/login'));
        }

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload();
        $this->data['upload']['allow_create_folder'] = allow_create_folder();
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        if (isset($params[0]) && $params[0] == 'download') {
            unset($params[0]);
            $otherParams = implode(DS, $params);
            if ($otherParams != '') {
                $file = str_replace('@', '.', $otherParams);
                if (file_exists($file)) {
                    $filename = basename($file);
                    header('Content-Type: ' . mime_content_type($file));
                    header('Content-Length: ' . filesize($file));
                    header(sprintf('Content-Disposition: attachment; filename=%s',
                        strpos('MSIE', $_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\""));
                    ob_flush();
                    readfile(base_url($file));
                    exit;
                }
            }
        }

        // Base configuration
        // Extra header information
        $this->data['title'] = titleMaker(' - ', set_value($this->setting['main']['title'] ?? ''), 'پنل مدیریت', 'مدیریت فایل‌ها');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/efm.css');
        $this->data['css'][] = $this->asset->css('be/css/treeview.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/media/fancybox.min.js');

        $this->load->view('templates/be/admin-header-part', $this->data);
        $this->load->view('pages/be/file-upload', $this->data);
        $this->load->view('templates/be/admin-js-part', $this->data);
        $this->load->view('templates/be/efm-main', $this->data);
        $this->load->view('templates/be/admin-footer-part', $this->data);
    }

    public function easyFileManagerAction()
    {
        if (!$this->auth->isAllow('file', AUTH_ACCESS_READ)) {
            err(403, "Forbidden");
            die();
        }
        //-----
        if (!$this->auth->isLoggedIn()) {
            err(403, "Forbidden");
        }

        $this->load->helper('easy file manager');
        //Security options
        $allow_delete = allow_delete();
        $allow_upload = allow_upload();
        $allow_create_folder = allow_create_folder();
        $disallowed_extensions = disallowed_extensions();
        $hidden_extensions = hidden_extensions();

        //Disable error report for undefined superglobals
        error_reporting(error_reporting() & ~E_NOTICE);
        // must be in UTF-8 or `basename` doesn't work
        setlocale(LC_ALL, 'en_US.UTF-8');
        $tmp_dir = UPLOAD_PATH;

        if (DIRECTORY_SEPARATOR === '\\') $tmp_dir = str_replace('/', DIRECTORY_SEPARATOR, $tmp_dir);
        $tmp = get_absolute_path($tmp_dir . '/' . $_REQUEST['file']);

        if ($tmp === false)
            err(404, 'File or Directory Not Found');
        if (substr($tmp, 0, strlen($tmp_dir)) !== $tmp_dir)
            err(403, "Forbidden");
        if (strpos($_REQUEST['file'], DIRECTORY_SEPARATOR) === 0)
            err(403, "Forbidden");
        if (!isset($_COOKIE['_sfm_xsrf']))
            setcookie('_sfm_xsrf', bin2hex(openssl_random_pseudo_bytes(16)));
        if ($_POST) {
            if ($_COOKIE['_sfm_xsrf'] !== $_POST['xsrf'] || !$_POST['xsrf'])
                err(403, "XSRF Failure");
        }

        $file = $_REQUEST['file'] ?: UPLOAD_PATH;
        if (strpos(str_replace('\\', '/', $file), str_replace('\\', '/', UPLOAD_PATH)) === false) {
            $file = UPLOAD_PATH;
        }
        $file = str_replace('\\', '/', $file);
        $file = str_replace('//', '/', $file);
        $file = rtrim($file, '/');

        if (isset($_GET['do']) && $_GET['do'] == 'list') {
            if (is_dir($file)) {
                $directory = $file;
                $result = [];
                $files = array_diff(scandir($directory), ['.', '..']);
                foreach ($files as $entry) {
                    $fileExt = get_extension($entry);
                    if ($entry !== basename(__FILE__) && !in_array($fileExt, $hidden_extensions)) {
                        $i = $directory . '/' . $entry;
                        $stat = stat($i);
                        $result[] = [
                            'test' => $directory,
                            'mtime' => $stat['mtime'],
                            'size' => $stat['size'],
                            'ext' => $fileExt,
                            'name' => basename($i),
                            'path' => preg_replace('@^\./@', '', $i),
                            'is_dir' => is_dir($i),
                            'is_deleteable' => $allow_delete && ((!is_dir($i) && is_writable($directory)) ||
                                    (is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
                            'is_readable' => is_readable($i),
                            'is_writable' => is_writable($i),
                            'is_executable' => is_executable($i),
                        ];
                    }
                }
            } else {
                err(412, "Not a Directory");
            }
            echo json_encode(['success' => true, 'is_writable' => is_writable($file), 'results' => $result]);
            exit;
        } elseif (isset($_POST['do']) && $_POST['do'] == 'delete') {
            if ($allow_delete) {
                rmrf($file);
            }
            exit;
        } elseif (isset($_POST['do']) && $_POST['do'] == 'rename') {
            $newName = $_POST['newName'] ?? '';
            if (empty($newName)) {
                err(200, "Invalid file name.");
            }
            $this->load->library('XSS/vendor/autoload');
            $xss = new AntiXSS();
            $filename = $xss->xss_clean(str_replace(' ', '-', $newName));

            $this->load->library('HConvert/vendor/autoload');
            $converter = \HConvert\Converter\NumberConverter::getInstance();
            $filename = $converter->toPersian($filename);
            $filename = $converter->toEnglish($filename);

            if (!file_exists($file)) {
                err(412, "File doesn't exists!");
            }

            if (strpos(str_replace('\\', '/', $file), str_replace('\\', '/', UPLOAD_PATH)) === false) {
                err(412, "Invalid folder selected");
            }
            // don't allow actions outside root. we also filter out slashes to catch args like './../outside'
            $dir = str_replace('/', '', $filename);
            if (substr($dir, 0, 2) === '..')
                exit;

            $bName = get_base_name($file);

            if ($bName == $filename)
                exit;

            $pos = mb_strrpos($file, $bName);
            if ($pos !== false) {
                $newFile = substr_replace($file, $filename, $pos, strlen($file));
            } else {
                err(412, "Something went wrong!");
            }

            if (file_exists($newFile)) {
                err(412, 'File with this name is currently exists!');
            }

            rename($file, $newFile);
            exit;
        } elseif (isset($_POST['do']) && $_POST['do'] == 'mkdir' && $allow_create_folder) {
            // don't allow actions outside root. we also filter out slashes to catch args like './../outside'
            $dir = $_POST['name'];
            $dir = str_replace('/', '', $dir);

            if (check_file_uploaded_length($dir)) {
                err(412, "Invalid name size.");
            }
            if (substr($dir, 0, 2) === '..')
                exit;
            chdir($file);
            @mkdir(str_replace(' ', '-', $_POST['name']));
            exit;
        } elseif (isset($_POST['do']) && $_POST['do'] == 'upload' && $allow_upload) {
            foreach ($disallowed_extensions as $ext) {
                if (preg_match(sprintf('/\.%s$/', preg_quote($ext)), $_FILES['file_data']['name'])) {
                    err(412, "Files of this type are not allowed.");
                }
            }

            $path = $_FILES['file_data']['name'];
            $ext = get_extension($path);

            $this->load->library('XSS/vendor/autoload');

            $xss = new AntiXSS();
            $filename = $xss->xss_clean(str_replace(' ', '-', $_FILES['file_data']['name']));
            $filename = str_replace('@', '', $filename);

            $this->load->library('HConvert/vendor/autoload');

            $converter = \HConvert\Converter\NumberConverter::getInstance();
            $filename = $converter->toPersian($filename);
            $filename = $converter->toEnglish($filename);

            if (check_file_uploaded_length($filename)) {
                err(412, "Invalid name size.");
            }

            var_dump(move_uploaded_file($_FILES['file_data']['tmp_name'], $file . '/' . $filename));
            exit;
        } elseif (isset($_POST['do']) && $_POST['do'] == 'mvdir' && $allow_create_folder) {
            $fileArr = json_decode($_REQUEST['file']);
            foreach ($fileArr as $files) {
                $file = $files;
                $newDir = $_POST['newPath'];

                if (!file_exists($file)) {
                    err(412, "File doesn't exists!");
                }

                if (strpos(str_replace('\\', '/', $file), str_replace('\\', '/', UPLOAD_PATH)) === false
                    || strpos(str_replace('\\', '/', $newDir), str_replace('\\', '/', UPLOAD_PATH)) === false
                ) {
                    err(412, "Invalid folder selected");
                }
                // don't allow actions outside root. we also filter out slashes to catch args like './../outside'
                $dir = str_replace('/', '', $newDir);
                if (substr($dir, 0, 2) === '..')
                    exit;

                $bName = get_base_name($file);
                $newFile = $newDir . '/' . $bName;

                if ($file == $newFile)
                    exit;

                rename($file, $newFile);
            }
            exit;
        }
    }

    public function foldersTreeAction()
    {
        if (!$this->auth->isAllow('file', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->redirect(base_url('admin/login'));
        }

        $this->load->helper('easy file manager');

        //Disable error report for undefined superglobals
        error_reporting(error_reporting() & ~E_NOTICE);
        // must be in UTF-8 or `basename` doesn't work
        setlocale(LC_ALL, 'en_US.UTF-8');
        $tmp_dir = UPLOAD_PATH;

        if (DIRECTORY_SEPARATOR === '\\') $tmp_dir = str_replace('/', DIRECTORY_SEPARATOR, $tmp_dir);
        $tmp = get_absolute_path($tmp_dir . '/' . $_REQUEST['file']);

        if ($tmp === false)
            err(404, 'File or Directory Not Found');
        if (substr($tmp, 0, strlen($tmp_dir)) !== $tmp_dir)
            err(403, "Forbidden");
        if (strpos($_REQUEST['file'], DIRECTORY_SEPARATOR) === 0)
            err(403, "Forbidden");
        if (!$_COOKIE['_sfm_xsrf'])
            setcookie('_sfm_xsrf', bin2hex(openssl_random_pseudo_bytes(16)));
        if ($_POST) {
            if ($_COOKIE['_sfm_xsrf'] !== $_POST['xsrf'] || !$_POST['xsrf'])
                err(403, "XSRF Failure");
        }

        $file = $_REQUEST['file'];
        if (!$file) {
            err(412, "Not a Directory");
        }

        if (strpos(str_replace('\\', '/', $file), str_replace('\\', '/', UPLOAD_PATH)) === false) {
            err(412, "Not a Directory");
        }

        if (is_dir($file)) {
            $directory = $file;
            $result = [];
            $files = array_diff(scandir($directory), ['.', '..']);
            foreach ($files as $entry) {
                $i = $directory . '/' . $entry;

                if ($entry !== basename(__FILE__) && is_dir($i)) {
                    $result[] = [
                        'name' => basename($i),
                        'path' => preg_replace('@^\./@', '', $i),
                    ];
                }
            }
        } else {
            err(412, "Not a Directory");
        }
        echo json_encode(['success' => true, 'is_writable' => is_writable($file), 'results' => $result]);
        exit;
    }

    public function browserAction()
    {
        if (!$this->auth->isAllow('file', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        if (!$this->auth->isLoggedIn()) {
            $this->error->access_denied();
        }

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload(false);
        $this->data['upload']['allow_create_folder'] = allow_create_folder(false);
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        $this->load->view('pages/be/browser', $this->data);
    }
}
