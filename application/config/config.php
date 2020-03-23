<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

// App version
defined('APP_VERSION') OR define('APP_VERSION', '0.0.1');

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
defined('MAIN_KEY') OR define('MAIN_KEY','Lk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=');
defined('ASSURED_KEY') OR define('ASSURED_KEY','EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFK/o9+Y5c83w==');

//===============================================

// Default user profile image
defined('PROFILE_DEFAULT_IMAGE') OR define('PROFILE_DEFAULT_IMAGE', 'public/fe/img/user-default.jpg');

// Default users profile image directory
defined('PROFILE_IMAGE_DIR') OR define('PROFILE_IMAGE_DIR', 'public/users/profileImages/');

// My custom payment status
defined('OWN_PAYMENT_STATUS_SUCCESSFUL') OR define('OWN_PAYMENT_STATUS_SUCCESSFUL', 1);
defined('OWN_PAYMENT_STATUS_FAILED') OR define('OWN_PAYMENT_STATUS_FAILED', 0);
defined('OWN_PAYMENT_STATUS_NOT_PAYED') OR define('OWN_PAYMENT_STATUS_NOT_PAYED', -9);
defined('OWN_PAYMENT_STATUS_WAIT') OR define('OWN_PAYMENT_STATUS_WAIT', -8);

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
    'routes' => array(
//        'blog/(:any)' => 'comingSoon',
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
