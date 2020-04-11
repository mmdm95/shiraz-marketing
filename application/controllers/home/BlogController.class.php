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
        $this->data['page_has_search'] = [
            'action' => base_url('blog/all'),
            'placeholder' => 'جستجو در بلاگ',
        ];

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'اخبار و اطلاعیه‌ها');

        $this->_render_page([
            'pages/fe/blog',
        ]);
    }

    public function detailAction($param)
    {
        $model = new Model();
        //-----
        if (!isset($param[0]) || !$model->is_exist(self::TBL_BLOG, 'id=:id AND publish=:pub', ['id' => $param[0], 'pub' => 1])) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'مطلب مورد نظر وجود ندارد!',
            ]);
            $this->redirect(base_url('blog/all'));
        }
        //-----
        $blog = new BlogModel();
        $this->data['blog'] = $blog->getBlogDetail('b.id=:id', ['id' => $param[0]]);
        $next = $blog->getSiblingBlog('b.id>:id', ['id' => $this->data['blog']['id']], ['id DESC']);
        $this->data['nextBlog'] = count($next) ? $next : $blog->getSiblingBlog('b.id<:id', ['id' => $this->data['blog']['id']], ['id ASC']);
        $prev = $blog->getSiblingBlog('b.id<:id', ['id' => $this->data['blog']['id']], ['id DESC']);
        $this->data['prevBlog'] = count($prev) ? $prev : $blog->getSiblingBlog('b.id>:id', ['id' => $this->data['blog']['id']], ['id ASC']);
        //-----
        $this->data['lastPosts'] = $blog->getAllBlog('b.publish=:pub', ['pub' => 1], 4);
        //-----
        $this->data['categories'] = $model->select_it(null, self::TBL_BLOG_CATEGORY, ['id', 'name', 'slug'],
            'publish=:pub AND show_in_side=:sis', ['pub' => 1, 'sis' => 1]);
        //-----
        $this->data['related'] = $blog->getRelatedBlog($this->data['blog'], 6);
        //-----
        $this->_view_count(self::TBL_BLOG, $param[0]);
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'جزئیات بلاگ', @$this->data['blog']['title']);

        $this->_render_page([
            'pages/fe/blog-detail',
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
        $this->data['categoryText'] = 'همه';

        $this->data['orderParam'] = 'newest';
        $this->data['orderText'] = $this->_order_type_globalization['newest'];

        $this->data['tagParam'] = '';

        $this->data['pagination']['page'] = 1;

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $extraWhere .= ' AND (b.title LIKE :q1 OR';
            $extraWhere .= ' b.abstract LIKE :q2 OR';
            $extraWhere .= ' b.abstract LIKE :q3 OR';
            $extraWhere .= ' b.keywords LIKE :q4 OR';
            $extraWhere .= ' c.name LIKE :q5)';
            $extraParams['q1'] = '%' . $_GET['q'] . '%';
            $extraParams['q2'] = '%' . $_GET['q'] . '%';
            $extraParams['q3'] = '%' . $_GET['q'] . '%';
            $extraParams['q4'] = '%' . $_GET['q'] . '%';
            $extraParams['q5'] = '%' . $_GET['q'] . '%';
        }
        if (isset($param[0])) {
            $param = array_map('mb_strtolower', $param);
            if ($param[0] == 'category') {
                if (isset($param[1])) {
                    if ($param[1] == 'tag') {
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
                                }
                            } else {
                                $extraWhere .= ' AND b.keywords LIKE :tag';
                                $extraParams['tag'] = '%' . $param[2] . '%';
                                $this->data['tagParam'] = $param[2];
                            }
                            if (isset($param[3])) {
                                if ($param[3] == 'order') {
                                    if (isset($param[4])) {
                                        if (in_array($param[4], $orderTypeKeys)) {
                                            $orderParams = $this->_order_types[$param[4]];
                                            $this->data['orderText'] = $this->_order_type_globalization[$param[4]];
                                            $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[4]])[0];
                                        }
                                        if (isset($param[5])) {
                                            if ($param[5] == 'page') {
                                                if (isset($param[6])) {
                                                    if (is_numeric($param[6])) {
                                                        $this->data['pagination']['page'] = $param[6];
                                                    }
                                                }
                                            }
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
                                    }
                                }
                            }
                        }
                    } elseif ($param[1] == 'order') {
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
                        if ($param[2] == 'tag') {
                            if (isset($param[3])) {
                                if ($param[3] == 'order') {
                                    if (isset($param[4])) {
                                        if (in_array($param[4], $orderTypeKeys)) {
                                            $orderParams = $this->_order_types[$param[4]];
                                            $this->data['orderText'] = $this->_order_type_globalization[$param[4]];
                                            $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[4]])[0];
                                        }
                                        if (isset($param[5])) {
                                            if ($param[5] == 'page') {
                                                if (isset($param[6])) {
                                                    if (is_numeric($param[6])) {
                                                        $this->data['pagination']['page'] = $param[6];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $extraWhere .= ' AND b.keywords LIKE :tag';
                                    $extraParams['tag'] = '%' . $param[3] . '%';
                                    $this->data['tagParam'] = $param[3];
                                }
                                if (isset($param[4])) {
                                    if ($param[4] == 'order') {
                                        if (isset($param[5])) {
                                            if (in_array($param[5], $orderTypeKeys)) {
                                                $orderParams = $this->_order_types[$param[5]];
                                                $this->data['orderText'] = $this->_order_type_globalization[$param[5]];
                                                $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[5]])[0];
                                            }
                                            if (isset($param[6])) {
                                                if ($param[6] == 'page') {
                                                    if (isset($param[7])) {
                                                        if (is_numeric($param[7])) {
                                                            $this->data['pagination']['page'] = $param[7];
                                                        }
                                                    }
                                                }
                                            }
                                            if (isset($param[5])) {
                                                if ($param[5] == 'page') {
                                                    if (isset($param[6])) {
                                                        if (is_numeric($param[6])) {
                                                            $this->data['pagination']['page'] = $param[6];
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } elseif ($param[2] == 'order') {
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
            } elseif ($param[0] == 'tag') {
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
                    } else {
                        $extraWhere .= ' AND b.keywords LIKE :tag';
                        $extraParams['tag'] = '%' . $param[1] . '%';
                        $this->data['tagParam'] = $param[1];
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
        $this->data['pagination']['total'] = $blogModel->getBlogCount('b.publish=:pub' . $extraWhere,
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