<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu-minimal', $data); ?>

<main class="main-container page-pay-result">
    <div class="container">
        <div class="text-center">
            <div class="box-header-simple">
                <h1>
                    نتیجه تراکنش
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
                    <div class="step-item done" title="پرداخت">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator done"></div>
                    <?php if (!isset($is_success) || $is_success === false): ?>
                        <div class="step-item failed" title="خطا">
                            <i class="la la-times" aria-hidden="true"></i>
                        </div>
                        <div class="step-separator failed"></div>
                        <div class="step-item" title="اتمام خرید"></div>
                    <?php else: ?>
                        <div class="step-item done" title="اتمام خرید">
                            <i class="la la-check" aria-hidden="true"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (isset($is_success) && $is_success === true): ?>
            <div class="box border border-success">
                <div class="box-body pt-0 text-center">
                    <div class="box-header-simple text-success">
                        <div>
                            <i class="la la-check-circle-o font-size-80px" aria-hidden="true"></i>
                        </div>
                        <h1>
                            تراکنش موفق
                        </h1>
                    </div>
                    <div class="text-center mb-5">
                        <div class="mb-3 font-weight-bolder">
                            سفارش به کد
                            <span class="en-font text-info">
                            <?= $order_code ?? ''; ?>
                        </span>
                            ثبت شد.
                        </div>
                        <?php if (isset($have_ref_id) && $have_ref_id === true): ?>
                            <div class="mb-2">
                                کد رهگیری :
                                <span class="iransans-bold">
                                <?= $ref_id ?: '<i class="la la-minus text-danger" aria-hidden="true"></i>'; ?>
                            </span>
                            </div>
                        <?php endif; ?>
                        <div class="mb-2">
                            عملیات پرداخت با موفقیت انجام شد.
                        </div>
                    </div>
                    <div class="ltr">
                        <?php if ($auth->isLoggedIn()): ?>
                            <a href="<?= base_url('user/manageOrders'); ?>" class="btn btn-info mb-3">
                                <i class="la la-archive font-size-21px float-right ml-3" aria-hidden="true"></i>
                                پیگیری سفارش
                            </a>
                        <?php endif; ?>
                        <a href="<?= base_url('index'); ?>" class="btn btn-success mb-3">
                            <i class="la la-arrow-right font-size-21px float-right ml-3" aria-hidden="true"></i>
                            بازگشت به صفحه اصلی
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="box border border-danger">
                <div class="box-body pt-0 text-center">
                    <div class="box-header-simple text-danger">
                        <div>
                            <i class="la la-times-circle-o font-size-80px" aria-hidden="true"></i>
                        </div>
                        <h1>
                            تراکنش ناموفق
                        </h1>
                    </div>
                    <div class="text-center mb-5">
                        <div class="mb-3 font-weight-bolder">
                            سفارش به کد
                            <span class="en-font text-info">
                            <?= $order_code ?? ''; ?>
                        </span>
                            ثبت شد.
                        </div>
                        <?php if (isset($have_ref_id) && $have_ref_id === true): ?>
                            <div class="mb-2">
                                کد رهگیری :
                                <span class="iransans-bold">
                                <?= $ref_id; ?>
                            </span>
                            </div>
                        <?php endif; ?>
                        <div class="mb-2">
                            <?= $error ?? ''; ?>
                        </div>
                    </div>
                    <p class="text-center badge badge-danger py-3 px-4 m-0">
                        در صورت کسر شدن مبلغ از حساب شما و عدم بازگشت تا ۷۲ ساعت، به بانک خود مراجعه کنید.
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
