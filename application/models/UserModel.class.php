<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HPayment\PaymentClasses\PaymentZarinPal;

require_once LIB_PATH . 'HPayment/vendor/autoload.php';

class UserModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = AbstractPaymentController::TBL_USER;
        $this->db = $this->getDb();
    }

    public function getNewUserCode($startCode = '1000001')
    {
        $model = new Model();
        $user = $model->select_it(null, $this->table, ['user_code'], null, [], null, ['id DESC'], 1);
        if (count($user)) {
            $lastCode = $user[0]['user_code'];
            $lastCode = explode('-', $lastCode);
            $newLastCode = 'U-' . ((int)$lastCode[1] + 1);
            return $newLastCode;
        }
        return 'U-' . convertNumbersToPersian($startCode, true);
    }
}