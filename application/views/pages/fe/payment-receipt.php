<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu-minimal', $data); ?>

<script>
    (function ($) {
        'use strict';

        $(function () {
            if ($.fn.persianDatepicker) {
                var altDP = $('.myAltDatepicker');
                $(altDP).each(function () {
                    var $this = $(this);
                    $this.persianDatepicker({
                        "inline": false,
                        "format": !!$this.attr('data-format') ? $this.attr('data-format') : 'L',
                        "viewMode": "day",
                        "initialValue": true,
                        "minDate": 0,
                        "maxDate": 0,
                        "autoClose": false,
                        "position": "auto",
                        "onlyTimePicker": false,
                        "onlySelectOnDate": false,
                        "calendarType": "persian",
                        "altFormat": 'X',
                        "altField": $this.attr('data-alt-field'),
                        "inputDelay": 800,
                        "observer": true,
                        "calendar": {
                            "persian": {
                                "locale": "fa",
                                "showHint": true,
                                "leapYearMode": "algorithmic"
                            },
                            "gregorian": {
                                "locale": "en",
                                "showHint": true
                            }
                        },
                        "navigator": {
                            "enabled": true,
                            "scroll": {
                                "enabled": true
                            },
                            "text": {
                                "btnNextText": "<",
                                "btnPrevText": ">"
                            }
                        },
                        "toolbox": {
                            "enabled": true,
                            "calendarSwitch": {
                                "enabled": false,
                                "format": "MMMM"
                            },
                            "todayButton": {
                                "enabled": true,
                                "text": {
                                    "fa": "امروز",
                                    "en": "Today"
                                }
                            },
                            "submitButton": {
                                "enabled": true,
                                "text": {
                                    "fa": "تایید",
                                    "en": "Submit"
                                }
                            },
                            "text": {
                                "btnToday": "امروز"
                            }
                        },
                        "timePicker": {
                            "enabled": !!$this.attr('data-time'),
                            "step": 1,
                            "hour": {
                                "enabled": true,
                                "step": null
                            },
                            "minute": {
                                "enabled": true,
                                "step": null
                            },
                            "second": {
                                "enabled": false,
                                "step": null
                            },
                            "meridian": {
                                "enabled": false
                            }
                        },
                        "dayPicker": {
                            "enabled": true,
                            "titleFormat": "YYYY MMMM"
                        },
                        "monthPicker": {
                            "enabled": true,
                            "titleFormat": "YYYY"
                        },
                        "yearPicker": {
                            "enabled": true,
                            "titleFormat": "YYYY"
                        },
                        "responsive": true
                    });
                });
            }
        });
    })(jQuery);
</script>

<main class="main-container page-payment">
    <div class="container">
        <div class="text-center">
            <div class="box-header-simple">
                <h1>
                    ثبت اطلاعات رسید
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="step-container">
                    <div class="step-item done" title="سبد خرید">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator done"></div>
                    <div class="step-item done" title="اطلاعات ارسال">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator done"></div>
                    <div class="step-item wait" title="پرداخت">
                        <i class="la la-credit-card" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator wait"></div>
                    <div class="step-item active" title="اطلاعات رسید">
                        <i class="la la-sticky-note" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator active"></div>
                    <div class="step-item" title="اتمام خرید"></div>
                </div>
            </div>
        </div>

        <form action="<?= base_url('paymentReceipt'); ?>" method="post">
            <?= $form_token; ?>

            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">
                    <?php $this->view('templates/fe/alert/error', ['errors' => $errors ?? null]); ?>

                    <div class="box-header-info">
                        اطلاعات رسید واریز
                    </div>
                    <div class="box box-info">
                        <div class="box-body text-secondary">
                            <div class="form-group">
                                <label for="pr-rc" class="d-inline-block">
                                    شماره رسید واریز
                                    <span class="text-danger">
                                    (اجباری)
                                </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="pr-rc" class="form-control"
                                           name="receipt_code" placeholder=""
                                           value="<?= $values['receipt_code'] ?? ''; ?>">
                                    <span class="input-icon right">
                                    <i class="la la-barcode"></i>
                                </span>
                                    <span class="input-icon left clear-icon">
                                    <i class="la la-times"></i>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pr-rd" class="d-inline-block">
                                    تاریخ رسید واریز
                                    <span class="text-danger">
                                    (اجباری)
                                </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="hidden" name="receipt_date" id="altDateField">
                                    <input type="text" id="pr-rd" class="form-control myAltDatepicker"
                                           data-time="true" data-format="L H:m:s"
                                           placeholder="تاریخ رسید" readonly data-alt-field="#altDateField"
                                           value="<?= date('Y/m/d H:i', (int)$values['receipt_date'] ?? time()); ?>">
                                    <span class="input-icon right">
                                    <i class="la la-calendar-check"></i>
                                </span>
                                    <span class="input-icon left clear-icon">
                                    <i class="la la-times"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 order-1 order-lg-2 mx-auto">
                    <?= $sideCard; ?>
                </div>
            </div>
        </form>
    </div>
</main>

<!-- Removed/Updated products modal -->
<?php $this->view('templates/fe/modal/modified-items', $data); ?>
<!-- Removed/Updated products modal -->

<?php $this->view('templates/fe/footer', $data); ?>
