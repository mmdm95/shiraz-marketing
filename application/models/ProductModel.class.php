<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

class ProductModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = AbstractPaymentController::TBL_PRODUCT;
        $this->db = $this->getDb();
    }

    public function getProducts($where = '', $bindParams = [], $limit = null, $offset = 0, $orderBy = ['p.id DESC'])
    {
        $select = $this->select();
        $select->cols([
            'p.id', 'p.title', 'p.slug', 'p.image', 'p.discount_price', 'p.stock_count', 'p.max_cart_count', 'p.place',
            'p.available', 'p.category_id', 'p.is_special', 'c.slug AS category_slug', 'c.name AS category_name',
            'c.icon AS category_icon', 'u.mobile AS username', 'u.first_name AS user_first_name',
        ])->from($this->table . ' AS p');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_CATEGORY . ' AS c',
                'c.id=p.category_id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_USER . ' AS u',
                'u.id=p.created_by'
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
        $select->offset($offset)->groupBy(['p.id']);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getSingleProduct($where, $bindParams = [])
    {
        $select = $this->select();
        $select->cols([
            'p.*', 'c.slug AS category_slug', 'c.name AS category_name', 'c.icon AS category_icon',
        ])->from($this->table . ' AS p');

        try {
            $select->join(
                'INNER',
                AbstractPaymentController::TBL_CITY . ' AS ci',
                'ci.id=p.city_id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_CATEGORY . ' AS c',
                'c.id=p.category_id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        $select->where($where);
        if (!empty($bindParams) && is_array($bindParams)) {
            $select->bindValues($bindParams);
        }
        $select->limit(1);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }
}