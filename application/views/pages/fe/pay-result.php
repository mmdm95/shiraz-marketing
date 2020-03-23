<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

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
                    <div class="step-item failed" title="خطا">
                        <i class="la la-times" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator failed"></div>
                    <div class="step-item" title="اتمام خرید">
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-danger shadow">
            <div class="text-center">
                <div class="box-header-simple text-danger">
                    <h1>
                        تراکنش ناموفق
                    </h1>
                </div>
                <div class="text-center mb-5">
                    <div class="mb-2">
                        کد رهگیری :
                        <span class="iransans-bold">
                            ۴۵۹۲۳۵۸۱۸۲۷۴
                        </span>
                    </div>
                    <div class="mb-2">
                        ارتباط با سرور بانک امکان پذیر نمی‌باشد، لطفا مجددا تلاش نمایید
                    </div>
                </div>
                <p class="text-center">
                    در صورت کسر شدن مبلغ از حساب شما و عدم بازگشت تا ۷۲ ساعت، به بانک خود مراجعه کنید.
                </p>
            </div>

        </div>

        <div class="alert alert-success shadow">
            <div class="text-center">
                <div class="box-header-simple text-success">
                    <h1>
                        تراکنش موفق
                    </h1>
                </div>
                <div class="text-center mb-5">
                    <div class="mb-2">
                        کد رهگیری :
                        <span class="iransans-bold">
                            ۴۵۹۲۳۵۸۱۸۲۷۴
                        </span>
                    </div>
                    <div class="mb-2">
                        عملیات پرداخت با موفقیت انجام شد.
                    </div>
                </div>
                <a href="<?= base_url('index'); ?>" class="btn btn-success mb-3">
                    <i class="la la-arrow-right font-size-21px float-right ml-3" aria-hidden="true"></i>
                    بازگشت به صفحه اصلی
                </a>
            </div>

        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
