<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-product-detail">
    <div class="container">
        <div class="card-gap"></div>
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">محصولات</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    بلیط رایگان هواپیما به چین
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-7 stretch-card">
                <div class="box d-flex flex-column justify-content-between">
                    <div class="thumbnail-slider-carousel owl-carousel" id="thumbnailSliderCarousel">
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/d-1.jpg'); ?>" alt="">
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/d-2.jpg'); ?>" alt="">
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/d-3.jpg'); ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="owl-thumb owl-carousel" data-owl-carousel-thumb-id="thumbnailSliderCarousel">
                        <div>
                            <a href="javascript:void(0);">
                                <img src="<?= asset_url('fe/images/tmp/d-1.jpg'); ?>" alt="" class="owl-thumb-image">
                            </a>
                        </div>
                        <div>
                            <a href="javascript:void(0);">
                                <img src="<?= asset_url('fe/images/tmp/d-2.jpg'); ?>" alt="" class="owl-thumb-image">
                            </a>
                        </div>
                        <div>
                            <a href="javascript:void(0);">
                                <img src="<?= asset_url('fe/images/tmp/d-3.jpg'); ?>" alt="" class="owl-thumb-image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 stretch-card">
                <div class="card justify-content-between">
                    <div>
                        <div class="box-body">
                            <div class="off-label">
                                ویژه
                            </div>
                            <div class="product-detail-side">
                                <h1 class="product-detail-side-title">
                                    بلیط هواپیما رایگان به چین
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="box-body pt-0">
                        <div class="product-detail-side">
                            <div class="card-info col">
                                <div class="card-price-off">
                                    رایگان
                                </div>
                                <div class="card-price">
                                    ۱،۲۰۰،۰۰۰
                                    تومان
                                </div>
                            </div>
                            <div class="text-center mr-2">
                                <span class="badge badge-danger">
                                    ۱۰۰٪ تخفیف
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="box-body pt-0">
                            <div class="mb-4 row justify-content-center">
                                <div class="col-lg-8 col-md-6 col-sm-12">
                                    <select id="cartAddCount" class="input-select2">
                                        <option value="1">
                                            ۱
                                        </option>
                                        <option value="2">
                                            ۲
                                        </option>
                                        <option value="3">
                                            ۳
                                        </option>
                                        <option value="4">
                                            ۴
                                        </option>
                                        <option value="5">
                                            ۵
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="product-detail-side justify-content-center">
                                <button type="button" class="btn btn-success col-lg-8 col-md-6 col-sm-12">
                                    <i class="la la-shopping-cart font-size-21px float-right ml-2"
                                       aria-hidden="true"></i>
                                    افزودن به سبد خرید
                                </button>
                            </div>
                        </div>
                        <div class="product-detail-side flex-column">
                            <div class="product-detail-side-item product-detail-side-location">
                                <i class="la la-map-marker" aria-hidden="true"></i>
                                <div>
                                    سعادت آباد
                                </div>
                            </div>
                            <div class="product-detail-side-item product-detail-side-time">
                                <i class="la la-clock-o" aria-hidden="true"></i>
                                <div countdown data-date="<?= date('Y-m-d H:i:s', time() + (365 * 24 * 60 * 60)); ?>">
                                    <div class="col">
                                        <span data-days>0</span>
                                        روز
                                    </div>
                                    <div class="col">
                                        <span data-hours>0</span>
                                        ساعت
                                    </div>
                                    <div class="col">
                                        <span data-minutes>0</span>
                                        دقیقه
                                    </div>
                                    <div class="col">
                                        <span data-seconds>0</span>
                                        ثانیه
                                    </div>
                                </div>
                            </div>
                            <div class="product-detail-side-item">
                                <div class="product-detail-side col">
                                    <div class="d-flex justify-content-between">
                                        <span class="mx-3 text-secondary">
                                            اشتراک گذاری در
                                        </span>
                                        <ul class="list-unstyled product-detail-side-share col p-0">
                                            <li class="list-inline-item">
                                                <a href="#" class="btn-link-black-reverse">
                                                    <i class="la la-paper-plane" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" class="btn-link-black-reverse">
                                                    <i class="la la-instagram" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" class="btn-link-black-reverse">
                                                    <i class="la la-whatsapp" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <i class="la la-file-text float-right ml-2" aria-hidden="true"></i>
                        <h5>
                            توضیحات
                        </h5>
                    </div>
                    <div class="box-body normal-line-height">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک
                        است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی
                        تکنولوژی
                        مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه
                        درصد
                        گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
                        طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می
                        توان
                        امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد
                        نیاز
                        شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده
                        قرار
                        گیرد.
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <a href="#" class="btn btn-outline-secondary m-2">
                            تگ شماره ۱
                        </a>
                        <a href="#" class="btn btn-outline-secondary m-2">
                            تگ شماره ۲
                        </a>
                        <a href="#" class="btn btn-outline-secondary m-2">
                            تگ شماره ۳
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="section-header align-items-center">
                    <div class="section-title-icon"></div>
                    <h1 class="section-title">
                        محصولات مرتبط
                    </h1>
                </div>
                <div class="similar-items owl-carousel">
                    <div class="card-wrapper semi-col-3">
                        <div class="card">
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="#">
                                    <img src="<?= asset_url('fe/images/tmp/c-1.jpg'); ?>" alt="">
                                </a>
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
                    <div class="card-wrapper semi-col-3">
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
                    <div class="card-wrapper semi-col-3">
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
                    <div class="card-wrapper semi-col-3">
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
                    <div class="card-wrapper semi-col-3">
                        <div class="card">
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="#">
                                    <img src="<?= asset_url('fe/images/tmp/c-1.jpg'); ?>" alt="">
                                </a>
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
                    <div class="card-wrapper semi-col-3">
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
                    <div class="card-wrapper semi-col-3">
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
                    <div class="card-wrapper semi-col-3">
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
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
