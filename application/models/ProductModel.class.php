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

    public function getProducts($where = '', $bindParams = [], $limit = null, $offset = 0)
    {
        $select = $this->select();
        $select->cols([
            'p.id', 'p.title', 'p.slug', 'p.image', 'p.discount_price', 'p.stock_count',
            'p.available', 'c.name AS category_name', 'c.icon AS category_icon'
        ])->from($this->table . ' AS p');

        try {
            $select->join(
                'INNER',
                AbstractPaymentController::TBL_CATEGORY . ' AS c',
                'c.id=p.category_id'
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
        $select->orderBy(['p.id DESC'])->offset($offset);
        $select->groupBy(['p.id']);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }
}