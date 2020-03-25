(function ($) {

    'use strict';

    $(function () {
        //------------------------------
        //---------- Variables ---------
        //------------------------------
        var
            address_radio,
            current_contact_item,
            //-----
            shipping_radio,
            shipping_info_container,
            //-----
            shipping_information_url,
            price_calculate_url,
            //-----
            shopping_side_card;

        var
            namespace = 'shoppingActions',
            //-----
            shop = $.shop(),
            //-----
            ajax_obj = {};

        shipping_information_url = baseUrl + 'shippingInformation';
        price_calculate_url = baseUrl + 'shoppingSideCard';

        //------------------------------
        //---------- Functions ---------
        //------------------------------
        function addressRadioChange() {
            var selected, id, the_address, addresses_keys;
            addresses_keys = Object.keys(addresses);

            address_radio.on('change.' + namespace, function () {
                selected = $('input[type="radio"][name="addrRadio"]:checked');
                id = selected.val();
                //-----
                if ($.inArray(id, addresses_keys) !== -1) {
                    the_address = addresses[id][0];
                    // change text of address information
                    current_contact_item.find('.checkout-contact-btn-edit').attr('href', baseUrl + 'user/editAddress/' + id + '?back_url=' + baseUrl + 'shopping')
                        .end().find('.full-name').html(the_address['receiver'])
                        .end().find('.mobile-phone').html(the_address['phone'])
                        .end().find('.post-code').html(the_address['postal_code'])
                        .end().find('.state').html(the_address['province'])
                        .end().find('.city').html(the_address['city'])
                        .end().find('.address-part').html(the_address['address']);
                }
            });
        }

        function shippingRadioChange() {
            var $this, selected, code;

            shipping_radio.on('change.' + namespace, function () {
                selected = $('input[type="radio"][name="shipping-radio"]:checked');
                code = selected.val();
                // Do ajax to get changed shipping information
                shop.ajaxRequest({
                    url: shipping_information_url,
                    method: 'POST',
                    data: {
                        postedCode: code
                    }
                }, function (response) {
                    // console.log(response);
                    var res = JSON.parse(response);

                    shop.isInProgress = false;
                    shop.showLoader = false;

                    shop.processAjaxData(res, function (content) {
                        shipping_info_container.html(content);
                    });

                    // Another ajax for change shopping side price
                    if(res.success) {
                        shop.ajaxRequest({
                            url: price_calculate_url,
                            method: 'POST',
                            data: {
                                postedCode: code
                            }
                        }, function (response2) {
                            // console.log(response2);
                            shop.processAjaxData(JSON.parse(response2), function (content2) {
                                shopping_side_card.html(content2);
                            });

                            repeaterCaller();
                        });
                        shop.showLoader = true;
                    }
                }, null, function () {
                    // Do nothing
                });
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
            address_radio = $('input[type="radio"][name="addrRadio"]');
            current_contact_item = $('#current-contact-item');
            //-----
            shipping_radio = $('input[type="radio"][name="shipping-radio"]');
            shipping_info_container = $('#shippingInformation');
            //-----
            shopping_side_card = $('.checkout-summary-main');
            //-----
            addressRadioChange();
            shippingRadioChange();
        }

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        functionsCaller();
        repeaterCaller();
    });
})(jQuery);