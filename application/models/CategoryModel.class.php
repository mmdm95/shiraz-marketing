<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

class CategoryModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = AbstractPaymentController::TBL_CATEGORY;
        $this->db = $this->getDb();
    }

    public function getCategories($where = '', $bindParams = [], $limit = null, $offset = 0, $orderBy = ['c.id DESC'])
    {
        $select = $this->select();
        $select->cols([
            'c.*', 'i.name AS icon_name'
        ])->from($this->table . ' AS c');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_ICON . ' AS i',
                'i.id=c.icon'
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
        $select->offset($offset)->groupBy(['c.id']);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }
}