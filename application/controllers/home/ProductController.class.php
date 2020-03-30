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
        $this->_manage_params($param);
        //-----
        $this->data['page_image'] = $this->setting['pages']['product']['topImage'] ?? '';
        $this->data['page_title'] = 'محصولات';

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
        $this->data['product'] = $productModel->getSingleProduct('id=:id', ['id' => $param[0]]);
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
        $this->data['product']['related'] = $extraPlaceholder != '' ? $productModel->getProducts('id IN (' . $extraPlaceholder . ')', $extraParams) : [];
        // Get cart item with current product item
        $cartItems = $this->_fetch_cart_items();
        $this->data['curCartItem'] = h_array_search($cartItems, 'id', $param[0]);
        //-----
        $this->data['title'] = titleMaker(' | ', set_value($this->setting['main']['title'] ?? ''), 'جزئیات محصول', @$this->data['product']['title']);

        $this->_render_page([
            'pages/fe/product-detail',
        ]);
    }

    //-----

    public function searchAction($param)
    {

    }

    //-----

    private $_order_types = [
        'newest' => ['p.id DESC'],
        'most_view' => ['p.view_count DESC', 'p.id DESC'],
        'most_discount' => ['p.discount_price ASC', 'p.id DESC']
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
                    } else {
                        $extraWhere .= ' AND p.category_id=:cId AND c.publish=:cPub';
                        $extraParams['cId'] = $param[1];
                        $extraParams['cPub'] = 1;
                        $this->data['categoryParam'] = $param[1];
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
        $this->data['pagination']['total'] = $model->it_count(self::TBL_PRODUCT, 'publish=:pub AND available=:av' . $extraWhere,
            array_merge(['pub' => 1, 'av' => 1], $extraParams));
        $this->data['pagination']['limit'] = isset($this->setting['pages']['product']['itemsEachPage']) && is_numeric($this->setting['pages']['product']['itemsEachPage']) && $this->setting['pages']['product']['itemsEachPage'] > 0 ? $this->setting['pages']['product']['itemsEachPage'] : ITEMS_EACH_PAGE_DEFAULT;
        $this->data['pagination']['offset'] = ($this->data['pagination']['page'] - 1) * $this->data['pagination']['limit'];
        $this->data['pagination']['firstPage'] = 1;
        $this->data['pagination']['lastPage'] = ceil($this->data['pagination']['total'] / $this->data['pagination']['limit']);
        //-----
        $this->data['products'] = $productModel->getProducts('publish=:pub AND available=:av' . $extraWhere,
            array_merge(['pub' => 1, 'av' => 1], $extraParams), $this->data['pagination']['limit'], $this->data['pagination']['offset'], $orderParams);
    }
}