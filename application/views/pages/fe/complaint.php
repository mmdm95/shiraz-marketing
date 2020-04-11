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
                            ثبت شکایت
                        </li>
                    </ol>
                </nav>

                <div class="box">
                    <div class="box-header-simple">
                        <h5>
                            ثبت شکایت
                            <small class="text-secondary d-block mt-3 font-size-14px">
                                از ما شکایتی دارید؟ با ما در میان بگذارید
                            </small>
                        </h5>
                    </div>
                    <div class="box-body">
                        <?php $this->view('templates/fe/alert/error', ['errors' => $complaintErrors ?? null]); ?>
                        <?php $this->view('templates/fe/alert/success', ['success' => $complaintSuccess ?? null]); ?>

                        <form action="<?= base_url('complaint'); ?>" method="post">
                            <?= $form_token_complaint; ?>

                            <div class="form-group">
                                <label for="co-title">
                                    عنوان
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="co-title" class="form-control" name="title"
                                           placeholder="عنوان" value="<?= $complaintValues['title'] ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="co-firstName">
                                    نام
                                    <span class="text-danger">
                                        (اجباری)
                                    </span> :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="co-firstName" class="form-control" name="first_name"
                                           placeholder="نام"
                                           value="<?= $complaintValues['first_name'] ?? $identity->first_name ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="co-lastName">
                                    نام خانوادگی :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="co-lastName" class="form-control" name="last_name"
                                           placeholder="نام خانوادگی"
                                           value="<?= $complaintValues['last_name'] ?? $identity->last_name ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="co-mobile">
                                    موبایل
                                    <span class="text-danger">
                                        (اجباری)
                                    </span> :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="co-mobile" class="form-control" name="mobile"
                                           placeholder="موبایل"
                                           value="<?= $complaintValues['mobile'] ?? $identity->mobile ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="co-email">
                                    ایمیل :
                                </label>
                                <div class="main-input__wrapper no-icon right">
                                    <input type="text" id="co-email" class="form-control" name="email"
                                           placeholder="ایمیل" value="<?= $complaintValues['email'] ?? ''; ?>">
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="co-body">
                                    متن
                                    <span class="text-danger">
                                        (اجباری)
                                    </span> :
                                </label>
                                <textarea name="body"
                                          id="co-body"
                                          cols="30" rows="10"
                                          class="form-control"
                                          placeholder="متن مورد نظر شما"><?= $complaintValues['body'] ?? ''; ?></textarea>
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
                                               name="complaintCaptcha"
                                               pattern="[(a-z)(A-Z)(0-9)]{6}" placeholder="کد تصویر بالا">
                                        <span class="input-icon left clear-icon">
                                            <i class="la la-times"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-left pt-5 pb-3">
                                <button type="submit" class="btn btn-primary btn-wd">
                                    ارسال شکایت
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
