<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

/**
 * App version
 * Use semantic-versioning (AKA SemVer) here
 * Numbers are Major.Minor.Patch[-a or -b]
 * -a stands for alpha
 * -b stands for beta
 * -rc stands for release candidate
 *
 * Note:
 *   Please use below options instead of -b and -a and -rc
 *     0 for alpha (status)
 *     1 for beta (status)
 *     2 for release candidate
 *     3 for (final) release
 *   ie.
 *     1.2.5.0 instead of 1.2.5-a
 *     1.2.5.0.1 instead of 1.2.5-a1 (I'm not sure)
 */
defined('APP_VERSION') OR define('APP_VERSION', '1.0.1');

//===============================================

/** Default page configuration ... */

// DEF_PLATFORM = folder of home page
defined('DEF_PLATFORM') OR define('DEF_PLATFORM', 'home');

// DEF_CONTROLLER = name of controller class
defined('DEF_CONTROLLER') OR define('DEF_CONTROLLER', 'Home');

// DEF_ACTION = name of controller class function
defined('DEF_ACTION') OR define('DEF_ACTION', 'index');

//===============================================

// Save The Keys In Your Configuration File
// Note: You must enter a base64 string
defined('MAIN_KEY') OR define('MAIN_KEY', 'ZClpMnB4LjVjZzhWVWxxQjNqYUhXYkB2PD8wIzF1c0RKcjlSKC0hNjp5b3xDJS93ZjRtNw==');
defined('ASSURED_KEY') OR define('ASSURED_KEY', 'NG9pP0VMemJqQXRyOjdQL18xV2xlO3hrWWc8MyM+MmRjW2YkNi01dndVWClEQHUwRihoXUJaLm5cT3BzISw4UkNISX45K1R8JiVxSnlNYVY=');

//===============================================

// Default user profile image
defined('PROFILE_DEFAULT_IMAGE') OR define('PROFILE_DEFAULT_IMAGE', 'public/fe/images/user-default.jpg');

// Default users profile image directory
defined('PROFILE_IMAGE_DIR') OR define('PROFILE_IMAGE_DIR', 'public/uploads/users/profileImages/');

// Default superset for users
defined('DEFAULT_SUPERSET') OR define('DEFAULT_SUPERSET', 'M-1000002');

// My custom payment status
defined('OWN_PAYMENT_STATUS_SUCCESSFUL') OR define('OWN_PAYMENT_STATUS_SUCCESSFUL', 1);
defined('OWN_PAYMENT_STATUS_FAILED') OR define('OWN_PAYMENT_STATUS_FAILED', 0);
defined('OWN_PAYMENT_STATUS_NOT_PAYED') OR define('OWN_PAYMENT_STATUS_NOT_PAYED', -9);
defined('OWN_PAYMENT_STATUS_WAIT') OR define('OWN_PAYMENT_STATUS_WAIT', -8);
defined('OWN_PAYMENT_STATUS_WAIT_VERIFY') OR define('OWN_PAYMENT_STATUS_WAIT_VERIFY', -7);
// My custom payment status array
defined('OWN_PAYMENT_STATUSES') OR define('OWN_PAYMENT_STATUSES', [
    OWN_PAYMENT_STATUS_SUCCESSFUL => 'پرداخت شده',
    OWN_PAYMENT_STATUS_FAILED => 'پرداخت ناموفق',
    OWN_PAYMENT_STATUS_NOT_PAYED => 'پرداخت نشده',
    OWN_PAYMENT_STATUS_WAIT => 'در انتظار پرداخت',
    OWN_PAYMENT_STATUS_WAIT_VERIFY => 'در انتظار تایید',
]);

// Shiraz city
defined('SHIRAZ_CITY') OR define('SHIRAZ_CITY', 232);

// My custom order code prefix
defined('ITEMS_EACH_PAGE_DEFAULT') OR define('ITEMS_EACH_PAGE_DEFAULT', 24);

// My custom sms replacement
defined('SMS_REPLACEMENT_CHARS') OR define('SMS_REPLACEMENT_CHARS', [
    'mobile' => '@mobile@',
    'code' => '@code@',
    'orderCode' => '@orderCode@',
    'status' => '@status@',
    'balance' => '@balance@',
]);

// My custom order code prefix
defined('ORDER_CODE_PREFIX') OR define('ORDER_CODE_PREFIX', 'SHM-');

// My custom send status
defined('SEND_STATUS_IN_QUEUE') OR define('SEND_STATUS_IN_QUEUE', 1);
defined('SEND_STATUS_UNVERIFIED') OR define('SEND_STATUS_UNVERIFIED', 2);
defined('SEND_STATUS_PREPARATION') OR define('SEND_STATUS_PREPARATION', 3);
defined('SEND_STATUS_OUT_OF_WAREHOUSE') OR define('SEND_STATUS_OUT_OF_WAREHOUSE', 4);
defined('SEND_STATUS_DELIVERED_TO_POST') OR define('SEND_STATUS_DELIVERED_TO_POST', 5);
defined('SEND_STATUS_DELIVERED_TO_CUSTOMER') OR define('SEND_STATUS_DELIVERED_TO_CUSTOMER', 6);
defined('SEND_STATUS_REFERRED') OR define('SEND_STATUS_REFERRED', 7);
defined('SEND_STATUS_CANCELED') OR define('SEND_STATUS_CANCELED', 8);

// My custom payment wait
defined('OWN_WAIT_TIME') OR define('OWN_WAIT_TIME', 10 * 60);

// Send method
defined('SEND_METHOD_SMS') OR define('SEND_METHOD_SMS', 1);
defined('SEND_METHOD_EMAIL') OR define('SEND_METHOD_EMAIL', 2);

// Payment methods
defined('PAYMENT_METHOD_WALLET') OR define('PAYMENT_METHOD_WALLET', 1);
defined('PAYMENT_METHOD_GATEWAY') OR define('PAYMENT_METHOD_GATEWAY', 2);
defined('PAYMENT_METHOD_IN_PLACE') OR define('PAYMENT_METHOD_IN_PLACE', 3);
defined('PAYMENT_METHOD_RECEIPT') OR define('PAYMENT_METHOD_RECEIPT', 4);
// Payment methods array
defined('PAYMENT_METHODS') OR define('PAYMENT_METHODS', [
    PAYMENT_METHOD_WALLET => 'کیف پول',
    PAYMENT_METHOD_GATEWAY => 'درگاه پرداخت',
    PAYMENT_METHOD_IN_PLACE => 'درب منزل',
    PAYMENT_METHOD_RECEIPT => 'رسید بانکی'
]);

// ُ Factor exportation type
defined('FACTOR_EXPORTATION_TYPE_BUY') OR define('FACTOR_EXPORTATION_TYPE_BUY', 1);
defined('FACTOR_EXPORTATION_TYPE_DEPOSIT') OR define('FACTOR_EXPORTATION_TYPE_DEPOSIT', 2);

// ُ Factor exportation type
defined('DEPOSIT_TYPE_SELF') OR define('DEPOSIT_TYPE_SELF', 1);
defined('DEPOSIT_TYPE_OTHER') OR define('DEPOSIT_TYPE_OTHER', 2);
defined('DEPOSIT_TYPE_REWARD') OR define('DEPOSIT_TYPE_REWARD', 3);

// Product type
defined('PRODUCT_TYPE_SERVICE') OR define('PRODUCT_TYPE_SERVICE', 1);
defined('PRODUCT_TYPE_ITEM') OR define('PRODUCT_TYPE_ITEM', 2);

// Custom education grades
defined('EDU_GRADES') OR define('EDU_GRADES', [
    14 => 'دیپلم',
    15 => 'فوق دیپلم',
    16 => 'لیسانس',
    17 => 'فوق لیسانس',
    18 => 'دکتری',
]);

// Custom education fields
defined('EDU_FIELDS') OR define('EDU_FIELDS', [
    1 => ' ریاضی و فیزیک',
    2 => 'علوم تجربی',
    3 => 'علوم انسانی',
    4 => 'هنرستان',
]);

// Custom military status
defined('MILITARY_STATUS') OR define('MILITARY_STATUS', [
    1 => 'دارای کارت پایان خدمت',
    2 => 'معافیت دائم',
    3 => 'معافیت موقت',
    4 => 'معافیت تحصیلی',
]);

// Gender
defined('GENDER_MALE') OR define('GENDER_MALE', 1);
defined('GENDER_FEMALE') OR define('GENDER_FEMALE', 2);

// Marriage
defined('MARRIAGE_MARRIED') OR define('MARRIAGE_MARRIED', 1);
defined('MARRIAGE_SINGLE') OR define('MARRIAGE_SINGLE', 2);
defined('MARRIAGE_DEAD') OR define('MARRIAGE_DEAD', 3);

// Custom marital status
defined('MARITAL_STATUS') OR define('MARITAL_STATUS', [
    MARRIAGE_MARRIED => 'متأهل',
    MARRIAGE_SINGLE => 'مجرد',
    MARRIAGE_DEAD => 'فوت همسر'
]);

//===============================================

return array(
    // Use to statically route from a [platform/controller/action/params] to another [platform/controller/action/params]
    // Support RegEx for mapping
    //$routes = array(
    //    'hello/*' => 'index'
    //);
    'routes' => array(//        'blog/(:any)' => 'comingSoon',
    ),

    //===============================================
    // Stay in default route and DOESN'T route. Useful for maintenance!
    'always_stay_in_default_route' => false,

    //===============================================
    // Maintenance password to see website just developer.
    // Give this to end of url as parameter to validate and access that url
    'maintenance_password' => "",

    //===============================================
    // Define languages
    // Index 0 in array below will be default language for site
    //$languages = ['fa', 'en'];
    'languages' => ['fa'],

    //===============================================
    // Acceptable values are
    // For development mode [development|dev]
    // For release mode [release|rel]
    // For semi development! mode(semi development mode just shut E_NOTICE down) [semi_development|semi_dev]
    'mode' => 'development',
//    'mode' => 'rel',

    //===============================================
    // Never delete this default notfound
    'default_notfound' => 'errors/fe/404',

    //===============================================
    'admin_notfound' => 'errors/be/404',

    //===============================================
    // Captcha session name to access in controller(s)
    'captcha_session_name' => 'captcha_text',
);
