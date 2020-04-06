(function ($) {

    'use strict';

    $(function () {
        var default_rout = baseUrl + 'admin/';
        var dataTable = $('.datatable-highlight');

        //********** ManageBlog Action
        $('.deleteBlogBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'blog/deleteBlog', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageBlogCategory Action
        $('.deleteBlogCategoryBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'blog/deleteCategory', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageComplaints Action
        $('.deleteComplaintBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteComplaint', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageComplaints Action (inside of viewComplaint)
        $('#delComplaintBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteComplaint', function () {
                setTimeout(function () {
                    window.location.href = default_rout + 'manageComplaints';
                }, 2000);
            });
        });
        //**********

        //********** ManageContactUs Action
        $('.deleteContactBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteContact', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageContactUs Action (inside of viewContact)
        $('#delContactBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteContact', function () {
                setTimeout(function () {
                    window.location.href = default_rout + 'manageContactUs';
                }, 2000);
            });
        });
        //**********

        //********** ManageCoupon Action
        $('.deleteCouponBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'shop/deleteCoupon', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageFAQ Action
        $('.deleteFAQBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteFAQ', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageReturnOrders Action
        $('.deleteReturnOrderBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'shop/deleteReturnOrder', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageReturnOrders Action (inside of viewReturnOrder)
        $('#delReturnOrderBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'shop/deleteReturnOrder', function () {
                setTimeout(function () {
                    window.location.href = default_rout + 'shop/manageReturnOrders';
                }, 2000);
            });
        });
        //**********

        //********** ManageReturnOrders Action (inside of viewReturnOrder)
        $('#closeReturnOrderBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'shop/closeReturnOrder', function () {
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            });
        });
        //**********

        //********** ManageProduct Action
        $('.deleteProductBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'shop/deleteProduct', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageShopCategory Action
        $('.deleteCategoryBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'shop/deleteCategory', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageSlider Action
        $('.deleteSlideBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteSlide', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageStaticPage Action
        $('.deleteStaticPageBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'deleteStaticPage', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageUser Action
        $('.deleteUserBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'user/deleteUser', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** ManageMarketer Action
        $('.deleteMarketerBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'user/deleteMarketer', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
        //**********

        //********** UserUpgrade Action
        $('.deleteMarketerRequestBtn').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            delete_something_action(this, 'user/deleteMarketerRequest', function () {
                $(del_btn).closest('tr').fadeOut(800, function () {
                    if ($.fn.DataTable) {
                        dataTable.DataTable().row($(this)).remove().draw();
                    } else {
                        $(this).remove();
                    }
                });
            });
        });
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

        //********** Show blog category to side
        $('.blogCategorySideShow').on('change', function (e) {
            e.preventDefault();
            var btn = $(this);
            var stat = btn.is(':checked') ? 1 : 0;

            active_deactive_action(this, 'blog/showInSide', {stat: stat});
        });
        //**********

        //********** Toggle product availability
        $('.productAvailability').on('change', function (e) {
            e.preventDefault();
            var btn = $(this);
            var stat = btn.is(':checked') ? 1 : 0;

            active_deactive_action(this, 'shop/availableProduct', {stat: stat});
        });
        //**********

        //********** Active/Deactive user
        $('.uActiveDeactiveBtn').on('change', function (e) {
            e.preventDefault();
            var btn = $(this);
            var stat = btn.is(':checked') ? 1 : 0;

            active_deactive_action(this, 'user/activeDeactive', {stat: stat});
        });
        //**********

        //********** Make user to be in our team
        $('.inOurTeamBtn').on('change', function (e) {
            e.preventDefault();
            var btn = $(this);
            var stat = btn.is(':checked') ? 1 : 0;

            active_deactive_action(this, 'user/inOurTeam', {stat: stat});
        });
        //**********

        //********** UserUpgrade accept user to be marketer
        $('.acceptMarketerBtn').on('change', function (e) {
            e.preventDefault();
            var btn = $(this);
            var stat = btn.is(':checked') ? 1 : 0;

            active_deactive_action(this, 'user/acceptMarketer', {stat: stat});
        });
        //**********

        function active_deactive_action(selector, sendUrl, params, callback) {
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