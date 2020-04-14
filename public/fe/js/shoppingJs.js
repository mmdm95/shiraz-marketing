(function ($) {

    'use strict';

    var namespace = 'shoppingActions';
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
            city_select,
            city,
            //-----
            shopping_side_card;

        var
            shop = $.shop(),
            //-----
            ajax_obj = {};

        price_calculate_url = baseUrl + 'tmpShoppingSideCard';
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
                                postedCode: code,
                                cityCode: city,
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
                discount_btn.attr('disabled', false);
            });
        }

        function citySelectChange() {
            var $this;
            city_select.on('change.' + namespace, function () {
                $this = $(this);
                city = $this.find(':selected');
                city = city ? city.val() : $this.find('option').first().val();
                if ($.trim(city) !== '' && city != '-1') {
                    shop.showLoader = false;
                    shop.ajaxRequest({
                        url: price_calculate_url,
                        method: 'POST',
                        data: {
                            cityCode: city
                        }
                    }, function (response) {
                        // console.log(response);
                        // console.log(JSON.parse(response));

                        var res = JSON.parse(response);
                        shop.processAjaxData(res, function (content) {
                            if (res.success) {
                                shopping_side_card.html(content);
                            }
                        });
                    }, null, function () {
                        shop.showLoader = true;
                        shop.isInProgress = false;
                        // Remove loader
                        shop.removeLoader();
                    });
                }
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
            city_select = $('#sh-rc');
            //-----
            discountBtnClick();
            discountDeleteBtnClick();
            //-----
            citySelectChange();
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
        repeaterCaller();
    });
    $(function () {
        var default_rout = baseUrl;

        $('.cityLoader').on('change.' + namespace, function () {
            var $this, target, province;
            $this = $(this);
            target = $this.data('target-for');
            target = target && $(target) && $(target).length ? $(target) : null;
            if (this.nodeName.toLowerCase() === 'select' && target) {
                province = $this.find(':selected');
                province = province ? province.val() : $this.find('option').first().val();
                $.ajax({
                    url: default_rout + 'getCity',
                    method: 'POST',
                    data: {
                        postedId: province
                    }
                }).done(function (response) {
                    // console.log(response);
                    // console.log(JSON.parse(response));

                    var res, cities;
                    res = JSON.parse(response);
                    if (res.success) {
                        // Remove all options first
                        target.find('.removable-city-option').remove();

                        // Add each city to select
                        cities = res.success.msg;
                        var i, len, option;
                        len = cities.length;
                        for (i = 0; i < len; ++i) {
                            option = createSelectOption(cities[i]['id'], cities[i]['name']);
                            target.append(option);
                        }
                    }
                });
            }
        });

        function createSelectOption(value, text) {
            return "<option value='" + value + "' class='removable-city-option'>" + text + "</option>";
        }
    });
})(jQuery);