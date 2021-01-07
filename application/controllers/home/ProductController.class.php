<?php
defined('BASE_PATH') OR exit('No direct script access allowed');

use HForm\Form;
use Home\AbstractController\AbstractController;

include_once 'AbstractController.class.php';

class ProductController extends AbstractController
{
    public function allAction($param)
    {
        $this->_shared();
        //-----
        $this->data['page_image'] = $this->setting['pages']['product']['topImage'] ?? '';
        $this->data['page_title'] = 'محصولات';
        //-----
        $this->_manage_params($param);

        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'محصولات');

        $this->_render_page([
            'pages/fe/product',
        ]);
    }

    public function detailAction($param)
    {
        $model = new Model();
        $productModel = new ProductModel();
        //-----
        if (!isset($param[0]) || !$model->is_exist(self::TBL_PRODUCT, 'id=:id AND publish=:pub', ['id' => $param[0], 'pub' => 1])) {
            $this->session->setFlash($this->messageSession, [
                'type' => self::FLASH_MESSAGE_TYPE_WARNING,
                'icon' => self::FLASH_MESSAGE_ICON_WARNING,
                'message' => 'محصول مورد نظر وجود ندارد!',
            ]);
            $this->redirect(base_url('product/all'));
        }
        //-----
        $this->data['param'] = $param;
        $this->data['product'] = $productModel->getSingleProduct('p.id=:id', ['id' => $param[0]]);
        //-----
        $this->data['product']['gallery'] = $model->select_it(null, self::TBL_PRODUCT_GALLERY, ['image'],
            'product_id=:pId', ['pId' => $param[0]]);
        // Get related products
        $extraPlaceholder = '';
        $extraParams = [];
        foreach (explode(',', $this->data['product']['related']) as $k => $item) {
            $extraPlaceholder .= ':rId' . $k . ',';
            $extraParams['rId' . $k] = trim($item);
        }
        $extraPlaceholder = trim($extraPlaceholder, ',');
        $this->data['product']['related'] = $extraPlaceholder != ''
            ? $productModel->getProducts('p.publish=:pub AND p.id IN (' . $extraPlaceholder . ')', array_merge(['pub' => 1], $extraParams))
            : [];
        // Get cart item with current product item
        $cartItems = $this->_fetch_cart_items();
        $this->data['curCartItem'] = h_array_search($cartItems, 'id', $param[0]);
        //-----
        $this->_view_count(self::TBL_PRODUCT, $param[0]);
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'جزئیات محصول', @$this->data['product']['title']);
        $this->data['extraKeywords'] = explode(',', $this->data['product']['keywords']);

        $this->_render_page([
            'pages/fe/product-detail',
        ]);
    }

    //-----

    private $_order_types = [
        'newest' => ['p.id DESC'],
        'most_view' => ['p.view_count DESC', 'p.id DESC'],
        'most_discount' => ['CASE WHEN (discount_until IS NULL OR discount_until >= UNIX_TIMESTAMP()) AND stock_count > 0 AND available = 1 THEN 0 ELSE 1 END', '((p.price - p.discount_price) / p.price * 100) DESC', 'p.discount_price ASC', 'p.id DESC']
    ];
    private $_order_type_globalization = [
        'newest' => 'جدیدترین',
        'most_view' => 'پربازدیدترین',
        'most_discount' => 'پرتخفیف‌ترین'
    ];

    protected function _manage_params($param)
    {
        $model = new Model();
        $productModel = new ProductModel();
        //-----
        $extraWhere = '';
        $extraParams = [];
        $orderParams = $this->_order_types['newest'];
        $orderTypeKeys = array_keys($this->_order_types);

        $this->data['categoryParam'] = '';
        $this->data['specialParam'] = '';

        $this->data['orderParam'] = 'newest';
        $this->data['orderText'] = $this->_order_type_globalization['newest'];

        $this->data['tagParam'] = '';

        $this->data['pagination']['page'] = 1;

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $this->data['page_has_search'] = [
                'action' => base_url('product/all'),
                'placeholder' => 'جستجو در محصولات و خدمات',
            ];
            //-----
            $extraWhere .= ' AND (p.title LIKE :q1 OR';
            $extraWhere .= ' c.name LIKE :q2)';
            $extraParams['q1'] = '%' . $_GET['q'] . '%';
            $extraParams['q2'] = '%' . $_GET['q'] . '%';
        }
        if (isset($param[0])) {
            $param = array_map('mb_strtolower', $param);
            if ($param[0] == 'category') {
                if (isset($param[1])) {
                    if ($param[1] == 'tag') {
                        if (isset($param[2])) {
                            if ($param[2] == 'offers') {
                                $extraWhere .= ' AND p.is_special=:spec';
                                $extraParams['spec'] = 1;
                                $this->data['specialParam'] = $param[2];
                                //-----
                                if (isset($param[3])) {
                                    if ($param[3] == 'order') {
                                        if (isset($param[4])) {
                                            if (in_array($param[4], $orderTypeKeys)) {
                                                $orderParams = $this->_order_types[$param[4]];
                                                $this->data['orderText'] = $this->_order_type_globalization[$param[4]];
                                                $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[4]])[0];

                                                if (isset($param[5])) {
                                                    if ($param[5] == 'page') {
                                                        if (isset($param[6])) {
                                                            if (is_numeric($param[6])) {
                                                                $this->data['pagination']['page'] = $param[6];
                                                            }
                                                        }
                                                    }
                                                }
                                            } elseif ($param[4] == 'page') {
                                                if (isset($param[5])) {
                                                    if (is_numeric($param[5])) {
                                                        $this->data['pagination']['page'] = $param[5];
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

                                        if (isset($param[4])) {
                                            if ($param[4] == 'page') {
                                                if (isset($param[5])) {
                                                    if (is_numeric($param[5])) {
                                                        $this->data['pagination']['page'] = $param[5];
                                                    }
                                                }
                                            }
                                        }
                                    } elseif ($param[3] == 'page') {
                                        if (isset($param[4])) {
                                            if (is_numeric($param[4])) {
                                                $this->data['pagination']['page'] = $param[4];
                                            }
                                        }
                                    }
                                }
                            } else {
                                $extraWhere .= ' AND p.keywords LIKE :tag';
                                $extraParams['tag'] = '%' . $param[2] . '%';
                                $this->data['tagParam'] = $param[2];
                            }
                            //-----
                            if (isset($param[3])) {
                                if ($param[3] == 'offers') {
                                    $extraWhere .= ' AND p.is_special=:spec';
                                    $extraParams['spec'] = 1;
                                    $this->data['specialParam'] = $param[3];
                                    //-----
                                    if (isset($param[4])) {
                                        if ($param[4] == 'order') {
                                            if (isset($param[5])) {
                                                if (in_array($param[5], $orderTypeKeys)) {
                                                    $orderParams = $this->_order_types[$param[5]];
                                                    $this->data['orderText'] = $this->_order_type_globalization[$param[5]];
                                                    $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[5]])[0];

                                                    if (isset($param[6])) {
                                                        if ($param[6] == 'page') {
                                                            if (isset($param[7])) {
                                                                if (is_numeric($param[7])) {
                                                                    $this->data['pagination']['page'] = $param[7];
                                                                }
                                                            }
                                                        }
                                                    }
                                                } elseif ($param[5] == 'page') {
                                                    if (isset($param[6])) {
                                                        if (is_numeric($param[6])) {
                                                            $this->data['pagination']['page'] = $param[6];
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } elseif ($param[3] == 'order') {
                                    if (isset($param[4])) {
                                        if (in_array($param[4], $orderTypeKeys)) {
                                            $orderParams = $this->_order_types[$param[4]];
                                            $this->data['orderText'] = $this->_order_type_globalization[$param[4]];
                                            $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[4]])[0];

                                            if (isset($param[5])) {
                                                if ($param[5] == 'page') {
                                                    if (isset($param[6])) {
                                                        if (is_numeric($param[6])) {
                                                            $this->data['pagination']['page'] = $param[6];
                                                        }
                                                    }
                                                }
                                            }
                                        } elseif ($param[4] == 'page') {
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
                    } elseif ($param[1] == 'offers') {
                        $extraWhere .= ' AND p.is_special=:spec';
                        $extraParams['spec'] = 1;
                        $this->data['specialParam'] = $param[1];
                        //-----
                        if (isset($param[2])) {
                            if ($param[2] == 'order') {
                                if (isset($param[3])) {
                                    if (in_array($param[3], $orderTypeKeys)) {
                                        $orderParams = $this->_order_types[$param[3]];
                                        $this->data['orderText'] = $this->_order_type_globalization[$param[3]];
                                        $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[3]])[0];

                                        if (isset($param[4])) {
                                            if ($param[4] == 'page') {
                                                if (isset($param[5])) {
                                                    if (is_numeric($param[5])) {
                                                        $this->data['pagination']['page'] = $param[5];
                                                    }
                                                }
                                            }
                                        }
                                    } elseif ($param[3] == 'page') {
                                        if (isset($param[4])) {
                                            if (is_numeric($param[4])) {
                                                $this->data['pagination']['page'] = $param[4];
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
                        // Top image
                        $tmpCat = $model->select_it(null, self::TBL_CATEGORY, [
                            'image', 'name'
                        ], 'slug=:slug AND publish=:pub', ['slug' => $param[1], 'pub' => 1]);
                        if (count($tmpCat)) {
                            $this->data['page_image'] = $tmpCat[0]['image'];
                            $this->data['page_sub_title'] = $tmpCat[0]['name'];
                        }
                    } else {
                        $extraWhere .= ' AND p.category_id=:cId AND c.publish=:cPub';
                        $extraParams['cId'] = $param[1];
                        $extraParams['cPub'] = 1;
                        $this->data['categoryParam'] = $param[1];
                        // Top image
                        $tmpCat = $model->select_it(null, self::TBL_CATEGORY, [
                            'image', 'name'
                        ], 'id=:id AND publish=:pub', ['id' => $param[1], 'pub' => 1]);
                        if (count($tmpCat)) {
                            $this->data['page_image'] = $tmpCat[0]['image'];
                            $this->data['page_sub_title'] = $tmpCat[0]['name'];
                        }
                    }
                    //-----
                    if (isset($param[2])) {
                        if ($param[2] == 'offers') {
                            $extraWhere .= ' AND p.is_special=:spec';
                            $extraParams['spec'] = 1;
                            $this->data['specialParam'] = $param[2];
                            //-----
                            if (isset($param[3])) {
                                if ($param[3] == 'order') {
                                    if (isset($param[4])) {
                                        if (in_array($param[4], $orderTypeKeys)) {
                                            $orderParams = $this->_order_types[$param[4]];
                                            $this->data['orderText'] = $this->_order_type_globalization[$param[4]];
                                            $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[4]])[0];

                                            if (isset($param[5])) {
                                                if ($param[5] == 'page') {
                                                    if (isset($param[6])) {
                                                        if (is_numeric($param[6])) {
                                                            $this->data['pagination']['page'] = $param[6];
                                                        }
                                                    }
                                                }
                                            }
                                        } elseif ($param[4] == 'page') {
                                            if (isset($param[5])) {
                                                if (is_numeric($param[5])) {
                                                    $this->data['pagination']['page'] = $param[5];
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

                                    if (isset($param[4])) {
                                        if ($param[4] == 'page') {
                                            if (isset($param[5])) {
                                                if (is_numeric($param[5])) {
                                                    $this->data['pagination']['page'] = $param[5];
                                                }
                                            }
                                        }
                                    }
                                } elseif ($param[3] == 'page') {
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
            } elseif ($param[0] == 'tag') {
                if (isset($param[1])) {
                    if ($param[1] == 'offers') {
                        $extraWhere .= ' AND p.is_special=:spec';
                        $extraParams['spec'] = 1;
                        $this->data['specialParam'] = $param[1];
                        //-----
                        if (isset($param[2])) {
                            if ($param[2] == 'order') {
                                if (isset($param[3])) {
                                    if (in_array($param[3], $orderTypeKeys)) {
                                        $orderParams = $this->_order_types[$param[3]];
                                        $this->data['orderText'] = $this->_order_type_globalization[$param[3]];
                                        $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[3]])[0];

                                        if (isset($param[4])) {
                                            if ($param[4] == 'page') {
                                                if (isset($param[5])) {
                                                    if (is_numeric($param[5])) {
                                                        $this->data['pagination']['page'] = $param[5];
                                                    }
                                                }
                                            }
                                        }
                                    } elseif ($param[3] == 'page') {
                                        if (isset($param[4])) {
                                            if (is_numeric($param[4])) {
                                                $this->data['pagination']['page'] = $param[4];
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

                                if (isset($param[3])) {
                                    if ($param[3] == 'page') {
                                        if (isset($param[4])) {
                                            if (is_numeric($param[4])) {
                                                $this->data['pagination']['page'] = $param[4];
                                            }
                                        }
                                    }
                                }
                            } elseif ($param[2] == 'page') {
                                if (isset($param[3])) {
                                    if (is_numeric($param[3])) {
                                        $this->data['pagination']['page'] = $param[3];
                                    }
                                }
                            }
                        }
                    } else {
                        $extraWhere .= ' AND p.keywords LIKE :tag';
                        $extraParams['tag'] = '%' . $param[1] . '%';
                        $this->data['tagParam'] = $param[1];
                    }
                    //-----
                    if(isset($param[2])) {
                        if ($param[2] == 'offers') {
                            $extraWhere .= ' AND p.is_special=:spec';
                            $extraParams['spec'] = 1;
                            $this->data['specialParam'] = $param[2];
                            //-----
                            if (isset($param[3])) {
                                if ($param[3] == 'order') {
                                    if (isset($param[4])) {
                                        if (in_array($param[4], $orderTypeKeys)) {
                                            $orderParams = $this->_order_types[$param[4]];
                                            $this->data['orderText'] = $this->_order_type_globalization[$param[4]];
                                            $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[4]])[0];

                                            if (isset($param[5])) {
                                                if ($param[5] == 'page') {
                                                    if (isset($param[6])) {
                                                        if (is_numeric($param[6])) {
                                                            $this->data['pagination']['page'] = $param[6];
                                                        }
                                                    }
                                                }
                                            }
                                        } elseif ($param[4] == 'page') {
                                            if (isset($param[5])) {
                                                if (is_numeric($param[5])) {
                                                    $this->data['pagination']['page'] = $param[5];
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

                                    if (isset($param[4])) {
                                        if ($param[4] == 'page') {
                                            if (isset($param[5])) {
                                                if (is_numeric($param[5])) {
                                                    $this->data['pagination']['page'] = $param[5];
                                                }
                                            }
                                        }
                                    }
                                } elseif ($param[3] == 'page') {
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
            } elseif ($param[0] == 'offers') {
                $extraWhere .= ' AND p.is_special=:spec';
                $extraParams['spec'] = 1;
                $this->data['specialParam'] = $param[0];
                //-----
                if (isset($param[1])) {
                    if ($param[1] == 'order') {
                        if (isset($param[2])) {
                            if (in_array($param[2], $orderTypeKeys)) {
                                $orderParams = $this->_order_types[$param[2]];
                                $this->data['orderText'] = $this->_order_type_globalization[$param[2]];
                                $this->data['orderParam'] = array_keys($this->_order_type_globalization, $this->_order_type_globalization[$param[2]])[0];

                                if (isset($param[3])) {
                                    if ($param[3] == 'page') {
                                        if (isset($param[4])) {
                                            if (is_numeric($param[4])) {
                                                $this->data['pagination']['page'] = $param[4];
                                            }
                                        }
                                    }
                                }
                            } elseif ($param[2] == 'page') {
                                if (isset($param[3])) {
                                    if (is_numeric($param[3])) {
                                        $this->data['pagination']['page'] = $param[3];
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
        $this->data['pagination']['total'] = $productModel->getProductsCount('p.publish=:pub' . $extraWhere,
            array_merge(['pub' => 1], $extraParams));
        $this->data['pagination']['limit'] = isset($this->setting['pages']['product']['itemsEachPage']) && is_numeric($this->setting['pages']['product']['itemsEachPage']) && $this->setting['pages']['product']['itemsEachPage'] > 0 ? $this->setting['pages']['product']['itemsEachPage'] : ITEMS_EACH_PAGE_DEFAULT;
        $this->data['pagination']['offset'] = ($this->data['pagination']['page'] - 1) * $this->data['pagination']['limit'];
        $this->data['pagination']['firstPage'] = 1;
        $this->data['pagination']['lastPage'] = ceil($this->data['pagination']['total'] / $this->data['pagination']['limit']);
        //-----
        $this->data['products'] = $productModel->getProducts('p.publish=:pub' . $extraWhere,
            array_merge(['pub' => 1], $extraParams), $this->data['pagination']['limit'], $this->data['pagination']['offset'], $orderParams);
    }
}