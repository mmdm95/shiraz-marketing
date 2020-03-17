<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

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



class UserController extends AbstractController
{
    public function manageUserAction(){


        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'مشاهده کاربران');

        $this->data['js'][] = $this->asset->script('be/js/admin.main.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/datatables.min.js');
        $this->data['js'][] = $this->asset->script('be/js/plugins/tables/datatables/numeric-comma.min.js');
        $this->data['js'][] = $this->asset->script('be/js/pages/datatables_advanced.js');

        $this->_render_page('pages/be/User/manageUser');
    }

    public function editUserAction($param)
    {
        if (!$this->auth->isLoggedIn()) {
            $this->redirect(base_url('admin/login'));
        }

        $model = new Model();

        if (!isset($param[0]) || !is_numeric($param[0]) || !$model->is_exist('users', 'id=:id', ['id' => $param[0]])) {
            $this->redirect(base_url('admin/manageUser'));
        }

        if ($this->data['identity']->id != $param[0]) {
            try {
                if (!$this->auth->isAllow('user', 3)) {
                    $this->error->access_denied();
                }

                // Prevent users with same or less graded id, access superior or equally graded of them
                $uRole = $model->select_it(null, 'users_roles', 'role_id', 'user_id=:uId', ['uId' => $param[0]]);
                if (!count($uRole) || ($uRole[0]['role_id'] <= $this->data['identity']->role_id)) {
                    $this->error->access_denied();
                }
            } catch (HAException $e) {
                echo $e;
            }
        }

        $this->data['param'] = $param;

        $this->data['errors'] = [];
        $this->data['userVals'] = [];

        $this->data['userVals'] = $model->join_it(null, 'users AS u', 'users_roles AS r',
            '*', 'u.id=r.user_id',
            'u.id=:id', [
                'id' => $param[0],
            ], null, 'u.id DESC', null, null, false, 'LEFT')[0];

        $this->data['roles'] = $model->select_it(null, 'roles', '*', 'id>:id AND id!=:id2', ['id' => $this->data['identity']->role_id, 'id2' => AUTH_ROLE_GUEST]);

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token'] = $form->csrfToken('editUser');
        $form->setFieldsName(['name', 'username', 'password', 'rePassword'])->setMethod('post');
        try {
            $form->beforeCheckCallback(function ($values) use ($model, $form) {
                $form->isRequired(['username'], 'فیلدهای ضروری را خالی نگذارید.');
                $form->validate('!numeric|string', 'name', 'نام و نام خانوادگی باید از نوع رشته باشد.');

                if (isset($_POST['role'])) {
                    if ($this->data['identity']->role_id <= AUTH_ROLE_ADMIN) {
                        if (!in_array($_POST['role'], array_column($this->data['roles'], 'id'))) {
                            $form->setError('نقش انتخاب شده وجود ندارد.');
                        }
                    }
                }

                if ((trim($values['password']) != '' || trim($values['rePassword']) != '') && $values['password'] != $values['rePassword']) {
                    $form->setError('رمز عبور با تکرار آن مغایرت دارد.');
                }

                if (trim($values['password']) != '') {
                    $form->isLengthInRange('password', 8, 16, 'پسورد باید حداقل ۸ و حداکثر ۱۶ رقم باشد.');
                    $form->validatePassword('password', 2, 'پسورد باید شامل حروف و اعداد انگلیسی باشد.');
                }

                if ($this->data['userVals']['username'] != $values['username'] &&
                    $model->is_exist('users', 'username=:username', ['username' => $values['username']])) {
                    $form->setError('این نام کاربری وجود دارد. لطفا دوباره تلاش کنید.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $model->transactionBegin();
                $res1 = $model->update_it('users', [
                    'username' => trim($values['username']),
                    'password' => trim($values['password']) != '' ? password_hash($values['password'], PASSWORD_BCRYPT) : $this->data['userVals']['password'],
                    'full_name' => trim($values['name'])
                ], 'id=:id', ['id' => $this->data['userVals']['id']]);

                if (isset($_POST['role'])) {
                    if ($this->data['identity']->role_id < 3) {
                        $res2 = $model->update_it('users_roles', [
                            'role_id' => $_POST['role']
                        ], 'user_id=:id', ['id' => $this->data['userVals']['id']]);
                    } else {
                        $res2 = true;
                    }
                } else {
                    $res2 = true;
                }

                if (!$res1 || !$res2) {
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
            }
        }

        $this->data['userVals'] = $model->join_it(null, 'users AS u', 'users_roles AS ur',
            '*', 'u.id=ur.user_id', 'u.id=:id', ['id' => $param[0]]);
        if (!count($this->data['userVals'])) {
            $this->data['errors'][] = 'خطا در یافتن کاربر';
        } else {
            $this->data['userVals'] = $this->data['userVals'][0];
        }

        // Base configuration
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'ویرایش کاربر');

        $this->_render_page('pages/be/User/editUser');
    }


    public function deleteUserAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            message('error', 403, 'دسترسی غیر مجاز');
        }

        try {
            if (!$this->auth->isAllow('user', 4)) {
                $this->error->access_denied();
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = 'users';

        try {
            if (!isset($id) || $id == $this->data['identity']->id) {
                message('error', 200, 'کاربر نامعتبر است.');
            }
            if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
                message('error', 200, 'کاربر وجود ندارد.');
            }

            $uRole = $model->select_it(null, 'users_roles', 'role_id', 'user_id=:uId', ['uId' => $id]);
            if (!count($uRole) || $uRole[0]['role_id'] > $this->data['identity']->role_id) {
                $res = $model->delete_it($table, 'id=:id', ['id' => $id]);
                if ($res) {
                    message('success', 200, 'کاربر با موفقیت حذف شد.');
                }

                message('error', 200, 'عملیات با خطا مواجه شد.');
            } else {
                message('error', 200, 'عملیات غیر مجاز است!');
            }
        } catch (Exception $e) {
            message('error', 200, 'امکان حذف کاربر وجود ندارد.');
        }
    }

    public function activeDeactiveAction()
    {
        if (!$this->auth->isLoggedIn() || !is_ajax()) {
            message('error', 403, 'دسترسی غیر مجاز');
        }

        try {
            if (!$this->auth->isAllow('user', 3)) {
                message('error', 403, 'دسترسی غیر مجاز');
            }
        } catch (HAException $e) {
            echo $e;
        }

        $model = new Model();

        $id = $_POST['postedId'];
        $stat = $_POST['stat'];
        $table = 'users';
        if (!isset($id) || !isset($stat) || !in_array($stat, [0, 1])) {
            message('error', 200, 'ورودی نامعتبر است.');
        }

        if (!$model->is_exist($table, 'id=:id', ['id' => $id])) {
            message('error', 200, 'کاربر وجود ندارد.');
        }

        $res = $model->update_it($table, ['active' => $stat], 'id=:id', ['id' => $id]);
        if ($res) {
            if ($stat == 1) {
                message('success', 200, 'کاربر فعال شد.');
            } else {
                message('warning', 200, 'کاربر غیر فعال شد.');
            }
        }

        message('error', 200, 'عملیات با خطا مواجه شد.');
    }
}
