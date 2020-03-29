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

    public function getAllBlog($where = '', $bindParams = [], $limit = null, $offset = 0, $orderBy = ['p.id DESC'])
    {
        $select = $this->select();
        $select->cols([
            'b.image', 'b.title', 'b.slug', 'b.abstract', 'b.view_count',
            'b.created_at', 'b.updated_at', 'b.category_id', 'c.name AS category_name'
        ])->from($this->table . ' AS b');

        try {
            $select->join(
                'LEFT',
                AbstractPaymentController::TBL_BLOG_CATEGORY . ' AS c',
                'c.id=b.category_id'
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
        if (isset($blog['c_id'])) {
            $where .= ' OR b.category_id=:catId';
            $params['catId'] = $blog['c_id'];
        }
        //-----
        $where = trim(trim($where), 'OR');
        //-----
        $relatedWhere .= !empty($where) ? ' AND (' . $where . ')' : '';

        return $this->getAllBlog($limit, 0, $relatedWhere, array_merge($relatedParams, $params));
    }

    public function getBlogDetail($params)
    {
        $select = $this->select();
        $select->cols([
            'b.*', 'b.id As id', 'b.publish AS publish', 'b.keywords',
            'c.id AS c_id', 'c.publish AS c_publish'
        ])->from('blog AS b');

        try {
            $select->join(
                'LEFT',
                'categories AS c',
                'b.category_id=c.id'
            );
        } catch (\Aura\SqlQuery\Exception $e) {
            die('unexpected error: ' . $e->getMessage());
        }

        if ($params['slug']) {
            $select->where('slug=:slug')->bindValues(['slug' => $params['slug']]);
        }
        $select->where('b.publish=:pub')->bindValues(['pub' => 1]);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }

    public function getSiblingBlog($where, $bindParams = [], $orderBy = [])
    {
        $select = $this->select();
        $select->cols([
            'b.title', 'b.slug', 'b.id AS id', 'b.created_at', 'b.updated_at', 'c.category_name', 'c.id AS c_id'
        ])->from('blog AS b');

        try {
            $select->join(
                'LEFT',
                'categories AS c',
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

        $select->where('b.publish=:pub')->bindValues(['pub' => 1])
            ->limit(1);

        $res = $this->db->fetchAll($select->getStatement(), $select->getBindValues());
        if (count($res)) return $res[0];
        return [];
    }
}