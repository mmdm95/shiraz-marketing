<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-cart">
    <div class="container">
        <div class="text-center">
            <div class="box-header-simple">
                <h1>
                    فراموشی کلمه عبور
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="step-container">
                    <div class="step-item active" title="طریقه ارسال">
                        <i class="la la-mobile" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator active"></div>
                    <div class="step-item" title="کد ارسال شده"></div>
                    <div class="step-separator"></div>
                    <div class="step-item" title="اتمام"></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="step-container">
                    <div class="step-item done" title="طریقه ارسال">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator done"></div>
                    <div class="step-item active" title="کد ارسال شده">
                        <i class="la la-barcode" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator active"></div>
                    <div class="step-item" title="اتمام"></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="step-container">
                    <div class="step-item done" title="طریقه ارسال">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator done"></div>
                    <div class="step-item done" title="کد ارسال شده">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator done"></div>
                    <div class="step-item done" title="اتمام">
                        <i class="la la-check" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="box-header-info">
                    شماره موبایل خود را وارد کنید
                </div>
                <div class="box">
                    <div class="box-body">
                        <form action="<?= base_url('forgetPassword'); ?>" method="post">
                            <div class="form-group">
                                <label for="fp-mobile">
                                    موبایل
                                    <span class="text-danger">
                                       (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="fp-mobile" class="form-control" name="mobile"
                                           placeholder="برای مثال: ۰۹۱۷xxxxxxx">
                                    <span class="input-icon right">
                                        <i class="la la-mobile"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary btn-wd">
                                    ارسال
                                    <i class="la la-angle-left mr-3 float-left font-size-21px" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="box-header-info">
                    وارد کردن کد ارسال شده
                </div>
                <div class="box">
                    <div class="box-body">
                        <form action="<?= base_url('forgetPassword'); ?>" method="post">
                            <div class="form-group">
                                <label for="fp-code">
                                    کد ارسال شده
                                    <span class="text-danger">
                                       (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="fp-code" class="form-control" name="code"
                                           placeholder="">
                                    <span class="input-icon right">
                                        <i class="la la-barcode"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="text-left">
                                <a href="<?= base_url('forgetPassword'); ?>" class="btn btn-light ml-2">
                                    <i class="la la-undo la-rotate-180 ml-3 float-right font-size-21px"
                                       aria-hidden="true"></i>
                                    مرحله قبل
                                </a>
                                <button type="submit" class="btn btn-primary btn-wd">
                                    ارسال
                                    <i class="la la-angle-left mr-3 float-left font-size-21px" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="alert alert-success shadow">
                    <div class="text-center">
                        <div class="box-header-simple text-success">
                            <h1>
                                اکانت کاربری شما با موفقیت فعال شد
                            </h1>
                        </div>
                        <a href="<?= base_url('login'); ?>" class="btn btn-success mt-4 mb-3">
                            <i class="la la-arrow-right font-size-21px float-right ml-3" aria-hidden="true"></i>
                            بازگشت به صفحه ورود
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
