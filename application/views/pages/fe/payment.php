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

        <form action="<?= base_url('prepareToPay'); ?>" method="post" id="paymentForm">
            <?= $form_token; ?>

            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">
                    <?php $this->view('templates/fe/alert/error', ['errors' => $errors ?? null]); ?>

                    <div class="box-header-info">
                        نحوه پرداخت
                    </div>
                    <div class="box box-info">
                        <div class="box-body text-secondary">
                            <?php if (isset($setting['payment']['bank_1']) && $setting['payment']['bank_1']['enable']): ?>
                                <div class="custom-control custom-radio mb-4">
                                    <input type="radio" class="custom-control-input" id="payRadio1" name="payment_radio"
                                           checked="checked" required value="PAY_798447359">
                                    <label class="custom-control-label" for="payRadio1">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($setting['payment']['bank_1']['image']),
                                            'alt' => '',
                                            'class' => 'img-40px-40px',
                                        ], true); ?>
                                        <?= $setting['payment']['bank_1']['text']; ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($setting['payment']['bank_2']) && $setting['payment']['bank_2']['enable']): ?>
                                <div class="custom-control custom-radio mb-4">
                                    <input type="radio" class="custom-control-input" id="payRadio2" name="payment_radio"
                                           required value="PAY_342515312">
                                    <label class="custom-control-label" for="payRadio2">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($setting['payment']['bank_2']['image']),
                                            'alt' => '',
                                            'class' => 'img-40px-40px',
                                        ], true); ?>
                                        <?= $setting['payment']['bank_2']['text']; ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($setting['payment']['bank_3']) && $setting['payment']['bank_3']['enable']): ?>
                                <div class="custom-control custom-radio mb-4">
                                    <input type="radio" class="custom-control-input" id="payRadio3" name="payment_radio"
                                           required value="PAY_654812379">
                                    <label class="custom-control-label" for="payRadio3">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($setting['payment']['bank_3']['image']),
                                            'alt' => '',
                                            'class' => 'img-40px-40px',
                                        ], true); ?>
                                        <?= $setting['payment']['bank_3']['text']; ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <?php if ($setting['payment']['wallet']['enable']): ?>
                                <div class="custom-control custom-radio mb-4">
                                    <input type="radio" class="custom-control-input" id="payRadio4" name="payment_radio"
                                           required value="<?= PAYMENT_METHOD_WALLET; ?>">
                                    <label class="custom-control-label" for="payRadio4">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($setting['payment']['wallet']['image']),
                                            'alt' => '',
                                            'class' => 'img-40px-40px',
                                        ], true); ?>
                                        <?= $setting['payment']['wallet']['text']; ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <?php if ($setting['payment']['receipt']['enable']): ?>
                                <div class="custom-control custom-radio mb-4">
                                    <input type="radio" class="custom-control-input" id="payRadio5" name="payment_radio"
                                           required value="<?= PAYMENT_METHOD_RECEIPT; ?>">
                                    <label class="custom-control-label" for="payRadio5">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($setting['payment']['receipt']['image']),
                                            'alt' => '',
                                            'class' => 'img-40px-40px',
                                        ], true); ?>
                                        <?= $setting['payment']['receipt']['text']; ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <?php if ($setting['payment']['in_place']['enable']): ?>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="payRadio6" name="payment_radio"
                                           required value="<?= PAYMENT_METHOD_IN_PLACE; ?>">
                                    <label class="custom-control-label" for="payRadio6">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($setting['payment']['in_place']['image']),
                                            'alt' => '',
                                            'class' => 'img-40px-40px',
                                        ], true); ?>
                                        <?= $setting['payment']['in_place']['text']; ?>
                                    </label>
                                </div>
                            <?php endif; ?>
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
