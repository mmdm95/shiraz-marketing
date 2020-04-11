<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

require_once LIB_PATH . 'HPayment/vendor/autoload.php';

class OrderModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = AbstractPaymentController::TBL_ORDER;
        $this->db = $this->getDb();
    }

    public function getOrders($where = '', $bindValues = [], $limit = null, $offset = 0)
    {
        $select = $this->select();
        $select->cols([
            'o.*', 'ss.name AS send_status_name', 'ss.badge',
        ])->from($this->table . ' AS o');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_SEND_STATUS . ' AS ss',
                'ss.priority=o.send_status'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (!empty($where) && is_string($where)) {
            $select->where($where);
        }
        if (!empty($bindValues) && is_array($bindValues)) {
            $select->bindValues($bindValues);
        }

        if (!empty($limit) && is_numeric($limit)) {
            $select->limit((int)$limit);
        }
        $select->offset((int)$offset);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getSingleOrder($where, $bindValues = [])
    {
        $select = $this->select();
        $select->cols([
            'o.*', 'ss.name AS send_status_name', 'ss.badge AS send_status_badge',
        ])->from($this->table . ' AS o');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_SEND_STATUS . ' AS ss',
                'ss.priority=o.send_status'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (!empty($where) && is_string($where)) {
            $select->where($where);
        }
        if (!empty($bindValues) && is_array($bindValues)) {
            $select->bindValues($bindValues);
        }

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }

    public function getOrdersCount($where = '', $bindParams = [])
    {
        $select = $this->select();
        $select->cols([
            'COUNT(*) AS count'
        ])->from($this->table . ' AS o');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_SEND_STATUS . ' AS ss',
                'ss.priority=o.send_status'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (!empty($where) && is_string($where)) {
            $select->where($where);
        }
        if (!empty($bindParams) && is_array($bindParams)) {
            $select->bindValues($bindParams);
        }

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0]['count'];
        return 0;
    }

    public function getOrderProducts($where, $bindValues = [])
    {
        $select = $this->select();
        $select->cols([
            'oi.*', 'p.title', 'p.image',
        ])->from(AbstractPaymentController::TBL_ORDER_ITEM . ' AS oi');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_PRODUCT . ' AS p',
                'p.id=oi.product_id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        $select->where($where);
        if (!empty($bindValues) && is_array($bindValues)) {
            $select->bindValues($bindValues);
        }

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getReturnOrders($where = '', $bindValues = [], $limit = null, $offset = 0)
    {
        $select = $this->select();
        $select->cols([
            'o.id', 'o.order_code', 'o.first_name', 'o.last_name', 'o.payment_date', 'o.order_date',
            'o.final_price', 'o.payment_status', 'o.payment_method', 'ss.name AS send_status_name', 'ss.badge',
            'ro.description', 'ro.status', 'ro.created_at'
        ])->from($this->table . ' AS o');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_SEND_STATUS . ' AS ss',
                'ss.priority=o.send_status'
            )->join(
                'RIGHT',
                AbstractPaymentController::TBL_RETURN_ORDER . ' AS ro',
                'ro.order_code=o.order_code'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (!empty($where) && is_string($where)) {
            $select->where($where);
        }
        if (!empty($bindValues) && is_array($bindValues)) {
            $select->bindValues($bindValues);
        }

        if (!empty($limit) && is_numeric($limit)) {
            $select->limit((int)$limit);
        }
        $select->offset((int)$offset);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getSingleReturnOrder($where, $bindValues = [])
    {
        $select = $this->select();
        $select->cols([
            'o.*', 'ss.name AS send_status_name', 'ss.badge', 'ro.description', 'ro.status',
            'ro.created_at', 'ro.id AS return_order_id', 'ro.respond', 'ro.respond_at'
        ])->from($this->table . ' AS o');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_SEND_STATUS . ' AS ss',
                'ss.priority=o.send_status'
            )->join(
                'RIGHT',
                AbstractPaymentController::TBL_RETURN_ORDER . ' AS ro',
                'ro.order_code=o.order_code'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (!empty($where) && is_string($where)) {
            $select->where($where);
        }
        if (!empty($bindValues) && is_array($bindValues)) {
            $select->bindValues($bindValues);
        }

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }

    public function getUserDeposit($where, $bindValues = [], $limit = null, $offset = 0)
    {
        $select = $this->select();
        $select->cols([
            'ud.id', 'ud.payer_id AS payer', 'ud.deposit_price', 'ud.description', 'ud.deposit_type',
            'ud.deposit_date', 'u1.first_name', 'u1.last_name', 'u1.mobile',
            'CONCAT(u2.first_name, " ", u2.last_name) AS payer_name', 'u2.mobile AS payer_mobile'
        ])->from(AbstractPaymentController::TBL_USER_ACCOUNT_DEPOSIT . ' AS ud');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_USER . ' AS u1',
                'u1.id=ud.user_id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_USER . ' AS u2',
                'u2.id=ud.payer_id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if (!empty($where) && is_string($where)) {
            $select->where($where);
        }
        if (!empty($bindValues) && is_array($bindValues)) {
            $select->bindValues($bindValues);
        }

        if (!empty($limit) && is_numeric($limit)) {
            $select->limit((int)$limit);
        }
        $select->offset((int)$offset);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getStatusId($priority)
    {
        $model = new Model();
        $res = $model->select_it(null, AbstractPaymentController::TBL_SEND_STATUS, 'id', 'priority=:pr', ['pr' => $priority]);
        return count($res) ? $res[0]['id'] : -1;
    }
}