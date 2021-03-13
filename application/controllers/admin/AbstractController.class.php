<?php

namespace Admin\AbstractController;

defined('BASE_PATH') OR exit('No direct script access allowed');

use AbstractPaymentController;
use Exception;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HConvert\Converter\NumberConverter;
use HForm\Form;
use Model;
use OrderModel;
use UserModel;


include_once CONTROLLER_PATH . 'AbstractPaymentController.class.php';

abstract class AbstractController extends AbstractPaymentController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('HAuthentication/Auth');
        try {
            $this->auth = new Auth();
            $_SESSION['admin_panel_namespace'] = 'admin_new_hva_ms_rhm_7472';
            $this->auth->setNamespace($_SESSION['admin_panel_namespace'])->setExpiration(365 * 24 * 60 * 60);
        } catch (HAException $e) {
            echo $e;
        }

        try {
            if (ACTION != 'login' && (!$this->auth->isLoggedIn() || !$this->auth->isInAdminRole())) {
                $this->redirect(base_url('admin/login'));
            }
        } catch (HAException $e) {
        }

        // Load file helper .e.g: read_json, etc.
        $this->load->helper('file');

        // Read settings once
        $this->setting = read_json(CORE_PATH . 'config.json');
        if (empty($this->setting)) {
            $this->setting = [];
        }

        // Read identity and store in data to pass in views
        $this->data['auth'] = $this->auth;
        $this->data['identity'] = $this->auth->getIdentity();

        // Config(s)
        $this->data['favIcon'] = !empty($this->setting['main']['favIcon']) ? base_url($this->setting['main']['favIcon']) : '';
        $this->data['logo'] = $this->setting['main']['logo'] ?? '';

        if (!is_ajax()) {
            // Extra js
            $this->data['js'][] = $this->asset->script('be/js/admin.main.js');

            // Get some count(s)
            $model = new Model();
            $userModel = new UserModel();
            $this->data['count__promote_request'] = $userModel->getUsersCount('r.id=:rId AND flag_marketer_request=:req',
                ['rId' => AUTH_ROLE_USER, 'req' => 1]);
            $this->data['count__return_order'] = $model->it_count(self::TBL_RETURN_ORDER, 'status=:st', ['st' => 0]);
            $this->data['count__contact'] = $model->it_count(self::TBL_CONTACT_US, 'status=:st', ['st' => 0]);
            $this->data['count__complaint'] = $model->it_count(self::TBL_COMPLAINT, 'status=:st', ['st' => 0]);
        }

//        $model = new Model();
//        $products = $model->select_it(null, AbstractPaymentController::TBL_PRODUCT, ['id', 'title', 'image']);
//        $this->load->library('HConvert/vendor/autoload');
//        $converter = NumberConverter::getInstance();
//        foreach ($products as $product) {
//            $title = $converter->toPersian($product['title']);
//            $title = $converter->toEnglish($title);
//            //-----
//            $image = $converter->toPersian($product['image']);
//            $image = $converter->toEnglish($image);
//            //-----
//            $model->update_it(AbstractPaymentController::TBL_PRODUCT, [
//                'title' => $title,
//                'slug' => url_title($title),
//                'image' => $image,
//            ], 'id=:id', ['id' => $product['id']]);
//        }
        //-----
//        $products = $model->select_it(null, AbstractPaymentController::TBL_PRODUCT_GALLERY, ['id', 'image']);
//        $this->load->library('HConvert/vendor/autoload');
//        $converter = NumberConverter::getInstance();
//        foreach ($products as $product) {
//            $image = $converter->toPersian($product['image']);
//            $image = $converter->toEnglish($image);
//            //-----
//            $model->update_it(AbstractPaymentController::TBL_PRODUCT_GALLERY, [
//                'image' => $image,
//            ], 'id=:id', ['id' => $product['id']]);
//        }

//        $this->load->library('HConvert/vendor/autoload');
//        function recursiveFileFix($folder)
//        {
//            $converter = NumberConverter::getInstance();
//            $files = array_diff(scandir($folder), ['.', '..']);
//            foreach ($files as $entry) {
//                if ($entry !== basename(__FILE__)) {
//                    $i = $folder . '/' . $entry;
//                    if(is_dir($i)) {
//                        recursiveFileFix($i);
//                    } else {
//                        $filename = $converter->toPersian($i);
//                        $filename = $converter->toEnglish($filename);
//                        rename($i, $filename);
//                    }
//                }
//            }
//        }
//        $file = UPLOAD_PATH;
//        $file = str_replace('\\', '/', $file);
//        $file = str_replace('//', '/', $file);
//        $file = rtrim($file, '/');
//        recursiveFileFix($file);

//        $model->insert_it('users', [
//            'mobile' => '09139518055',
//            'password' => password_hash('m9516271', PASSWORD_DEFAULT),
//            'ip_address' => get_client_ip_server(),
//            'email' => 'saeedgerami72@gmail.com',
//            'created_at' => time(),
//            'active' => '1',
//            'first_name' => 'سعید',
//            'last_name' => 'گرامی فر',
//            'image' => 'user-default.png',
//            'n_code' => '4420440392',
//        ]);
        // SuperUse and Admin role_page_perm
//        foreach ([1, 2] as $r) {
//            for ($pg = 1; $pg <= 14; ++$pg) {
//                for ($pr = 1; $pr <= 4; ++$pr) {
//                    $model->insert_it('roles_pages_perms', [
//                        'role_id' => $r,
//                        'page_id' => $pg,
//                        'perm_id' => $pr,
//                    ]);
//                }
//            }
//        }
        // Writer role_page_perm
//        foreach ([3] as $r) {
//            foreach ([4, 5, 14] as $pg) {
//                for ($pr = 1; $pr <= 4; ++$pr) {
//                    $model->insert_it('roles_pages_perms', [
//                        'role_id' => $r,
//                        'page_id' => $pg,
//                        'perm_id' => $pr,
//                    ]);
//                }
//            }
//        }
        // ProductManager role_page_perm
//        foreach ([7] as $r) {
//            foreach ([3, 14] as $pg) {
//                for ($pr = 1; $pr <= 4; ++$pr) {
//                    $model->insert_it('roles_pages_perms', [
//                        'role_id' => $r,
//                        'page_id' => $pg,
//                        'perm_id' => $pr,
//                    ]);
//                }
//            }
//        }
        // UserManager role_page_perm
//        foreach ([8] as $r) {
//            foreach ([2] as $pg) {
//                for ($pr = 1; $pr <= 4; ++$pr) {
//                    $model->insert_it('roles_pages_perms', [
//                        'role_id' => $r,
//                        'page_id' => $pg,
//                        'perm_id' => $pr,
//                    ]);
//                }
//            }
//        }
        // OrderManager role_page_perm
//        foreach ([9] as $r) {
//            foreach ([11, 12] as $pg) {
//                for ($pr = 1; $pr <= 4; ++$pr) {
//                    $model->insert_it('roles_pages_perms', [
//                        'role_id' => $r,
//                        'page_id' => $pg,
//                        'perm_id' => $pr,
//                    ]);
//                }
//            }
//        }
    }

    public function loginAction()
    {
        if ($this->auth->isLoggedIn()) {
            $this->redirect(base_url('admin/index'));
        }

        // For showing 404 page in ErrorController
        unset($_SESSION['admin_panel_namespace']);

        $model = new Model();

        $this->data['errors'] = [];
        $this->data['loginVals'] = [];

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('login');
        $form->setFieldsName(['username', 'password', 'remember'])
            ->setMethod('post', [], ['remember']);
        try {
            $form->afterCheckCallback(function ($values) use ($model, $form) {
                $login = $this->auth->login($values['username'], $values['password'], $form->isChecked('remember'), true,
                    'active=:active', ['active' => 1]);
                if (is_array($login)) {
                    $form->setError($login['err']);
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $this->redirect(base_url('admin/index'));
            } else {
                $this->data['errors'] = $form->getError();
                $this->data['loginVals'] = $form->getValues();
            }
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ورود');

        $this->load->view('pages/be/login', $this->data);
    }

    public function logoutAction()
    {
        if ($this->auth->isLoggedIn()) {
            $this->auth->logout();
            $this->redirect(base_url('admin/login'));
        } else {
            $this->redirect(base_url('index'));
        }
    }

    protected function _render_page($pages, $loadHeaderAndFooter = true)
    {
        if ($loadHeaderAndFooter) {
            $this->load->view('templates/be/admin-header-part', $this->data);
            $this->load->view('templates/be/admin-js-part', $this->data);
        }

        // show wait for check products alert to admin
        if (ACTION != 'login') {
            try {
                if (
                    $this->auth->isAllow('order', AUTH_ACCESS_READ) &&
                    $this->auth->isAllow('order', AUTH_ACCESS_UPDATE)
                ) {
                    $orderModel = new OrderModel();
                    $this->load->view('templates/be/alert/product-check', [
                        'checkProductsCount' => $orderModel->getOrdersCount('ss.priority=:status', ['status' => SEND_STATUS_IN_QUEUE]),
                    ]);
                }
            } catch (HAException $e) {
            }
        }

        $allPages = is_string($pages) ? [$pages] : (is_array($pages) ? $pages : []);
        foreach ($allPages as $page) {
            $this->load->view($page, $this->data);
        }

        if ($loadHeaderAndFooter) {
            $this->load->view('templates/be/admin-footer-part', $this->data);
        }
    }
}