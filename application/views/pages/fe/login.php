<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-gap"></div>
                <div class="box overflow-hidden">
                    <div class="box-header bg-info text-white py-4">
                        <i class="la la-user" aria-hidden="true"></i>
                        ورود به پنل کاربری
                    </div>
                    <div class="box-body">
                        <form action="<?= base_url('login'); ?>" method="post">
                            <div class="form-group">
                                <label for="l-username">
                                    نام کاربری
                                    <span class="text-danger">
                                       (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="l-username" class="form-control" name="username"
                                           placeholder="نام کاربری">
                                    <span class="input-icon right">
                                        <i class="la la-user"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="l-password" class="d-inline-block">
                                        کلمه عبور
                                        <span class="text-danger">
                                            (اجباری)
                                        </span>
                                        :
                                    </label>
                                    <a href="<?= base_url('forgetPassword'); ?>" class="btn-link float-left">
                                        کلمه عبور خود را فراموش کردم
                                    </a>
                                </div>
                                <div class="main-input__wrapper">
                                    <input type="password" id="l-password" class="form-control" name="password"
                                           placeholder="کلمه عبور">
                                    <span class="input-icon right">
                                        <i class="la la-lock"></i>
                                    </span>
                                    <span class="input-icon left-far clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                    <span class="input-icon left password-icon">
                                        <i class="la la-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="l-remember"
                                           checked="checked" name="remember">
                                    <label class="custom-control-label" for="l-remember">مرا به خاطر بسپار</label>
                                </div>
                            </div>
                            <div class="form-group text-center mt-5">
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
                                               name="loginCaptcha"
                                               pattern="[(a-z)(A-Z)(0-9)]{6}" placeholder="کد تصویر بالا">
                                        <span class="input-icon left clear-icon">
                                            <i class="la la-times"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-info">
                                    ورود به پنل
                                    <i class="la la-angle-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="bg-light text-center">
                        <div class="box-body">
                            هنوز ثبت نام نکرده‌اید؟
                            <a href="<?= base_url('register'); ?>" class="btn-link">
                                ثبت نام کنید
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
