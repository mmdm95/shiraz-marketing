<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HPayment\PaymentClasses\PaymentZarinPal;

require_once LIB_PATH . 'HPayment/vendor/autoload.php';

class UserModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'users';
        $this->db = $this->getDb();
    }

    public function getPayedEvents($params)
    {
        $select = $this->select();
        $select->cols([
            'p.id', 'p.title', 'p.slug', 'p.contact', 'p.image',
            'p.start_at', 'p.end_at', 'p.status', 'MAX(zp.payment_date) AS payment_date',
            'f.total_amount', 'f.payed_amount', 'f.created_at'
        ])->from('plans AS p');

        try {
            $select->join(
                'INNER',
                'factors AS f',
                'p.id=f.plan_id'
            )->join(
                'LEFT',
                'zarinpal_payment AS zp',
                'p.id=zp.plan_id AND zp.payment_date=' . PaymentZarinPal::PAYMENT_STATUS_OK_ZARINPAL
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        $select->where('f.user_id=:uId')
            ->bindValues(['uId' => $params['user_id']])
            ->groupBy(['p.id']);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getEventDetail($params)
    {
        $select = $this->select();
        $select->cols([
            '*', 'p.id AS id', 'f.id AS f_id', 'p.options AS plan_options', 'f.options AS options'
        ])->from('plans AS p');

        try {
            $select->join(
                'INNER',
                'factors AS f',
                'p.id=f.plan_id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (isset($params['slug'])) {
            $select->where('p.slug=:slug')->bindValues(['slug' => $params['slug']]);
        }
        if (isset($params['user_id'])) {
            $select->where('f.user_id=:uId')->bindValues(['uId' => $params['user_id']]);
        }

        $select->groupBy(['p.id']);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }
}