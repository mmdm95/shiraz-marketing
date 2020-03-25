(function ($) {
    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            cart_wrapper,
            remove_item_btn,
            quantity_select_input;

        var
            namespace = 'cardCheckoutActions',
            //-----
            shop = $.shop(),
            cart_cls = $.cart(),
            //-----
            fetch_updated_url = baseUrl + 'fetchUpdatedCart',
            update_cart_url = baseUrl + 'updateCart',
            remove_from_cart_url = baseUrl + 'removeFromCart',
            ajax_obj = {};

        cart_wrapper = $('.cart_page__wrapper');

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function doUpdate() {
            shop.ajaxRequest({
                url: update_cart_url,
                method: 'POST',
                data: ajax_obj
            }, function (response) {
                // console.log(JSON.parse(response));
                shop.processAjaxData(JSON.parse(response));
                shop.isInProgress = false;
                fetchUpdatedItems();
            });
        }

        function doDelete() {
            shop.ajaxRequest({
                url: remove_from_cart_url,
                method: 'POST',
                data: ajax_obj
            }, function (response) {
                // console.log(JSON.parse(response));
                shop.processAjaxData(JSON.parse(response));
                shop.isInProgress = false;
                fetchUpdatedItems();
            });
        }

        function fetchUpdatedItems() {
            shop.showLoader = false;
            shop.ajaxRequest({
                url: fetch_updated_url,
                method: 'GET',
            }, function (response) {
                // console.log(response);
                var res = JSON.parse(response);
                // console.log(res);
                if (res.success) {
                    if (res.success.msg) {
                        cart_wrapper.html(res.success.msg);
                    } else {
                        shop.showMessage('خطا در واکشی سبد خرید!', 'خطا', 'error', shop.messageIcon.danger);
                    }
                } else {
                    shop.showMessage('خطا در واکشی سبد خرید!', 'خطا', 'error', shop.messageIcon.danger);
                }

                cart_cls.refresh();
            }, null, function () {
                shop.isInProgress = false;
                shop.showLoader = true;
                functionsCaller();

                // Remove loader
                shop.removeLoader();
            });
        }

        function quantitySelectInputChange () {
            var $this, qnt, p_id, color;
            quantity_select_input.off('change.' + namespace).on('change.' + namespace, function (e) {
                $this = $(this);
                p_id = $this.closest('tr').data('product-id');
                color = $this.closest('tr').data('color-code');
                qnt = $this.find(':selected');
                qnt = qnt ? qnt.val() : $this.find('option').first().val();
                if(qnt && p_id) {
                    ajax_obj.postedId = p_id;
                    ajax_obj.quantity = qnt;
                    ajax_obj.postedColorCode = color;
                    doUpdate();
                }
            });
        }

        function removeItemClick() {
            var $this, p_id, color;
            remove_item_btn.off('click.' + namespace).on('click.' + namespace, function (e) {
                e.preventDefault();
                //-----
                $this = $(this);
                //-----
                shop.question(null, function () {
                    p_id = $this.closest('tr').data('product-id');
                    color = $this.closest('tr').data('color-code');
                    if(p_id) {
                        ajax_obj.postedId = p_id;
                        ajax_obj.postedColorCode = color;
                        doDelete();
                    }
                });
            });
        }

        function functionsCaller() {
            remove_item_btn = $('.checkout-btn-remove');
            quantity_select_input = $('.quantity-select-input');
            //-----
            removeItemClick();
            quantitySelectInputChange();
            //-----
            var wiki = $('.wiki');
            wiki.each(function () {
                var $this = $(this);
                $this.popover({
                    content: $($this.data('content-el')).html(),
                    html: true
                });
            });
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
    });
})(jQuery);