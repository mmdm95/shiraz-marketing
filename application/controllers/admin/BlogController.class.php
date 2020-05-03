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

class BlogController extends AbstractController
{
    public function manageCategoryAction()
    {
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['categories'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, '*',
            null, null, null, ['id DESC']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مدیریت دسته‌بندی‌ها');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/BlogCategory/manageCategory');
    }

    public function addCategoryAction()
    {
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['errors'] = [];
        $this->data['catValues'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addBlogCategory');
        $form->setFieldsName(['title', 'publish'])
            ->setDefaults('publish', 'off')
            ->setMethod('post', [], ['publish']);

        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if(is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['title'], 'فیلدهای ضروری را خالی نگذارید.');

                if ($model->is_exist(self::TBL_BLOG_CATEGORY, 'name=:title', ['title' => trim($values['title'])])) {
                    $form->setError('دسته‌بندی با این نام وجود دارد.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_BLOG_CATEGORY, [
                    'name' => $values['title'],
                    'slug' => url_title($values['title']),
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
                    'show_in_side' => 1,
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
                $this->data['catValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن دسته‌بندی');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/BlogCategory/addCategory');
    }

    public function editCategoryAction($param)
    {
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_BLOG_CATEGORY, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/blog/manageCategory'));
        }

        $this->data['catTrueValues'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['name'], 'id=:id', ['id' => $param[0]])[0];

        $this->data['param'] = $param;

        $this->data['errors'] = [];
        $this->data['catValues'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editBlogCategory');
        $form->setFieldsName(['title', 'publish'])
            ->setDefaults('publish', 'off')
            ->setMethod('post', [], ['publish']);

        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if(is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['title'], 'فیلدهای ضروری را خالی نگذارید.');

                if ($this->data['catTrueValues']['name'] != $values['title'] &&
                    $model->is_exist(self::TBL_BLOG_CATEGORY, 'name=:title', ['title' => trim($values['title'])])) {
                    $form->setError('دسته‌بندی با این نام وجود دارد.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_BLOG_CATEGORY, [
                    'name' => $values['title'],
                    'slug' => url_title($values['title']),
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
                    'updated_at' => time(),
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
                $this->data['catValues'] = $form->getValues();
            }
        }

        $this->data['catTrueValues'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, '*', 'id=:id', ['id' => $param[0]])[0];

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش دسته‌بندی');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/BlogCategory/editCategory');
    }

    public function deleteCategoryAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_BLOG_CATEGORY;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه دسته‌بندی نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسته‌بندی وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'دسته‌بندی با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    public function showInSideAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = $_POST['postedId'];
        $stat = $_POST['stat'];
        $table = self::TBL_BLOG_CATEGORY;
        if (!isset($id) || !isset($stat) || !in_array($stat, [0, 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسته‌بندی وجود ندارد.');
        }

        $res = $model->update_it($table, ['show_in_side' => $stat], 'id=:id', ['id' => $id]);
        if ($res) {
            if ($stat == 1) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'نمایش دسته‌بندی در کنار صفحه فعال شد.');
            } else {
                message(self::AJAX_TYPE_WARNING, 200, 'نمایش دسته‌بندی در کنار صفحه غیر فعال شد.');
            }
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageBlogAction()
    {
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $blogModel = new BlogModel();
        $this->data['blog'] = $blogModel->getAllBlog();

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مدیریت مطالب');

        $this->data['js'][] = $this->asset->script('be/js/plugins/media/fancybox.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Blog/manageBlog');
    }

    public function addBlogAction()
    {
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['categories'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['id', 'name']);

        $this->data['errors'] = [];
        $this->data['blogValues'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addBlog');
        $form->setFieldsName(['image', 'title', 'category', 'abstract', 'body', 'publish', 'keywords'])
            ->setDefaults('publish', 'off')
            ->xssOption('body', ['style', 'href', 'src', 'target', 'class'], ['video'])
            ->setMethod('post', [], ['publish']);

        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if(is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['image', 'title', 'category', 'abstract', 'body', 'keywords'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate main image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }
                if ($model->is_exist(self::TBL_BLOG, 'title=:title', ['title' => trim($values['title'])])) {
                    $form->setError('مطلب با این عنوان وجود دارد.');
                }
                if (!in_array($values['category'], array_column($this->data['categories'], 'id'))) {
                    $form->setError('دسته‌بندی نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_BLOG, [
                    'title' => $values['title'],
                    'slug' => url_title($values['title']),
                    'image' => $values['image'],
                    'abstract' => $values['abstract'],
                    'body' => $values['body'],
                    'category_id' => $values['category'],
                    'keywords' => $values['keywords'],
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
                    'created_by' => $this->data['identity']->id,
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
                $this->data['blogValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن مطلب');

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
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->_render_page([
            'pages/be/Blog/addBlog',
            'templates/be/browser-tiny-func',
            'templates/be/efm'
        ]);
    }

    public function editBlogAction($param)
    {
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_BLOG, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/blog/manageBlog'));
        }

        $this->data['param'] = $param;

        $this->data['categories'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['id', 'name']);

        $this->data['errors'] = [];
        $this->data['blogValues'] = $model->select_it(null, self::TBL_BLOG, ['title'], 'id=:id', ['id' => $param[0]])[0];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editBlog');
        $form->setFieldsName(['image', 'title', 'category', 'abstract', 'body', 'publish', 'keywords'])
            ->setDefaults('publish', 'off')
            ->xssOption('body', ['style', 'href', 'src', 'target', 'class'], ['video'])
            ->setMethod('post', [], ['publish']);

        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if(is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['image', 'title', 'category', 'abstract', 'body', 'keywords'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate main image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }
                if ($values['title'] != $this->data['blogValues']['title']) {
                    if ($model->is_exist(self::TBL_BLOG, 'title=:title', ['title' => trim($values['title'])])) {
                        $form->setError('نوشته با این عنوان وجود دارد.');
                    }
                }
                if (!in_array($values['category'], array_column($this->data['categories'], 'id'))) {
                    $form->setError('دسته‌بندی نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_BLOG, [
                    'title' => $values['title'],
                    'slug' => url_title($values['title']),
                    'image' => $values['image'],
                    'abstract' => $values['abstract'],
                    'body' => $values['body'],
                    'category_id' => $values['category'],
                    'keywords' => $values['keywords'],
                    'publish' => $form->isChecked('publish') ? 1 : 0,
                    'updated_by' => $this->data['identity']->id,
                    'updated_at' => time(),
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
                $this->data['blogValues'] = $form->getError();
            }
        }

        $this->data['blogTrueValues'] = $model->select_it(null, self::TBL_BLOG, '*', 'id=:id', ['id' => $param[0]])[0];

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش مطلب');

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
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->_render_page([
            'pages/be/Blog/editBlog',
            'templates/be/browser-tiny-func',
            'templates/be/efm'
        ]);
    }

    public function deleteBlogAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('blog', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('blog', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_BLOG;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه مطلب نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'مطلب وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'مطلب با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }
}