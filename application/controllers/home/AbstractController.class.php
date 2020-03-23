<?php
namespace Home\AbstractController;

defined('BASE_PATH') OR exit('No direct script access allowed');

use AbstractPaymentController;
use Exception;
use HAuthentication\Auth;
use HAuthentication\HAException;
use HForm\Form;
use Model;


include_once CONTROLLER_PATH . 'AbstractPaymentController.class.php';

abstract class AbstractController extends AbstractPaymentController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('HAuthentication/Auth');
        try {
            $this->auth = new Auth();
            $_SESSION['home_panel_namespace'] = 'home_hva_ms_rhm_7472';
            $this->auth->setNamespace($_SESSION['home_panel_namespace'])->setExpiration(365 * 24 * 60 * 60);
        } catch (HAException $e) {
            echo $e;
        }

        // Load file helper .e.g: read_json, etc.
        $this->load->helper('file');

        if (!is_ajax()) {
            // Read settings once
            $this->setting = read_json(CORE_PATH . 'config.json');
            $this->data['setting'] = $this->setting;
        }

        // Read identity and store in data to pass in views
        $this->data['auth'] = $this->auth;
        $this->data['identity'] = $this->auth->getIdentity();

        if (!is_ajax()) {
            // Config(s)
            $this->data['favIcon'] = $this->setting['main']['favIcon'] ? base_url($this->setting['main']['favIcon']) : '';
            $this->data['logo'] = $this->setting['main']['logo'] ?? '';
        }
    }

    public function logout()
    {
        if ($this->auth->isLoggedIn()) {
            $this->auth->logout();
            if ($_GET['back_url']) {
                $this->redirect($_GET['back_url']);
            } else {
                $this->redirect(base_url('index'));
            }
        } else {
            $this->error->show_404();
        }
    }

    //-------------------------------
    //----------- Captcha -----------
    //-------------------------------

    public function captchaAction($param)
    {
        if (isset($param[0])) {
            createCaptcha((string)$param[0]);
        } else {
            createCaptcha();
        }
    }

    //-------------------------------
    //------ Register & Login -------
    //-------------------------------

    protected function _register($param)
    {
        $this->data['registerErrors'] = [];
        $this->data['registerValues'] = [];

        if ($this->auth->isLoggedIn()) {
            return;
        }

        $model = new Model();

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_register'] = $form->csrfToken('register');
        $form->setFieldsName(['mobile', 'password', 're_password', 'role', 'registerCaptcha'])
            ->setDefaults('role', AUTH_ROLE_GUEST)
            ->setMethod('post', [], ['role']);
        try {
            $form->beforeCheckCallback(function (&$values) use ($model, $form, $param) {
                $values['mobile'] = convertNumbersToPersian($values['mobile'], true);

                $form->isRequired(['mobile', 'password', 're_password', 'role', 'registerCaptcha'], 'فیلدهای ضروری را خالی نگذارید.');
                if ($model->is_exist('users', 'username=:name AND active=:a',
                    ['name' => $values['mobile'], 'a' => 1])) {
                    $form->setError('این شماره تلفن وجود دارد، لطفا دوباره تلاش کنید.');
                }
                $form->isLengthInRange('password', 8, 16, 'تعداد رمز عبور باید بین ۸ تا ۱۶ کاراکتر باشد.');
                $form->validatePersianMobile('mobile');
                $form->validatePassword('password', 2, 'رمز عبور باید شامل حروف و اعداد باشد.');
                if ($values['role'] == AUTH_ROLE_GUEST || !in_array($values['role'], [AUTH_ROLE_STUDENT, AUTH_ROLE_COLLEGE_STUDENT, AUTH_ROLE_GRADUATE])) {
                    $form->setError('نقش انتخاب شده نامعتبر است.');
                }
                $config = getConfig('config');
                if (!isset($config['captcha_session_name']) ||
                    !isset($_SESSION[$config['captcha_session_name']][$param['captcha']]) ||
                    !isset($param['captcha']) ||
                    encryption_decryption(ED_DECRYPT, $_SESSION[$config['captcha_session_name']][$param['captcha']]) != strtolower($values['registerCaptcha'])) {
                    $form->setError('کد وارد شده با کد تصویر مغایرت دارد. دوباره تلاش کنید.');
                }
            })->afterCheckCallback(function ($values) use ($model, $form) {
                $this->data['code'] = generateRandomString(6, GRS_NUMBER);
                $this->data['_username'] = $values['mobile'];
                $this->data['_password'] = trim($values['password']);

                $model->transactionBegin();
                $res2 = $model->delete_it('users', 'username=:u', ['u' => $values['mobile']]);
                $res = $model->insert_it('users', [
                    'activation_code' => $this->data['code'],
                    'username' => convertNumbersToPersian(trim($values['mobile']), true),
                    'password' => password_hash(trim($values['password']), PASSWORD_DEFAULT),
                    'ip_address' => get_client_ip_env(),
                    'created_on' => time(),
                    'active' => 1,
                    'image' => PROFILE_DEFAULT_IMAGE,
                ], [], true);
                $res3 = $model->insert_it('users_roles', [
                    'user_id' => $res,
                    'role_id' => (int)$values['role'],
                ]);

                if ($res && $res2 && $res3) {
                    $model->transactionComplete();
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
                $_SESSION['username_validation_sess'] = encryption_decryption(ED_ENCRYPT, $this->data['_username']);
                $_SESSION['password_validation_sess'] = encryption_decryption(ED_ENCRYPT, $this->data['_password']);

                // Send SMS code goes here

                // Unset data
                unset($this->data['mobile']);
                unset($this->data['code']);

                $message = 'در حال پردازش عملیات ورود';
                $delay = 1;
//                if (isset($_GET['back_url'])) {
//                    $this->redirect(base_url('verifyPhone?back_url=' . $_GET['back_url']), $message, $delay);
//                }

                $login = $this->auth->login($this->data['_username'], $this->data['_password'], false,
                    false, 'active=:active', ['active' => 1]);
                if (is_array($login)) {
                    $form->setError($login['err']);
                    $this->data['registerErrors'] = $form->getError();
                } else {
                    $this->redirect(base_url('user/dashboard#profile'), $message, $delay);
                }
            } else {
                $this->data['registerErrors'] = $form->getError();
                $this->data['registerValues'] = $form->getValues();
            }
        }
    }

    protected function _login($param)
    {
        $this->data['loginErrors'] = [];
        $this->data['loginValues'] = [];


        if ($this->auth->isLoggedIn()) {
            return;
        }

        $model = new Model();

        $this->load->library('HForm/Form');
        $form = new Form();
        $this->data['form_token_login'] = $form->csrfToken('login');
        $form->setFieldsName(['username', 'password', 'remember', 'loginCaptcha'])
            ->setMethod('post', [], ['remember']);
        try {
            $form->afterCheckCallback(function (&$values) use ($model, $form, $param) {
                $values['username'] = convertNumbersToPersian($values['username'], true);

                $config = getConfig('config');
                if (!isset($config['captcha_session_name']) ||
                    !isset($_SESSION[$config['captcha_session_name']][$param['captcha']]) ||
                    !isset($param['captcha']) ||
                    encryption_decryption(ED_DECRYPT, $_SESSION[$config['captcha_session_name']][$param['captcha']]) != strtolower($values['loginCaptcha'])) {
                    $form->setError('کد وارد شده با کد تصویر مغایرت دارد. دوباره تلاش کنید.');
                }
                // If there is no captcha error
                if (!count($form->getError())) {
                    $login = $this->auth->login($values['username'], $values['password'], $form->isChecked('remember'),
                        false, 'active=:active', ['active' => 1]);
                    if (is_array($login)) {
                        $form->setError($login['err']);
                    }
                }
            });
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $res = $form->checkForm()->isSuccess();
        if ($form->isSubmit()) {
            if ($res) {
                $message = 'در حال پردازش عملیات ورود';
                $delay = 1;

                if (isset($_GET['back_url'])) {
                    $this->redirect($_GET['back_url'], $message, $delay);
                }
                $this->redirect(base_url('user/dashboard'), $message, $delay);
            } else {
                $this->data['loginErrors'] = $form->getError();
                $this->data['loginValues'] = $form->getValues();
            }
        }
    }

    //-----

    public function cartAction()
    {
        // Check cart and cart items
//        $cartItems = $this->_fetch_cart_items();
//        $this->data['updated_items_in_cart'] = $cartItems['deleted'];
//        $this->data['items'] = $cartItems['items'];

//        var_dump();
        //-----
//        $this->data['totalAmount'] = 0;
//        $this->data['totalDiscountedAmount'] = 0;
//        foreach ($this->data['items'] as $item) {
//            $this->data['totalAmount'] += $item['price'] * $item['quantity'];
//            $this->data['totalDiscountedAmount'] += $item['discount_price'] * $item['quantity'];
//        }

//        $this->data['cart_content'] = $this->load->view('templates/fe/cart/main-cart', $this->data, true);

        // Other information
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'سبد خرید');

        // Extra js
//        $this->data['js'][] = $this->asset->script('fe/js/checkoutJs.js');

        $this->_render_page(['pages/fe/cart']);
    }

    public function addToCartAction()
    {
        if (!is_ajax()) {
            message('error', 403, 'دسترسی غیر مجاز');
        }

        $cookieModel = new CookieModel();
        $model = new Model();

        $type = 'success';
        $msg = 'محصول با موفقیت به سبد اضافه شد.';

        $id = $_POST['postedId'] ?? null;
        $colorCode = $_POST['postedColorCode'] ?? null;
        if (!isset($id) || !is_numeric($id)) {
            message('error', 200, 'ورودی نامعتبر است.');
        }
        if (!$model->is_exist('products', 'id=:id', ['id' => $id])) {
            message('error', 200, 'این محصول وجود ندارد.');
        }
        if (!$model->it_count('products', 'id=:id AND stock_count>:sc AND available=:av', ['id' => $id, 'sc' => 0, 'av' => 1])) {
            message('error', 200, 'محصول ناموجود است.');
        }

        // Find color id with color code or select first one
        if (!isset($colorCode) || !$model->is_exist('colors', 'color_code=:cc', ['cc' => $colorCode])) {
            $colorId = $model->select_it(null, 'products_advanced', 'color_id', 'id=:id', ['id' => $id])[0]['color_id'];
        } else {
            $colorId = $model->select_it(null, 'colors', 'id', 'color_code=:cc', ['cc' => $colorCode])[0]['id'];
            if (!$model->is_exist('products_colors', 'product_id=:pId AND color_id=:cId', ['pId' => $id, 'cId' => $colorId])) {
                $colorId = $model->select_it(null, 'products_advanced', 'color_id', 'id=:id', ['id' => $id])[0]['color_id'];
            }
        }
        if (!$model->it_count('products_colors', 'product_id=:id AND color_id=:cId AND count>:c', ['id' => $id, 'cId' => $colorId, 'c' => 0])) {
            message('error', 200, 'محصول ناموجود است.');
        }

        // read
        $saved_cart_items = $this->_read_cart_cookie();

        // check if the item is in the array, if it is, do not add
        if (array_key_exists($id, $saved_cart_items)) {
            $curArrKey = array_search($colorId, array_column($saved_cart_items[$id], 'color'));
            if ($curArrKey === false) {
                // add new item to existence item in array
                $saved_cart_items[$id][] = array('quantity' => 1, 'color' => $colorId);
            } else {
                $stockCount = $model->select_it(null, 'products_colors', 'count',
                    'product_id=:pId AND color_id=:cId', ['pId' => $id, 'cId' => $saved_cart_items[$id][$curArrKey]['color']]);
                if ($stockCount) {
                    $stockCount = convertNumbersToPersian($stockCount[0]['count'], true);
                    if ($saved_cart_items[$id][$curArrKey]['quantity'] + 1 > $stockCount) {
                        $type = 'warning';
                        $msg = 'محصول به تعداد حداکثر خود رسیده است!';
                    } else {
                        $saved_cart_items[$id][$curArrKey]['quantity'] += 1;
                        $type = 'info';
                        $msg = 'تعداد محصول در سبد افزایش یافت.';
                    }
                } else {
                    $type = 'error';
                    $msg = 'خطا در افزودن محصول به سبد!!';
                }
            }
            $cart_items = $saved_cart_items;
        } else {
            // add new item on array
            $cart_items[$id] = array(
                array('quantity' => 1, 'color' => $colorId)
            );

            $cart_items = array_merge_recursive_distinct($cart_items, $saved_cart_items);
        }

        $cart_items_count = array_sum(array_map(function ($v) {
            return count($v);
        }, $cart_items));

        // put item to cookie
        $json = json_encode($cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);

        message($type, 200, [$msg, $cart_items_count]);
    }

    public function updateCartAction()
    {
        if (!is_ajax() && $this->haveCartAccess !== true) {
            message('error', 403, 'دسترسی غیر مجاز');
        }

        $cookieModel = new CookieModel();
        $model = new Model();

        $id = $_POST['postedId'] ?? null;
        $colorCode = $_POST['postedColorCode'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        if (!isset($id) || !is_numeric($id)) {
            message('error', 200, 'ورودی نامعتبر است.');
        }
        if (!$model->is_exist('products', 'id=:id', ['id' => $id])) {
            message('error', 200, 'این محصول وجود ندارد.');
        }
        if (!$model->it_count('products', 'id=:id AND stock_count>:sc AND available=:av', ['id' => $id, 'sc' => 0, 'av' => 1])) {
            message('error', 200, 'محصول ناموجود است.');
        }

        // Find color id with color code or select first one
        if (isset($colorCode) && $model->is_exist('colors', 'color_code=:cc', ['cc' => $colorCode])) {
            $colorId = $model->select_it(null, 'colors', 'id', 'color_code=:cc', ['cc' => $colorCode])[0]['id'];
            if (!$model->is_exist('products_colors', 'product_id=:pId AND color_id=:cId', ['pId' => $id, 'cId' => $colorId])) {
                message('error', 200, 'محصول مورد نظر با چنین رنگی وجود ندارد!');
            }
        } else {
            message('error', 200, 'محصول مورد نظر با چنین رنگی وجود ندارد!');
        }
        if (!$model->it_count('products_colors', 'product_id=:id AND color_id=:cId AND count>:c', ['id' => $id, 'cId' => $colorId, 'c' => 0])) {
            message('error', 200, 'محصول ناموجود است.');
        }

        // make quantity a minimum of 1
        $quantity = !is_numeric($quantity) || $quantity <= 0 ? 1 : $quantity;

        // read cookie
        $saved_cart_items = $this->_read_cart_cookie();

        // Get current key of item
        $curArrKey = array_search($colorId, array_column($saved_cart_items[$id], 'color'));
        if ($curArrKey === false) {
            message('error', 200, 'چنین محصولی در سبد خرید وجود ندارد!');
        }

        // delete cookie value
        $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

        // add the item with updated quantity
        $saved_cart_items[$id][$curArrKey]['quantity'] = $quantity;

        // enter new value
        $json = json_encode($saved_cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);

        if ($this->haveCartAccess === true) {
            return true;
        }
        message('success', 200, 'سبد خرید بروزرسانی شد.');
    }

    public function removeFromCartAction()
    {
        if (!is_ajax() && $this->haveCartAccess !== true) {
            message('error', 403, 'دسترسی غیر مجاز');
        }

        $cookieModel = new CookieModel();
        $model = new Model();

        $id = $_POST['postedId'] ?? null;
        $colorCode = $_POST['postedColorCode'] ?? null;
        if (!isset($id) || !is_numeric($id)) {
            message('error', 200, 'ورودی نامعتبر است.');
        }
        if (!$model->is_exist('products', 'id=:id', ['id' => $id])) {
            message('error', 200, 'این محصول وجود ندارد.');
        }
        if (!$model->it_count('products', 'id=:id AND stock_count>:sc AND available=:av', ['id' => $id, 'sc' => 0, 'av' => 1])) {
            message('error', 200, 'محصول ناموجود است.');
        }

        // read
        $saved_cart_items = $this->_read_cart_cookie();

        if (isset($colorCode) && $colorCode == 'all') {
            // remove the item from the array
            unset($saved_cart_items[$id]);

            // delete cookie value
            unset($_COOKIE[$this->cartCookieName]);

            // empty value and expiration one hour before
            $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

            // enter new value
            $json = json_encode($saved_cart_items);
            $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);
            $_COOKIE[$this->cartCookieName] = $json;

            if ($this->haveCartAccess === true) {
                $this->haveCartAccess = false;
                return $saved_cart_items;
            }
            exit;
        }

        // Find color id with color code or select first one
        if (isset($colorCode) && $model->is_exist('colors', 'color_code=:cc', ['cc' => $colorCode])) {
            $colorId = $model->select_it(null, 'colors', 'id', 'color_code=:cc', ['cc' => $colorCode])[0]['id'];
            if (!$model->is_exist('products_colors', 'product_id=:pId AND color_id=:cId', ['pId' => $id, 'cId' => $colorId])) {
                message('error', 200, 'محصول مورد نظر با چنین رنگی وجود ندارد!');
            }
        } else {
            message('error', 200, 'محصول مورد نظر با چنین رنگی وجود ندارد!');
        }
        if (!$model->it_count('products_colors', 'product_id=:id AND color_id=:cId AND count>:c', ['id' => $id, 'cId' => $colorId, 'c' => 0])) {
            message('error', 200, 'محصول ناموجود است.');
        }

        // Get current key of item
        $curArrKey = array_search($colorId, array_column($saved_cart_items[$id], 'color'));
        if ($curArrKey === false) {
            message('error', 200, 'چنین محصولی در سبد خرید وجود ندارد!');
        }

        $saved_cart_items = array_map('array_values', $saved_cart_items);

        // remove the item from the array
        unset($saved_cart_items[$id][$curArrKey]);

        // delete cookie value
        unset($_COOKIE[$this->cartCookieName]);

        // empty value and expiration one hour before
        $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

        // enter new value
        $json = json_encode($saved_cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);
        $_COOKIE[$this->cartCookieName] = $json;

        $cart_items_count = array_sum(array_map(function ($v) {
            return count($v);
        }, $saved_cart_items));

        if ($this->haveCartAccess === true) {
            $this->haveCartAccess = false;
            return $saved_cart_items;
        } else {
            message('info', 200, ['محصول از سبد خرید حذف شد.', $cart_items_count]);
            exit;
        }
    }

    public function removeAllFromCartAction()
    {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');

        $cookieModel = new CookieModel();

        // read
        $saved_cart_items = $this->_read_cart_cookie();

        // remove values
        unset($saved_cart_items);
        $saved_cart_items = array();

        // delete cookie value
        unset($_COOKIE[$this->cartCookieName]);

        // empty value and expiration one hour before
        $cookieModel->set_cookie($this->cartCookieName, '', time() - 3600);

        // enter empty value
        $json = json_encode($saved_cart_items);
        $cookieModel->set_cookie($this->cartCookieName, $json, time() + 365 * 24 * 60 * 60, '/', null, null, true);
        $_COOKIE[$this->cartCookieName] = $json;
    }

    public function fetchUpdatedCartAction()
    {
        if (!is_ajax()) {
            message('error', 403, 'دسترسی غیر مجاز');
        }

        $saved_cart_items = $this->_read_cart_cookie();

        // Fetch cart items

        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $data['items'] = $cartItems['items'];
        //-----
        $data['totalAmount'] = 0;
        $data['totalDiscountedAmount'] = 0;
        foreach ($data['items'] as $item) {
            $data['totalAmount'] += $item['price'] * $item['quantity'];
            $data['totalDiscountedAmount'] += $item['discount_price'] * $item['quantity'];
        }
        $data['auth'] = $this->auth;

        message('success', 200, $this->load->view('templates/fe/cart/main-cart', $data, true));
    }

    public function fetchCardItemsAction()
    {
        $saved_cart_items = $this->_read_cart_cookie();
        $data['auth'] = $this->data['auth'];
        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $data['items'] = $cartItems['items'];
        //-----
        $data['totalAmount'] = 0;
        foreach ($data['items'] as $item) {
            $data['totalAmount'] += $item['discount_price'] * $item['quantity'];
        }

        $cart_items_count = array_sum(array_map(function ($v) {
            return count($v);
        }, $saved_cart_items));

        if (!is_ajax()) {
            return [$this->load->view('templates/fe/cart/cart-items', $data, true), $cart_items_count];
        } else {
            message('success', 200, [$this->load->view('templates/fe/cart/cart-items', $data, true), $cart_items_count]);
            exit;
        }
    }

    //----->

    private function _read_cart_cookie()
    {
        $cookieModel = new CookieModel();
        $cookie = $cookieModel->is_cookie_set($this->cartCookieName, true, true);
        $cookie = $cookie ? $cookie : "";
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);

        // if $saved_cart_items is null, prevent null error
        if (!$saved_cart_items) {
            $saved_cart_items = array();
        }

        return $saved_cart_items;
    }

    private function _fetch_cart_items($cookie_items = null)
    {
        //-----
        $model = new Model();
        //-----
        $cartItems = $this->_check_cart_items_again($cookie_items);
        $tmpItems = $cartItems['items'];
        $saved_cart_items = $this->_read_cart_cookie();
        //-----
        $items = [];
        //-----
        foreach ($tmpItems as $info) {
            $res = $info;
            foreach ($saved_cart_items[$res['id']] as $k => $v) {
                //-----
                if (isset($v['color']) && $model->is_exist('products_colors', 'product_id=:pId AND color_id=:cId',
                        ['pId' => $res['id'], 'cId' => $v['color']])) {
                    $tmpColorCount = $model->select_it(null, 'products_colors', 'count',
                        'product_id=:pId AND color_id=:cId', ['pId' => $res['id'], 'cId' => $v['color']])[0]['count'];
                    $tmpColorCount = convertNumbersToPersian($tmpColorCount, true);
                    $color = $model->select_it(null, 'colors', ['id', 'color_code', 'color_name', 'color_hex', 'deletable'],
                        'id=:id', ['id' => $v['color']])[0];
                    $res['color_code'] = $color['color_code'];
                    $res['color_name'] = $color['color_name'];
                    $res['color_hex'] = $color['color_hex'];
                    $res['deletable'] = $color['deletable'];
                } else {
                    $this->haveCartAccess = true;
                    $_POST['postedId'] = $res['id'];
                    $_POST['postedColorCode'] = 'all';
                    $saved_cart_items = $this->removeFromCartAction();
                    $this->haveCartAccess = false;
                    unset($_POST['postedId']);
                    unset($_POST['postedColorCode']);
                    continue;
                }
                //-----
                $price = $model->select_it(null, 'products_guarantee', 'guarantee_price',
                    'product_id=:pId', ['pId' => $res['id']]);
                if (count($price)) {
                    $price = convertNumbersToPersian($price[0]['guarantee_price'], true) ?: 0;
                } else {
                    $price = 0;
                }

                $res['guarantee_price'] = $price;
                $res['base_price'] = convertNumbersToPersian($model->select_it(null, 'products_colors', 'price',
                    'product_id=:pId AND color_id=:cId AND count>:c', ['pId' => $res['id'], 'cId' => $color['id'], 'c' => 0],
                    null, 'id ASC', 1)[0]['price'], true);
                $res['price'] = $price + $res['base_price'];

                $discount = $res['discount'];
                $haveFestival = false;

                if (in_array($res['f_id'], $this->data['activeFestivalsId'])) {
                    $discount = $res['festival_discount'];
                    $haveFestival = $res['festival_discount'] ? true : false;
                }
                $haveDiscount = $discount ? true : false;

                $res['in_festival'] = $haveFestival;

                if ($haveDiscount) {
                    if (!$haveFestival && $res['discount_unit'] == 1) {
                        $res['discount_amount'] = $res['discount'] ?: 0;
                        $discountedPrice = convertNumbersToPersian($res['price'], true) - convertNumbersToPersian($res['discount'] ?: 0, true);
                    } else if ($haveFestival || $res['discount_unit'] == 2) {
                        $res['discount_amount'] = $discount ?: 0;
                        $discountedPrice = convertNumbersToPersian($res['price'], true) - (convertNumbersToPersian($res['price'], true) * convertNumbersToPersian($discount ?: 0, true) / 100);
                    }
                } else {
                    $res['discount_amount'] = 0;
                    $discountedPrice = convertNumbersToPersian($res['price'], true);
                }
                $res['discount_price'] = $discountedPrice;
                $res['quantity'] = $v['quantity'] > $tmpColorCount ? $tmpColorCount : $v['quantity'];

                $items[] = $res;
            }
        }

        return [
            'deleted' => $cartItems['deleted'],
            'items' => $items
        ];
    }

    private function _check_cart_items_again($cookie_items = null)
    {
        $delete_items_array = [];
        $main_items_array = [];
        //-----
        $saved_cart_items = is_null($cookie_items) ? $this->_read_cart_cookie() : $cookie_items;

        // Check if we have any item in cart
        if (!count($saved_cart_items)) {
            return [
                'deleted' => $delete_items_array,
                'items' => $main_items_array
            ];
        }
        //-----
        $model = new Model();
        //-----
        foreach ($saved_cart_items as $id => $eachItem) {
            foreach ($eachItem as $k => $item) {
                $mainItem = $model->join_it(null, 'products_festivals AS pf', 'products_advanced AS p', [
                    'pf.festival_id AS f_id', 'pf.discount AS festival_discount', 'p.id', 'p.product_code', 'p.product_title',
                    'p.image', 'p.discount', 'p.discount_unit', 'p.stock_count', 'p.brand_name', 'p.brand_id', 'p.category_code',
                    'p.category_name', 'p.available'
                ], 'pf.product_id=p.id', 'p.id=:id AND p.stock_count>:sc AND p.available=:av', ['id' => $id, 'sc' => 0, 'av' => 1],
                    ['p.id'], null, null, null, false, 'RIGHT');
                $mainItemColor = $model->select_it(null, 'products_colors', ['count'],
                    'product_id=:pId AND color_id=:cId', ['pId' => $id, 'cId' => $item['color']]);
                $this->haveCartAccess = true;
                if (!count($mainItem) || !count($mainItemColor) ||
                    (count($mainItem) && $mainItem[0]['available'] == 0) ||
                    (count($mainItemColor) && $mainItemColor[0]['count'] == 0)) {

                    $_POST['postedId'] = $id;
                    $_POST['postedColorCode'] = 'all';
                    if (count($mainItemColor)) {
                        $_POST['postedColorCode'] = $item['color'];
                    }
                    if (count($mainItem)) {
                        $delete_items_array[] = $mainItem[0];
                    }
                    $this->removeFromCartAction();
                    //-----
                    unset($_POST['postedId']);
                    unset($_POST['postedColorCode']);
                }
                if (count($mainItemColor) && $mainItemColor[0]['count'] < $item['quantity']) {
                    $colorCode = $model->select_it(null, 'colors', ['color_code'],
                        'id=:id', ['id' => $item['color']])[0]['color_code'];
                    $_POST['postedId'] = $id;
                    $_POST['postedColorCode'] = $colorCode;
                    $_POST['quantity'] = $mainItemColor[0]['count'];
                    if ($this->updateCartAction() === true) {
                        $delete_items_array[] = $mainItem[0];
                    }
                    //-----
                    unset($_POST['postedId']);
                    unset($_POST['postedColorCode']);
                    unset($_POST['quantity']);
                }
                if (count($mainItem)) {
                    $main_items_array[] = $mainItem[0];
                }
                $this->haveCartAccess = false;
            }
        }
        return [
            'deleted' => $delete_items_array,
            'items' => $main_items_array
        ];
    }

    //------------------------
    //---- Gateway actions ---
    //------------------------

    private function _gateway_processor($payment, $address, $shipping, $wantFactor, $offCode)
    {
        $gatewayCode = $payment['method_code'];
        $model = new Model();
        // Select gateway table if gateway code is one of the bank payment gateway's code
        foreach ($this->gatewayTables as $table => $codeArr) {
            if (array_search($gatewayCode, $codeArr) !== false) {
                $gatewayTable = $table;
                break;
            }
        }
        // Create transaction
        $model->transactionBegin();
        // Create factor code
        $common = new CommonModel();
        $factorCode = $common->generate_random_unique_code('factors', 'factor_code', 'BTK_', 6, 15, 10, CommonModel::DIGITS);
        $factorCode = 'BTK_' . $factorCode;
        // Check cart and cart items
        $cartItems = $this->_fetch_cart_items();
        $items = $cartItems['items'];
        // Insert factor information to factors table
        $res1 = $model->insert_it('factors', [
            'factor_code' => $factorCode,
            'user_id' => $this->data['identity']->id,
            'first_name' => $this->data['identity']->first_name,
            'last_name' => $this->data['identity']->last_name,
            'mobile' => $this->data['identity']->username,
            'method_code' => $gatewayCode,
            'payment_title' => $payment['method_title'],
            'payment_status' => OWN_PAYMENT_STATUS_NOT_PAYED,
            'send_status' => 1,
            'shipping_address' => $address['address'],
            'shipping_receiver' => $address['receiver'],
            'shipping_province' => $address['province'],
            'shipping_city' => $address['city'],
            'shipping_postal_code' => $address['postal_code'],
            'shipping_phone' => $address['phone'],
            'want_factor' => $wantFactor ? 1 : 0,
            'order_date' => time()
        ]);
        // Calculate price of product(s) and store in factors_item
        $totalAmount = 0;
        $totalDiscountedAmount = 0;
        $discountPrice = 0;
        foreach ($items as $item) {
            try {
                $productTotalPrice = $item['price'] * $item['quantity'];
                // Add to total amount and total discounted amount variable
                $totalAmount += $productTotalPrice;
                $totalDiscountedAmount += $item['discount_price'] * $item['quantity'];
                $discountPrice = $totalAmount - $totalDiscountedAmount;
                // Insert each product information to factors_item table
                $model->insert_it('factors_item', [
                    'factor_code' => $factorCode,
                    'product_code' => $item['product_code'],
                    'product_count' => $item['quantity'],
                    'product_color' => $item['color_name'],
                    'product_color_hex' => $item['color_hex'],
                    'product_unit_price' => $item['base_price'],
                    'product_price' => $productTotalPrice,
                ]);
                $model->update_it('products', [], 'product_code=:pc', ['pc' => $item['product_code']], [
                    'stock_count' => 'stock_count-' . (int)$item['quantity'],
                    'sold_count' => 'sold_count+' . (int)$item['quantity'],
                ]);
            } catch (Exception $e) {
                continue;
            }
        }

        // Coupon check
        $couponCode = '';
        $couponTitle = '';
        $couponAmount = '';
        $couponUnit = null;
        if ($this->_validate_coupon($offCode)) {
            $theCoupon = $model->select_it(null, 'coupons', ['coupon_code', 'coupon_title', 'amount', 'unit'],
                'coupon_code=:code AND coupon_expire_time>=:expire', ['code' => $offCode, 'expire' => time()])[0];
            $couponCode = $offCode;
            $couponTitle = $theCoupon['coupon_title'];
            $couponAmount = $theCoupon['amount'];
            $couponUnit = $theCoupon['unit'];

            // Discount coupon price
            if ($theCoupon['unit'] == 2) { // Percentage unit
                $totalDiscountedAmount -= ($totalDiscountedAmount * convertNumbersToPersian($theCoupon['amount'], true) / 100);
            } else { // Otherwise it is toman unit
                $totalDiscountedAmount -= convertNumbersToPersian($theCoupon['amount'], true);
            }
        }

        // Add shipping price to total amounts
        $totalAmount += $totalDiscountedAmount < convertNumbersToPersian($shipping['max_price'], true) ?
            convertNumbersToPersian($shipping['shipping_price'], true) : 0;
        $totalDiscountedAmount += $totalDiscountedAmount < convertNumbersToPersian($shipping['max_price'], true) ?
            convertNumbersToPersian($shipping['shipping_price'], true) : 0;

        // Update factor information in factors table
        $res2 = $model->update_it('factors', [
            'amount' => $totalAmount,
            'shipping_title' => $shipping['shipping_title'],
            'shipping_price' => $totalDiscountedAmount < convertNumbersToPersian($shipping['max_price'], true) ?
                convertNumbersToPersian($shipping['shipping_price'], true) : 0,
            'shipping_min_days' => $shipping['min_days'],
            'shipping_max_days' => $shipping['max_days'],
            'final_amount' => $totalDiscountedAmount,
            'coupon_code' => $couponCode,
            'coupon_title' => $couponTitle,
            'coupon_amount' => $couponAmount,
            'coupon_unit' => $couponUnit,
            'discount_price' => $discountPrice,
        ], 'factor_code=:fc', ['fc' => $factorCode]);

        // Insert factor code to reserved factors codes
        $reserved = $model->insert_it('factors_reserved', [
            'factor_code' => $factorCode,
            'factor_time' => time(),
        ]);
        //-----

        if (!$res1 || !$res2 || !$reserved) {
            $model->transactionRollback();
            return false;
        } else {
            // Make transaction complete
            $model->transactionComplete();

            // Delete cart items
            $this->removeAllFromCartAction();

            // If any gateway exists (if method code is one of the bank payment gateways)
            if (isset($gatewayTable)) {
                // Fill parameters variable to pass between gateway connection functions
                $parameters = [
                    'price' => $discountPrice,
                    'factor_code' => $factorCode,
                ];
                // Call one of the [_*_connection] functions
                $res = call_user_func_array($this->gatewayFunctions[$gatewayTable], $parameters);
                if (!$res) {
                    $model->delete_it('factors', 'factor_code=:fc', ['fc' => $factorCode]);
                    return false;
                }
            } else {
                $_SESSION[$this->otherParamSessionName] = encryption_decryption(ED_ENCRYPT, $factorCode);
                $this->redirect(base_url('paymentResult/' . self::PAYMENT_RESULT_PARAM_OTHER), 'لطفا صبر کنید...در حال نهایی‌سازی ثبت سفارش', 1);
            }
            return true;
        }
    }

    // Gateway connection functions

    protected function _idpay_connection($parameters)
    {
        $this->load->library('HPayment/vendor/autoload');
        try {
            $model = new Model();
            $idpay = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_IDPAY);
            //-----
            $redirectMessage = 'انتقال به درگاه پرداخت ...';
            $wait = 1;
            //-----
            $payRes = $idpay->create_request([
                'order_id' => $parameters['factor_code'],
                'amount' => $parameters['price'] * 10,
                'callback' => base_url('paymentResult/' . self::PAYMENT_RESULT_PARAM_IDPAY)])->get_result();
            // Handle result of payment gateway
            if ((!isset($payRes['error_code']) || $idpay->get_message($payRes['error_code'], Payment::PAYMENT_STATUS_REQUEST_IDPAY) === false) && isset($payRes['id']) && isset($payRes['link'])) {
                // Insert new payment in DB
                $res = $model->insert_it(self::PAYMENT_TABLE_IDPAY, [
                    'factor_code' => $parameters['factor_code'],
                    'payment_id' => $payRes['id'],
                    'payment_link' => $payRes['link'],
                ]);

                if ($res) {
                    // Send user to idpay for transaction
                    $this->redirect($payRes['link'], $redirectMessage, $wait);
                    return true;
                } else {
//                    $error = 'عملیات انجام تراکنش با خطا روبرو شد! لطفا مجددا تلاش نمایید.';
                    return false;
                }
            } else {
                return false;
            }
        } catch (PaymentException $e) {
//            $error = $e->__toString();
            return false;
        }
    }

    protected function _mabna_connection()
    {

    }

    protected function _zarinpal_connection($parameters)
    {
        $this->load->library('HPayment/vendor/autoload');
        try {
            $model = new Model();
            $zarinpal = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_ZARINPAL);
            //-----
            $redirectMessage = 'انتقال به درگاه پرداخت ...';
            $wait = 1;
            //-----
            $payRes = $zarinpal->create_request([
                'Amount' => $parameters['price'],
                'Description' => '',
                'CallbackURL' => base_url('paymentResult/' . self::PAYMENT_RESULT_PARAM_ZARINPAL)])->get_result();
            if ($payRes->Status == Payment::PAYMENT_STATUS_OK_ZARINPAL) {
                // Insert new payment in DB
                $res = $model->insert_it(self::PAYMENT_TABLE_ZARINPAL, [
                    'authority' => 'zarinpal-' . $payRes->Authority,
                    'factor_code' => $parameters['factor_code'],
                ]);

                if ($res) {
                    // Send user to zarinpal for transaction
                    $this->redirect($zarinpal->urls[Payment::PAYMENT_URL_PAYMENT_ZARINPAL] . $payRes->Authority, $redirectMessage, $wait);
                    return true;
                } else {
//                    $error = 'عملیات انجام تراکنش با خطا روبرو شد! لطفا مجددا تلاش نمایید.';
                    return false;
                }
            } else {
//                $error = $zarinpal->get_message($payRes->Status);
                return false;
            }
        } catch (PaymentException $e) {
//            $error = $e->__toString();
            return false;
        }
    }

    // Gateway get result functions

    protected function _idpay_result()
    {
        $this->load->library('HPayment/vendor/autoload');

        try {
            $model = new Model();
            $idpay = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_IDPAY);
            $postVars = $idpay->handle_request()->get_result();

            // Check for factor first and If factor exists
            if (isset($postVars['order_id']) && isset($postVars['status']) &&
                $model->is_exist('factors', 'factor_code=:fc', ['fc' => $postVars['order_id']])) {
                // Set factor_code to global data
                $this->data['factor_code'] = $postVars['order_id'];
                // Select factor
                $factor = $model->select_it(null, 'factors', [
                    'factor_code', 'final_amount', 'payment_status'
                ], 'factor_code=:fc', ['fc' => $postVars['order_id']])[0];
                // Select factor payment according to gateway id result
                $factorPayment = $model->select_it(null, self::PAYMENT_TABLE_IDPAY, [
                    'payment_id', 'status'
                ], 'factor_code=:fc AND payment_id=:pId', ['fc' => $postVars['order_id'], 'pId' => $postVars['id']]);
                // If there is a record in gateway table(only one record is acceptable)
                if (count($factorPayment) == 1) {
                    // Select factor payment
                    $factorPayment = $factorPayment[0];
                    // Check if factor was advice before
                    if ($factor['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED &&
                        !in_array($factorPayment['status'], [Payment::PAYMENT_STATUS_OK_IDPAY, Payment::PAYMENT_STATUS_DUPLICATE_IDPAY]) &&
                        $postVars['status'] == Payment::PAYMENT_STATUS_WAIT_IDPAY) {
                        // Check for returned amount
                        if ((intval($factor['final_amount']) * 10) == $postVars['amount']) {
                            // If all are ok send advice to bank gateway
                            // This means ready to transfer money to our bank account
                            $advice = $idpay->send_advice([
                                'id' => $postVars['id'],
                                'order_id' => $postVars['order_id']
                            ]);

                            // Check for error
                            if (!isset($advice['error_code'])) {
                                $status = $advice['status'];

                                // Check for status if it's just OK/100 [100 => OK, 101 => Duplicate, etc.]
                                if ($status == Payment::PAYMENT_STATUS_OK_IDPAY) {
                                    // Store extra info from bank's gateway result
                                    $model->update_it('factors', [
                                        'payment_status' => OWN_PAYMENT_STATUS_SUCCESSFUL
                                    ], 'factor_code=:fc', ['fc' => $factor['factor_code']]);
                                    $model->update_it(self::PAYMENT_TABLE_IDPAY, [
                                        'payment_code' => $advice['payment']['track_id'],
                                        'status' => $status,
                                    ], 'factor_code=:fc', ['fc' => $factor['factor_code']]);
                                    $success = $idpay->get_message($status, Payment::PAYMENT_STATUS_VERIFY_IDPAY);
                                    $traceNumber = $advice['payment']['track_id'];

                                    // Set success parameters
                                    $this->data['success'] = $success;
                                    $this->data['is_success'] = true;
                                    $this->data['ref_id'] = $traceNumber;
                                    $this->data['have_ref_id'] = true;

                                    // Send sms to user if is login
//                                    if ($this->auth->isLoggedIn()) {
//                                        $this->load->library('HSMS/rohamSMS');
//                                        $sms = new rohamSMS();
//                                        try {
//                                            $is_sent = $sms->set_numbers($this->data['identity']->username)->body('خرید با موفقیت برای فاکتور ' . $factor['factor_code'] . ' انجام شد.')->send();
//                                        } catch (SMSException $e) {
//                                            die($e->getMessage());
//                                        }
//                                    }
                                    // Store sms operation to database
                                }
                            } else {
                                $this->data['error'] = $idpay->get_message($advice['error_code'], Payment::PAYMENT_STATUS_VERIFY_IDPAY);
                                $this->data['is_success'] = false;
                                $this->data['ref_id'] = $postVars['track_id'];
                                $this->data['have_ref_id'] = true;
                            }
                        } else {
                            $this->data['error'] = 'فاکتور نامعتبر است!';
                            $this->data['is_success'] = false;
                            $this->data['ref_id'] = $postVars['track_id'];
                            $this->data['have_ref_id'] = true;
                        }
                    } else {
                        $this->data['error'] = 'فاکتور نامعتبر است!';
                        $this->data['is_success'] = false;
                        $this->data['ref_id'] = $postVars['track_id'];
                        $this->data['have_ref_id'] = true;
                    }
                } else {
                    $this->data['error'] = 'فاکتور نامعتبر است!';
                    $this->data['is_success'] = false;
                    $this->data['ref_id'] = $postVars['track_id'];
                    $this->data['have_ref_id'] = true;
                }

                // Store current result from bank gateway
                $model->update_it('factors', [
                    'payment_date' => $postVars['date']
                ], 'factor_code=:fc', ['fc' => $factor['factor_code']]);
                $model->update_it(self::PAYMENT_TABLE_IDPAY, [
                    'status' => isset($status) ? $status : $postVars['status'],
                    'track_id' => $postVars['track_id'],
                    'msg' => isset($status) ? $idpay->get_message($status, Payment::PAYMENT_STATUS_VERIFY_IDPAY) : $idpay->get_message($postVars['status'], Payment::PAYMENT_STATUS_VERIFY_IDPAY),
                    'mask_card_number' => $postVars['card_no'],
                    'payment_date' => time(),
                ], 'factor_code=:fc', ['fc' => $factor['factor_code']]);

                // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                if (isset($success)) {
                    $model->delete_it('factors_reserved', 'factor_code=:fc', ['fc' => $factor['factor_code']]);
                }
            } else {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } catch (PaymentException $e) {
            die($e);
        }
    }

    protected function _mabna_result()
    {

    }

    protected function _zarinpal_result()
    {
        $this->load->library('HPayment/vendor/autoload');

        try {
            $model = new Model();
            $zarinpal = PaymentFactory::get_instance(PaymentFactory::BANK_TYPE_ZARINPAL);
            $getVars = $zarinpal->handle_request()->get_result();
            if (!isset($getVars[Payment::PAYMENT_RETURNED_AUTHORITY_ZARINPAL]) || !isset($getVars[Payment::PAYMENT_RETURNED_STATUS_ZARINPAL])) {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
                return;
            }

            $authority = $getVars[Payment::PAYMENT_RETURNED_AUTHORITY_ZARINPAL];
            // Get payment with current authority
            $curPay = $model->select_it(null, self::PAYMENT_TABLE_ZARINPAL, '*',
                'authority=:auth', ['auth' => 'zarinpal-' . $authority]);

            if (count($curPay)) {
                $curPay = $curPay[0];
                // Set factor_code to global data
                $this->data['factor_code'] = $curPay['factor_code'];
                if ($curPay['status'] != Payment::PAYMENT_TRANSACTION_SUCCESS_ZARINPAL) {
                    $res = $zarinpal->verify_request($curPay['amount']);
                    if (intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_SUCCESS_ZARINPAL || // Successful transaction
                        intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_DUPLICATE_ZARINPAL) { // Duplicated transaction
                        $this->data['is_success'] = true;
                        $this->data['have_ref_id'] = true;

                        if (intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_SUCCESS_ZARINPAL) {
                            $this->data['ref_id'] = $res->RefID;

                            // Update payment status and refID for success
                            $model->update_it(self::PAYMENT_TABLE_ZARINPAL, [
                                'payment_code' => $this->data['ref_id'],
                                'status' => $zarinpal->status,
                                'payment_date' => time(),
                            ], 'authority=:auth', ['auth' => 'zarinpal-' . $authority]);
                            $model->update_it('factors', [
                                'payment_status' => OWN_PAYMENT_STATUS_SUCCESSFUL,
                                'payment_date' => time(),
                            ],
                                'factor_code=:fc', ['fc' => $curPay['factor_code']]);
                        }
                    } else if (intval($zarinpal->status) == Payment::PAYMENT_TRANSACTION_CANCELED_ZARINPAL) { // Transaction was canceled
                        $this->data['is_success'] = false;
                        $this->data['have_ref_id'] = false;
                        $this->data['error'] = $res;
                    } else { // Failed transaction
                        $this->data['is_success'] = false;
                        $this->data['have_ref_id'] = true;
                        $this->data['ref_id'] = $res->RefID;

                        // Update payment status and refID for fail
                        $model->update_it(self::PAYMENT_TABLE_ZARINPAL, [
                            'payment_code' => $this->data['ref_id'],
                            'status' => $zarinpal->status,
                            'payment_date' => time(),
                        ], 'authority=:auth', ['auth' => 'zarinpal-' . $authority]);
                        $model->update_it('factors', [
                            'payment_status' => OWN_PAYMENT_STATUS_FAILED,
                            'payment_date' => time(),
                        ],
                            'factor_code=:fc', ['fc' => $curPay['factor_code']]);
                        $this->data['error'] = $zarinpal->get_message($zarinpal->status);
                    }

                    // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                    if ($this->data['is_success']) {
                        $model->delete_it('factors_reserved', 'factor_code=:fc', ['fc' => $curPay['factor_code']]);
                    }
                } else {
                    $this->data['is_success'] = true;
                    $this->data['have_ref_id'] = true;
                    $this->data['ref_id'] = $curPay['payment_code'];
                }
            } else {
                $this->data['error'] = 'تراکنش نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } catch (PaymentException $e) {
            die($e);
        }
    }

    protected function _other_result()
    {
        $model = new Model();
        if (isset($_SESSION[$this->otherParamSessionName])) {
            $factorCode = encryption_decryption(ED_DECRYPT, $_SESSION[$this->otherParamSessionName]);

            if ($model->is_exist('factors', 'factor_code=:fc', ['fc' => $factorCode])) {
                $model->update_it('factors', [
                    'payment_status' => OWN_PAYMENT_STATUS_WAIT,
                    'payment_date' => time(),
                ], 'factor_code=:fc', ['fc' => $factorCode]);

                $this->data['factor_code'] = $factorCode;
                $this->data['is_success'] = true;
                $this->data['have_ref_id'] = false;

                // Delete factor from reserved items if result is success otherwise give some time to user to pay its items
                $model->delete_it('factors_reserved', 'factor_code=:fc', ['fc' => $factorCode]);
            } else {
                $this->data['error'] = 'فاکتور نامعتبر است!';
                $this->data['is_success'] = false;
                $this->data['have_ref_id'] = false;
            }
        } else {
            $this->data['error'] = 'ورودی نامعتبر است!';
            $this->data['is_success'] = false;
            $this->data['have_ref_id'] = false;
        }
    }

    //-----

    protected function _cancel_reserved_items()
    {
        // Remove not payed items from reserved factors and return item(s) count to stock
        $model = new Model();
        $reservedTime = time() - OWN_WAIT_TIME;
        $previouslyReserved = $model->select_it(null, 'factors_reserved', '*', 'factor_time<=:ft', ['ft' => $reservedTime]);
        if (count($previouslyReserved)) {
            foreach ($previouslyReserved as $reserved) {
                $factorStatus = $model->select_it(null, 'factors', 'payment_status', 'factor_code=:fc', ['fc' => $reserved['factor_code']]);
                $items = $model->select_it(null, 'factors_item', ['product_code', 'product_count'], 'factor_code=:fc', ['fc' => $reserved['factor_code']]);
                foreach ($items as $k => $item) {
                    try {
                        $res = $model->update_it('products', [], [
                            'stock_count' => 'stock_count+' . (int)$item['product_count'],
                            'sold_count' => 'sold_count-' . (int)$item['product_count'],
                        ]);
                    } catch (Exception $e) {
                    }
                }
                if (count($factorStatus) && $factorStatus[0]['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED) {
                    $model->delete_it('factors', 'factor_code=:fc', ['fc' => $reserved['factor_code']]);
                } else if ($factorStatus[0]['payment_status'] == OWN_PAYMENT_STATUS_FAILED) {
                    $model->update_it('factors', [
                        'send_status' => 8
                    ], 'factor_code=:fc', ['fc' => $reserved['factor_code']]);
                }
            }
            $model->delete_it('factors_reserved', 'factor_time<=:ft', ['ft' => $reservedTime]);
        }
        //-----
    }

    //-----

    protected function _render_page($pages, $loadHeaderAndFooter = true)
    {
        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/home-header-part', $this->data);
        }

        $allPages = is_string($pages) ? [$pages] : (is_array($pages) ? $pages : []);
        foreach ($allPages as $page) {
            $this->load->view($page, $this->data);
        }

        if ($loadHeaderAndFooter) {
            $this->load->view('templates/fe/home-js-part', $this->data);
            $this->load->view('templates/fe/home-end-part', $this->data);
        }
    }
}