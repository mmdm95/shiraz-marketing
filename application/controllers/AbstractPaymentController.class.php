<?php

use HPayment\Payment;

defined('BASE_PATH') OR exit('No direct script access allowed');

abstract class AbstractPaymentController extends HController
{
    protected $auth;
    protected $setting;
    protected $data = [];
    //-----
    const AJAX_TYPE_ERROR = 'error';
    const AJAX_TYPE_INFO = 'info';
    const AJAX_TYPE_WARNING = 'warning';
    const AJAX_TYPE_SUCCESS = 'success';
    // Define payment tables and codes and functions
    const PAYMENT_TABLE_MABNA = 'gateway_mabna';
    const PAYMENT_TABLE_IDPAY = 'gateway_idpay';
    const PAYMENT_TABLE_ZARINPAL = 'gateway_zarinpal';
    const PAYMENT_TABLE_BEH_PARDAKHT = 'gateway_beh_pardakht';
    protected $gatewayTables = [
        self::PAYMENT_TABLE_IDPAY => [
            'PAY_798447359',
        ],
        self::PAYMENT_TABLE_MABNA => [],
        self::PAYMENT_TABLE_BEH_PARDAKHT => [
            'PAY_342515312',
        ],
        self::PAYMENT_TABLE_ZARINPAL => [],
    ];
    protected $gatewayFunctions = [
        self::PAYMENT_TABLE_IDPAY => [\Home\AbstractController\AbstractController::class, '_idpay_connection'],
        self::PAYMENT_TABLE_ZARINPAL => [\Home\AbstractController\AbstractController::class, '_zarinpal_connection'],
    ];
    //-----
    const PAYMENT_RESULT_PARAM_IDPAY = 'idpay';
    const PAYMENT_RESULT_PARAM_MABNA = 'mabna';
    const PAYMENT_RESULT_PARAM_BEH_PARDAKHT = 'beh_pardakht';
    const PAYMENT_RESULT_PARAM_ZARINPAL = 'zarinpal';
    const PAYMENT_RESULT_PARAM_WALLET = 'wallet';
    const PAYMENT_RESULT_PARAM_IN_PLACE = 'in_place';
    const PAYMENT_RESULT_PARAM_RECEIPT = 'receipt';
    protected $paymentResultParam = [
        self::PAYMENT_RESULT_PARAM_IDPAY => [\Home\AbstractController\AbstractController::class, '_idpay_result'],
        self::PAYMENT_RESULT_PARAM_MABNA => [\Home\AbstractController\AbstractController::class, '_mabna_result'],
        self::PAYMENT_RESULT_PARAM_BEH_PARDAKHT => [\Home\AbstractController\AbstractController::class, '_beh_pardakht_result'],
        self::PAYMENT_RESULT_PARAM_ZARINPAL => [\Home\AbstractController\AbstractController::class, '_zarinpal_result'],
        self::PAYMENT_RESULT_PARAM_WALLET => [\Home\AbstractController\AbstractController::class, '_wallet_result'],
        self::PAYMENT_RESULT_PARAM_IN_PLACE => [\Home\AbstractController\AbstractController::class, '_in_place_result'],
        self::PAYMENT_RESULT_PARAM_RECEIPT => [\Home\AbstractController\AbstractController::class, '_receipt_result'],
    ];
    protected $paymentParamTable = [
        self::PAYMENT_RESULT_PARAM_IDPAY => self::PAYMENT_TABLE_IDPAY,
        self::PAYMENT_RESULT_PARAM_MABNA => self::PAYMENT_TABLE_MABNA,
        self::PAYMENT_RESULT_PARAM_BEH_PARDAKHT => self::PAYMENT_TABLE_BEH_PARDAKHT,
        self::PAYMENT_RESULT_PARAM_ZARINPAL => self::PAYMENT_TABLE_ZARINPAL,
    ];
    protected $gatewaySuccessCode;

    // Define all tables' name for convenient
    // 25 table(s)
    const TBL_BLOG = 'blog';
    const TBL_BLOG_CATEGORY = 'blog_categories';
    const TBL_CATEGORY = 'categories';
    const TBL_CITY = 'cities';
    const TBL_COMPLAINT = 'complaints';
    const TBL_CONTACT_US = 'contact_us';
    const TBL_COUPON = 'coupons';
    const TBL_FAQ = 'faq';
    const TBL_ICON = 'icons';
    const TBL_MAIN_SLIDER = 'main_sliders';
    const TBL_ORDER = 'orders';
    const TBL_ORDER_ITEM = 'order_item';
    const TBL_ORDER_RESERVED = 'order_reserved';
    const TBL_PRODUCT = 'products';
    const TBL_PRODUCT_GALLERY = 'product_gallery';
    const TBL_PROVINCE = 'provinces';
    const TBL_RETURN_ORDER = 'return_order';
    const TBL_ROLE = 'roles';
    const TBL_SEND_STATUS = 'send_status';
    const TBL_STATIC_PAGES = 'static_pages';
    const TBL_USER = 'users';
    const TBL_USER_ROLE = 'users_roles';
    const TBL_USER_ACCOUNT = 'user_accounts';
    const TBL_USER_ACCOUNT_BUY = 'user_accounts_buy';
    const TBL_USER_ACCOUNT_DEPOSIT = 'user_account_deposit';

    //-----

    public function __construct()
    {
        parent::__construct();

        // Define gateway table to its success code after load library to access Payment constants
        $this->load->library('HPayment/vendor/autoload');
        $this->gatewaySuccessCode = [
            self::PAYMENT_TABLE_IDPAY => Payment::PAYMENT_STATUS_OK_IDPAY,
            self::PAYMENT_TABLE_MABNA => Payment::PAYMENT_STATUS_OK_MABNA,
            self::PAYMENT_TABLE_BEH_PARDAKHT => Payment::PAYMENT_STATUS_OK_BEH_PARDAKHT,
            self::PAYMENT_TABLE_ZARINPAL => Payment::PAYMENT_STATUS_OK_ZARINPAL,
        ];
    }

    public function getCityAction()
    {
        if (!is_ajax()) {
            $this->error->access_denied();
        }

        $model = new Model();

        $id = @$_POST['postedId'];
        $table = self::TBL_CITY;
        if (!isset($id)) {
            message(self::AJAX_TYPE_ERROR, 200, []);
        }
        if (!$model->is_exist(self::TBL_PROVINCE, 'id=:id', ['id' => $id])) {
            message(self::AJAX_TYPE_ERROR, 200, []);
        }

        $res = $model->select_it(null, $table, [
            'id', 'name'
        ], 'province_id=:id', ['id' => $id]);

        message(self::AJAX_TYPE_SUCCESS, 200, $res);
    }

    //-----

    protected function _isInfoFlagOK($uId)
    {
        $model = new Model();
        if (!$model->is_exist(self::TBL_USER, 'id=:id', ['id' => $uId])) {
            return false;
        }
        $user = $model->select_it(null, self::TBL_USER, '*', 'id=:id', ['id' => $uId])[0];
        if (!empty($user['first_name']) && !empty($user['last_name']) && !empty($user['n_code']) && !empty($user['province']) &&
            !empty($user['city']) && !empty($user['address']) && $user['image'] != PROFILE_DEFAULT_IMAGE && !empty($user['father_name']) &&
            !empty($user['gender']) && !empty($user['birth_certificate_code']) && !empty($user['birth_certificate_code_place']) &&
            !empty($user['birth_date']) && !empty($user['question1']) && !empty($user['question2']) &&
            !empty($user['question3']) && !empty($user['question4']) && !empty($user['question5']) &&
            !empty($user['question6']) && !empty($user['question7']) && !empty($user['description'])) {
            $model->update_it(self::TBL_USER, [
                'flag_info' => 1
            ], 'id=:id', ['id' => $uId]);
            return true;
        }
        $model->update_it(self::TBL_USER, [
            'flag_info' => 0
        ], 'id=:id', ['id' => $uId]);
        return false;
    }

    //-----

    protected function _uploadUserImage($inputName, $image, $imageName, $userId)
    {
        $userDir = PROFILE_IMAGE_DIR;
        //
        if (!file_exists($userDir)) {
            mkdir($userDir, 0777, true);
        }
        //
        $this->load->library('Upload/vendor/autoload');
        $storage = new \Upload\Storage\FileSystem($userDir, true);
        $file = new \Upload\File($inputName, $storage);

        // Set file name to user's phone number
        $file->setName($imageName);

        // Validate file upload
        // MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations(array(
            // Ensure file is of type "image/png"
            new \Upload\Validation\Mimetype(['image/png', 'image/jpg', 'image/jpeg', 'image/gif']),

            // Ensure file is no larger than 2M (use "B", "K", M", or "G")
            new \Upload\Validation\Size('2M')
        ));

        // Try to upload file
        try {
            // Success!
            $res = $file->upload();
        } catch (\Exception $e) {
            // Fail!
            $res = false;
        }
        //
        if ($res) {
            if ($userId == $this->data['identity']->id) {
                $this->auth->storeIdentity([
                    'image' => $image,
                ]);
                $this->data['identity'] = $this->auth->getIdentity();
            }

            return true;
        }
        return false;
    }
}
