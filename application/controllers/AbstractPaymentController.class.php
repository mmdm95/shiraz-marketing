<?php
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
    protected $gatewayTables = [
        self::PAYMENT_TABLE_IDPAY => [
            'PAY_742147359',
            'PAY_328797312',
        ],
        self::PAYMENT_TABLE_MABNA => [],
        self::PAYMENT_TABLE_ZARINPAL => [],
    ];
    protected $gatewayFunctions = [
        self::PAYMENT_TABLE_IDPAY => [__CLASS__, '_idpay_connection'],
        self::PAYMENT_TABLE_MABNA => [__CLASS__, '_mabna_connection'],
        self::PAYMENT_TABLE_ZARINPAL => [__CLASS__, '_zarinpal_connection'],
    ];
    //-----
    const PAYMENT_RESULT_PARAM_IDPAY = 'idpay';
    const PAYMENT_RESULT_PARAM_MABNA = 'mabna';
    const PAYMENT_RESULT_PARAM_ZARINPAL = 'zarinpal';
    const PAYMENT_RESULT_PARAM_OTHER = 'other';
    protected $paymentResultParam = [
        self::PAYMENT_RESULT_PARAM_IDPAY => [__CLASS__, '_idpay_result'],
        self::PAYMENT_RESULT_PARAM_MABNA => [__CLASS__, '_mabna_result'],
        self::PAYMENT_RESULT_PARAM_ZARINPAL => [__CLASS__, '_zarinpal_result'],
        self::PAYMENT_RESULT_PARAM_OTHER => [__CLASS__, '_other_result'],
    ];
    protected $paymentParamTable = [
        self::PAYMENT_RESULT_PARAM_IDPAY => self::PAYMENT_TABLE_IDPAY,
        self::PAYMENT_RESULT_PARAM_MABNA => self::PAYMENT_TABLE_MABNA,
        self::PAYMENT_RESULT_PARAM_ZARINPAL => self::PAYMENT_TABLE_ZARINPAL,
    ];

    // Define all tables' name for convenient
    // 23 table(s)
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
    const TBL_SEND_STATUS = 'send_status';
    const TBL_STATIC_PAGES = 'static_pages';
    const TBL_USER = 'users';
    const TBL_USER_ACCOUNT = 'user_accounts';
    const TBL_USER_ACCOUNT_DEPOSIT = 'user_account_deposit';
    const TBL_USER_BANK_ACCOUNT = 'user_bank_accounts';

    //-----

    public function __construct()
    {
        parent::__construct();
    }
}
