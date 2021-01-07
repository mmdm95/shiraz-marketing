(function ($) {
    'use strict';

    $(function () {
        var Cart = function () {
            //------------------------------
            //---------- Variables ---------
            //------------------------------
            var
                _this = this,
                shop = $.shop();

            var
                cart_wrapper,
                cart_btn,
                cart_count_wrapper,
                cart_item_wrapper,
                remove_item_btn,
                //-----
                add_item_btn;

            var
                namespace = 'cardActions',
                //-----
                fetch_cart_items_url = baseUrl + 'fetchCardItems',
                add_to_cart_url = baseUrl + 'addToCart',
                remove_from_cart_url = baseUrl + 'removeFromCart',
                remove_all_from_cart_url = baseUrl + 'removeAllFromCart',
                ajax_obj = {},
                //----
                cart_btn_main = "<div class=\"menu-icon basket-icon dropdown-toggle\" id=\"shoppingCart\" data-toggle=\"dropdown\"\n\
                                     aria-haspopup=\"true\" aria-expanded=\"false\" data-target=\"basketDropdown\">\n\
                                    <i class=\"la la-shopping-cart\" id=\"cart\"></i>\n\
                                    <span class=\"basket-number badge\">۰</span>\n\
                                 </div>";

            cart_wrapper = $('.basket-container').first();
            cart_item_wrapper = cart_wrapper.find('#basketDropdown');
            cart_btn = cart_wrapper.find('#shoppingCart');
            cart_count_wrapper = cart_btn.find('.basket-number');

            //------------------------------
            //---------- Functions ---------
            //------------------------------
            function doAddAjax() {
                var obj = ajax_obj.add ? ajax_obj.add : {};
                shop.ajaxRequest({
                    url: add_to_cart_url,
                    method: 'POST',
                    data: obj
                }, function (response) {
                    // console.log(response);
                    // console.log(JSON.parse(response));

                    shop.processAjaxData(JSON.parse(response), function () {
                        shop.isInProgress = false;
                        fetchCartItems();
                    });
                });
            }

            function doDeleteAjax() {
                var obj = ajax_obj.del ? ajax_obj.del : {};
                shop.ajaxRequest({
                    url: remove_from_cart_url,
                    method: 'POST',
                    data: obj
                }, function (response) {
                    // console.log(response);
                    // console.log(JSON.parse(response));
                    shop.processAjaxData(JSON.parse(response), function () {
                        shop.isInProgress = false;
                        if (siteAction === 'cart') {
                            window.location.reload();
                        }
                        fetchCartItems();
                    });
                }, null, function () {
                    shop.isInProgress = false;
                });
            }

            function fetchCartItems() {
                shop.showLoader = false;
                shop.ajaxRequest({
                    url: fetch_cart_items_url,
                    method: 'GET'
                }, function (response) {
                    // console.log(response);
                    var res = JSON.parse(response);
                    // console.log(res);
                    if (res.success) {
                        if (res.success.msg) {
                            cart_item_wrapper.html(res.success.msg[0]);
                            cart_count_wrapper.text(res.success.msg[1]);
                        } else {
                            shop.showMessage('خطا در واکشی سبد خرید!', 'خطا', 'error', shop.messageIcon.danger);
                        }
                    } else {
                        shop.showMessage('خطا در واکشی سبد خرید!', 'خطا', 'error', shop.messageIcon.danger);
                    }
                }, null, function () {
                    shop.isInProgress = false;
                    shop.showLoader = true;
                    functionsCaller();

                    // Remove loader
                    shop.removeLoader();
                });
            }

            function addToCartClick() {
                var $this, item, quantity;
                add_item_btn.off('click.' + namespace).on('click.' + namespace, function (e) {
                    e.preventDefault();
                    //-----
                    $this = $(this);
                    item = $this.attr('data-item-id');
                    quantity = $this.attr('data-item-quantity');
                    _this.addToCart(item, false, quantity);
                });
            }

            function removeFromCartClick() {
                var $this, item;
                remove_item_btn.off('click.' + namespace).on('click.' + namespace, function (e) {
                    e.preventDefault();
                    //-----
                    $this = $(this);
                    //-----
                    shop.question(null, function () {
                        item = $this.attr('data-item-id');
                        _this.removeFromCart(item);
                    });
                });
            }

            function functionsCaller() {
                if (!cart_wrapper.length) {
                    // console.error('بستر اصلی سبد خرید وجود ندارد. لطفا صفحه را مجددا بارگذاری نمایید!');
                    return;
                }
                //-----
                if (!cart_btn.length) {
                    // console.error('دکمه اصلی سبد خرید وجود ندارد. لطفا صفحه را مجددا بارگذاری نمایید!');
                    // return;
                    cart_wrapper.prepend(cart_btn_main);
                    cart_btn = cart_wrapper.find('.cart-btn');
                    cart_count_wrapper = cart_btn.find('.count-cart');

                    // Reassign dropdown event
                    $(cart_btn).dropdown('destroy').dropdown();
                }
                //-----
                if (!cart_item_wrapper.length) {
                    // console.error('بستر آیتم‌های سبد خرید وجود ندارد. لطفا صفحه را مجددا بارگذاری نمایید!');
                    return;
                }
                //-----
                add_item_btn = $('.add-to-cart-btn');
                remove_item_btn = cart_wrapper.find('.remove-from-cart-btn');
                //-----
                addToCartClick();
                removeFromCartClick();
            }

            //***************************************
            //************* Global Cart *************
            //***************************************
            _this.init = function () {
                functionsCaller();
            };
            _this.addToCart = function (item, color, quantity) {
                ajax_obj.add = {};
                if (item) {
                    ajax_obj['add']['postedId'] = item;
                    if (color) {
                        ajax_obj['add']['postedColorCode'] = color;
                    }
                    if (quantity) {
                        ajax_obj['add']['quantity'] = quantity;
                    }

                    doAddAjax();
                }
            };
            _this.removeFromCart = function (item, color) {
                ajax_obj.del = {};
                if (item) {
                    ajax_obj['del']['postedId'] = item;
                    if (color) {
                        ajax_obj['del']['postedColorCode'] = color;
                    }
                    doDeleteAjax();
                }
            };
            _this.refresh = function () {
                fetchCartItems();
            };
            _this.removeAllFromCart = function () {
                // Implement if needed
            };
        };

        $.cart = function () {
            return new Cart();
        };

        var cart = $.cart();
        cart.init();
    });

    // Product detail add to cart js part
    $(function () {
        var
            namespace = 'product_detail_action',
            //-----
            minusBtn,
            plusBtn,
            //-----
            minCartCount,
            maxCartCount,
            //-----
            interval,
            internalTime = 70,
            timeout,
            timeoutTime = 150,
            //-----
            inp;
        var $this, qnt, dist;

        inp = $('[data-cart-quantity-for]');
        dist = inp.data('cart-quantity-for');
        dist = dist && $(dist) && $(dist).length ? $(dist) : false;
        //-----
        minusBtn = $('.product-detail-cart-count-btn-minus');
        plusBtn = $('.product-detail-cart-count-btn-plus');
        //-----
        minCartCount = inp.attr('min');
        maxCartCount = inp.attr('max');
        //-----
        minusBtn.off('touchstart.' + namespace + ' mousedown.' + namespace).on('touchstart.' + namespace + ' mousedown.' + namespace, function () {
            timeout = setTimeout(function () {
                interval = setInterval(function () {
                    qnt = inp.val();
                    qnt = isNaN(parseInt(qnt, 10)) ? 0 : parseInt(qnt, 10);
                    if (qnt > minCartCount) {
                        inp.val((qnt - 1));
                        dist.attr('data-item-quantity', inp.val());
                    }
                }, internalTime);
            }, timeoutTime);
        }).off('mouseup.' + namespace).on('mouseup.' + namespace, function () {
            clearTimeout(timeout);
            clearInterval(interval);
        }).off('mouseleave.' + namespace).on('mouseleave.' + namespace, function () {
            clearTimeout(timeout);
            clearInterval(interval);
        }).off('click.' + namespace).on('click.' + namespace, function () {
            qnt = inp.val();
            qnt = isNaN(parseInt(qnt, 10)) ? 0 : parseInt(qnt, 10);
            if (qnt > minCartCount) {
                inp.val((qnt - 1));
                if (dist) {
                    dist.attr('data-item-quantity', inp.val());
                }
            }
        });
        plusBtn.off('touchstart.' + namespace + ' mousedown.' + namespace).on('touchstart.' + namespace + ' mousedown.' + namespace, function () {
            timeout = setTimeout(function () {
                interval = setInterval(function () {
                    qnt = inp.val();
                    qnt = isNaN(parseInt(qnt, 10)) ? 0 : parseInt(qnt, 10);
                    if (qnt < maxCartCount) {
                        inp.val((qnt + 1));
                        if (dist) {
                            dist.attr('data-item-quantity', inp.val());
                        }
                    }
                }, internalTime);
            }, timeoutTime);
        }).off('mouseup.' + namespace).on('mouseup.' + namespace, function () {
            clearTimeout(timeout);
            clearInterval(interval);
        }).off('mouseleave.' + namespace).on('mouseleave.' + namespace, function () {
            clearTimeout(timeout);
            clearInterval(interval);
        }).off('click.' + namespace).on('click.' + namespace, function () {
            qnt = inp.val();
            qnt = isNaN(parseInt(qnt, 10)) ? 0 : parseInt(qnt, 10);
            if (qnt < maxCartCount) {
                inp.val((qnt + 1));
                if (dist) {
                    dist.attr('data-item-quantity', inp.val());
                }
            }
        });
        //-----
        inp.off('input.' + namespace).on('input.' + namespace, function () {
            $this = $(this);
            qnt = $this.val();
            //-----
            qnt = isNaN(parseInt(qnt, 10)) ? 0 : parseInt(qnt, 10);
            qnt = qnt < minCartCount ? minCartCount : qnt;
            qnt = qnt > maxCartCount ? maxCartCount : qnt;
            //-----
            inp.val(qnt);
            //-----
            if (qnt && dist) {
                dist.attr('data-item-quantity', qnt);
            }
        });
    });
})(jQuery);
