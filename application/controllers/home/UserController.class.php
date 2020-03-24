<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HForm\Form;
use Home\AbstractController\AbstractController;
use HPayment\Payment;
use HPayment\PaymentClasses\PaymentZarinPal;
use HPayment\PaymentException;
use HPayment\PaymentFactory;

include_once 'AbstractController.class.php';

class UserController extends AbstractController
{
    public function dashboardAction()
    {
        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'داشبورد');
        $this->data['todayDate'] = jDateTime::date('l d F Y') . ' - ' . date('d F');

        $model = new Model();

        $this->_render_page('pages/fe/user/dashboard');
    }

    public function paymentResultAction()
    {

    }

//    public function ajaxUploadUserImageAction()
//    {
//        if (!$this->auth->isLoggedIn() || !is_ajax()) {
//            message('error', 200, 'دسترسی غیر مجاز');
//        }
//        if (empty($_FILES['file'])) {
//            message('error', 200, 'پارامترهای وارد شده نامعتبر است.');
//        }
//
//        $userDir = PROFILE_IMAGE_DIR;
//        //
//        if (!file_exists($userDir)) {
//            mkdir($userDir, 0777, true);
//        }
//        //
//        $imageExt = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//        $image = PROFILE_IMAGE_DIR . $this->data['identity']->username . '.' . $imageExt;
//        $model = new Model();
//        $model->transactionBegin();
//        $res = $model->update_it('users', ['image' => $image], 'id=:id', ['id' => $this->data['identity']->id]);
//        //
//        if ($res) {
//            $this->load->library('Upload/vendor/autoload');
//            $storage = new \Upload\Storage\FileSystem($userDir, true);
//            $file = new \Upload\File('file', $storage);
//
//            // Set file name to user's phone number
//            $file->setName($this->data['identity']->username);
//
//            // Validate file upload
//            // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
//            $file->addValidations(array(
//                // Ensure file is of type "image/png"
//                new \Upload\Validation\Mimetype(['image/png', 'image/jpg', 'image/jpeg', 'image/gif']),
//
//                // Ensure file is no larger than 4M (use "B", "K", M", or "G")
//                new \Upload\Validation\Size('4M')
//            ));
//
//            // Try to upload file
//            try {
//                // Success!
//                $res = $file->upload();
//            } catch (\Exception $e) {
//                // Fail!
//                $res = false;
//            }
//            //
//            if ($res) {
//                $this->auth->storeIdentity([
//                    'image' => $image,
//                ]);
//                $this->data['identity'] = $this->auth->getIdentity();
//                $model->transactionComplete();
//                message('success', 200, ['تصویر با موفقیت بروزرسانی شد.', $image]);
//            }
//        }
//        $model->transactionRollback();
//        message('error', 200, 'خطا در بروزرسانی تصویر');
//    }

    //----- We need this action

//    public function informationCompletionAction()
//    {
//        $this->_checker();
//        //-----
//        $this->_saveInformation();
//        //-----
//        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'فرم اطلاعات');
//
//        // Extra js
//        $this->data['js'][] = $this->asset->script('fe/js/userDashboardJs.js');
//
//        $this->_render_page([
//            'pages/fe/user-information',
//        ]);
//    }

//
//    protected function _exportTicket()
//    {
//        if (!$this->_checker(true)) return;
//        //-----
//        $model = new Model();
//        $this->data['ticketErrors'] = [];
//        $this->load->library('HForm/Form');
//        $form = new Form();
//        $this->data['form_token_ticket'] = $form->csrfToken('ticketToken');
//        $form->setFieldsName(['ticket'])->setMethod('post');
//        try {
//            $form->beforeCheckCallback(function ($values) use ($model, $form) {
//
//            })->afterCheckCallback(function ($values) use ($model, $form) {
////                $res = $model->update_it('users', [
////                    'password' => password_hash($values['new-password'], PASSWORD_DEFAULT),
////                ], 'id=:id', ['id' => $this->data['identity']->id]);
//
////                if (!$res) {
////                $form->setError('خطا در انجام عملیات!');
//                $form->setError('این امکان هنوز فعال نشده است!');
////                }
//            });
//        } catch (Exception $e) {
//            die($e->getMessage());
//        }
//
//        $res = $form->checkForm()->isSuccess();
//        if ($form->isSubmit()) {
//            if ($res) {
//
//            } else {
//                $this->data['ticketErrors'] = $form->getError();
//            }
//        }
//    }
//
//    //-----
//
//    protected function _checker($returnBoolean = false)
//    {
//        if (!$this->auth->isLoggedIn()) {
//            if ((bool)$returnBoolean) return false;
//            $this->error->show_404();
//        }
//
//        return true;
//    }
//
//    //-----

    protected function _render_page($pages, $loadHeaderAndFooter = true)
    {
        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/user/admin-header-part', $this->data);
            $this->load->view('templates/fe/user/admin-js-part', $this->data);
        }

        $allPages = is_string($pages) ? [$pages] : (is_array($pages) ? $pages : []);
        foreach ($allPages as $page) {
            $this->load->view($page, $this->data);
        }

        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/user/admin-footer-part', $this->data);
        }
    }
}