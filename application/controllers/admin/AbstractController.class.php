<?php
defined('BASE_PATH') OR exit('No direct script access allowed');


include_once CONTROLLER_PATH . 'AbstractPaymentController.class.php';

abstract class AbstractController extends AbstractPaymentController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('HAuthentication/Auth');
        try {
            $this->auth = new Auth();
            $_SESSION['admin_panel_namespace'] = 'admin_hva_ms_rhm_7472';
            $this->auth->setNamespace($_SESSION['admin_panel_namespace'])->setExpiration(365 * 24 * 60 * 60);
        } catch (HAException $e) {
            echo $e;
        }

        // Load file helper .e.g: read_json, etc.
        $this->load->helper('file');

        // Read settings once
        $this->setting = read_json(CORE_PATH . 'config.json');

        // Read identity and store in data to pass in views
        $this->data['auth'] = $this->auth;
        $this->data['identity'] = $this->auth->getIdentity();

        // Config(s)
        $this->data['favIcon'] = $this->setting['main']['favIcon'] ? base_url($this->setting['main']['favIcon']) : '';
        $this->data['logo'] = $this->setting['main']['logo'] ?? '';

//        $model = new Model();
//        $model->insert_it('users', [
//            'username' => 'godheeva@gmail.com',
//            'password' => password_hash('m9516271', PASSWORD_DEFAULT),
//            'ip_address' => get_client_ip_server(),
//            'email' => 'saeedgerami72@gmail.com',
//            'created_on' => time(),
//            'active' => '1',
//            'full_name' => 'سعید گرامی فر',
//            'image' => 'user-default.png',
//            'n_code' => '4420440392',
//        ]);
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

        $allPages = is_string($pages) ? [$pages] : (is_array($pages) ? $pages : []);
        foreach ($allPages as $page) {
            $this->load->view($page, $this->data);
        }

        if ($loadHeaderAndFooter) {
            $this->load->view('templates/be/admin-footer-part', $this->data);
        }
    }
}