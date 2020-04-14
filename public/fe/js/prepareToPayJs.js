(function ($) {

    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            theForm,
            //-----
            get_token_url;

        var
            namespace = 'shoppingActions',
            //-----
            shop = $.shop(),
            //-----
            ajax_obj = {};

        get_token_url = baseUrl + '_mabna_connection';

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function formSubmission() {
            var $this, terminal_field, token_field;
            var code;
            theForm.submit(function () {
                $this = $(this);
                code = $("input[name='payment_radio']:checked").val();
                //-----
                if ($.trim(code) !== '' && code == 'PAY_342515312') {
                    shop.ajaxRequest({
                        url: get_token_url,
                        method: 'POST',
                        data: {
                            paymentCode: code,
                        }
                    }, function (response) {
                        // console.log(response);
                        // console.log(JSON.parse(response));

                        var res = JSON.parse(response);

                        shop.processAjaxData(res, function (content) {
                            if (res.success) {
                                $this.attr('action', content[0] /* url */).attr('method', 'post');
                                terminal_field = _hiddenField('terminalID', content[1] /* terminal */);
                                token_field = _hiddenField('token', content[2] /* token */);
                                $this.prepend(terminal_field);
                                $this.prepend(token_field);
                            } else {
                                return false;
                            }
                        });
                    });
                }
                //-----
                return true;
            });
        }

        function _hiddenField(name, value) {
            return $('<input type="hidden" name="' + name + '" value="' + value + '"/>');
        }

        function functionsCaller() {
            theForm = $('#paymentForm');
            //-----
            formSubmission();
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
    });
})(jQuery);