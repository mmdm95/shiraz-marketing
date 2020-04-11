(function ($) {

    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            price_calculate_url,
            check_off_code_url,
            //-----
            discount_inp,
            discount_btn,
            discount_delete_btn,
            //-----
            shopping_side_card;

        var
            namespace = 'shoppingActions',
            //-----
            shop = $.shop(),
            //-----
            ajax_obj = {};

        price_calculate_url = baseUrl + 'shoppingSideCard';
        check_off_code_url = baseUrl + 'checkCouponCode';

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function discountBtnClick() {
            var $this, code;
            discount_btn.on('click.' + namespace, function () {
                $this = $(this);
                if (!$this.is(':disabled')) {
                    code = discount_inp.val();
                    if ($.trim(code) !== '') {
                        shop.ajaxRequest({
                            url: check_off_code_url,
                            method: 'POST',
                            data: {
                                postedCode: code
                            }
                        }, function (response) {
                            // console.log(response);
                            // console.log(JSON.parse(response));

                            var res = JSON.parse(response);
                            shop.processAjaxData(res, function (content) {
                                if (res.success) {
                                    shopping_side_card.html(content);
                                    // Disable edit/click the/on input/button
                                    discount_inp.attr('readonly', 'readonly');
                                    $this.attr('disabled', 'disabled');
                                    // Call repeater function
                                    repeaterCaller();
                                }
                            });
                        });
                    }
                }
            });
        }

        function discountDeleteBtnClick() {
            discount_delete_btn.on('click.' + namespace, function () {
                discount_inp.attr('readonly', false).val('');
            });
        }

        function repeaterCaller() {
            var wiki = $('.wiki');
            wiki.each(function () {
                var $this = $(this);
                $this.popover({
                    content: $($this.data('content-el')).html(),
                    html: true
                });
            });
        }

        function functionsCaller() {
            shopping_side_card = $('#main_sidebar__wrapper');
            //-----
            discount_inp = $('input[name="coupon_code"]');
            discount_btn = $('#couponChecker');
            discount_delete_btn = $('#couponDelete');
            //-----
            discountBtnClick();
            discountDeleteBtnClick();
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
        repeaterCaller();
    });
})(jQuery);