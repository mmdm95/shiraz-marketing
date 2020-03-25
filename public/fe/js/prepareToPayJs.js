(function ($) {

    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            shopping_side_card,
            //-----
            off_inp,
            off_btn,
            //-----
            check_off_code_url,
            price_calculate_url;

        var
            namespace = 'shoppingActions',
            //-----
            shop = $.shop(),
            //-----
            ajax_obj = {};

        check_off_code_url = baseUrl + 'checkOffCode';
        price_calculate_url = baseUrl + 'prepareShoppingSideCard';

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function offBtnClick() {
            var $this, code;
            off_btn.on('click.' + namespace, function () {
                $this = $(this);
                if(!$this.is(':disabled')) {
                    code = off_inp.val();
                    if ($.trim(code) !== '') {
                        shop.ajaxRequest({
                            url: check_off_code_url,
                            method: 'POST',
                            data: {
                                postedCode: code
                            }
                        }, function (response) {
                            var res = JSON.parse(response);

                            shop.processAjaxData(res, function (content) {
                                if (res.success) {
                                    shopping_side_card.html(content);
                                    // Disable edit/click the/on input/button
                                    off_inp.attr('readonly', 'readonly');
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
            off_inp = $('input[name="code"]');
            off_btn = $('#offBtn');
            //-----
            offBtnClick();
            //-----
            shopping_side_card = $('.checkout-summary-main');
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
        repeaterCaller();
    });
})(jQuery);