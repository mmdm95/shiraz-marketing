(function ($) {

    'use strict';

    $(function () {
        var default_rout = $('#BASE_URL').val() + 'user/';
        var dataTable = $('.datatable-highlight');

        //********** ManageContacts Action
        $('.deleteReturnOrderBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteReturnOrder', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        // **********

        //********** ManageContacts Action (inside of viewContact)
        // $('#').on('click', function (e) {
        //     e.preventDefault();
        //     var del_btn = $(this);
        //
        //     delete_something_action(this, '', function () {
        //         setTimeout(function () {
        //             window.location.href = default_rout + '';
        //         }, 2000);
        //     });
        // });
        //**********

        function delete_something_action(selector, sendUrl, callback) {
            var _this = this, del_btn = $(selector);
            var id = $(del_btn).find('input[type=hidden]').val();
            if ($.trim(id) != '') {
                var sure = confirm('آیا مطمئن هستید؟');
                if (sure) {
                    var url = default_rout + sendUrl;
                    $.post(url, {
                        postedId: id
                    }, function (data, status) {
                        var opts, action = false;

                        // console.log(data);
                        data = JSON.parse(data);
                        if (status == 'success') {
                            if (data.success) {
                                opts = {
                                    title: "موفقیت",
                                    text: data.success.msg,
                                    icon: 'icon-checkmark-circle2',
                                    type: "success",
                                    addclass: 'border-success-600 bg-success-600 stack-top-left',
                                    buttons: {
                                        sticker: false
                                    }
                                };

                                action = true;
                            } else {
                                opts = {
                                    title: "خطا",
                                    text: data.error.msg,
                                    icon: 'icon-exclamation',
                                    type: "error",
                                    addclass: 'border-danger-400 bg-danger-400 stack-top-left',
                                    buttons: {
                                        sticker: false
                                    }
                                };
                            }
                        } else {
                            opts = {
                                title: "خطا",
                                text: "خطای پیش‌بینی نشده! وضعیت خطا:" + status,
                                icon: 'icon-exclamation',
                                type: "error",
                                addclass: 'border-danger-400 bg-danger-400 stack-top-left',
                                buttons: {
                                    sticker: false
                                }
                            };
                        }

                        new PNotify(opts);
                        if (action) {
                            if (typeof callback === typeof function () {
                            }) {
                                callback.apply(null);
                            }
                        }
                    });
                }
            }
        }

        $.active_deactive_action = function (selector, sendUrl, params, callback) {
            var _this = this, btn = $(selector);
            var id = $(btn).parent().find('input[type=hidden]').val();
            if ($.trim(id) != '') {
                var url = default_rout + sendUrl;
                params = $.extend({postedId: id}, params);
                $.post(url, params, function (data, status) {
                    var opts, action = false;

                    // console.log(data);
                    data = JSON.parse(data);
                    if (status == 'success') {
                        if (data.success) {
                            opts = {
                                text: data.success.msg,
                                icon: 'icon-checkmark-circle2',
                                type: "success",
                                addclass: 'border-success-600 bg-success-600 stack-top-left',
                                buttons: {
                                    sticker: false
                                }
                            };

                            action = true;
                        } else if (data.warning) {
                            opts = {
                                text: data.warning.msg,
                                icon: 'icon-checkmark-circle2',
                                type: "warning",
                                addclass: 'border-grey-700 bg-grey-700 stack-top-left',
                                buttons: {
                                    sticker: false
                                }
                            };

                            action = true;
                        } else {
                            opts = {
                                title: "خطا",
                                text: data.error.msg,
                                icon: 'icon-exclamation',
                                type: "error",
                                addclass: 'border-danger-400 bg-danger-400 stack-top-left',
                                buttons: {
                                    sticker: false
                                }
                            };
                        }
                    } else {
                        opts = {
                            title: "خطا",
                            text: "خطای پیش‌بینی نشده! وضعیت خطا:" + status,
                            icon: 'icon-exclamation',
                            type: "error",
                            addclass: 'border-danger-400 bg-danger-400 stack-top-left',
                            buttons: {
                                sticker: false
                            }
                        };
                    }

                    new PNotify(opts);
                    if (action) {
                        if (typeof callback === typeof function () {
                        }) {
                            callback.apply(null);
                        }
                    }
                });
            }
        }
    });
})(jQuery);