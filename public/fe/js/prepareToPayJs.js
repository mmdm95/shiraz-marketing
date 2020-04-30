(function ($) {

    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            theForm,
            //-----
            get_token_url_beh_pardakht;

        var
            namespace = 'shoppingActions',
            //-----
            shop = $.shop(),
            //-----
            ajax_obj = {};

        get_token_url_beh_pardakht = baseUrl + '_beh_pardakht_connection';

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function formSubmission() {
            var $this, refId_field;
            var code;
            theForm.submit(function () {
                var canSubmit = false;
                $this = $(this);
                code = $("input[name='payment_radio']:checked").val();
                //-----
                if ($.trim(code) !== '') {
                    if (code == 'PAY_342515312') {
                        shop.ajaxRequest({
                            url: get_token_url_beh_pardakht,
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
                                    refId_field = _hiddenField('RefId', content[1] /* Reference ID */);
                                    $this.prepend(refId_field);
                                    //-----
                                    canSubmit = true;
                                } else {
                                    canSubmit = false;
                                }
                            });
                        });
                    }
                } else {
                    canSubmit = true;
                }
                //-----
                return canSubmit;
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

    // ----- Mabna connection request -----
    // shop.ajaxRequest({
    //     url: get_token_url_beh_pardakht,
    //     method: 'POST',
    //     data: {
    //         paymentCode: code,
    //     }
    // }, function (response) {
    //     // console.log(response);
    //     // console.log(JSON.parse(response));
    //
    //     var res = JSON.parse(response);
    //
    //     shop.processAjaxData(res, function (content) {
    //         if (res.success) {
    //             $this.attr('action', content[0] /* url */).attr('method', 'post');
    //             terminal_field = _hiddenField('terminalID', content[1] /* terminal */);
    //             token_field = _hiddenField('token', content[2] /* token */);
    //             $this.prepend(terminal_field);
    //             $this.prepend(token_field);
    //             //-----
    //             canSubmit = true;
    //         } else {
    //             canSubmit = false;
    //         }
    //     });
    // });
})(jQuery);