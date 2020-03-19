<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container">
    <?php $this->view('templates/fe/each-page-header', $data); ?>

    <div class="container">
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    محصولات
                </li>
            </ol>
        </nav>
    </div>

    <div class="container card-container">
        <div class="section-header section-header-low-gap d-md-flex d-block align-items-center justify-content-between mb-0">
            <div class="d-flex mb-4">
                <div class="section-title-icon"></div>
                <h1 class="section-title">
                    جدیدترین
                </h1>
            </div>
            <div class="d-sm-flex d-block align-items-center mb-4 justify-content-end">
                <div class="d-sm-flex d-inline-block align-items-center ml-sm-4 ml-0 mb-3">
                    <label for="sortBySelect" class="text-nowrap ml-3 mb-0">
                        مرتب سازی:
                    </label>
                    <select name="sort_by" id="sortBySelect" class="input-select2">
                        <option value="1">
                            جدیدترین
                        </option>
                        <option value="2">
                            پرتخفیفترین
                        </option>
                        <option value="3">
                            پربازدیدترین
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <!--                    <a href="#">-->
                        <!--                        <img src="-->
                        <? //= asset_url('fe/images/tmp/c-1.jpg'); ?><!--" alt="">-->
                        <!--                    </a>-->
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        میدان ولیعصر
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۳۵٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۳۳،۸۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۵۲،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-2.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        ماسال
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تور 2.5 روزه ماسوله تا ماسال
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۲۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۱۹۹،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۲۴۹،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-3.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        مشهد
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تور ۳.۵ روزه مشهد
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۵۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۲۸۰،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۵۶۰،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-4.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        زعفرانیه
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تئاتر کمدی پاستیل
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۵۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۲۰،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۴۰،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <!--                    <a href="#">-->
                        <!--                        <img src="-->
                        <? //= asset_url('fe/images/tmp/c-1.jpg'); ?><!--" alt="">-->
                        <!--                    </a>-->
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        میدان ولیعصر
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۳۵٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۳۳،۸۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۵۲،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-2.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        ماسال
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تور 2.5 روزه ماسوله تا ماسال
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۲۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۱۹۹،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۲۴۹،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-3.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        مشهد
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تور ۳.۵ روزه مشهد
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۵۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۲۸۰،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۵۶۰،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-4.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        زعفرانیه
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تئاتر کمدی پاستیل
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۵۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۲۰،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۴۰،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <!--                    <a href="#">-->
                        <!--                        <img src="-->
                        <? //= asset_url('fe/images/tmp/c-1.jpg'); ?><!--" alt="">-->
                        <!--                    </a>-->
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        میدان ولیعصر
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۳۵٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۳۳،۸۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۵۲،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-2.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        ماسال
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تور 2.5 روزه ماسوله تا ماسال
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۲۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۱۹۹،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۲۴۹،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-3.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        مشهد
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تور ۳.۵ روزه مشهد
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۵۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۲۸۰،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۵۶۰،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-4.jpg'); ?>" alt="">
                        </a>
                        <span class="card-location">
                        <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                        زعفرانیه
                    </span>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            تئاتر کمدی پاستیل
                        </a>
                    </div>
                    <div class="card-info">
                        <div>
                        <span class="btn rounded-pill card-off-percentage">
                            ۵۰٪
                            <span class="card-off-percentage-takhfif">
                                تخفیف
                            </span>
                        </span>
                        </div>
                        <div>
                        <span class="card-price-off">
                            ۲۰،۰۰۰
                            تومان
                        </span>
                            <span class="card-price">
                            ۴۰،۰۰۰
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav aria-label="صفحه‌بندی محصولات">
            <ul class="pagination flex-row-reverse justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="la la-angle-left" aria-hidden="true"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">۱</a></li>
                <li class="page-item"><a class="page-link" href="#">۲</a></li>
                <li class="page-item"><a class="page-link" href="#">۳</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="la la-angle-right" aria-hidden="true"></i></a></li>
            </ul>
        </nav>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
