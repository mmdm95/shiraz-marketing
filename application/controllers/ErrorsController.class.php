<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HAuthentication\Auth;
use HAuthentication\HAException;

require_once CONTROLLER_PATH . "home/AbstractController.class.php";

class ErrorsController extends AbstractController
{
    // Index is notFound method
    public function indexAction()
    {
        http_response_code(404);

        $config = getConfig('config');

        $this->load->library('HAuthentication/Auth');

        try {
            $auth = new Auth();
            if (isset($_SESSION['admin_panel_namespace']) &&
                ($auth->setStorageType(AUTH::session)->setNamespace($_SESSION['admin_panel_namespace'])->isLoggedIn() ||
                    $auth->setStorageType(AUTH::cookie)->setNamespace($_SESSION['admin_panel_namespace'])->isLoggedIn())) {
                $data['identity'] = $auth->getIdentity();
                $this->load->view($config['admin_notfound'], $data);
            } else {
//                $data['auth'] = $auth;
//                $data['identity'] = $auth->setNamespace('homePanel')->getIdentity();
                $this->load->view($config['default_notfound'], $this->data);
            }
        } catch (Exception $e) {
        }
    }

    public function serverErrorAction()
    {
        http_response_code(500);
        $this->load->view('errors/Err_ServerErr');
    }

    public function anyErrorAction()
    {
        http_response_code(http_response_code() ?: 200);
        $this->load->view('errors/Err_AnyErr');
    }
}