<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container">
    <div class="container">
        <div class="card-gap"></div>
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="main-slider-carousel owl-carousel">
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/1.jpg'); ?>" alt="">
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/2.jpg'); ?>" alt="">
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/3.jpg'); ?>" alt="">
                            </a>
                        </div>
                        <div>
                            <a href="#">
                                <img src="<?= asset_url('fe/images/tmp/4.jpg'); ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container card-container">
        <div class="section-header align-items-center">
            <div class="section-title-icon"></div>
            <h1 class="section-title">
                ویژه‌های هفته
            </h1>
        </div>
        <div class="row">
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="off-label">
                        ویژه
                    </div>
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
                    <div class="off-label">
                        ویژه
                    </div>
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
    </div>

    <div class="container card-container">
        <div class="section-header align-items-center">
            <div class="section-title-icon"></div>
            <h1 class="section-title">
                جدیدترین تخفیف‌ها
            </h1>
        </div>
        <div class="row">
            <div class="card-wrapper col-lg-3 col-md-6 col-12">
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
            <div class="card-wrapper col-lg-3 col-md-6 col-12">
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
            <div class="card-wrapper col-lg-3 col-md-6 col-12">
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
            <div class="card-wrapper col-lg-3 col-md-6 col-12">
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
    </div>

    <div class="container card-container">
        <div class="section-header align-items-center">
            <div class="section-title-icon"></div>
            <h1 class="section-title">
                آخرین اخبار شیراز مارکتینگ
            </h1>
        </div>
        <div class="row">
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card card-news">
                    <div class="card-img">
                        <div class="img-placeholder">
                            <i class="la la-image" aria-hidden="true"></i>
                        </div>
                        <!--                    <a href="#">-->
                        <!--                        <img src="-->
                        <? //= asset_url('fe/images/tmp/c-1.jpg'); ?><!--" alt="">-->
                        <!--                    </a>-->
                        <div class="card-date">
                        <span class="day">
                            ۲۶
                        </span>
                            <span class="month">
                            اردیبهشت
                        </span>
                        </div>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <p class="card-abstract">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی
                        مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد
                        گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
                        طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان
                        امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز
                        شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                        گیرد.
                    </p>
                    <div class="card-info">
                        <ul class="list-unstyled">
                            <li class="list-inline-item">
                                <i class="la la-list"></i>
                                <a href="#" class="btn-link-secondary">
                                    خبررسانی
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="la la-eye"></i>
                                ۱،۱۱۰
                                بازدید
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card card-news">
                    <div class="card-img">
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-2.jpg'); ?>" alt="">
                        </a>
                        <div class="card-date">
                        <span class="day">
                            ۲۶
                        </span>
                            <span class="month">
                            شهریور
                        </span>
                        </div>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <p class="card-abstract">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی
                        مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد
                        گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
                        طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان
                        امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز
                        شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                        گیرد.
                    </p>
                    <div class="card-info">
                        <ul class="list-unstyled">
                            <li class="list-inline-item">
                                <i class="la la-list"></i>
                                <a href="#" class="btn-link-secondary">
                                    خبررسانی
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="la la-eye"></i>
                                ۱،۱۱۰
                                بازدید
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card card-news">
                    <div class="card-img">
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-3.jpg'); ?>" alt="">
                        </a>
                        <div class="card-date">
                        <span class="day">
                            ۲۶
                        </span>
                            <span class="month">
                            شهریور
                        </span>
                        </div>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <p class="card-abstract">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی
                        مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد
                        گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
                        طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان
                        امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز
                        شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                        گیرد.
                    </p>
                    <div class="card-info">
                        <ul class="list-unstyled">
                            <li class="list-inline-item">
                                <i class="la la-list"></i>
                                <a href="#" class="btn-link-secondary">
                                    خبررسانی
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="la la-eye"></i>
                                ۱،۱۱۰
                                بازدید
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                <div class="card card-news">
                    <div class="card-img">
                        <a href="#">
                            <img src="<?= asset_url('fe/images/tmp/c-4.jpg'); ?>" alt="">
                        </a>
                        <div class="card-date">
                        <span class="day">
                            ۲۶
                        </span>
                            <span class="month">
                            شهریور
                        </span>
                        </div>
                    </div>
                    <div class="card-title">
                        <a href="#">
                            رستوران زند هتل پارسیان کوثر صبحانه
                        </a>
                    </div>
                    <p class="card-abstract">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است،
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی
                        مورد
                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد
                        گذشته
                        حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای
                        طراحان
                        رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان
                        امید
                        داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز
                        شامل
                        حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار
                        گیرد.
                    </p>
                    <div class="card-info">
                        <ul class="list-unstyled">
                            <li class="list-inline-item">
                                <i class="la la-list"></i>
                                <a href="#" class="btn-link-secondary">
                                    خبررسانی
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="la la-eye"></i>
                                ۱،۱۱۰
                                بازدید
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
