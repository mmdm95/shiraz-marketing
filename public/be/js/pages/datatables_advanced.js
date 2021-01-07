/* ------------------------------------------------------------------------------
*
*  # Advanced datatables
*
*  Specific JS code additions for datatable_advanced.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function () {

    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            width: '100px'
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>فیلتر:</span> _INPUT_',
            lengthMenu: '<span>نمایش:</span> _MENU_',
            paginate: {'ضفحه اول': 'صفحه اول', 'صفحه آخر': 'صفحه آخر', 'next': '&larr;', 'previous': '&rarr;'},
            emptyTable: 'موردی یافت نشد.',
            zeroRecords: 'مورد جستجو شده وجود ندارد.',
            info: 'نمایش' + '<span class="text-primary ml-5 mr-5">_START_</span>' + 'تا' +
                '<span class="text-primary ml-5 mr-5">_END_</span>' + 'از' + 'مجموع' + '<span class="text-primary ml-5 mr-5">_TOTAL_</span>' + 'رکورد',
            infoEmpty: 'نمایش' + '<span class="text-primary ml-5 mr-5">0</span>' + 'تا' +
                '<span class="text-primary ml-5 mr-5">0</span>' + 'از' + 'مجموع' + '<span class="text-primary ml-5 mr-5">0</span>' + 'رکورد'
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        },

    });


    // Datatable 'length' options
    $('.datatable-show-all').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "همه"]]
    });


    // DOM positioning
    $('.datatable-dom-position').DataTable({
        dom: '<"datatable-header length-left"lp><"datatable-scroll"t><"datatable-footer info-right"fi>'
    });


    // Highlighting rows and columns on mouseover
    var lastIdx = null;
    var table = $('.datatable-highlight').DataTable();

    $('.datatable-highlight tbody, .datatable-product tbody').on('mouseover', 'td', function () {
        try {
            var colIdx = table.cell(this).index().column;

            if (colIdx !== lastIdx) {
                $(table.cells().nodes()).removeClass('active');
                $(table.column(colIdx).nodes()).addClass('active');
            }
        } catch (ex) {
        }
    }).on('mouseleave', function () {
        $(table.cells().nodes()).removeClass('active');
    });
    table.on('page.dt', function () {
        setTimeout(function () {
            // Lazy loader (pictures, videos, etc.)
            if ($.fn.lazy) {
                $('.lazy').lazy({
                    effect: "fadeIn",
                    effectTime: 800,
                    threshold: 50,
                    // callback
                    afterLoad: function (element) {
                        $(element).css({'background': 'none'});
                    }
                });
            }
            $('[data-popup=lightbox]').off('click').on('click', function (e) {
                e.preventDefault();
            }).each(function () {
                if ($.fn.fancybox) {
                    $(this).fancybox({
                        href: $(this).attr('data-url')
                    });
                }
            });
        }, 200);
    }).on('draw.dt', function () {
        setTimeout(function () {
            // Lazy loader (pictures, videos, etc.)
            if ($.fn.lazy) {
                $('.lazy').lazy({
                    effect: "fadeIn",
                    effectTime: 800,
                    threshold: 50,
                    // callback
                    afterLoad: function (element) {
                        $(element).css({'background': 'none'});
                    }
                });
            }
            $('[data-popup=lightbox]').off('click').on('click', function (e) {
                e.preventDefault();
            }).each(function () {
                if ($.fn.fancybox) {
                    $(this).fancybox({
                        href: $(this).attr('data-url')
                    });
                }
            });
        }, 200);
    });

    //====================================================
    //====================================================
    var checkboxes = [];

    function checkChk(chk) {
        chk.find('input').attr('checked', 'checked').prop('checked', 'checked');
        chk.find('span').addClass('checked');
    }

    function uncheckChk(chk) {
        chk.find('input').removeAttr('checked').prop('checked', false);
        chk.find('span').removeClass('checked');
    }

    //-----
    function checkedAllChks(chks) {
        chks.closest('tr').addClass('info');
        addItemToChkArr(chks);
    }

    function uncheckedAllChks(chks) {
        chks.closest('tr').removeClass('info');
        removeItemFromChkArr(chks);
    }

    //-----
    function addItemToChkArr(chk) {
        var id;
        chk.each(function () {
            id = $(this).attr('data-product-id');
            if (id && $.inArray(id, checkboxes) === -1) {
                checkboxes.push(id);
                showMultiMenu();
            }
        });
    }

    function removeItemFromChkArr(chk) {
        var id;
        chk.each(function () {
            id = $(this).attr('data-product-id');
            if (id && $.inArray(id, checkboxes) !== -1) {
                checkboxes.splice(checkboxes.indexOf(id), 1);
            }
            if (!checkboxes.length) {
                hideMultiMenu();
            }
        });
    }

    //-----
    var multiMenu = $('#multiOperationMenu');

    //-----
    function showMultiMenu() {
        if (multiMenu.is(':hidden')) {
            multiMenu.hide();
        }
        multiMenu.removeClass('hide').stop().fadeIn(300);
    }

    function hideMultiMenu() {
        multiMenu.stop().fadeOut(300, function () {
            $(this).hide().addClass('hide');
        });
    }

    //-----
    var mainChk = $('#chks');
    var allChks = $('.product-chk');

    //-----
    function initFn() {
        mainChk.off('click.productChk').on('click.productChk', function () {
            if ($(this).find('input').attr('checked') !== 'checked') {
                checkChk($(this));
                checkChk(allChks);
                checkedAllChks(allChks);
            } else {
                uncheckChk($(this));
                uncheckChk(allChks);
                uncheckedAllChks(allChks);
            }
        });
        allChks.off('click.productChk').on('click.productChk', function () {
            uncheckChk(mainChk);
            mainChk.find('span').removeClass('checked');
            //-----
            if ($(this).find('input').attr('checked') !== 'checked') {
                checkChk($(this));
                checkedAllChks($(this));
            } else {
                uncheckChk($(this));
                uncheckedAllChks($(this));
            }
        });
    }

    initFn();
    //-----
    if ($('.datatable-product').length) {
        var table2 = $('.datatable-product').DataTable({
            columnDefs: [{
                orderable: false,
                targets: 0,
            }, {
                width: '100px'
            }],
        });
        table2.on('page.dt', function () {
            setTimeout(function () {
                // Lazy loader (pictures, videos, etc.)
                if ($.fn.lazy) {
                    $('.lazy').lazy({
                        effect: "fadeIn",
                        effectTime: 800,
                        threshold: 50,
                        // callback
                        afterLoad: function (element) {
                            $(element).css({'background': 'none'});
                        }
                    });
                }
                $('[data-popup=lightbox]').off('click').on('click', function (e) {
                    e.preventDefault();
                }).each(function () {
                    if ($.fn.fancybox) {
                        $(this).fancybox({
                            href: $(this).attr('data-url')
                        });
                    }
                });
            }, 200);
            initFn();
        }).on('draw.dt', function () {
            setTimeout(function () {
                // Lazy loader (pictures, videos, etc.)
                if ($.fn.lazy) {
                    $('.lazy').lazy({
                        effect: "fadeIn",
                        effectTime: 800,
                        threshold: 50,
                        // callback
                        afterLoad: function (element) {
                            $(element).css({'background': 'none'});
                        }
                    });
                }
                $('[data-popup=lightbox]').off('click').on('click', function (e) {
                    e.preventDefault();
                }).each(function () {
                    if ($.fn.fancybox) {
                        $(this).fancybox({
                            href: $(this).attr('data-url')
                        });
                    }
                });
            }, 200);
            initFn();
        });

        $(function () {
            var form = $('#multiEditForm');
            form.on('submit', function () {
                var isOK = false;
                if (checkboxes.length) {
                    form.attr('action', baseUrl + 'admin/shop/multiEditProduct/' + checkboxes.join('/'));
                    isOK = true;
                }
                return isOK;
            });
        });
    }

    // Columns rendering
    $('.datatable-columns').dataTable({
        columnDefs: [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                render: function (data, type, row) {
                    return data + ' (' + row[3] + ')';
                },
                targets: 0
            },
            {visible: false, targets: [3]}
        ]
    });


    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder', 'جستجو...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });

});
