(function ($) {

    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            theForm,
            payment_radio,
            //-----
            get_token_url;

        var
            namespace = 'shoppingActions',
            //-----
            shop = $.shop(),
            //-----
            ajax_obj = {};

        get_token_url = baseUrl + '';

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function formSubmission(url, terminal, token) {
            var $this, terminal_field, token_field;
            theForm.submit(function () {
                $this = $(this);
                $this.attr('action', url).attr('method', 'post');
                terminal_field = _hiddenField('terminalID', terminal);
                token_field = _hiddenField('token', token);
                $this.prepend(terminal_field);
                $this.prepend(token_field);
                return true;
            });
        }

        function paymentRadioChange() {
            var $this, code;
            payment_radio.on('change.' + namespace, function () {
                $this = $(this);
                code = $this.val();
                if ($.trim(code) !== '' && code == 'PAY_342515312') {
                    shop.ajaxRequest({
                        url: get_token_url,
                        method: 'POST',
                        data: {
                            paymentCode: code,
                        }
                    }, function (response) {
                        var res = JSON.parse(response);

                        shop.processAjaxData(res, function (content) {
                            if (res.success) {
                                formSubmission(content[0], content[1], content[2]);
                            }
                        });
                    });
                }
            });
        }

        function _hiddenField(name, value) {
            return $('<input type="hidden" name="' + name + '" value="' + value + '"/>');
        }

        function functionsCaller() {
            theForm = $('#paymentForm');
            payment_radio = $('input[name="payment-radio"]');
            //-----
            paymentRadioChange();
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
    });
})(jQuery);