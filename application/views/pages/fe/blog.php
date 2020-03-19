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
                    اخبار و اطلاعیه‌ها
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
                    <label for="sortByCategorySelect" class="text-nowrap ml-3 mb-0">
                        دسته‌بندی:
                    </label>
                    <select name="sort_by_category" id="sortByCategorySelect" class="input-select2">
                        <option value="1">
                            اطلاعیه
                        </option>
                        <option value="2">
                            خبررسانی
                        </option>
                    </select>
                </div>
                <div class="d-sm-flex d-inline-block align-items-center mb-3">
                    <label for="sortBySelect" class="text-nowrap ml-3 mb-0">
                        مرتب سازی:
                    </label>
                    <select name="sort_by" id="sortBySelect" class="input-select2">
                        <option value="1">
                            جدیدترین
                        </option>
                        <option value="2">
                            پربازدیدترین
                        </option>
                    </select>
                </div>
            </div>
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

        <nav aria-label="صفحه‌بندی اخبار و اطلاعیه‌ها">
            <ul class="pagination flex-row-reverse justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="la la-angle-left"
                                                                                aria-hidden="true"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">۱</a></li>
                <li class="page-item"><a class="page-link" href="#">۲</a></li>
                <li class="page-item"><a class="page-link" href="#">۳</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="la la-angle-right" aria-hidden="true"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
