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
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: "در حال بارگذاری...",
            lengthMenu: "_MENU_",
            search: '<span>فیلتر:</span> _INPUT_',
            paginate: {'first': 'صفحه اول', 'last': 'صفحه آخر', 'next': '&larr;', 'previous': '&rarr;'},
            emptyTable: 'موردی یافت نشد.',
            zeroRecords: 'مورد جستجو شده وجود ندارد.',
            info: 'نمایش' + '<span class="text-primary ml-5 mr-5">_START_</span>' + 'تا' +
                '<span class="text-primary ml-5 mr-5">_END_</span>' + 'از' + 'مجموع' + '<span class="text-primary ml-5 mr-5">_TOTAL_</span>' + 'رکورد',
            infoEmpty: 'نمایش' + '<span class="text-primary ml-5 mr-5">0</span>' + 'تا' +
                '<span class="text-primary ml-5 mr-5">0</span>' + 'از' + 'مجموع' + '<span class="text-primary ml-5 mr-5">0</span>' + 'رکورد',
            infoFiltered: '(' + 'فیلتر شده از مجموع' + ' _MAX_ ' + 'رکورد' + ')',
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

    /**
     * Instantiate switchery plugin with prevent multiple instantiation
     */
    function instantiateSwitchery() {
        if (typeof Switchery !== 'undefined') {
            var elems;

            if (Array.prototype.forEach) {
                // Initialize multiple switches
                elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
                elems.forEach(function (html) {
                    if (!$(html).attr('data-switchery')) {
                        var switchery = new Switchery(html);
                    }
                });
            } else {
                elems = document.querySelectorAll('.switchery');
                for (var i = 0; i < elems.length; i++) {
                    if (!$(elems[i]).attr('data-switchery')) {
                        var switchery = new Switchery(elems[i]);
                    }
                }
            }
        }
    }

    /**
     * Actions to take after a datatable initialize(reinitialize)
     */
    function datatableInitCompleteActions(table) {
        // reInstantiate switchery plugin
        instantiateSwitchery();

        // reinitiate checkboxes and radios
        $(".styled").uniform({radioClass: ''});

        // reinitialize dropdown
        $('[data-toggle="dropdown"]').dropdown();

        // reinitialize lazy plugin for images
        $('.lazy').lazy({
            effect: "fadeIn",
            effectTime: 800,
            threshold: 0,
            // callback
            afterLoad: function (element) {
                $(element).css({'background': 'none'});
            }
        });

        // reinitialize lightbox plugin for images
        $('[data-popup=lightbox]').off('click').on('click', function (e) {
            e.preventDefault();
        }).each(function () {
            if ($.fn.fancybox) {
                $(this).fancybox({
                    href: $(this).attr('data-url')
                });
            }
        });

        //********** ManageProduct Action
        $('.deleteProductBtn').off('click').on('click', function (e) {
            e.preventDefault();
            var del_btn = $(this);

            $.delete_something_action(this, 'shop/deleteProduct', function () {
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

        //********** Toggle product availability
        $('.productAvailability').off('change').on('change', function (e) {
            e.preventDefault();
            var btn = $(this);
            var stat = btn.is(':checked') ? 1 : 0;

            $.active_deactive_action(this, 'shop/availableProduct', {stat: stat});
        });
        //**********
    }

    /**
     * Pipelining function for DataTables. To be used to the `ajax` option of DataTables
     *
     * @see https://datatables.net/examples/server_side/pipeline.html
     * @param [opts]
     * @returns {Function}
     */
    $.fn.dataTable.pipeline = function (opts) {
        // Configuration options
        var conf = $.extend({
            pages: 5,     // number of pages to cache
            url: '',      // script url
            data: null,   // function or object with parameters to send to the server
                          // matching how `ajax.data` works in DataTables
            method: 'GET' // Ajax HTTP method
        }, opts);

        // Private variables for storing the cache
        var
            cacheLower = -1,
            cacheUpper = null,
            cacheLastRequest = null,
            cacheLastJson = null;

        return function (request, drawCallback, settings) {
            var
                ajax = false,
                requestStart = request.start,
                drawStart = request.start,
                requestLength = request.length,
                requestEnd = requestStart + requestLength;

            if (settings.clearCache) {
                // API requested that the cache be cleared
                ajax = true;
                settings.clearCache = false;
            } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                // outside cached data - need to make a request
                ajax = true;
            } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
            ) {
                // properties changed (ordering, columns, searching)
                ajax = true;
            }

            // Store the request for checking next time around
            cacheLastRequest = $.extend(true, {}, request);

            if (ajax) {
                // Need data from the server
                if (requestStart < cacheLower) {
                    requestStart = requestStart - (requestLength * (conf.pages - 1));

                    if (requestStart < 0) {
                        requestStart = 0;
                    }
                }

                cacheLower = requestStart;
                cacheUpper = requestStart + (requestLength * conf.pages);

                request.start = requestStart;
                request.length = requestLength * conf.pages;

                // Provide the same `data` options as DataTables.
                if (typeof conf.data === 'function') {
                    // As a function it is executed with the data object as an arg
                    // for manipulation. If an object is returned, it is used as the
                    // data object to submit
                    var d = conf.data(request);
                    if (d) {
                        $.extend(request, d);
                    }
                } else if ($.isPlainObject(conf.data)) {
                    // As an object, the data given extends the default
                    $.extend(request, conf.data);
                }

                return $.ajax({
                    "type": conf.method,
                    "url": conf.url,
                    "data": request,
                    "dataType": "json",
                    "cache": false,
                    "success": function (json) {
                        cacheLastJson = $.extend(true, {}, json);

                        if (json.data) {
                            if (cacheLower != drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }
                        } else {
                            json.data = [];
                            json.recordsFiltered = 0;
                            json.recordsTotal = 0;
                        }

                        drawCallback(json);
                    },
                    // for debugging
                    // "error": function (err) {
                    //     console.log(err);
                    // },
                });
            } else {
                var json = $.extend(true, {}, cacheLastJson);
                json.draw = request.draw; // Update the echo for each response
                if (json.data) {
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);
                } else {
                    json.data = [];
                    json.recordsFiltered = 0;
                    json.recordsTotal = 0;
                }

                drawCallback(json);
            }
        }
    };

    // Register an API method that will empty the pipelined data, forcing an Ajax
    // fetch on the next draw (i.e. `table.clearPipeline().draw()`)
    $.fn.dataTable.Api.register('clearPipeline()', function () {
        return this.iterator('table', function (settings) {
            settings.clearCache = true;
        });
    });

    $.each($('.datatable-highlight'), function () {
        var $this, table, url;
        $this = $(this);

        url = $this.attr('data-ajax-url');
        if (url) {
            table = $this.DataTable({
                stateSave: true,
                processing: true,
                serverSide: true,
                ajax: $.fn.dataTable.pipeline({
                    url: url,
                    method: 'POST',
                    pages: 5, // number of pages to cache
                }),
                deferRender: true,
                initComplete: function () {
                    // do something after init complete
                    datatableInitCompleteActions($this);
                },
            });
        } else {
            table = $this.DataTable({
                stateSave: true,
                initComplete: function () {
                    // do something after init complete
                    datatableInitCompleteActions($this);
                },
            });
        }

        // Highlighting rows and columns on mouseover
        var lastIdx = null;
        $('.datatable-highlight tbody').off('mouseover').on('mouseover', 'td', function () {
            if (table.cell(this).index()) {
                var colIdx = table.cell(this).index().column;

                if (colIdx !== lastIdx) {
                    $(table.cells().nodes()).removeClass('active');
                    $(table.column(colIdx).nodes()).addClass('active');
                }
            }
        }).off('mouseleave').on('mouseleave', function () {
            $(table.cells().nodes()).removeClass('active');
        });

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
                datatableInitCompleteActions($this);
            }, 200);
        }).on('draw.dt', function () {
            setTimeout(function () {
                datatableInitCompleteActions($this);
            }, 200);
        });
    });

    //====================================================
    //====================================================
    var checkboxes = [],
        mainChk = $('#chks'),
        allChks,
        multiMenu = $('#multiOperationMenu');

    function allCheckboxesClickEvent(selector) {
        uncheckChk(mainChk);
        mainChk.find('span').removeClass('checked');
        //-----
        if ($(selector).find('input').attr('checked') !== 'checked') {
            checkChk($(selector));
            checkedAllChks($(selector));
        } else {
            uncheckChk($(selector));
            uncheckedAllChks($(selector));
        }
    }

    //-----

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

    function checkCheckboxesFromCheckboxesArray(chks) {
        var id;
        $(chks).each(function () {
            id = $(this).attr('data-product-id');
            if (id && $.inArray(id, checkboxes) !== -1) {
                checkChk($(this));
                checkedAllChks($(this));
            }
        });
    }

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
    function initFn() {
        allChks = $('.product-chk');

        checkCheckboxesFromCheckboxesArray(allChks);

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
            allCheckboxesClickEvent($(this));
        });
    }

    initFn();
    //-----
    if ($('.datatable-product').length) {
        $('.datatable-product').each(function () {
            var $this, table2, url;
            $this = $(this);
            url = $this.attr('data-ajax-url');

            if (url) {
                table2 = $this.DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 0,
                    }, {
                        width: '100px'
                    }],
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    ajax: $.fn.dataTable.pipeline({
                        url: url,
                        method: 'POST',
                        pages: 5, // number of pages to cache
                    }),
                    deferRender: true,
                    initComplete: function () {
                        // do something after init complete
                        datatableInitCompleteActions($this);
                    },
                });
            } else {
                table2 = $this.DataTable({
                    columnDefs: [{
                        orderable: false,
                        targets: 0,
                    }, {
                        width: '100px'
                    }],
                    stateSave: true,
                    initComplete: function () {
                        // do something after init complete
                        datatableInitCompleteActions($this);
                    },
                });
            }

            // Highlighting rows and columns on mouseover
            var lastIdx = null;
            $('.datatable-highlight tbody').off('mouseover').on('mouseover', 'td', function () {
                if (table2.cell(this).index()) {
                    var colIdx = table2.cell(this).index().column;

                    if (colIdx !== lastIdx) {
                        $(table2.cells().nodes()).removeClass('active');
                        $(table2.column(colIdx).nodes()).addClass('active');
                    }
                }
            }).off('mouseleave').on('mouseleave', function () {
                $(table2.cells().nodes()).removeClass('active');
            });

            $('.datatable-highlight tbody, .datatable-product tbody').on('mouseover', 'td', function () {
                try {
                    var colIdx = table2.cell(this).index().column;

                    if (colIdx !== lastIdx) {
                        $(table2.cells().nodes()).removeClass('active');
                        $(table2.column(colIdx).nodes()).addClass('active');
                    }
                } catch (ex) {
                }
            }).on('mouseleave', function () {
                $(table2.cells().nodes()).removeClass('active');
            });

            table2.on('page.dt', function () {
                setTimeout(function () {
                    datatableInitCompleteActions($this);
                }, 200);

                initFn();
                uncheckChk(mainChk);
                checkCheckboxesFromCheckboxesArray(allChks);
            }).on('draw.dt', function () {
                setTimeout(function () {
                    datatableInitCompleteActions($this);
                }, 200);

                initFn();
                uncheckChk(mainChk);
                checkCheckboxesFromCheckboxesArray(allChks);
            });
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
