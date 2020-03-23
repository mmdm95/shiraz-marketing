<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-gap"></div>
                <div class="box">
                    <div class="box-header-simple text-center">
                        <div class="huge-icon">
                            <i class="la la-user-plus" aria-hidden="true"></i>
                        </div>
                        <h5>
                            ثبت نام در شیراز مارکتینگ
                            <small class="text-secondary d-block mt-3 font-size-14px">
                                حساب کاربری جدید
                            </small>
                        </h5>
                    </div>
                    <div class="box-body">
                        <form action="<?= base_url('login'); ?>" method="post">
                            <div class="form-group">
                                <label for="r-username">
                                    نام کاربری
                                    <span class="text-danger">
                                    (اجباری)
                                </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="r-username" class="form-control" name="username"
                                           placeholder="برای مثال: ۰۹۱۷xxxxxxx">
                                    <span class="input-icon right">
                                    <i class="la la-user"></i>
                                </span>
                                    <span class="input-icon left clear-icon">
                                    <i class="la la-times"></i>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="r-password" class="d-inline-block">
                                    کلمه عبور
                                    <span class="text-danger">
                                    (اجباری)
                                </span>
                                    :
                                </label>
                                <div class="clearfix"></div>
                                <div class="main-input__wrapper">
                                    <input type="text" id="r-password" class="form-control" name="password"
                                           placeholder="کلمه عبور">
                                    <span class="input-icon right">
                                    <i class="la la-lock"></i>
                                </span>
                                    <span class="input-icon left clear-icon">
                                    <i class="la la-times"></i>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="r-rePassword" class="d-inline-block">
                                    تکرار کلمه عبور
                                    <span class="text-danger">
                                    (اجباری)
                                </span>
                                    :
                                </label>
                                <div class="clearfix"></div>
                                <div class="main-input__wrapper">
                                    <input type="text" id="r-rePassword" class="form-control" name="re_password"
                                           placeholder="تکرار کلمه عبور">
                                    <span class="input-icon right">
                                    <i class="la la-lock"></i>
                                </span>
                                    <span class="input-icon left clear-icon">
                                    <i class="la la-times"></i>
                                </span>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="form-group form-account-captcha" data-captcha-url="<?= ACTION; ?>">
                                    <img src="" alt="captcha">
                                    <button type="button"
                                            class="btn btn-link text-danger font-size-21px mr-2 mb-0 form-captcha">
                                        <i class="la la-refresh"></i>
                                    </button>
                                </div>
                                <div>
                                    <div class="main-input__wrapper no-icon right">
                                        <input type="text" class="form-control ltr text-right"
                                               name="registerCaptcha"
                                               pattern="[(a-z)(A-Z)(0-9)]{6}" placeholder="کد تصویر بالا">
                                        <span class="input-icon left clear-icon">
                                            <i class="la la-times"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('activation'); ?>" class="btn-link">
                                    ارسال کد فعالسازی
                                </a>
                                <button type="submit" class="btn btn-success">
                                    ثبت نام
                                    <i class="la la-angle-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="bg-light text-center">
                        <div class="box-body">
                            قبلا ثبت نام کرده‌اید؟
                            <a href="<?= base_url('login'); ?>" class="btn-link">
                                ورود به پنل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
