(function ($) {

    'use strict';

    $(function () {
        //----- Global variables
        var
            change_avatar_url = baseUrl + 'user/changeAvatar',
            remove_favorite_url = baseUrl + 'user/deleteFavorite',
            remove_address_url = baseUrl + 'user/deleteAddress',
            remove_comment_url = baseUrl + 'user/deleteComment',
            //-----
            namespace = 'changeAvatarsActions',
            //-----
            shop = $.shop();
        //----- Comment operations
        var
            acmt_remove_btn = $('.btn-comment-remove');

        acmt_remove_btn.on('click.' + namespace, function () {
            var $this, cmt_id;

            $this = $(this);
            cmt_id = $this.data('comment-id');
            if(cmt_id) {
                shop.question(null, function () {
                    shop.ajaxRequest({
                        url: remove_comment_url,
                        method: 'POST',
                        data: {
                            postedId: cmt_id
                        }
                    }, function (response) {
                        var res = JSON.parse(response);
                        //-----
                        if (res.success) {
                            $this.closest('.comment-cards').fadeOut(300, function () {
                                $(this).remove();
                            });
                        }
                        //-----
                        shop.processAjaxData(res);
                    });
                });
            }
        });

        //----- Address operations
        var
            addr_remove_btn = $('.btn-address-remove');

        addr_remove_btn.on('click.' + namespace, function () {
            var $this, addr_id;

            $this = $(this);
            addr_id = $this.data('address-id');
            if(addr_id) {
                shop.question(null, function () {
                    shop.ajaxRequest({
                        url: remove_address_url,
                        method: 'POST',
                        data: {
                            postedId: addr_id
                        }
                    }, function (response) {
                        var res = JSON.parse(response);
                        //-----
                        if (res.success) {
                            $this.closest('.address-cards').fadeOut(300, function () {
                                $(this).remove();
                            });
                        }
                        //-----
                        shop.processAjaxData(res);
                    });
                });
            }
        });
        //----- Favorite operations
        var
            fav_remove_btn = $('.btn-action-remove'),
            favorite_wrapper = $('#favorite_items__wrapper'),
            //-----
            empty_favorite = '<div class="col-12">\
                                <div class="content-section default text-center">\
                                    <h5 class="m-0">\
                                        لیست علاقه‌مندی‌ها خالی می‌باشد.\
                                    </h5>\
                                </div>\
                              </div>';

        fav_remove_btn.on('click.' + namespace, function () {
            var $this, fav_id;

            $this = $(this);
            fav_id = $this.data('favorite-id');
            if (fav_id) {
                shop.question(null, function () {
                    shop.ajaxRequest({
                        url: remove_favorite_url,
                        method: 'POST',
                        data: {
                            postedId: fav_id
                        }
                    }, function (response) {
                        var res = JSON.parse(response);
                        //-----
                        if (res.success) {
                            $this.closest('.favorites-card').fadeOut(300, function () {
                                $(this).remove();
                            });
                        }
                        //-----
                        shop.processAjaxData(res, function (content) {
                            if (content == 0) {
                                favorite_wrapper.html(empty_favorite);
                            }
                        });
                    });
                });
            }
        });
        //----- Avatar operations
        var filesBody = $('#avatars-wrapper'),
            files = filesBody.find('.user-avatar'),
            avatarsPath = baseUrl + 'public/fe/img/avatars/',
            selectClass = 'selected',
            nameAttr = 'data-emote-name';
        var imagePlaceholder = $('.emote-image');

        files.on('click.' + namespace, function () {
            var $this, name;
            //-----
            $this = $(this);
            name = $this.attr(nameAttr);

            // Change selected class
            files.removeClass(selectClass);
            $this.addClass(selectClass);

            if (name && imagePlaceholder.length) {
                shop.ajaxRequest({
                    url: change_avatar_url,
                    method: 'POST',
                    data: {
                        postedName: name
                    }
                }, function (response) {
                    var res = JSON.parse(response);
                    // console.log(response);
                    shop.processAjaxData(res);

                    if (res.success) {
                        // Show selected avatar in placeholder(s)
                        imagePlaceholder.attr('src', avatarsPath + name);
                    }
                });
            }
        });
    });
})(jQuery);