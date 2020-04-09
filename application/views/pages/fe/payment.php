<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu-minimal', $data); ?>

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
                <?php $this->view('templates/fe/alert/error', ['errors' => $errors ?? null]); ?>

                <div class="box-header-info">
                    نحوه پرداخت
                </div>
                <div class="box box-info">
                    <div class="box-body text-secondary">
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio1" name="payment-radio"
                                   checked="checked" required value="PAY_798447359">
                            <label class="custom-control-label" for="payRadio1">
                                <img src="<?= asset_url('fe/images/bank-mellat.png'); ?>" alt=""
                                     class="img-40px-40px">
                                درگاه بانک ملت
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio2" name="payment-radio"
                                   required value="PAY_342515312">
                            <label class="custom-control-label" for="payRadio2">
                                <img src="<?= asset_url('fe/images/bank-saderat.png'); ?>" alt=""
                                     class="img-40px-40px">
                                درگاه بانک صادرات
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio3" name="payment-radio"
                                   required value="<?= PAYMENT_METHOD_WALLET; ?>">
                            <label class="custom-control-label" for="payRadio3">
                                <img src="<?= asset_url('fe/images/wallet.png'); ?>" alt="" class="img-40px-40px">
                                پرداخت از کیف پول
                            </label>
                        </div>
                        <div class="custom-control custom-radio mb-4">
                            <input type="radio" class="custom-control-input" id="payRadio4" name="payment-radio"
                                   required value="<?= PAYMENT_METHOD_RECEIPT; ?>">
                            <label class="custom-control-label" for="payRadio4">
                                <img src="<?= asset_url('fe/images/receipt.png'); ?>" alt="" class="img-40px-40px">
                                پرداخت از طریق فیش بانکی
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="payRadio5" name="payment-radio"
                                   required value="<?= PAYMENT_METHOD_IN_PLACE; ?>">
                            <label class="custom-control-label" for="payRadio5">
                                <img src="<?= asset_url('fe/images/marker.png'); ?>" alt="" class="img-40px-40px">
                                پرداخت درب منزل
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 order-1 order-lg-2 mx-auto">
                <?= $sideCard; ?>
            </div>
        </div>
    </div>
</main>

<!-- Removed/Updated products modal -->
<?php $this->view('templates/fe/modal/modified-items', $data); ?>
<!-- Removed/Updated products modal -->

<?php $this->view('templates/fe/footer', $data); ?>
