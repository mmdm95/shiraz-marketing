<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-payment">
    <div class="container">
        <div class="text-center">
            <div class="box-header-simple">
                <h1>
                    پرداخت
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
                    <div class="step-item active" title="پرداخت">
                        <i class="la la-credit-card" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator active"></div>
                    <div class="step-item" title="اتمام خرید"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="box-header-info">
                    نحوه پرداخت
                </div>
                <div class="box box-info">
                    <div class="box-body text-secondary">
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio1" name="payment-radio" checked="checked" required>
                            <label class="custom-control-label" for="payRadio1">
                                <img src="<?= asset_url('fe/images/tmp/bank-mellat.png'); ?>" alt="" class="img-40px-40px">
                                درگاه بانک ملت
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio2" name="payment-radio" required>
                            <label class="custom-control-label" for="payRadio2">
                                <img src="<?= asset_url('fe/images/tmp/bank-saderat.png'); ?>" alt="" class="img-40px-40px">
                                درگاه بانک صادرات
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio3" name="payment-radio" required>
                            <label class="custom-control-label" for="payRadio3">
                                <img src="<?= asset_url('fe/images/tmp/wallet.png'); ?>" alt="" class="img-40px-40px">
                                پرداخت از کیف پول
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio4" name="payment-radio" required>
                            <label class="custom-control-label" for="payRadio4">
                                <img src="<?= asset_url('fe/images/tmp/receipt.png'); ?>" alt="" class="img-40px-40px">
                                پرداخت از طریق فیش بانکی
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="payRadio5" name="payment-radio" required>
                            <label class="custom-control-label" for="payRadio5">
                                <img src="<?= asset_url('fe/images/tmp/marker.png'); ?>" alt="" class="img-40px-40px">
                                پرداخت درب منزل
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 order-1 order-lg-2 mx-auto">
                <div class="box">
                    <div class="box-body">
                        <div class="shopping-cart-container">
                            <div class="shopping-cart-info">
                                <div class="shopping-cart-info-item">
                                    <div>
                                        مبلغ کل (۱ کالا) :
                                    </div>
                                    <div class="text-dark">
                                        ۸۵۰،۰۰۰
                                        تومان
                                    </div>
                                </div>
                                <div class="shopping-cart-info-item">
                                    <div class="text-primary">
                                        مبلغ تخفیف :
                                    </div>
                                    <div class="text-primary">
                                        ۲۰۰،۰۰۰
                                        تومان
                                    </div>
                                </div>
                                <div class="shopping-cart-info-item">
                                    <div>
                                        هزینه ارسال :
                                    </div>
                                    <div class="text-dark">
                                        ۶،۰۰۰
                                        تومان
                                    </div>
                                </div>
                            </div>
                            <div class="shopping-cart-continue">
                                <div class="text-secondary mb-2">
                                    مبلغ کل‌ :
                                </div>
                                <div class="text-danger font-size-21px mb-4">
                                    ۶۵۶،۰۰۰
                                    تومان
                                </div>
                                <a href="#" class="btn btn-success btn-block">
                                    ادامه ثبت سفارش
                                    <i class="la la-angle-left font-size-21px mr-3 float-left" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
