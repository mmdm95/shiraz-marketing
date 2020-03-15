(function ($) {
    "use strict";

    var namespc = 'shz_marketing';

    /**
     * Super global shop object that have required functionality
     * @constructor
     */
    var SHM = function () {
        //************************************************************
        //********************* Local Operations *********************
        //************************************************************

        //------------------------------
        //---- Variables & Objects -----
        //------------------------------
        var
            _this = this,
            body = $('body'),
            //-----
            is_connect = false,
            is_local = true, // Change this after development (for release it must be false)
            //-----
            info_icon = 'la la-info-circle',
            warning_icon = 'la la-bell',
            success_icon = 'la la-check',
            danger_icon = 'la la-times';

        var
            loader = "<div class='custom-loader-modal'>\
                         <div class='custom-loader-contents'>\
                            <img class='custom-loader-img' src='" + baseUrl + siteLogo + "' alt=''/>\
                            <div class='custom-loader-loader'>\
                                <svg class=\"circular\" viewBox=\"25 25 50 50\">\
                                    <circle class=\"base-path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"1\" stroke-miterlimit=\"10\"/>\
                                    <circle class=\"path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"2\" stroke-miterlimit=\"10\"/>\
                                </svg>\
                            </div>\
                         </div>\
                       </div>",
            loader_relative = "<div class='custom-loader-modal is-relative'>\
                         <div class='custom-loader-contents'>\
                            <img class='custom-loader-img' src='" + baseUrl + siteLogo + "' alt=''/>\
                            <div class='custom-loader-loader'>\
                                <svg class=\"circular\" viewBox=\"25 25 50 50\">\
                                    <circle class=\"base-path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"1\" stroke-miterlimit=\"10\"/>\
                                    <circle class=\"path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"2\" stroke-miterlimit=\"10\"/>\
                                </svg>\
                            </div>\
                         </div>\
                       </div>",
            loader_limited = "<div class='custom-loader-modal limited'>\
                                 <div class='custom-loader-contents limited'>\
                                    <div class='custom-loader-loader'>\
                                        <svg class=\"circular\" viewBox=\"25 25 50 50\">\
                                            <circle class=\"base-path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"1\" stroke-miterlimit=\"10\"/>\
                                            <circle class=\"path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"2\" stroke-miterlimit=\"10\"/>\
                                        </svg>\
                                    </div>\
                                 </div>\
                               </div>",
            loader_limited_type2 = "<div class='custom-loader-modal limited type-2'>\
                                 <div class='custom-loader-contents limited type-2'>\
                                    <div class='custom-loader-loader'>\
                                        <svg class=\"circular\" viewBox=\"25 25 50 50\">\
                                            <circle class=\"base-path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"1\" stroke-miterlimit=\"10\"/>\
                                            <circle class=\"path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"2\" stroke-miterlimit=\"10\"/>\
                                        </svg>\
                                    </div>\
                                 </div>\
                               </div>";

        var defDoneFn, defFailFn, defAlwaysFn;

        defDoneFn = function () {
        };
        defFailFn = function (jqXHR, textStatus) {
            _this.showMessage('خطا در ارسال/دریافت اطلاعات، لطفا دوباره تلاش نمایید!', 'خطا', 'error', danger_icon);
        };
        defAlwaysFn = function () {
            _this.isInProgress = false;

            // Remove loader
            _this.removeLoader();
        };

        //************************************************************
        //******************** Public Operations *********************
        //************************************************************

        //------------------------------
        //---- Variables & Objects -----
        //------------------------------
        _this.isInProgress = false;
        _this.messageIcon = {
            info: info_icon,
            warning: warning_icon,
            danger: danger_icon,
            success: success_icon
        };

        //------------------------------
        //--------- Functions ----------
        //------------------------------
        _this.ajaxRequest = function (ajaxObj, doneFn, failFn, alwaysFn) {
            if (_this.hasInternetConnection) {
                if (_this.isInProgress) return;
                _this.isInProgress = true;

                doneFn = typeof doneFn === typeof function () {
                } ? doneFn : defDoneFn;
                failFn = typeof failFn === typeof function () {
                } ? failFn : defFailFn;
                alwaysFn = typeof alwaysFn === typeof function () {
                } ? alwaysFn : defAlwaysFn;

                if (_this.showLoader) {
                    // Add loader
                    _this.addLoader();
                }

                $.ajax(ajaxObj).done(doneFn).fail(failFn).always(alwaysFn);
            } else {
                _this.showMessage('ابتدا اتصال اینترنت را برقرار کنید و سپس تلاش نمایید!', 'اخطار', 'warning', _this.messageIcon.warning);
            }
        };
        _this.processAjaxData = function (response, callback) {
            var content, msg;
            if (response.success) {
                msg = Array.isArray(response.success.msg) ? response.success.msg[0] : (response.success.msg ? response.success.msg : '');
                content = Array.isArray(response.success.msg) && typeof response.success.msg[1] !== typeof undefined ? response.success.msg.slice(1) : undefined;
                if (msg != '') {
                    _this.showMessage(msg, 'موفقیت', 'success', _this.messageIcon.success);
                }
            } else if (response.info) {
                msg = Array.isArray(response.info.msg) ? response.info.msg[0] : (response.info.msg ? response.info.msg : '');
                content = Array.isArray(response.info.msg) && typeof response.info.msg[1] !== typeof undefined ? response.info.msg.slice(1) : undefined;
                if (msg != '') {
                    _this.showMessage(msg, 'اطلاع', 'info', _this.messageIcon.info);
                }
            } else if (response.warning) {
                msg = Array.isArray(response.warning.msg) ? response.warning.msg[0] : (response.warning.msg ? response.warning.msg : '');
                content = Array.isArray(response.warning.msg) && typeof response.warning.msg[1] !== typeof undefined ? response.warning.msg.slice(1) : undefined;
                if (msg != '') {
                    _this.showMessage(msg, 'اخطار', 'warning', _this.messageIcon.warning);
                }
            } else if (response.error) {
                msg = Array.isArray(response.error.msg) ? response.error.msg[0] : (response.error.msg ? response.error.msg : '');
                content = Array.isArray(response.error.msg) && typeof response.error.msg[1] !== typeof undefined ? response.error.msg.slice(1) : undefined;
                if (msg != '') {
                    _this.showMessage(msg, 'خطا', 'error', _this.messageIcon.danger);
                }
            } else {
                console.error('داده دریافتی دچار مشکل شده است! لطفا صفحه را دوباره بارگذاری کنید.');
                return;
            }

            if (typeof callback === typeof function () {
            }) {
                callback.call(this, content);
            }
        };

        _this.showLoader = true;
        _this.addLoader = function (to, limited, type) {
            var which;
            if (typeof to !== typeof undefined && $(to).length) {
                to = to && $(to).length ? $(to) : body;
                limited = limited === true;
                which = limited ? (type == 2 ? loader_limited_type2 : loader_limited) : loader_relative;
            } else {
                to = body;
                which = loader;
            }

            to.append(which).find('.custom-loader-modal').css('visibility', 'visible')
                .animate({
                    'opacity': 1
                }, 300);
        };
        _this.removeLoader = function () {
            body.find('.custom-loader-modal').fadeOut(300, function () {
                $(this).remove()
            });
        };
        _this.scrollToElement = function (el, distance) {
            var top;
            el = el && $(el).length ? $(el) : 'html, body';
            top = el === 'html, body' ? 0 : el.offset().top;
            top += typeof distance === typeof 1 ? distance : 0;
            $('html, body').stop().animate({
                scrollTop: top
            }, 300);
        };
        _this.showMessage = function (message, title, type, icon, theme, overlay, position, draggable) {
            message = message ? message : '';
            title = title ? title : '';
            type = type ? type : 'dark';
            icon = icon ? icon : '';
            theme = theme ? theme : 'light';
            position = position ? position : 'topRight';
            draggable = draggable ? draggable : true;

            // For iziToast
            overlay = overlay === true;

            if (iziToast) {
                var iziObj = {
                    theme: type == 'dark' ? 'dark' : theme,
                    icon: icon,
                    title: title,
                    message: message,
                    rtl: true,
                    close: false,
                    displayMode: 'replace',
                    overlay: overlay,
                    drag: draggable,
                    position: position
                };

                switch (type) {
                    case 'info':
                        iziToast.info(iziObj);
                        break;
                    case 'success':
                        iziToast.success(iziObj);
                        break;
                    case 'warning':
                        iziToast.warning(iziObj);
                        break;
                    case 'error':
                        iziToast.error(iziObj);
                        break;
                    default:
                        iziToast.show(iziObj);
                        break;
                }
            } else if ($.alert) {
                $.alert({
                    theme: theme,
                    icon: icon,
                    title: title,
                    content: message,
                    type: type,
                    rtl: true,
                    backgroundDismiss: true,
                    animationSpeed: 240,
                    // closeIcon: true
                });
            } else {
                alert(message);
            }
        };
        _this.question = function (message, okCallback) {
            message = message ? message : 'آیا مطمئن هستید؟';
            if (iziToast) {
                iziToast.show({
                    theme: 'dark',
                    timeout: 30000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    position: 'center',
                    message: message,
                    buttons: [
                        ['<button><b>بله</b></button>', function (instance, toast) {
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                            // -----
                            if (typeof okCallback === 'function') {
                                okCallback.call(this);
                            }
                        }, true],
                        ['<button>خیر</button>', function (instance, toast) {
                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                        }],
                    ],
                });
            } else {
                var sure = confirm(message);
                if (sure) {
                    if (typeof okCallback === 'function') {
                        okCallback.call(this);
                    }
                }
            }
        };
        _this.updateStatus = function () {
            if (navigator.onLine || is_local) {
                is_connect = true;
                _this.hasInternetConnection = is_connect;
            }
        };
        _this.log = function (context, ...parameters) {
            console.log(context, parameters)
        };

        //------------------------------
        //----------- Events -----------
        //------------------------------
        /* Update the online status icon based on connectivity */
        window.addEventListener('online', _this.updateStatus);
        window.addEventListener('offline', _this.updateStatus);

        //------------------------------
        //------- Call Functions -------
        //------------------------------
        _this.updateStatus();
    };
    $(function () {
        $.shm = function () {
            return new SHM();
        };

        // initialize select 2
        $(document).ready(function () {
            $(".input-select2").select2({
                multiple: false,
                width: "100%",
                placeholder: "انتخاب کنید",
                containerCssClass: "form-control"
            });
        });

        // enable bootstrap tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // testimonial-carousel
        $(".main-carousel").owlCarousel({
            items: 1,
            dots: false,
            nav: true,
            navText: ['<span class="i la la-long-arrow-right"></span>', '<span class="i la la-long-arrow-left"></span>']
        });

        // logo carousel
        $(".news-carousel").owlCarousel({
            items: 3,
            nav: false,
            dots: false,
            margin: 100,
            responsive: {
                0: {
                    items: 2
                },
                575: {
                    items: 2
                },
                767: {
                    items: 2
                },
                991: {
                    items: 3
                }
            }
        });

        //setting css bg image as inline in html
        $(".bg_image_holder").each(function () {
            var $this = $(this);
            var imgLink = $this.children().attr("src");
            $this.css({
                "background-image": "url(" + imgLink + ")",
                "opacity": "1"
            }).children().attr('alt', imgLink)
        });

        /* custom upload file name */
        // $("#uploadImage").on("change", function () {
        //     var file = $("#")[0].files[0].name;
        //     $("#file_name").html(file);
        // });

        //custom scrollbar
        $(".custom-scrollbar").mCustomScrollbar({
            axis: "y",
            scrollInertia: 200,
            scrollEasing: "easeIn",
            // alwaysShowScrollbar: 1,
            theme:"dark",
        });

        /* offcanvas menu */
        // var oc_menu = $(".offcanvas-menu__contents");
        // $(".offcanvas-menu__user").on("click", function (e) {
        //     oc_menu.addClass("active");
        //     e.preventDefault();
        // });
        // $(".offcanvas-menu__close").on("click", function (e) {
        //     oc_menu.removeClass("active");
        //     e.preventDefault();
        // });


        // Reload captcha
        $('.form-captcha').on('click', function () {
            var action, sameAction, sameImgSrc;
            action = $(this).closest('.form-account-captcha').data('captcha-url');
            sameAction = $('[data-captcha-url="' + action + '"]');
            sameAction.first().find('img').attr('src', baseUrl + 'captcha/' + action + '?' + Date.now());
            sameImgSrc = sameAction.first().find('img').attr('src');
            sameAction.each(function () {
                $(this).find('img').attr('src', sameImgSrc);
            });
        }).trigger('click');

        $('.smooth-scroll').on('click', function (e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $.shm().scrollToElement(target, -30);
        });

        // Show components according to id
        var hash = window.location.hash.substr(1);
        var modalArr = [];
        var elemArr = [];
        if (modalArr.length && $.inArray(hash, modalArr) !== -1) {
            var selector = $('#' + hash);
            if (selector.length && selector.hasClass('modal')) {
                selector.modal('show');
            }
        }
        if (elemArr.length && $.inArray(hash, elemArr) !== -1) {
            var selector = $('#' + hash);
            if (selector.length) {
                $.shm().scrollToElement(selector, -30);
            }
        }

        //------------------------------------------------

        // Refine bootstrap dropdown inside click issue
        $('.dropdown-menu').on('click', function (e) {
            e.stopPropagation();
        });
    });
})(jQuery);