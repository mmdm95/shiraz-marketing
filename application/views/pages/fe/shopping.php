<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu-minimal', $data); ?>

<main class="main-container page-shopping">
    <div class="container">
        <div class="text-center">
            <div class="box-header-simple">
                <h1>
                    اطلاعات ارسال
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
                    <div class="step-item active" title="اطلاعات ارسال">
                        <i class="la la-pencil" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator active"></div>
                    <div class="step-item" title="پرداخت"></div>
                    <div class="step-separator"></div>
                    <div class="step-item" title="اتمام خرید"></div>
                </div>
            </div>
        </div>

        <form action="<?= base_url('shopping'); ?>" method="post">
            <?= $form_token; ?>

            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">
                    <?php $this->view('templates/fe/alert/error', ['errors' => $errors ?? null]); ?>

                    <div class="box-header-info">
                        آدرس تحویل سفارش
                    </div>
                    <div class="box box-info">
                        <div class="box-body text-secondary">
                            <div class="mb-4">
                                <span class="text-primary">
                                    به صورت پیش فرض از اطلاعات شما برای گیرنده استفاده می‌شود.
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="sh-rn" class="d-inline-block">
                                    نام گیرنده
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-rn" class="form-control" required
                                           name="receiver_name" placeholder="حروف فارسی"
                                           value="<?= $values['receiver_name'] ?? trim(($identity->first_name ?? '') . ' ' . ($identity->last_name ?? '')); ?>">
                                    <span class="input-icon right">
                                        <i class="la la-user-circle"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sh-rm" class="d-inline-block">
                                    شماره تماس گیرنده
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-rm" class="form-control" required
                                           name="receiver_mobile" placeholder="۰۹۱۷xxxxxxx"
                                           value="<?= $values['receiver_mobile'] ?? $identity->mobile ?? ''; ?>">
                                    <span class="input-icon right">
                                        <i class="la la-mobile"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sh-rp" class="d-inline-block">
                                    استان
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-rp" class="form-control" required
                                           name="receiver_province" placeholder="وارد کنید"
                                           value="<?= $values['receiver_province'] ?? $identity->province ?? ''; ?>">
                                    <span class="input-icon right">
                                        <i class="la la-map-marker"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sh-rc" class="d-inline-block">
                                    شهر
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-rc" class="form-control" required
                                           name="receiver_city" placeholder="وارد کنید"
                                           value="<?= $values['receiver_city'] ?? $identity->city ?? ''; ?>">
                                    <span class="input-icon right">
                                        <i class="la la-map-marker"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sh-ra" class="d-inline-block">
                                    آدرس
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-ra" class="form-control" required
                                           name="receiver_address" placeholder="وارد کنید"
                                           value="<?= $values['receiver_address'] ?? $identity->address ?? ''; ?>">
                                    <span class="input-icon right">
                                        <i class="la la-map-marker"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sh-rpc" class="d-inline-block">
                                    کد پستی
                                    <span class="text-danger">
                                        (اجباری)
                                    </span>
                                    :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-rpc" class="form-control" required
                                           name="receiver_postal_code" placeholder="کد ۱۰ رقمی"
                                           value="<?= $values['receiver_postal_code'] ?? $identity->postal_code ?? ''; ?>">
                                    <span class="input-icon right">
                                        <i class="la la-envelope"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-header-info">
                        اعمال کد تخفیف
                    </div>
                    <div class="box border-top border-info">
                        <div class="box-body text-secondary">
                            <div class="form-group">
                                <label for="sh-cc" class="d-inline-block">
                                    کد تخفیف خود را استفاده کنید :
                                </label>
                                <div class="main-input__wrapper">
                                    <input type="text" id="sh-cc" class="form-control"
                                           name="coupon_code" placeholder="کد تخفیف"
                                           value="<?= $values['coupon_code'] ?? ''; ?>">
                                    <span class="input-icon right">
                                        <i class="la la-dollar-sign"></i>
                                    </span>
                                    <span class="input-icon left clear-icon">
                                        <i class="la la-times"></i>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p class="text-danger">
                                    با کلیک بر روی حذف کد تخفیف، محاسبه قیمت در مرحله بعد انجام می‌شود.
                                </p>
                            </div>
                            <div class="text-left">
                                <button type="button" class="btn btn-light" id="couponDelete">
                                    <i class="la la-trash-alt float-right ml-3 font-size-21px"
                                       aria-hidden="true"></i>
                                    حذف کد اعمال شده
                                </button>
                                <button type="button" class="btn btn-info" id="couponChecker">
                                    <i class="la la-undo la-rotate-180 float-right ml-3 font-size-21px"
                                       aria-hidden="true"></i>
                                    بررسی کد تخفیف
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 order-1 order-lg-2 mx-auto" id="main_sidebar__wrapper">
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
