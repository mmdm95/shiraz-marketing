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

    public function getUsers($where = '', $bindParams = [], $limit = null, $offset = 0, $orderBy = ['u.id DESC'])
    {
        $select = $this->select();
        $select->cols([
            'u.id', 'u.user_code', 'u.subset_of', 'u.mobile AS username', 'u.first_name', 'u.last_name', 'u.active',
            'u.created_at', 'u.flag_marketer_request', 'r.name AS role_name', 'r.id AS role_id'
        ])->from($this->table . ' AS u');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_USER_ROLE . ' AS ur',
                'ur.user_id=u.id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_ROLE . ' AS r',
                'r.id=ur.role_id'
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
        if (!empty((int)$limit)) {
            $select->limit($limit);
        }
        if (!empty($orderBy) && is_array($orderBy)) {
            $select->orderBy($orderBy);
        }
        $select->offset($offset)->groupBy(['u.id']);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getSingleUser($where = '', $bindParams = [])
    {
        $select = $this->select();
        $select->cols([
            'u.*', 'r.name AS role_name', 'r.id AS role_id', 'uu.mobile AS superset_username',
            'uu.first_name AS superset_first_name', 'uu.last_name AS superset_last_name', 'uu.user_code AS superset_code',
        ])->from($this->table . ' AS u');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_USER_ROLE . ' AS ur',
                'ur.user_id=u.id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_ROLE . ' AS r',
                'r.id=ur.role_id'
            )->join(
                'LEFT',
                $this->table . ' AS uu',
                'uu.id=u.subset_of'
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

        $select->limit(1)->groupBy(['u.id']);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }

    public function getUsersCount($where = '', $bindParams = [])
    {
        $select = $this->select();
        $select->cols(['COUNT(*) AS count'])->from($this->table . ' AS u');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_USER_ROLE . ' AS ur',
                'ur.user_id=u.id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_ROLE . ' AS r',
                'r.id=ur.role_id'
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
        if (count($res)) {
            return $res[0]['count'];
        }
        return 0;
    }

    public function getNewUserCode($startCode = '1000001')
    {
        $model = new Model();
        $user = $model->select_it(null, $this->table, ['user_code'], null, [], null, ['id DESC'], 1);

        if (!count($user) || is_null($user[0]['user_code'])) return 'U-' . convertNumbersToPersian($startCode, true);

        $lastCode = $user[0]['user_code'];
        $lastCode = explode('-', $lastCode);
        $newLastCode = 'U-' . ((int)$lastCode[1] + 1);
        return $newLastCode;
    }

    public function changeToMarketer($id)
    {
        if (!is_numeric($id)) return false;

        $model = new Model();
        $model->transactionBegin();
        $user = $model->select_it(null, $this->table, ['user_code'], 'id=:id', ['id' => $id]);

        if (!count($user) || is_null($user[0]['user_code'])) return false;

        $code = $user[0]['user_code'];
        $code = explode('-', $code);
        $newMarketerCode = 'M-' . ((int)$code[1]);
        $res = $model->update_it($this->table, [
            'user_code' => $newMarketerCode,
            'flag_marketer_request' => 2,
        ], 'id=:id', ['id' => $id]);
        $res2 = true;
        if (!$model->is_exist(AbstractPaymentController::TBL_USER_ROLE, 'user_id=:uId AND role_id=:rId', ['uId' => $id, 'rId' => AUTH_ROLE_MARKETER])) {
            $res2 = $model->insert_it(AbstractPaymentController::TBL_USER_ROLE, [
                'user_id' => $id,
                'role_id' => AUTH_ROLE_MARKETER
            ]);
        }
        if ($res && $res2) {
            $model->transactionComplete();
            return true;
        }
        $model->transactionRollback();
        return false;
    }

    public function changeToUser($id)
    {
        if (!is_numeric($id)) return false;

        $model = new Model();
        $model->transactionBegin();
        $user = $model->select_it(null, $this->table, ['user_code'], 'id=:id', ['id' => $id]);

        if (!count($user) || is_null($user[0]['user_code'])) return false;

        $code = $user[0]['user_code'];
        $code = explode('-', $code);
        $newMarketerCode = 'U-' . ((int)$code[1]);
        $res = $model->update_it($this->table, [
            'user_code' => $newMarketerCode,
            'flag_marketer_request' => 0,
        ], 'id=:id', ['id' => $id]);
        $res2 = $model->delete_it(AbstractPaymentController::TBL_USER_ROLE,
            'user_id=:uId AND role_id=:rId', ['uId' => $id, 'rId' => AUTH_ROLE_MARKETER]);
        if ($res && $res2) {
            $model->transactionComplete();
            return true;
        }
        $model->transactionRollback();
        return false;
    }
}
