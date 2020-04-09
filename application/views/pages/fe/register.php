<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card-gap"></div>
                <div class="box overflow-hidden">
                    <div class="box-header bg-success text-white py-4">
                        <i class="la la-user-plus" aria-hidden="true"></i>
                        ثبت نام در شیراز مارکتینگ
                    </div>
                    <div class="box-body">
                        <div class="alert alert-info">
                            کلمه عبور باید شامل حروف و اعداد انگلیسی باشد و حداقل ۹ کاراکتر داشته باشد.
                        </div>
                        <?php $this->view('templates/fe/alert/error', ['errors' => $registerErrors ?? null]); ?>

                        <form action="<?= base_url('register'); ?><?= isset($_GET['back_url']) ? '?back_url=' . URITracker::get_last_uri() : ''; ?>"
                              method="post">
                            <?= $form_token_register; ?>

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
                                           placeholder="برای مثال: ۰۹۱۷xxxxxxx"
                                           value="<?= $registerValues['username'] ?? ''; ?>">
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
                                <div class="main-input__wrapper has-extra-icon">
                                    <input type="password" id="r-password" class="form-control" name="password"
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
                                <label for="r-rePassword" class="d-inline-block">
                                    تکرار کلمه عبور
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper has-extra-icon">
                                    <input type="password" id="r-rePassword" class="form-control" name="re_password"
                                           placeholder="تکرار کلمه عبور">
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
                                    <input type="checkbox" class="custom-control-input" id="r-rules"
                                           checked="checked" name="rules">
                                    <label class="custom-control-label" for="r-rules">
                                        <a href="<?= base_url('pages/rules'); ?>" target="_blank">
                                            قوانین سایت
                                        </a>
                                        را مطالعه کردم و آنها را می‌پذیرم.
                                    </label>
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
