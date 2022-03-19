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

    public function getProducts(
        $where = '',
        $bindParams = [],
        $limit = null,
        $offset = 0,
        $orderBy = ['p.id DESC'],
        $columns = [
            'p.id', 'p.title', 'p.slug', 'p.image', 'p.discount_price', 'p.price', 'p.discount_until', 'p.stock_count',
            'p.max_cart_count', 'p.place', 'p.available', 'p.category_id', 'p.is_special', 'p.sold_count', 'p.product_type',
            'p.publish', 'c.slug AS category_slug', 'c.name AS category_name', 'c.icon AS category_icon',
            'u.mobile AS username', 'u.first_name AS user_first_name', 'u.last_name AS user_last_name',
            'ci.name AS city_name', 'pr.name AS province_name'
        ]
    )
    {
        $select = $this->select();
        $select->cols($columns)->from($this->table . ' AS p');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_CATEGORY . ' AS c',
                'c.id=p.category_id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_USER . ' AS u',
                'u.id=p.created_by'
            )->join(
                'INNER',
                AbstractPaymentController::TBL_CITY . ' AS ci',
                'p.city_id=ci.id'
            )->join(
                'INNER',
                AbstractPaymentController::TBL_PROVINCE . ' AS pr',
                'ci.province_id=pr.id'
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
            'ci.name AS city_name', 'pr.name AS province_name'
        ])->from($this->table . ' AS p');

        try {
            $select->join(
                'INNER',
                AbstractPaymentController::TBL_CITY . ' AS ci',
                'ci.id=p.city_id'
            )->join(
                'INNER',
                AbstractPaymentController::TBL_PROVINCE . ' AS pr',
                'ci.province_id=pr.id'
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

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }

    public function getProductsCount($where = '', $bindParams = [])
    {
        $select = $this->select();
        $select->cols([
            'COUNT(*) AS count'
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

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0]['count'];
        return 0;
    }

    public function getProductsReward($orderCode)
    {
        $model = new Model();
        if (empty($orderCode) || $model->is_exist(AbstractPaymentController::TBL_ORDER, 'order_code=:oc', ['oc' => $orderCode])) return 0;
        //-----
        $productsID = $model->select_it(null, AbstractPaymentController::TBL_ORDER_ITEM, 'product_id',
            'order_code=:oc', ['oc' => $orderCode]);
        if (!count($productsID)) return 0;
        //-----
        $productsID = array_column($productsID, 'product_id');
        //-----
        $select = $this->select();
        $select->cols([
            'SUM(p.reward*oi.product_price) AS all_reward',
        ])->from($this->table . ' AS p');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_ORDER_ITEM . ' AS oi',
                'oi.product_id=p.id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        $where = 'p.id IN (';
        $bindParams = [];
        foreach ($productsID as $k => $id) {
            $where .= ':id' . ($k + 1) . ' AND ';
            $bindParams['id' . ($k + 1)] = $id;
        }
        $where = trim(trim($where, 'AND '));
        $select->where($where)->bindValues($bindParams);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        return $res[0]['all_reward'];
    }

    /**
     * @param array $config
     * @return array
     */
    public function getSliders(array $config)
    {
        if (!isset($config['type'])) return [];

        $model = new Model();

        $select = $model->select();
        try {
            $select
                ->from(AbstractPaymentController::TBL_PRODUCT . ' AS p')
                ->cols([
                    'p.id', 'p.title', 'p.slug', 'p.image', 'p.discount_price', 'p.price', 'p.discount_until', 'p.stock_count',
                    'p.max_cart_count', 'p.place', 'p.available', 'p.category_id', 'p.is_special', 'p.sold_count', 'p.product_type',
                    'p.publish', 'c.name AS city_name', 'pr.name AS province_name'
                ])
                ->where('p.publish=:pub')
                ->bindValue('pub', 1)
                ->join(
                    'INNER',
                    AbstractPaymentController::TBL_CITY . ' AS c',
                    'p.city_id=c.id'
                )->join(
                    'INNER',
                    AbstractPaymentController::TBL_PROVINCE . ' AS pr',
                    'c.province_id=pr.id'
                );
        } catch (\Aura\SqlQuery\Exception $e) {
            return [];
        }

        $config['limit'] = isset($config['limit']) && (int)$config['limit'] > 0 ? (int)$config['limit'] : 4;

        switch ($config['type']) {
            case SLIDER_TABBED_NEWEST:
                $select->orderBy(['p.id DESC']);
                break;
            case SLIDER_TABBED_MOST_VIEWED:
                $select->orderBy(['p.view_count DESC']);
                break;
            case SLIDER_TABBED_MOST_DISCOUNT:
                $select
                    ->orderBy(['CASE WHEN (p.discount_until IS NULL OR p.discount_until >= UNIX_TIMESTAMP()) AND p.stock_count > 0 AND p.available = 1 THEN 0 ELSE 1 END', '((p.price - p.discount_price) / p.price * 100) DESC', 'p.discount_price ASC', 'p.title DESC']);
                break;
            case SLIDER_TABBED_SPECIAL:
                $select
                    ->where('p.is_special=:spec')
                    ->bindValue('spec', 1);
                break;
            default:
                return [];
        }

        $select
            ->limit($config['limit'])
            ->orderBy(['p.title DESC'])
            ->groupBy(['p.id']);

        if (isset($config['category']) && !empty($config['category']) && $config['category'] != -1) {
            try {
                $select->join(
                    'INNER',
                    AbstractPaymentController::TBL_CATEGORY . ' AS cat',
                    'p.category_id=cat.id'
                )
                    ->where('p.category_id=:cat_id')
                    ->bindValues([
                        'cat_id' => $config['category'],
                    ]);
            } catch (\Aura\SqlQuery\Exception $e) {
                return [];
            }
        }

        return $model->select_it($select);
    }
}
