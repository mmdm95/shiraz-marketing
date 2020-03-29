<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HForm\Form;
use Home\AbstractController\AbstractController;

include_once 'AbstractController.class.php';

class BlogController extends AbstractController
{
    public function allAction($param)
    {
        $model = new Model();
        $this->_shared();
        $this->_manage_params($param);
        //-----
        $this->data['categories'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['id', 'name', 'slug'], 'publish=:pub', ['pub' => 1]);
        //-----
        $this->data['page_image'] = $this->setting['pages']['blog']['topImage'] ?? '';
        $this->data['page_title'] = 'اخبار و اطلاعیه‌ها';

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'اخبار و اطلاعیه‌ها');

        $this->_render_page([
            'pages/fe/blog',
        ]);
    }

    public function detailAction($param)
    {
        $model = new Model();
        //-----
//        if (!isset($param[0]) || !$model->is_exist('blog', 'slug=:slug AND publish=:pub', ['slug' => $param[0], 'pub' => 1])) {
//            $_SESSION['blog-detail-err'] = 'پارامترهای ارسالی برای مشاهده بلاگ نادرست هستند!';
//            $this->redirect(base_url('blog/allBlog'));
//        }
        //-----
//        $blog = new BlogModel();
//        $this->data['blog'] = $blog->getBlogDetail(['slug' => $param[0]]);
//        $next = $blog->getSiblingBlog('b.id>:id', ['id' => $this->data['blog']['id']], ['id DESC']);
//        $this->data['nextBlog'] = count($next) ? $next : $blog->getSiblingBlog('b.id<:id', ['id' => $this->data['blog']['id']], ['id ASC']);
//        $prev = $blog->getSiblingBlog('b.id<:id', ['id' => $this->data['blog']['id']], ['id DESC']);
//        $this->data['prevBlog'] = count($prev) ? $prev : $blog->getSiblingBlog('b.id>:id', ['id' => $this->data['blog']['id']], ['id ASC']);
        //-----
//        $this->data['lastPosts'] = $model->select_it(null, 'blog', [
//            'image', 'title', 'slug', 'writer', 'created_at', 'updated_at'
//        ], 'publish=:pub', ['pub' => 1], null, ['id DESC'], 5);
        //-----
//        $this->data['categories'] = $model->select_it(null, 'categories', ['id', 'category_name'],
//            'publish=:pub', ['pub' => 1]);
        //-----
//        $this->data['related'] = $blog->getRelatedBlog($this->data['blog'], 3);

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'بلاگ');

        // Extra js
//        $this->data['js'][] = $this->asset->script('fe/js/blogJs.js');

        $this->_render_page([
            'pages/fe/blog-detail',
        ]);
    }

    //-----

    public function searchAction($param)
    {
        $query = isset($param[1]) ? urldecode($param[1]) : (isset($param[0]) ? urldecode($param[0]) : '');
        if (empty($query)) {
            if (isset($_GET['blog-query'])) {
                $param = [$_GET['blog-query']];
                $query = urldecode($param[0]);
            } else {
                $param = ['all'];
                $query = 'نمایش همه';
            }
        }
        //-----
        $this->data['param'] = $param;
        $this->data['searchText'] = $query;
        $this->data['searchTitle'] = '';
        //-----
        $where = '';
        $bindValues = [];

        $model = new Model();
        $blog = new BlogModel();
        if (isset($param[1])) {
            $this->data['searchTitle'] .= $query;
            switch (strtolower($param[0])) {
                case 'category':
                    $this->data['searchTitle'] = 'دسته‌بندی - ';
                    //-----
                    $where .= '(c.id=:cat';
                    $bindValues['cat'] = $query;
                    //+++++
                    $where .= ') AND ';
                    break;
                case 'writer':
                    $this->data['searchTitle'] = 'نویسنده - ';
                    //-----
                    $where .= '(b.writer LIKE :writer';
                    $bindValues['writer'] = '%' . $query . '%';
                    //+++++
                    $where .= ') AND ';
                    break;
                case 'tag':
                    $this->data['searchTitle'] = 'کلمات کلیدی - ';
                    //-----
                    $where .= '(b.keywords LIKE :kw';
                    $bindValues['kw'] = '%' . $query . '%';
                    //+++++
                    $where .= ') AND ';
                    break;
            }
            //-----
            $this->data['pagination']['total'] = $model->it_count(null, $where . ' b.publish=:pub',
                array_merge($bindValues, ['pub' => 1]));
            $this->data['pagination']['page'] = isset($param[3]) && strtolower($param[2]) == 'page' ? (int)$param[3] : 1;
            $this->data['pagination']['limit'] = 12;
            $this->data['pagination']['offset'] = ($this->data['pagination']['page'] - 1) * $this->data['pagination']['limit'];
            $this->data['pagination']['firstPage'] = 1;
            $this->data['pagination']['lastPage'] = ceil($this->data['pagination']['total'] / $this->data['pagination']['limit']);
            //-----
            $this->data['result'] = $blog->getAllBlog($where . ' b.publish=:pub', array_merge($bindValues, ['pub' => 1]),
                $this->data['pagination']['limit'], $this->data['pagination']['offset']);
            //-----
            if (strtolower($param[0]) == 'category') {
                $category = $model->select_it(null, 'categories', 'category_name', 'id=:id', ['id' => $query]);
                $this->data['searchTitle'] .= count($category) ? $category[0]['category_name'] : 'ناشناخته';
            }
        } else {
            $this->data['searchTitle'] = 'همه - ';
            $this->data['searchTitle'] .= $query;
            if (!empty($query)) {
                $where .= '(b.title LIKE :title OR ';
                $bindValues['title'] = '%' . $query . '%';
                //+++++
                $where .= 'b.abstract LIKE :abs OR ';
                $bindValues['abs'] = '%' . $query . '%';
                //+++++
                $where .= 'b.writer LIKE :writer OR ';
                $bindValues['writer'] = '%' . $query . '%';
                //+++++
                $where .= 'b.keywords LIKE :kw OR ';
                $bindValues['kw'] = '%' . $query . '%';
                //+++++
                $where .= 'c.category_name LIKE :cat';
                $bindValues['cat'] = '%' . $query . '%';
                //+++++
                $where .= ') AND ';
            }
            //-----
            $this->data['pagination']['total'] = $model->it_count(null, $where . ' b.publish=:pub',
                array_merge($bindValues, ['pub' => 1]));
            $this->data['pagination']['page'] = isset($param[2]) && strtolower($param[1]) == 'page' ? (int)$param[2] : 1;
            $this->data['pagination']['limit'] = 12;
            $this->data['pagination']['offset'] = ($this->data['pagination']['page'] - 1) * $this->data['pagination']['limit'];
            $this->data['pagination']['firstPage'] = 1;
            $this->data['pagination']['lastPage'] = ceil($this->data['pagination']['total'] / $this->data['pagination']['limit']);
            //-----
            $this->data['result'] = $blog->getAllBlog($where . ' b.publish=:pub', array_merge($bindValues, ['pub' => 1]),
                $this->data['pagination']['limit'], $this->data['pagination']['offset']);
        }
        //-----

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'جستجو', $query);

        $this->_render_page([
            'pages/fe/blog-search',
        ]);
    }

    //-----

    private $_order_types = [
        'newest' => ['b.id DESC'],
        'most_view' => ['b.view_count DESC', 'b.id DESC'],
    ];
    private $_order_type_globalization = [
        'newest' => 'جدیدترین',
        'most_view' => 'پربازدیدترین',
    ];

    protected function _manage_params($param)
    {
        $model = new Model();
        $blogModel = new BlogModel();
        //-----
        $extraWhere = '';
        $extraParams = [];
        $orderParams = $this->_order_types['newest'];
        $orderTypeKeys = array_keys($this->_order_types);

        $this->data['categoryParam'] = '';
        $this->data['categoryText'] = '';

        $this->data['orderParam'] = 'newest';
        $this->data['orderText'] = $this->_order_type_globalization['newest'];

        $this->data['pagination']['page'] = 1;

        if (isset($param[0])) {
            $param = array_map('strtolower', $param);
            if ($param[0] == 'category') {
                if (isset($param[1])) {
                    if ($param[1] == 'order') {
                        if (isset($param[2])) {
                            if (in_array($param[2], $orderTypeKeys)) {
                                $orderParams = $this->_order_types[$param[2]];
                                $this->data['orderText'] = $this->_order_type_globalization[$param[2]];
                                $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[2]])[0];
                            }
                            if (isset($param[3])) {
                                if ($param[3] == 'page') {
                                    if (isset($param[4])) {
                                        if (is_numeric($param[4])) {
                                            $this->data['pagination']['page'] = $param[4];
                                        }
                                    }
                                }
                            }
                        }
                    } elseif (!is_numeric($param[1])) {
                        $extraWhere .= ' AND c.slug=:cSlug AND c.publish=:cPub';
                        $extraParams['cSlug'] = $param[1];
                        $extraParams['cPub'] = 1;
                        $this->data['categoryParam'] = $param[1];
                        // Get category name
                        $this->data['categoryText'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['name'],
                            'slug=:slug', ['slug' => $param[1]]);
                        $this->data['categoryText'] = count($this->data['categoryText']) ? $this->data['categoryText'][0]['name'] : '';
                    } else {
                        $extraWhere .= ' AND b.category_id=:cId AND c.publish=:cPub';
                        $extraParams['cId'] = $param[1];
                        $extraParams['cPub'] = 1;
                        $this->data['categoryParam'] = $param[1];
                        // Get category name
                        $this->data['categoryText'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['name'],
                            'id=:id', ['id' => $param[1]]);
                        $this->data['categoryText'] = count($this->data['categoryText']) ? $this->data['categoryText'][0]['name'] : '';
                    }
                    if (isset($param[2])) {
                        if ($param[2] == 'order') {
                            if (isset($param[3])) {
                                if (in_array($param[3], $orderTypeKeys)) {
                                    $orderParams = $this->_order_types[$param[3]];
                                    $this->data['orderText'] = $this->_order_type_globalization[$param[3]];
                                    $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[3]])[0];
                                }
                                if (isset($param[4])) {
                                    if ($param[4] == 'page') {
                                        if (isset($param[5])) {
                                            if (is_numeric($param[5])) {
                                                $this->data['pagination']['page'] = $param[5];
                                            }
                                        }
                                    }
                                }
                                if (isset($param[3])) {
                                    if ($param[3] == 'page') {
                                        if (isset($param[4])) {
                                            if (is_numeric($param[4])) {
                                                $this->data['pagination']['page'] = $param[4];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } elseif ($param[0] == 'order') {
                if (isset($param[1])) {
                    if (in_array($param[1], $orderTypeKeys)) {
                        $orderParams = $this->_order_types[$param[1]];
                        $this->data['orderText'] = $this->_order_type_globalization[$param[1]];
                        $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[1]])[0];
                    }
                    if (isset($param[2])) {
                        if ($param[2] == 'page') {
                            if (isset($param[3])) {
                                if (is_numeric($param[3])) {
                                    $this->data['pagination']['page'] = $param[3];
                                }
                            }
                        }
                    }
                }
            } elseif ($param[0] == 'page') {
                if (isset($param[1])) {
                    if (is_numeric($param[1])) {
                        $this->data['pagination']['page'] = $param[1];
                    }
                }
            }
        }

        //-----
        $this->data['pagination']['total'] = $model->it_count(self::TBL_BLOG, 'publish=:pub' . $extraWhere,
            array_merge(['pub' => 1], $extraParams));
        $this->data['pagination']['limit'] = isset($this->setting['pages']['product']['itemsEachPage']) && is_numeric($this->setting['pages']['product']['itemsEachPage']) && $this->setting['pages']['product']['itemsEachPage'] > 0 ? $this->setting['pages']['product']['itemsEachPage'] : ITEMS_EACH_PAGE_DEFAULT;
        $this->data['pagination']['offset'] = ($this->data['pagination']['page'] - 1) * $this->data['pagination']['limit'];
        $this->data['pagination']['firstPage'] = 1;
        $this->data['pagination']['lastPage'] = ceil($this->data['pagination']['total'] / $this->data['pagination']['limit']);
        //-----
        $this->data['blog'] = $blogModel->getAllBlog('b.publish=:pub' . $extraWhere,
            array_merge(['pub' => 1], $extraParams), $this->data['pagination']['limit'], $this->data['pagination']['offset'], $orderParams);
    }
}