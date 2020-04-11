<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-contact-us">
    <?php $this->view('templates/fe/each-page-header', $data); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <nav class="page-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            تماس با ما
                        </li>
                    </ol>
                </nav>

                <div class="box">
                    <div class="box-header-simple">
                        <h5>
                            تماس با ما
                            <small class="text-secondary d-block mt-3 font-size-14px">
                                پیام خود را با ما به اشتراک بگذارید
                            </small>
                        </h5>
                    </div>
                    <div class="box-body">
                        <?php $this->view('templates/fe/alert/error', ['errors' => $contactErrors ?? null]); ?>
                        <?php $this->view('templates/fe/alert/success', ['success' => $contactSuccess ?? null]); ?>

                        <form action="<?= base_url('contactUs'); ?>" method="post">
                            <?= $form_token_contact; ?>

                            <div class="form-group">
                                <label for="c-title">
                                    عنوان
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="c-title" class="form-control" name="title"
                                           placeholder="عنوان" value="<?= $contactValues['title'] ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-firstName">
                                    نام
                                    <span class="text-danger">
                                        (اجباری)
                                    </span> :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="c-firstName" class="form-control" name="first_name"
                                           placeholder="نام"
                                           value="<?= $contactValues['first_name'] ?? $identity->first_name ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-lastName">
                                    نام خانوادگی :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="c-lastName" class="form-control" name="last_name"
                                           placeholder="نام خانوادگی"
                                           value="<?= $contactValues['last_name'] ?? $identity->last_name ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-mobile">
                                    موبایل
                                    <span class="text-danger">
                                        (اجباری)
                                    </span> :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="c-mobile" class="form-control" name="mobile"
                                           placeholder="موبایل"
                                           value="<?= $contactValues['mobile'] ?? $identity->mobile ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-email">
                                    ایمیل :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="c-email" class="form-control" name="email"
                                           placeholder="ایمیل" value="<?= $contactValues['email'] ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-body">
                                    متن
                                    <span class="text-danger">
                                        (اجباری)
                                    </span> :
                                </label>
                                <textarea name="body"
                                          id="c-body"
                                          cols="30" rows="10"
                                          class="form-control"
                                          placeholder="متن مورد نظر شما"><?= $contactValues['body'] ?? ''; ?></textarea>
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
                                               name="contactCaptcha"
                                               pattern="[(a-z)(A-Z)(0-9)]{6}" placeholder="کد تصویر بالا">
                                        <span class="input-icon left clear-icon">
                                            <i class="la la-times"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left pt-5 pb-3">
                                <button type="submit" class="btn btn-primary btn-wd">
                                    ارسال
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
