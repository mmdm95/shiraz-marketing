<?php
defined('BASE_PATH') OR exit('No direct script access allowed');


class BlogModel extends HModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = AbstractPaymentController::TBL_BLOG;
        $this->db = $this->getDb();
    }

    public function getAllBlog($where = '', $bindParams = [], $limit = null, $offset = 0, $orderBy = ['b.id DESC'])
    {
        $select = $this->select();
        $select->cols([
            'b.id', 'b.image', 'b.title', 'b.slug', 'b.abstract', 'b.view_count', 'b.publish',
            'b.created_at', 'b.updated_at', 'b.category_id', 'c.name AS category_name',
            'u.mobile AS username', 'u.first_name AS user_first_name', 'u.last_name AS user_last_name'
        ])->from($this->table . ' AS b');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_BLOG_CATEGORY . ' AS c',
                'c.id=b.category_id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_USER . ' AS u',
                'u.id=b.created_by'
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
        $select->offset($offset)->groupBy(['b.id']);

        return $this->db->fetchAll($select->getStatement(), $select->getBindValues());
    }

    public function getRelatedBlog($blog, $limit = 3)
    {
        if (!isset($blog['id'])) return [];
        //-----
        $relatedWhere = 'b.id!=:bId';
        $relatedParams = ['bId' => $blog['id']];
        $where = '';
        $params = [];
        //-----
        if (isset($blog['title'])) {
            $where .= 'b.title LIKE :bTitle';
            $params['bTitle'] = '%' . $blog['title'] . '%';
            $where .= ' OR b.body LIKE :bBody';
            $params['bBody'] = '%' . $blog['title'] . '%';
        }
        if (isset($blog['keywords'])) {
            $keywords = array_map('trim', explode(',', $blog['keywords']));
            foreach ($keywords as $k => $keyword) {
                $where .= ' OR b.keywords LIKE :key_' . $k;
                $params['key_' . $k] = '%' . $keyword . '%';
            }
        }
        if (isset($blog['category_id'])) {
            $where .= ' OR b.category_id=:catId';
            $params['catId'] = $blog['category_id'];
        }
        //-----
        $where = trim(trim($where), 'OR');
        //-----
        $relatedWhere .= !empty($where) ? ' AND (' . $where . ')' : '';

        return $this->getAllBlog($relatedWhere, array_merge($relatedParams, $params), $limit);
    }

    public function getBlogDetail($where, $bindParams = [])
    {
        $select = $this->select();
        $select->cols([
            'b.*', 'b.id As id', 'b.publish AS publish', 'b.keywords',
            'c.id AS category_id', 'c.name AS category_name', 'c.publish AS category_publish'
        ])->from($this->table . ' AS b');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_BLOG_CATEGORY . ' AS c',
                'b.category_id=c.id'
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
        if (count($res)) return $res[0];
        return [];
    }

    public function getSiblingBlog($where, $bindParams = [], $orderBy = [])
    {
        $select = $this->select();
        $select->cols([
            'b.id', 'b.title', 'b.slug', 'b.image', 'b.created_at',
            'b.updated_at', 'c.name AS category_name', 'c.id AS category_id'
        ])->from($this->table . ' AS b');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_BLOG_CATEGORY . ' AS c',
                'b.category_id=c.id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        $select->where($where);
        if (!empty($bindParams) && is_array($bindParams)) {
            $select->bindValues($bindParams);
        }
        if (!empty($orderBy) && is_array($orderBy)) {
            $select->orderBy($orderBy);
        }

        $select->limit(1);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }

    public function getBlogCount($where = '', $bindParams = [])
    {
        $select = $this->select();
        $select->cols([
            'COUNT(*) AS count'
        ])->from($this->table . ' AS b');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_BLOG_CATEGORY . ' AS c',
                'c.id=b.category_id'
            )->join(
                'LEFT',
                AbstractPaymentController::TBL_USER . ' AS u',
                'u.id=b.created_by'
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
        $select->groupBy(['b.id']);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0]['count'];
        return 0;
    }
}