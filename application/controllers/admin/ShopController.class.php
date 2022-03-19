<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use Admin\AbstractController\AbstractController;
use Apfelbox\FileDownload\FileDownload;
use application\handlers\datatable\DatatableHandler;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HForm\Form;
use HPayment\PaymentFactory;
use HSMS\rohamSMS;
use HSMS\SMSException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use voku\helper\AntiXSS;

include_once 'AbstractController.class.php';

class ShopController extends AbstractController
{
    public function manageCategoryAction()
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $categoryModel = new CategoryModel();
        $this->data['catValues'] = $categoryModel->getCategories();

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده دسته‌بندی‌ها');

        $this->data['js'][] = $this->asset->script('be/js/plugins/media/fancybox.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/ShopCategory/manageCategory');
    }

    public function addCategoryAction()
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['icons'] = $model->select_it(null, self::TBL_ICON);

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addCategory');
        $form->setFieldsName(['image', 'title', 'icon', 'publish'])
            ->setDefaults('publish', 'off')
            ->setMethod('post', [], ['publish']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['image', 'title', 'icon'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }

                if ($model->is_exist(self::TBL_CATEGORY, 'name=:title', ['title' => $values['title']])) {
                    $form->setError('دسته‌بندی با این نام وجود دارد!');
                }

                if (!in_array($values['icon'], array_column($this->data['icons'], 'id'))) {
                    $form->setError('آیکون انتخاب شده نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_CATEGORY, [
                    'name' => $values['title'],
                    'slug' => url_title($values['title']),
                    'parent_id' => 0, // Change if need in future
                    'image' => $values['image'],
                    'icon' => $values['icon'],
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
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
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن دسته‌بندی‌');

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
            'pages/be/ShopCategory/addCategory',
            'templates/be/efm',
        ]);
    }

    public function editCategoryAction($param)
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_CATEGORY, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/shop/manageCategory'));
        }

        $this->data['catTrueValues'] = $model->select_it(null, self::TBL_CATEGORY, ['name'], 'id=:id', ['id' => $param[0]])[0];
        $this->data['icons'] = $model->select_it(null, self::TBL_ICON);

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editCategory');
        $form->setFieldsName(['image', 'title', 'icon', 'publish'])
            ->setDefaults('publish', 'off')
            ->setMethod('post', [], ['publish']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['image', 'title', 'icon'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }

                if ($this->data['catTrueValues']['name'] != $values['title'] &&
                    $model->is_exist(self::TBL_CATEGORY, 'name=:title', ['title' => $values['title']])) {
                    $form->setError('دسته‌بندی با این نام وجود دارد!');
                }

                if (!in_array($values['icon'], array_column($this->data['icons'], 'id'))) {
                    $form->setError('آیکون انتخاب شده نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_CATEGORY, [
                    'name' => $values['title'],
                    'slug' => url_title($values['title']),
                    'parent_id' => 0, // Change if need in future
                    'image' => $values['image'],
                    'icon' => $values['icon'],
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

        $this->data['catTrueValues'] = $model->select_it(null, self::TBL_CATEGORY, '*', 'id=:id', ['id' => $param[0]])[0];

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش دسته‌بندی‌');

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
            'pages/be/ShopCategory/editCategory',
            'templates/be/efm',
        ]);
    }

    public function deleteCategoryAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('product', AUTH_ACCESS_CREATE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('product', AUTH_ACCESS_CREATE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_CATEGORY;
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

    //-----

    public function manageCouponAction()
    {
        if (!$this->auth->isAllow('coupon', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $this->data['copValues'] = $model->select_it(null, self::TBL_COUPON, '*',
            null, null, null, ['id DESC']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده کوپن‌های تخفیف');

        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Coupon/manageCoupon');
    }

    public function addCouponAction()
    {
        if (!$this->auth->isAllow('coupon', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addCoupon');
        $form->setFieldsName(['code', 'title', 'price', 'min_price', 'max_price', 'use_count', 'expire', 'publish'])
            ->setDefaults('publish', 'off')
            ->setMethod('post', [], ['publish']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['code', 'title', 'price', 'min_price', 'expire'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->validate('numeric', 'price', 'تمامی قیمت‌ها باید از نوع عدد باشند.')
                    ->validate('numeric', 'min_price', 'تمامی قیمت‌ها باید از نوع عدد باشند.')
                    ->isInRange('price', 0, PHP_INT_MAX, 'تمامی قیمت‌ها باید عددی بزرگتر از صفر باشند.')
                    ->isInRange('min_price', 0, PHP_INT_MAX, 'تمامی قیمت‌ها باید عددی بزرگتر از صفر باشند.')
                    ->validate('numeric', 'use_count', 'تعداد استفاده از کوپن باید از نوع عدد باشند.');
                if (!empty($values['max_price'])) {
                    $form->validate('numeric', 'max_price', 'تمامی قیمت‌ها باید از نوع عدد باشند.')
                        ->isInRange('max_price', 0, PHP_INT_MAX, 'تمامی قیمت‌ها باید عددی بزرگتر از صفر باشند.');
                }

                if ($model->is_exist(self::TBL_COUPON, 'title=:title', ['title' => $values['title']])) {
                    $form->setError('کوپن با این عنوان وجود دارد!');
                }
                // Check for price and min-price
                if ($values['price'] > $values['min_price']) {
                    $form->setError('حداقل قیمت اعمال تخفیف باید از مبلغ تخفیف بیشتر باشد.');
                }
                if (!empty($values['max_price']) && $values['min_price'] > $values['max_price']) {
                    $form->setError('حداقل قیمت نباید از حداکثر قیمت بیشتر باشد.');
                }
                $form->validateDate('expire', date('Y-m-d', $values['expire']), 'تاریخ انقضا کوپن نامعتبر است.', 'Y-m-d');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->insert_it(self::TBL_COUPON, [
                    'coupon_code' => $values['code'],
                    'title' => $values['title'],
                    'price' => $values['price'],
                    'min_price' => $values['min_price'],
                    'max_price' => $values['max_price'],
                    'use_count' => abs((int)$values['use_count']),
                    'expire_time' => $values['expire'],
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
                $this->data['coValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن کوپن تخفیف');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page('pages/be/Coupon/addCoupon');
    }

    public function editCouponAction($param)
    {
        if (!$this->auth->isAllow('coupon', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_COUPON, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/shop/manageCoupon'));
        }

        $this->data['coTrueValues'] = $model->select_it(null, self::TBL_COUPON, ['title'], 'id=:id', ['id' => $param[0]])[0];

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editCoupon');
        $form->setFieldsName(['code', 'title', 'price', 'min_price', 'max_price', 'use_count', 'expire', 'publish'])
            ->setDefaults('publish', 'off')
            ->setMethod('post', [], ['publish']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['code', 'title', 'price', 'min_price', 'expire'], 'فیلدهای ضروری را خالی نگذارید.')
                    ->validate('numeric', 'price', 'تمامی قیمت‌ها باید از نوع عدد باشند.')
                    ->validate('numeric', 'min_price', 'تمامی قیمت‌ها باید از نوع عدد باشند.')
                    ->isInRange('price', 0, PHP_INT_MAX, 'تمامی قیمت‌ها باید عددی بزرگتر از صفر باشند.')
                    ->isInRange('min_price', 0, PHP_INT_MAX, 'تمامی قیمت‌ها باید عددی بزرگتر از صفر باشند.')
                    ->validate('numeric', 'use_count', 'تعداد استفاده از کوپن باید از نوع عدد باشند.');
                if (!empty($values['max_price'])) {
                    $form->validate('numeric', 'max_price', 'تمامی قیمت‌ها باید از نوع عدد باشند.')
                        ->isInRange('max_price', 0, PHP_INT_MAX, 'تمامی قیمت‌ها باید عددی بزرگتر از صفر باشند.');
                }

                if ($this->data['coTrueValues']['title'] != $values['title'] &&
                    $model->is_exist(self::TBL_COUPON, 'title=:title', ['title' => $values['title']])) {
                    $form->setError('کوپن با این عنوان وجود دارد!');
                }
                // Check for price and min-price
                if ($values['price'] > $values['min_price']) {
                    $form->setError('حداقل قیمت اعمال تخفیف باید از مبلغ تخفیف بیشتر باشد.');
                }
                if (!empty($values['max_price']) && $values['min_price'] > $values['max_price']) {
                    $form->setError('حداقل قیمت نباید از حداکثر قیمت بیشتر باشد.');
                }
                $form->validateDate('expire', date('Y-m-d', $values['expire']), 'تاریخ انقضا کوپن نامعتبر است.', 'Y-m-d');
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_COUPON, [
                    'coupon_code' => $values['code'],
                    'title' => $values['title'],
                    'price' => $values['price'],
                    'min_price' => $values['min_price'],
                    'max_price' => $values['max_price'],
                    'use_count' => abs((int)$values['use_count']),
                    'expire_time' => $values['expire'],
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
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
                $this->data['coValues'] = $form->getValues();
            }
        }

        $this->data['coTrueValues'] = $model->select_it(null, self::TBL_COUPON, '*', 'id=:id', ['id' => $param[0]])[0];

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش کوپن تخفبف');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page('pages/be/Coupon/editCoupon');
    }

    public function deleteCouponAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('coupon', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('coupon', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_COUPON;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه کوپن نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'کوپن وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'کوپن با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    public function manageProductAction()
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده محصولات');

        $this->data['js'][] = $this->asset->script('be/js/plugins/media/fancybox.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');
        //-----
        $this->data['js'][] = $this->asset->script('be/js/plugins/ui/fab.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/extra_fab.js');

        $this->_render_page('pages/be/Product/manageProduct');
    }

    public function addProductAction()
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_CREATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        $this->data['categories'] = $model->select_it(null, self::TBL_CATEGORY, ['id', 'name']);
        $this->data['cities'] = $model->select_it(null, self::TBL_CITY, ['id', 'name']);
        $this->data['products'] = $model->select_it(null, self::TBL_PRODUCT, ['id', 'title']);

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('addProduct');
        $form->setFieldsName(['image', 'title', 'category', 'product_type', 'city', 'place', 'price',
            'discount_price', 'no_expire', 'discount_expire', 'reward', 'stock_count', 'max_basket_count',
            'keywords', 'publish', 'is_special', 'imageGallery', 'related', 'description'])
            ->setDefaults('publish', 'off')
            ->setDefaults('is_special', 'off')
            ->setDefaults('no_expire', 'off')
            ->setDefaults('related', [0 => 0])
            ->setMethod('post', [], ['publish', 'is_special']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['image', 'title', 'category', 'product_type', 'city', 'place', 'price',
                    'discount_price', 'discount_expire', 'stock_count', 'max_basket_count', 'description'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }

                if ($model->is_exist(self::TBL_PRODUCT,
                    'title=:title', ['title' => $values['title']])) {
                    $form->setError('محصول با این عنوان وجود دارد.');
                }

                if (!in_array($values['category'], array_column($this->data['categories'], 'id'))) {
                    $form->setError('دسته‌بندی انتخاب شده نامعتبر است.');
                }
                if (!in_array($values['city'], array_column($this->data['cities'], 'id'))) {
                    $form->setError('شهر انتخاب شده نامعتبر است.');
                }

                $form->isIn('product_type', [PRODUCT_TYPE_SERVICE, PRODUCT_TYPE_ITEM], 'نوع محصول نامعتبر است.');

                $form->isInRange('price', 0, PHP_INT_MAX, 'قیمت باید عددی بزرگتر از صفر باشد.');
                $form->isInRange('discount_price', 0, PHP_INT_MAX, 'قیمت تخفیف باید عددی بزرگتر از صفر باشد.');

                $form->validateDate('discount_expire', date('Y-m-d H:i:s', $values['discount_expire']), 'تاریخ انقضای تخفیف نامعتبر است.', 'Y-m-d H:i:s');

                $form->isInRange('max_basket_count', 1, PHP_INT_MAX, 'حداکثر تعداد در یک خرید باید عددی بزرگتر از ۱ باشد.');

                $form->isInRange('reward', 0, 100, 'پاداش خرید عددی بین ۰ و ۱۰۰ است.');

                $values['imageGallery'] = array_filter($values['imageGallery'], function ($img) {
                    return file_exists($img);
                });
                if (!count($values['imageGallery'])) {
                    $values['imageGallery'] = [0 => ''];
                    $form->setError('انتخاب حداقل یک تصویر برای گالری اجباری است.');
                }

                $values['related'] = array_filter($values['related'], function ($product) use ($model) {
                    return $model->is_exist(self::TBL_PRODUCT, 'id=:id', ['id' => $product]);
                });
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $model->transactionBegin();

                $res = $model->insert_it(self::TBL_PRODUCT, [
                    'title' => $values['title'],
                    'slug' => url_title($values['title']),
                    'image' => $values['image'],
                    'city_id' => $values['city'],
                    'place' => $values['place'],
                    'category_id' => $values['category'],
                    'price' => convertNumbersToPersian($values['price'], true),
                    'discount_price' => convertNumbersToPersian($values['discount_price'], true),
                    'discount_until' => $form->isChecked('no_expire') ? null : $values['discount_expire'],
                    'reward' => $values['reward'],
                    'product_type' => $values['product_type'],
                    'description' => $values['description'],
                    'keywords' => $values['keywords'],
                    'related' => is_array($values['related']) ? implode(',', $values['related']) : '',
                    'stock_count' => $values['stock_count'],
                    'max_cart_count' => $values['max_basket_count'],
                    'is_special' => $form->isChecked('is_special') ? 1 : 0,
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
                    'created_by' => $this->data['identity']->id,
                    'created_at' => time(),
                ], [], true);

                $res3 = false;
                foreach ($values['imageGallery'] as $img) {
                    $res3 = $model->insert_it(self::TBL_PRODUCT_GALLERY, [
                        'product_id' => $res,
                        'image' => $img
                    ]);
                }

                if (!$res || !$res3) {
                    $model->transactionRollback();
                    $form->setError('خطا در انجام عملیات!');
                } else {
                    $model->transactionComplete();
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
                $this->data['pValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'افزودن محصول‌');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');
        $this->data['css'][] = $this->asset->css('be/css/efm.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/forms/tags/tagsinput.min.js');
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload(false);
        $this->data['upload']['allow_create_folder'] = allow_create_folder(false);
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        $this->_render_page([
            'pages/be/Product/addProduct',
            'templates/be/browser-tiny-func',
            'templates/be/efm',
        ]);
    }

    public function editProductAction($param)
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_PRODUCT, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/shop/manageProduct'));
        }

        $this->data['categories'] = $model->select_it(null, self::TBL_CATEGORY, ['id', 'name']);
        $this->data['cities'] = $model->select_it(null, self::TBL_CITY, ['id', 'name']);
        $this->data['products'] = $model->select_it(null, self::TBL_PRODUCT, ['id', 'title'], 'id!=:id', ['id' => $param[0]]);

        $this->data['pTitle'] = $model->select_it(null, self::TBL_PRODUCT, ['title'], 'id=:id', ['id' => $param[0]])[0];

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editProduct');
        $form->setFieldsName(['image', 'title', 'category', 'product_type', 'city', 'place', 'price',
            'discount_price', 'no_expire', 'discount_expire', 'reward', 'stock_count', 'max_basket_count',
            'keywords', 'publish', 'is_special', 'imageGallery', 'related', 'description'])
            ->setDefaults('publish', 0)
            ->setDefaults('is_special', 0)
            ->setDefaults('no_expire', 0)
            ->setDefaults('related', [0 => 0])
            ->setMethod('post', [], ['publish', 'is_special']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['image', 'title', 'category', 'product_type', 'city', 'place', 'price',
                    'discount_price', 'discount_expire', 'stock_count', 'max_basket_count', 'description'], 'فیلدهای ضروری را خالی نگذارید.');

                // Validate image
                if (!file_exists($values['image'])) {
                    $form->setError('تصویر شاخص نامعتبر است.');
                }

                if ($this->data['pTitle']['title'] != $values['title'] &&
                    $model->is_exist(self::TBL_PRODUCT, 'title=:title', ['title' => $values['title']])) {
                    $form->setError('محصول با این عنوان وجود دارد.');
                }

                if (!in_array($values['category'], array_column($this->data['categories'], 'id'))) {
                    $form->setError('دسته‌بندی انتخاب شده نامعتبر است.');
                }
                if (!in_array($values['city'], array_column($this->data['cities'], 'id'))) {
                    $form->setError('شهر انتخاب شده نامعتبر است.');
                }

                $form->isIn('product_type', [PRODUCT_TYPE_SERVICE, PRODUCT_TYPE_ITEM], 'نوع محصول نامعتبر است.');

                $form->isInRange('price', 0, PHP_INT_MAX, 'قیمت باید عددی بزرگتر از صفر باشد.');
                $form->isInRange('discount_price', 0, PHP_INT_MAX, 'قیمت تخفیف باید عددی بزرگتر از صفر باشد.');

                $form->validateDate('discount_expire', date('Y-m-d H:i:s', $values['discount_expire']), 'تاریخ انقضای تخفیف نامعتبر است.', 'Y-m-d H:i:s');

                $form->isInRange('max_basket_count', 1, PHP_INT_MAX, 'حداکثر تعداد در یک خرید باید عددی بزرگتر از ۱ باشد.');

                $form->isInRange('reward', 0, 100, 'پاداش خرید عددی بین ۰ و ۱۰۰ است.');

                $values['imageGallery'] = array_filter($values['imageGallery'], function ($img) {
                    return file_exists($img);
                });
                if (!count($values['imageGallery'])) {
                    $values['imageGallery'] = [0 => ''];
                    $form->setError('انتخاب حداقل یک تصویر برای گالری اجباری است.');
                }

                $values['related'] = array_filter($values['related'], function ($product) use ($model) {
                    return $model->is_exist(self::TBL_PRODUCT, 'id=:id', ['id' => $product]);
                });
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $model->transactionBegin();

                $res = $model->update_it(self::TBL_PRODUCT, [
                    'title' => $values['title'],
                    'slug' => url_title($values['title']),
                    'image' => $values['image'],
                    'city_id' => $values['city'],
                    'place' => $values['place'],
                    'category_id' => $values['category'],
                    'price' => convertNumbersToPersian($values['price'], true),
                    'discount_price' => convertNumbersToPersian($values['discount_price'], true),
                    'discount_until' => $form->isChecked('no_expire') ? null : $values['discount_expire'],
                    'reward' => $values['reward'],
                    'product_type' => $values['product_type'],
                    'description' => $values['description'],
                    'keywords' => $values['keywords'],
                    'related' => is_array($values['related']) ? implode(',', $values['related']) : '',
                    'stock_count' => $values['stock_count'],
                    'max_cart_count' => $values['max_basket_count'],
                    'is_special' => $form->isChecked('is_special') ? 1 : 0,
                    'publish' => !$form->isChecked('publish') ? 0 : 1,
                    'updated_by' => $this->data['identity']->id,
                    'updated_at' => time(),
                ], 'id=:id', ['id' => $this->data['param'][0]]);

                $res2 = $model->delete_it(self::TBL_PRODUCT_GALLERY, 'product_id=:id', ['id' => $this->data['param'][0]]);
                $res3 = false;
                foreach ($values['imageGallery'] as $img) {
                    $res3 = $model->insert_it(self::TBL_PRODUCT_GALLERY, [
                        'product_id' => $this->data['param'][0],
                        'image' => $img
                    ]);
                }

                if (!$res || !$res2 || !$res3) {
                    $model->transactionRollback();
                    $form->setError('خطا در انجام عملیات!');
                } else {
                    $model->transactionComplete();
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
                $this->data['pValues'] = $form->getValues();
            }
        }

        $this->data['pTrueValues'] = $model->select_it(null, self::TBL_PRODUCT, '*', 'id=:id', ['id' => $param[0]])[0];
        $this->data['pTrueValues']['related'] = explode(',', $this->data['pTrueValues']['related']);
        $this->data['pTrueValues']['imageGallery'] = array_column($model->select_it(null, self::TBL_PRODUCT_GALLERY, ['image'],
            'product_id=:id', ['id' => $param[0]]), 'image');

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش محصول‌');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');
        $this->data['css'][] = $this->asset->css('be/css/efm.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/forms/tags/tagsinput.min.js');
        $this->data['js'][] = $this->asset->script('be/js/tinymce/tinymce.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pick.file.js');

        $this->load->helper('easy file manager');
        //Security options
        $this->data['upload']['allow_upload'] = allow_upload(false);
        $this->data['upload']['allow_create_folder'] = allow_create_folder(false);
        $this->data['upload']['allow_direct_link'] = allow_direct_link();
        $this->data['upload']['MAX_UPLOAD_SIZE'] = max_upload_size();

        $this->_render_page([
            'pages/be/Product/editProduct',
            'templates/be/browser-tiny-func',
            'templates/be/efm',
        ]);
    }

    public function deleteProductAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('product', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('product', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_PRODUCT;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه محصول نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'محصول وجود ندارد.');
        }

        try {
            if ($this->auth->hasUserRole([AUTH_ROLE_SUPER_USER, AUTH_ROLE_ADMIN])) {
                $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
            } else {
                $res = $model->update_it($table, [
                    'delete' => 1
                ], 'id=:id', ['id' => $id]);
            }
            if ($res) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'محصول با موفقیت حذف شد.');
            }

            message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
        } catch (HAException $e) {
            message(self::AJAX_TYPE_ERROR, 200, 'امکان حذف محصول وجود ندارد.');
        }
    }

    public function availableProductAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('product', AUTH_ACCESS_UPDATE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('product', AUTH_ACCESS_UPDATE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = $_POST['postedId'];
        $stat = $_POST['stat'];
        $table = self::TBL_PRODUCT;
        if (!isset($id) || !isset($stat) || !in_array($stat, [0, 1])) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'محصول وجود ندارد.');
        }

        $res = $model->update_it($table, ['available' => $stat], 'id=:id', ['id' => $id]);
        if ($res) {
            if ($stat == 1) {
                message(self::AJAX_TYPE_SUCCESS, 200, 'محصول به حالت موجود تبدیل شد.');
            } else {
                message(self::AJAX_TYPE_WARNING, 200, 'محصول از حالت موجود خارج شد.');
            }
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    public function multiEditProductAction($param)
    {
        if (!$this->auth->isAllow('product', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        if (!count($param)) {
            $this->redirect(base_url('admin/shop/manageProduct'));
        }
        //-----
        $model = new Model();

        $this->data['categories'] = $model->select_it(null, self::TBL_CATEGORY, ['id', 'name']);
        $this->data['cities'] = $model->select_it(null, self::TBL_CITY, ['id', 'name']);

        $this->data['param'] = $param;

        $this->data['errors'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editMultiProduct');
        $form->setFieldsName(['category', 'product_type', 'city', 'place', 'price', 'discount_price',
            'no_expire', 'discount_expire', 'reward', 'stock_count', 'max_basket_count',
            'no_publish_change', 'publish', 'no_special_change', 'is_special'])
            ->setDefaults('publish', 0)
            ->setDefaults('is_special', 0)
            ->setDefaults('no_expire', 0)
            ->setDefaults('no_publish_change', 0)
            ->setDefaults('no_special_change', 0)
            ->setMethod('post', [], ['publish', 'is_special']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                $form->isRequired(['product_type'], 'انتخاب نوع محصول اجباری است.');

                if (!in_array($values['category'], array_merge([-1], array_column($this->data['categories'], 'id')))) {
                    $form->setError('دسته‌بندی انتخاب شده نامعتبر است.');
                }
                if (!in_array($values['city'], array_merge([-1], array_column($this->data['cities'], 'id')))) {
                    $form->setError('شهر انتخاب شده نامعتبر است.');
                }

                $form->isIn('product_type', [-1, PRODUCT_TYPE_SERVICE, PRODUCT_TYPE_ITEM], 'نوع محصول نامعتبر است.');

                if (!empty($values['price'])) {
                    $form->isInRange('price', 0, PHP_INT_MAX, 'قیمت باید عددی بزرگتر از صفر باشد.');
                }
                if (!empty($values['discount_price'])) {
                    $form->isInRange('discount_price', 0, PHP_INT_MAX, 'قیمت تخفیف باید عددی بزرگتر از صفر باشد.');
                }

                if (!$form->isChecked('no_expire')) {
                    $form->validateDate('discount_expire', date('Y-m-d H:i:s', $values['discount_expire']), 'تاریخ انقضای تخفیف نامعتبر است.', 'Y-m-d H:i:s');
                }

                if (!empty($values['max_basket_count'])) {
                    $form->isInRange('max_basket_count', 1, PHP_INT_MAX, 'حداکثر تعداد در یک خرید باید عددی بزرگتر از ۱ باشد.');
                }

                if (!empty($values['reward'])) {
                    $form->isInRange('reward', 0, 100, 'پاداش خرید عددی بین ۰ و ۱۰۰ است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $updateColumns = [];
                if ($values['category'] != -1) {
                    $updateColumns['category_id'] = $values['category'];
                }
                if ($values['city'] != -1) {
                    $updateColumns['city_id'] = $values['city'];
                }
                if (!empty($values['place'])) {
                    $updateColumns['place'] = $values['place'];
                }
                if (!empty($values['price'])) {
                    $updateColumns['price'] = $values['price'];
                }
                if (!empty($values['discount_price'])) {
                    $updateColumns['discount_price'] = $values['discount_price'];
                }
                if (!empty($values['reward'])) {
                    $updateColumns['reward'] = $values['reward'];
                }
                if (!empty($values['stock_count'])) {
                    $updateColumns['stock_count'] = $values['stock_count'];
                }
                if (!empty($values['max_basket_count'])) {
                    $updateColumns['max_cart_count'] = $values['max_basket_count'];
                }
                if ($values['product_type'] != -1) {
                    $updateColumns['product_type'] = $values['product_type'];
                }
                if (!$form->isChecked('no_expire')) {
                    $updateColumns['discount_until'] = $values['discount_expire'];
                }
                if (!$form->isChecked('no_special_change')) {
                    $updateColumns['is_special'] = $form->isChecked('is_special') ? 1 : 0;
                }
                if (!$form->isChecked('no_publish_change')) {
                    $updateColumns['publish'] = !$form->isChecked('publish') ? 0 : 1;
                }
                $updateColumns['updated_by'] = $this->data['identity']->id;
                $updateColumns['updated_at'] = time();
                //-----
                $inWhere = '';
                $extraParams = [];
                foreach ($this->data['param'] as $k => $id) {
                    $inWhere .= ':id' . ($k + 1) . ',';
                    $extraParams['id' . ($k + 1)] = $id;
                }
                $inWhere = trim($inWhere, ',');
                $res = $model->update_it(self::TBL_PRODUCT, $updateColumns, 'id IN (' . $inWhere . ')', $extraParams);

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
                $this->data['pValues'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش محصولات');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');

        $this->_render_page([
            'pages/be/Product/multiEditProduct',
        ]);
    }

    public function getProductPaginatedTableAction()
    {
        $columns = [
            ['db' => 'p.id', 'db_alias' => 'id', 'dt' => 'id'],
            [
                'dt' => 'chk',
                'formatter' => function ($row) {
                    return '<div class="product-chk" 
                    data-product-id="' . $row['id'] . '"> 
                    <input type="checkbox" class="styled" name="product_group_checkbox">
                    </div>';
                }
            ],
            [
                'db' => 'p.image',
                'db_alias' => 'image',
                'dt' => 'image',
                'formatter' => function ($d, $row) {
                    return $this->load->view('templates/be/parser/image-placeholder', [
                        'url' => $d,
                        'alt' => $row['title'],
                    ], true);
                }
            ],
            [
                'db' => 'p.title',
                'db_alias' => 'title',
                'dt' => 'title',
                'formatter' => function ($d, $row) {
                    $res = '<a href="' . base_url('product/detail/' . $row['id'] . $row['slug']) . '" target="_blank">
                        ' . $d . '
                        </a>';
                    if (1 == $row['is_special']) {
                        $res .= '<span class="label label-danger ml-5">ویژه</span>';
                    }

                    return $res;
                }
            ],
            ['db' => 'c.name', 'db_alias' => 'category_name', 'dt' => 'category'],
            [
                'db' => 'p.stock_count',
                'db_alias' => 'stock_count',
                'dt' => 'stock',
                'formatter' => function ($d) {
                    return '<span class="text-success">' . $d . '</span>';
                }
            ],
            [
                'db' => 'p.sold_count',
                'db_alias' => 'sold_count',
                'dt' => 'sold',
                'formatter' => function ($d) {
                    return '<span class="text-info">' . $d . '</span>';
                }
            ],
            [
                'db' => 'p.product_type',
                'db_alias' => 'product_type',
                'dt' => 'type',
                'formatter' => function ($d) {
                    $res = 'نامشخص';
                    if ($d == PRODUCT_TYPE_SERVICE) {
                        $res = 'خدمات';
                    } elseif ($d == PRODUCT_TYPE_ITEM) {
                        $res = 'کالا';
                    }

                    return $res;
                }
            ],
            [
                'db' => 'p.publish',
                'db_alias' => 'publish',
                'dt' => 'publish',
                'formatter' => function ($d) {
                    if (1 == $d) {
                        $res = $this->load->view('templates/be/parser/status-label-bordered', [
                            'label' => 'فعال',
                            'class' => 'border-left-success',
                        ], true);
                    } else {
                        $res = $this->load->view('templates/be/parser/status-label-bordered', [
                            'label' => 'غیر فعال',
                            'class' => 'border-left-danger',
                        ], true);
                    }

                    return $res;
                }
            ],
            [
                'db' => 'p.available',
                'db_alias' => 'available',
                'dt' => 'availability',
                'formatter' => function ($d, $row) {
                    return $this->load->view('templates/be/operations/op-product-switch', [
                        'id' => $row['id'],
                        'status' => $d,
                    ], true);
                }
            ],
            [
                'dt' => 'operations',
                'formatter' => function ($row) {
                    return $this->load->view('templates/be/operations/op-product', [
                        'row' => $row,
                    ], true);
                }
            ],
        ];

        if (in_array(AUTH_ROLE_SUPER_USER, $this->auth->getIdentity()->role_id) ||
            in_array(AUTH_ROLE_ADMIN, $this->auth->getIdentity()->role_id)) {
            $columns[] = [
                'db' => '(CASE WHEN (u.id IS NOT NULL) THEN CONCAT(u.first_name, " ", u.last_name) WHEN (u.mobile IS NOT NULL) THEN u.mobile ELSE NULL END)',
                'db_alias' => 'creator',
                'dt' => 'creator',
                'formatter' => function ($d) {
                    $res = $this->load->view('templates/be/parser/dash-icon', [], true);
                    if (!is_null($d)) {
                        $res = $d;
                    }
                    return $res;
                }
            ];
        }

        $res = DatatableHandler::handle($_POST, $columns, function ($cols, $where, $bindValues, $limit, $offset, $order) {
            $productModel = new ProductModel();

            $cols[] = 'p.slug';
            $cols[] = 'p.is_special';

            try {
                if (!$this->auth->hasUserRole([AUTH_ROLE_SUPER_USER, AUTH_ROLE_ADMIN])) {
                    if ('' == trim($where)) {
                        $where .= 'p.delete!=:del';
                    } else {
                        $where .= ' AND (p.delete!=:del)';
                    }
                    $bindValues['del'] = 1;
                }
            } catch (HAException $e) {
            }

            $res = $productModel->getProducts($where, $bindValues, $limit, $offset, $order, $cols);
            $count = $productModel->getProductsCount($where, $bindValues);
            $totalCount = $productModel->getProductsCount();

            return [$res, $count, $totalCount];
        });

        echo json_encode($res);
    }

    //-----

    public function manageOrdersAction()
    {
        if (!$this->auth->isAllow('order', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $userModel = new UserModel();
        $orderModel = new OrderModel();

        $this->data['_where'] = '';
        $this->data['_params'] = [];

        $this->data['users'] = $userModel->getUsers();
        $this->data['status'] = $model->select_it(null, self::TBL_SEND_STATUS, ['id', 'name'],
            null, [], null, ['priority ASC']);

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('filterOrders');
        $form->setFieldsName(['user', 'from_date', 'to_date', 'send_status', 'payment_status', 'payment_method', 'province', 'city'])
            ->setMethod('post')
            ->clearVariablesOnSuccess(false);
        try {
            $form->afterCheckCallback(function ($values) use ($model, $orderModel, $form) {
                $where = '';
                $params = [];

                //user
                if ($values['user'] != -1 && in_array($values['user'], array_column($this->data['users'], 'id'))) {
                    $where .= 'user_id=:uId AND ';
                    $params['uId'] = $values['user'];
                }
                // date
                if (!empty($values['from_date'])) {
                    $where .= 'order_date>=:fd AND ';
                    $params['fd'] = (int)$values['from_date'];
                }
                if (!empty($values['to_date'])) {
                    $where .= 'order_date<=:td AND ';
                    $params['td'] = (int)$values['to_date'];
                }
                // send status
                if ($values['send_status'] != -1) {
                    $where .= 'send_status=:ss AND ';
                    $params['ss'] = $values['send_status'];
                }
                // payment status
                if ($values['payment_status'] != -100) {
                    $where .= 'payment_status=:ps AND ';
                    $params['ps'] = $values['payment_status'];
                }
                // payment method
                if ($values['payment_method'] != -100) {
                    $where .= 'payment_method=:pm AND ';
                    $params['pm'] = $values['payment_method'];
                }
                // province and city
                if (!empty($values['province'])) {
                    $where .= 'province LIKE :province AND ';
                    $params['province'] = '%' . $values['province'] . '%';

                }
                if (!empty($values['city'])) {
                    $where .= 'city LIKE :city AND ';
                    $params['city'] = '%' . $values['city'] . '%';
                }
                //-----
                $where = trim(trim($where), 'AND');
                //-----
                $this->data['_where'] = $where;
                $this->data['_params'] = $params;
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['hasFilter'] = true;
                $this->data['filters'] = $form->getValues();
            }
        }

        $this->data['orders'] = $orderModel->getOrders($this->data['_where'], $this->data['_params']);
        unset($this->data['_where']);
        unset($this->data['_params']);

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مدیرت سفارشات‌');

        // Extra css
        $this->data['css'][] = $this->asset->css('be/css/persian-datepicker-custom.css');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-date.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/pickers/persian-datepicker.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Order/manageOrder');
    }

    public function viewOrderAction($param)
    {
        if (!$this->auth->isAllow('order', AUTH_ACCESS_READ) || !$this->auth->isAllow('order', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $orderModel = new OrderModel();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist(self::TBL_ORDER, 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/shop/manageOrders'));
        }

        $this->data['status'] = $model->select_it(null, self::TBL_SEND_STATUS, ['id', 'name', 'priority']);
        $this->data['cancelStatusID'] = $orderModel->getStatusId(SEND_STATUS_CANCELED);
        $this->data['order'] = $model->select_it(null, self::TBL_ORDER, ['order_code', 'mobile', 'payment_status', 'send_status', 'got_reward'], 'id=:id', ['id' => $param[0]])[0];

        $this->data['param'] = $param;

        // Send status
        $this->data['status_errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_status'] = $form->csrfToken('changeSendStatus');
        $form->setFieldsName(['send_status'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                if (!in_array($values['send_status'], array_column($this->data['status'], 'id'))) {
                    $form->setError('وضعیت ارسال انتخاب شده نامعتبر است.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $orderModel = new OrderModel();

                $model->transactionBegin();
                $res = true;
                if ($this->data['cancelStatusID'] != $this->data['order']['send_status']) {
                    $res = $model->update_it(self::TBL_ORDER, [
                        'send_status' => (int)$values['send_status'],
                        'send_status_changed_by' => $this->auth->getIdentity() ? ($this->auth->getIdentity()->id ?? 0) : 0,
                    ], 'id=:id', ['id' => $this->data['param'][0]]);
                }
                $res2 = true;
                $res3 = true;
                if ($values['send_status'] == $orderModel->getStatusId(SEND_STATUS_DELIVERED_TO_CUSTOMER) &&
                    !$model->is_exist(self::TBL_ORDER, 'order_code=:oc AND got_reward=:gr', ['oc' => $this->data['order']['order_code'], 'gr' => 1])) {
                    // Calculate reward
                    $productModel = new \ProductModel();
                    $commonModel = new CommonModel();
                    $reward = $productModel->getProductsReward($this->data['order']['order_code']);
                    $code = $commonModel->generate_random_unique_code(self::TBL_USER_ACCOUNT_DEPOSIT, 'deposit_code',
                        'DEP-', 6, 15, 10, CommonModel::DIGITS);
                    $res2 = true;
                    if ($reward > 0) {
                        // Store reward to wallet
                        $res2 = $model->insert_it(self::TBL_USER_ACCOUNT_DEPOSIT, [
                            'deposit_code' => 'DEP-' . $code,
                            'user_id' => $this->data['identity']->id,
                            'deposit_price' => $reward,
                            'description' => 'پاداش خرید',
                            'deposit_type' => DEPOSIT_TYPE_REWARD,
                            'deposit_date' => time(),
                        ]);
                    }
                    // Update reward gotten status
                    $res3 = $model->update_it(self::TBL_ORDER, [
                        'got_reward' => 1
                    ], 'order_code=:oc', ['oc' => $this->data['order']['order_code']]);
                }
                $res4 = true;
                if ($this->data['cancelStatusID'] != $this->data['order']['send_status'] && $values['send_status'] == $this->data['cancelStatusID']) {
                    $res4 = $orderModel->returnProductsToStock($this->data['order']['order_code']);
                }

                if ($res && $res2 && $res3 && $res4) {
                    $model->transactionComplete();

                    if ($values['send_status'] != $this->data['order']['send_status']) {
                        // Send SMS code goes here
                        $this->load->library('HSMS/rohamSMS');
                        $sms = new rohamSMS();

                        try {
                            $status = $model->select_it(null, self::TBL_SEND_STATUS, 'name', 'id=:id', ['id' => (int)$values['send_status']]);
                            $status = count($status) ? $status[0]['name'] : 'نامشخص';

                            $body = $this->setting['sms']['changeStatusMsg'];
                            $body = str_replace(SMS_REPLACEMENT_CHARS['mobile'], $this->data['order']['mobile'], $body);
                            $body = str_replace(SMS_REPLACEMENT_CHARS['orderCode'], $this->data['order']['order_code'], $body);
                            $body = str_replace(SMS_REPLACEMENT_CHARS['status'], $status, $body);
                            $is_sent = $sms->set_numbers($this->data['order']['mobile'])->body($body)->send();
                        } catch (SMSException $e) {
                            die($e->getMessage());
                        }
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
                $this->data['status_success'] = 'وضعیت ارسال برورسانی شد.';
            } else {
                $this->data['status_errors'] = $form->getError();
            }
        }

        // Payment status
        $this->data['payment_errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_payment'] = $form->csrfToken('changePaymentStatus');
        $form->setFieldsName(['payment_status'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form) {
                foreach ($values as &$value) {
                    if (is_string($value)) {
                        $value = trim($value);
                    }
                }
                if (!in_array($values['payment_status'], array_keys(OWN_PAYMENT_STATUSES))) {
                    $form->setError('وضعیت پرداخت انتخاب شده نامعتبر است.');
                    return;
                }
                if ($this->data['order']['payment_status'] == OWN_PAYMENT_STATUS_SUCCESSFUL) {
                    $form->setError('وضعیت پرداخت موفق است و نمی‌توان آن را تغییر داد.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_ORDER, [
                    'payment_status' => (int)$values['payment_status'],
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
                $this->data['payment_success'] = 'وضعیت پرداخت برورسانی شد.';
            } else {
                $this->data['payment_errors'] = $form->getError();
            }
        }

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

        $this->_export_pdf();

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), '‌مشاهده سفارش');

        $this->_render_page('pages/be/Order/viewOrder');
//        $this->load->view('pages/test', $this->data);
    }

    //-----

    public function manageReturnOrdersAction()
    {
        if (!$this->auth->isAllow('return_order', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $orderModel = new OrderModel();
        $this->data['orders'] = $orderModel->getReturnOrders();

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سفارشات مرجوعی');

        // Extra js
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/Order/manageReturnOrder');
    }

    public function viewReturnOrderAction($param)
    {
        if (!$this->auth->isAllow('return_order', AUTH_ACCESS_READ) || !$this->auth->isAllow('return_order', AUTH_ACCESS_UPDATE)) {
            $this->error->access_denied();
            die();
        }
        //-----
        $model = new Model();
        $orderModel = new OrderModel();

        if (!isset($param[0]) || is_numeric($param[0]) || !$model->is_exist(self::TBL_RETURN_ORDER, 'order_code=:code', ['code' => $param[0]])) {
            $this->redirect(base_url('admin/shop/manageReturnOrders'));
        }

        $this->data['param'] = $param;

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_answer'] = $form->csrfToken('returnOrderAnswer');
        $form->setFieldsName(['answer'])
            ->setMethod('post');
        try {
            $form->afterCheckCallback(function ($values) use ($model, $form) {
                $res = $model->update_it(self::TBL_RETURN_ORDER, [
                    'respond' => trim($values['answer']),
                    'respond_at' => time(),
                    'status' => 2
                ], 'order_code=:code AND is_closed!=:ic', ['code' => $this->data['param'][0], 'ic' => 1]);

                if (!$res) {
                    $form->setError('عملیات با خطا مواجه شد!');
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->data['answer_success'] = 'پاسخ با موفقیت ثبت شد.';
            } else {
                $this->data['answer_errors'] = $form->getError();
            }
        }

        $this->data['order'] = $orderModel->getSingleReturnOrder('ro.order_code=:code', ['code' => $param[0]]);

        if ($this->data['order']['status'] == 0) {
            $model->update_it(self::TBL_RETURN_ORDER, ['status' => 1], 'order_code=:code', ['code' => $param[0]]);
            $this->data['order']['status'] = 1;
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده سفارش مرجوعی');

        $this->_render_page('pages/be/Order/viewReturnOrder');
    }

    public function deleteReturnOrderAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('return_order', AUTH_ACCESS_DELETE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('return_order', AUTH_ACCESS_DELETE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_RETURN_ORDER;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'شناسه سفارش مرجوعی نامعتبر است.');
        }
        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'سفارش مرجوعی وجود ندارد.');
        }

        $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'سفارش مرجوعی با موفقیت حذف شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    public function closeReturnOrderAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            $this->error->access_denied();
        }
        //-----
        if (!$this->auth->isAllow('return_order', AUTH_ACCESS_UPDATE) && !is_ajax()) {
            $this->error->access_denied();
            die();
        } elseif (!$this->auth->isAllow('return_order', AUTH_ACCESS_UPDATE) && is_ajax()) {
            message(self::AJAX_TYPE_ERROR, 200, 'دسترسی غیر مجاز');
            die();
        }
        //-----

        $model = new Model();

        $id = $_POST['postedId'];
        $table = self::TBL_RETURN_ORDER;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, 'درخواست مرجوعی وجود ندارد.');
        }

        $res = $model->update_it($table, ['is_closed' => 1], 'id=:id', ['id' => $id]);
        if ($res) {
            message(self::AJAX_TYPE_SUCCESS, 200, 'درخواست مرجوعی بسته شد.');
        }

        message(self::AJAX_TYPE_ERROR, 200, 'عملیات با خطا مواجه شد.');
    }

    //-----

    protected function _export_pdf()
    {
        if (!$this->auth->isAllow('order', AUTH_ACCESS_READ)) {
            $this->error->access_denied();
            die();
        }
        //-----
        // Spreadsheet name
        $name = 'factor-' . $this->data['order']['order_code'];
        // Payment status
        $this->data['pdf_export_errors'] = [];
        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_pdf'] = $form->csrfToken('pdfExport');
        $form->setFieldsName(['pdfExporter'])
            ->setMethod('post');
        try {
            $form->beforeCheckCallback(function () use ($form) {

            })->afterCheckCallback(function () use ($form, $name) {
                try {
                    $this->load->library('mPDF/vendor/autoload');
                    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
                    $fontDirs = $defaultConfig['fontDir'];

                    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
                    $fontData = $defaultFontConfig['fontdata'];
                    $mpdf = new \Mpdf\Mpdf([
                        'mode' => 'utf-8',
                        'format' => 'A4',
                        'fontDir' => array_merge($fontDirs, [
                            ROOT . FONTS_PATH,
                        ]),
                        'fontdata' => $fontData + [
                                'IRS' => [
                                    'R' => 'IRANSansWeb.ttf',
                                    'B' => 'IRANSansWeb_Bold.ttf',
                                ]
                            ],
                        'default_font' => 'IRS'
                    ]);
                    if (isset($this->setting['main']['title']) && !empty($this->setting['main']['title'])) {
                        // Show watermark
                        $mpdf->SetWatermarkText($this->setting['main']['title']);
                        $mpdf->showWatermarkText = true;
                        $mpdf->watermarkTextAlpha = 0.1;
                    }

                    $stylesheet = file_get_contents(PUBLIC_PATH . 'fe/css/pdfExport.css');
                    $html = "
<!DOCTYPE html>
<html lang='fa'>
<head>
<title>فاکتور برای سفارش به شماره {$this->data['order']['order_code']}</title>
</head>
<body style='font-family: IRS, Arial, sans-serif;'>
<div class='section'>
    <div class='section-header'>
        <strong>
            وضعیت سفارش
        </strong>
    </div>
    <div class='section-body section-important'>
        <strong>
        {$this->data['order']['send_status_name']}
        </strong>
    </div>
</div>

<div class='section'>
    <div class='section-header'>
        <strong>
            مشخصات پرداخت
        </strong>
    </div>
    <div class='section-body'>
        <div>
            <div class='section-half'>
                <small>
                    کد فاکتور:
                </small>
                <strong>
                    {$this->data['order']['order_code']}
                </strong>
            </div>
            <div class='section-half'>
                <small>
                    نحوه پرداخت:
                </small>
                <strong>";
                    if (in_array($this->data['order']['payment_method'], array_keys(PAYMENT_METHODS))) {
                        $html .= PAYMENT_METHODS[$this->data['order']['payment_method']];
                    } else {
                        $html .= 'نامشخص';
                    }
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div>
            <div class='section-half'>
                <small>
                    تاریخ پرداخت فیش واریزی:
                </small>
                <strong>";
                    if ($this->data['order']['payment_method'] == PAYMENT_METHOD_RECEIPT && !empty($this->data['order']['receipt_date'])) {
                        $html .= jDateTime::date('j F Y در ساعت H:i', $this->data['order']['receipt_date']);
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
            </div>
            <div class='section-half'>
                <small>
                    شماره فیش واریزی:
                </small>
                <strong>";
                    if ($this->data['order']['payment_method'] == PAYMENT_METHOD_RECEIPT && !empty($this->data['order']['receipt_code'])) {
                        $html .= $this->data['order']['receipt_code'];
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div>
            <div class='section-half'>
                <small>
                    کد رهگیری:
                </small>
                <strong>";
                    if (isset($this->data['order']['payment_info']['payment_code'])) {
                        $html .= convertNumbersToPersian($this->data['order']['payment_info']['payment_code']);
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div class='section-body bg-gray'>
            <small>
                وضعیت پرداخت:
            </small>
            <strong>";
                    if (in_array($this->data['order']['payment_status'], array_keys(OWN_PAYMENT_STATUSES))) {
                        $html .= OWN_PAYMENT_STATUSES[$this->data['order']['payment_status']];
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
        </div>
    </div>
    <div class='section-body'>
        <div>
            <div class='section-half'>
                <small>
                    مبلغ کل:
                </small>
                <strong>";
                    $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($this->data['order']['amount'], true)));
                    $html .= "تومان";
                    $html .= "</strong>
            </div>
            <div class='section-half'>
                <small>
                    مبلغ تخفیف:
                </small>
                <strong>";
                    $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($this->data['order']['discount_price'], true)));
                    $html .= "تومان";
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div>
            <div class='section-half'>
                <small>
                    عنوان کد تخفیف:
                </small>
                <strong>";
                    if (!empty($this->data['order']['coupon_title'])) {
                        $html .= $this->data['order']['coupon_title'];
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
            </div>
            <div class='section-half'>
                <small>
                    مبلغ کد تخفیف:
                </small>
                <strong>";
                    if (!empty($this->data['order']['coupon_amount'])) {
                        $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($this->data['order']['coupon_amount'], true)));
                        $html .= "تومان";
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div>
            <div class='section-half'>
                <small>
                    هزینه ارسال:
                </small>
                <strong>";
                    if ($this->data['order']['shipping_price'] != 0) {
                        $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($this->data['order']['shipping_price'], true)));
                        $html .= "تومان";
                    } else {
                        $html .= 'رایگان';
                    }
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div class='section-body bg-gray'>
            <small>
                مبلغ قابل پرداخت:
            </small>
            <strong>";
                    $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($this->data['order']['final_price'], true)));
                    $html .= "تومان";
                    $html .= "</strong>
        </div>
    </div>
</div>

<div class='section'>
    <div class='section-header'>
        <strong>
            مشخصات ثبت کننده سفارش
        </strong>
    </div>
    <div class='section-body'>
        <div>
            <div class='section-half'>
                <small>
                    نام و نام خانوادگی:
                </small>
                <strong>";
                    if (!empty($this->data['order']['first_name']) || !empty($this->data['order']['last_name'])) {
                        $html .= $this->data['order']['first_name'] . ' ' . $this->data['order']['last_name'];
                    } else {
                        $html .= '-';
                    }
                    $html .= "</strong>
            </div>
            <div class='section-half'>
                <small>
                    شماره موبایل:
                </small>
                <strong>";
                    $html .= convertNumbersToPersian($this->data['order']['mobile']);
                    $html .= "</strong>
            </div>
        </div>
    </div>
</div>

<div class='section'>
    <div class='section-header'>
        <strong>
            مشخصات گیرنده سفارش
        </strong>
    </div>
    <div class='section-body'>
        <div>
            <div class='section-half'>
                <small>
                    شماره تماس:
                </small>
                <strong>";
                    $html .= convertNumbersToPersian($this->data['order']['receiver_phone']);
                    $html .= "</strong>
            </div>
            <div class='section-half'>
                <small>
                    استان:
                </small>
                <strong>";
                    $html .= $this->data['order']['province'];
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div>
            <div class='section-half'>
                <small>
                    شهر:
                </small>
                <strong>";
                    $html .= $this->data['order']['city'];
                    $html .= "</strong>
            </div>
            <div class='section-half'>
                <small>
                    کد پستی:
                </small>
                <strong>";
                    $html .= convertNumbersToPersian($this->data['order']['postal_code']);
                    $html .= "</strong>
            </div>
        </div>
        <div class='section-sep'></div>
        <div>
            <small>
                آدرس:
            </small>
            <strong>";
                    $html .= $this->data['order']['address'];
                    $html .= "</strong>
        </div>
    </div>
</div>
<br>
<div class='section'>
    <div class='section-header'>
        <strong>
            محصولات خریداری شده
        </strong>
    </div>
    <div class='section-body'>
        <table class='table'>
        <thead>
            <tr>
                <th>
                    ردیف
                </th>
                <th>
                    نام کالا
                </th>
                <th>
                    تعداد
                </th>
                <th>
                    فی
                </th>
                <th>
                    تخفیف
                </th>
                <th>
                    قیمت نهایی
                </th>
            </tr>
        </thead>
        <tbody>";
                    $i = 0;
                    foreach ($this->data['order']['products'] as $product) {
                        $html .= "<tr>";
                        $html .= "<td>";
                        $html .= convertNumbersToPersian(++$i);
                        $html .= "</td>";
                        $html .= "<td>";
                        $html .= $product['title'];
                        $html .= "</td>";
                        $html .= "<td>";
                        $html .= convertNumbersToPersian($product['product_count']);
                        $html .= "</td>";
                        $html .= "<td>";
                        $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($product['product_unit_price'], true)));
                        $html .= "تومان";
                        $html .= "</td>";
                        $html .= "<td>";
                        $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($product['product_discounted_price'], true)));
                        $html .= "تومان";
                        $html .= "</td>";
                        $html .= "<td>";
                        $html .= convertNumbersToPersian(number_format(convertNumbersToPersian($product['product_price'], true)));
                        $html .= "تومان";
                        $html .= "</td>";
                        $html .= "</tr>";
                    }
                    $html .= "</tbody>
        </table>
    </div>
</div>
</body>
</html>";

                    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
                    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
                    $mpdf->Output($name . '.pdf', true);
                } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception name used for catch
                    // Process the exception, log, print etc.
                    echo $e->getMessage();
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                // Do nothing
            }
        }
    }
}
