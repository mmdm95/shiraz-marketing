(function ($) {
    "use strict";

    var namespc = 'shz_marketing';

    /**
     * Super global shop object that have required functionality
     * @constructor
     */
    var Shop = function () {
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
            is_local = false, // Change this after development (for release it must be false)
            //-----
            info_icon = 'la la-info-circle',
            warning_icon = 'la la-bell',
            success_icon = 'la la-check',
            danger_icon = 'la la-times-circle';

        var
            loader = "<div class='loader-modal'>\
                        <div class='loading'>\
                            <div></div>\
                            <div></div>\
                            <div></div>\
                        </div>\
                      </div>",
            loader_little = "<div class='loader-modal loader-little'>\
                                <div class='loading'>\
                                    <div></div>\
                                    <div></div>\
                                    <div></div>\
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
        _this.addLoader = function (to, type, relative) {
            var which;
            if (typeof to !== typeof undefined && $(to).length) {
                to = to && $(to).length ? $(to) : body;
                which = type === 2 ? loader_little : loader;
            } else {
                to = body;
                which = loader;
            }
            relative = !!relative;

            var loaderContainer = to.append(which).find('.loader-modal');
            if (relative) {
                loaderContainer.addClass('is-relative');
            }
            loaderContainer.css('visibility', 'visible')
                .animate({
                    'opacity': 1
                }, 300);
        };
        _this.removeLoader = function () {
            body.find('.loader-modal').fadeOut(300, function () {
                $(this).remove()
            });
        };
        _this.scrollToElement = function (el, distance, duration) {
            var top;
            duration = typeof duration === typeof 1 ? Math.abs(duration) : 300;
            el = el && $(el).length ? $(el) : 'html, body';
            top = el === 'html, body' ? 0 : el.offset().top;
            top += typeof distance === typeof 1 ? distance : 0;
            $('html, body').stop().animate({
                scrollTop: top
            }, duration);
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
        _this.log = console.log;

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
        $.shop = function () {
            return new Shop();
        };

        // initialize select 2
        $(document).ready(function () {
            $(".input-select2").select2({
                multiple: false,
                width: "100%",
                placeholder: "انتخاب کنید",
                containerCssClass: "form-control",
                minimumResultsForSearch: 12,
                dir: 'rtl',
                // theme: "classic",
            });
        });

        // enable bootstrap tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // testimonial-carousel
        $(".main-slider-carousel").owlCarousel({
            items: 1,
            dots: true,
            nav: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 10000,
            autoplayHoverPause: true,
            rtl: true,
            navText: ['<span class="i la la-angle-right"></span>', '<span class="i la la-angle-left"></span>'],
        });

        $('.our-team').owlCarousel({
            items: 6,
            margin: 25,
            dots: false,
            nav: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 10000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
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
            },
            rtl: true,
            navText: ['<span class="i la la-angle-right"></span>', '<span class="i la la-angle-left"></span>'],
        });

        // testimonial-carousel
        $(".thumbnail-slider-carousel").owlCarousel({
            items: 1,
            dots: false,
            nav: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 10000,
            autoplayHoverPause: true,
            rtl: true,
            navText: ['<span class="i la la-angle-right"></span>', '<span class="i la la-angle-left"></span>'],
        });

        // testimonial-carousel
        $(".owl-thumb").owlCarousel({
            dots: false,
            nav: false,
            rtl: true,
            autoWidth: true,
            margin: 13,
        });

        // Owl carousel thumb activation
        var changeActiveThumb = function (thumb, owl, event) {
            var items = event.item.count;     // Number of items
            var item = event.item.index - 1;     // Position of the current item
            // it loop is true then reset counter from 1
            if (item > items) {
                item = item - items
            } else if (item < 1) {
                item = items;
            }
            var thumbItems = thumb.data('owl.carousel')._items;
            $(thumbItems).each(function () {
                $(this).find('img').removeClass('active');
            });
            $(thumbItems[item - 1]).find('img').addClass('active');
        };

        $('[data-owl-carousel-thumb-id]').each(function () {
            var $this, carousel;
            $this = $(this);
            carousel = $('#' + $this.data('owl-carousel-thumb-id'));
            carousel.on('changed.owl.carousel', function (event) {
                changeActiveThumb($this, carousel, event);
            });
        });
        var thumbImages = $('.owl-thumb-image');
        thumbImages.on('click.' + namespc, function () {
            var $this, thumbs, carousel;
            $this = $(this);
            thumbs = $this.closest('[data-owl-carousel-thumb-id]');
            carousel = $('#' + thumbs.data('owl-carousel-thumb-id'));
            thumbImages.removeClass('active');
            $this.addClass('active');
            carousel.data('owl.carousel').to($this.closest('.owl-item').index());
        });

        // logo carousel
        $(".items-slider-col-3").owlCarousel({
            items: 3,
            nav: true,
            dots: false,
            rtl: true,
            margin: 25,
            responsive: {
                0: {
                    items: 1
                },
                575: {
                    items: 2
                },
                767: {
                    items: 2
                },
                991: {
                    items: 4
                }
            },
            navText: ['<span class="i la la-angle-right"></span>', '<span class="i la la-angle-left"></span>'],
        });

        // logo carousel
        $(".items-slider-col-4").owlCarousel({
            items: 3,
            nav: true,
            dots: false,
            rtl: true,
            margin: 25,
            responsive: {
                0: {
                    items: 1
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
            },
            navText: ['<span class="i la la-angle-right"></span>', '<span class="i la la-angle-left"></span>'],
        });

        // footer namad carousel
        $(".namad-carousel").owlCarousel({
            items: 1,
            dots: false,
            nav: false,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: true,
            margin: 100,
        });

        /* custom upload file name */
        // $("#uploadImage").on("change", function () {
        //     var file = $("#")[0].files[0].name;
        //     $("#file_name").html(file);
        // });

        //custom scrollbar
        $(".custom-scrollbar-y").mCustomScrollbar({
            axis: "y",
            scrollInertia: 200,
            scrollEasing: "easeIn",
            theme: "dark",
        });

        //custom scrollbar
        $(".custom-scrollbar-x").mCustomScrollbar({
            axis: "x",
            scrollInertia: 200,
            scrollEasing: "easeIn",
            autoHideScrollbar: true,
            theme: "dark",
        });

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
            $.shop().scrollToElement(target, -30);
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
                $.shop().scrollToElement(selector, -30);
            }
        }

        // Always show these modals
        $('.always-show-modal').modal();

        //------------------------------------------------

        // Back to top
        var backToTop = $('#backToTop');
        var checkBTTBtnVisibility = function () {
            if ($(window).scrollTop() > 300) {
                backToTop.fadeIn(300);
            } else {
                backToTop.stop().fadeOut(300);
            }
        };
        //-----
        checkBTTBtnVisibility();
        $(window).on('scroll.' + namespc, function () {
            checkBTTBtnVisibility();
        });

        backToTop.on('click.' + namespc, function () {
            $.shop().scrollToElement('body', 0, 500);
        });

        // Refine bootstrap dropdown inside click issue
        $('.dropdown-menu').on('click', function (e) {
            e.stopPropagation();
        });

        // Off-canvas menu
        $('#offCanvasMenu').offcanvas({
            modifiers: "right,overlay",
            triggerButton: '#menuBtn',
        });

        // Clear text from form-control
        var triggerClearInputIcon = function (selector) {
            var clearIcon = $(selector).parent().find('.clear-icon');
            if (clearIcon.length) {
                if ($(selector).val().trim() !== '') {
                    clearIcon.addClass('show');
                } else {
                    clearIcon.removeClass('show');
                }
            }
        };
        $('.form-control').on('input.' + namespc, function () {
            triggerClearInputIcon(this);
        }).on('focus.' + namespc, function () {
            triggerClearInputIcon(this);
        });
        $('.clear-icon').on('click.' + namespc, function () {
            var formControl = $(this).parent().find('.form-control');
            formControl.val('').focus();
        });

        // Password show from form-control
        $('.password-icon').on('click.' + namespc, function () {
            var formControl, type, $this;
            formControl = $(this).parent().find('.form-control');
            type = formControl.attr('type');
            $this = $(this);
            if (type === 'text') {
                $this.removeClass('text-primary');
                formControl.attr('type', 'password');
            } else {
                $this.addClass('text-primary');
                formControl.attr('type', 'text');
            }
            formControl.focus();
        });
    });
})(jQuery);