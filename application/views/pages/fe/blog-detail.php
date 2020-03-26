<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-blog-detail">
    <div class="container">
        <div class="card-gap"></div>
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('blog/all'); ?>" class="btn-link-black">اخبار و
                        اطلاعیه‌ها</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    این مطلب فاقد اهمیت است
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="box overflow-hidden">
                    <img src="<?= asset_url('fe/images/tmp/b-1.jpg'); ?>" alt="" class="img-fluid">
                </div>
                <div class="section-header section-header-low-gap">
                    <h1 class="section-title">
                        این مطلب فاقد اهمیت است
                    </h1>
                </div>
                <ul class="blog-info list-unstyled">
                    <li class="list-inline-item">
                        در تاریخ
                        ۲۶ شهریور ۱۳۹۹
                    </li>
                    <li class="list-inline-item">
                        در دسته‌بندی
                        <a href="#" class="btn-link-black mr-1">
                            اطلاعیه
                        </a>
                    </li>
                </ul>

                <div class="box">
                    <div class="normal-line-height box-body">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی
                        مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه
                        درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری
                        را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این
                        صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد
                        وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی
                        اساسا مورد استفاده قرار گیرد.
                    </div>
                </div>

                <div class="box">
                    <div class="box-body">
                        <ul class="list-unstyled m-0 p-0">
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-outline-secondary">
                                    برچسب شماره ۱
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-outline-secondary">
                                    برچسب ۲
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-outline-secondary">
                                    برچسب شماره ۳
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-outline-secondary">
                                    برچسب
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn btn-outline-secondary">
                                    شماره
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="box">
                    <form action="<?= base_url('blog/search'); ?>" method="get">
                        <div class="main-input__wrapper">
                            <input type="text" class="form-control box" name="q" placeholder="جستجو در بلاگ">
                            <span class="input-icon right">
                                <i class="la la-search"></i>
                            </span>
                            <span class="input-icon left clear-icon">
                                <i class="la la-times"></i>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="box">
                    <div class="box-header">
                        <i class="la la-th-large float-right ml-2" aria-hidden="true"></i>
                        <h5>
                            دسته‌بندی‌ها
                        </h5>
                    </div>
                    <div class="box-body">
                        <ul class="list-unstyled m-0 p-0">
                            <li class="mb-3">
                                <a href="#" class="btn-link-black-reverse">
                                    <i class="la la-arrow-left ml-2" aria-hidden="true"></i>
                                    اخبار
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn-link-black-reverse">
                                    <i class="la la-arrow-left ml-2" aria-hidden="true"></i>
                                    اطلاعیه‌ها
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <i class="la la-list-alt float-right ml-2" aria-hidden="true"></i>
                        <h5>
                            جدیدترین‌ها
                        </h5>
                    </div>
                    <div class="box-body">
                        <div class="page-side__wrapper">
                            <div class="page-side">
                                <a href="#" class="page-side-img">
                                    <img src="<?= asset_url('fe/images/tmp/b-1.jpg'); ?>" alt="">
                                </a>
                                <ul class="page-side-detail list-unstyled col m-0 p-0">
                                    <li class="mb-2 text-secondary">
                                        <i class="la la-clock-o"></i>
                                        در تاریخ
                                        ۲۶ شهریور ۱۳۹۹
                                    </li>
                                    <li class="text-secondary">
                                        <i class="la la-th-large"></i>
                                        در دسته‌بندی
                                        <a href="#" class="btn-link-black mr-1">
                                            اطلاعیه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="#" class="page-side-title btn-link">
                                این مطلب فاقد اهمیت است
                            </a>
                        </div>
                        <div class="page-side__wrapper">
                            <div class="page-side">
                                <a href="#" class="page-side-img">
                                    <img src="<?= asset_url('fe/images/tmp/b-2.jpg'); ?>" alt="">
                                </a>
                                <ul class="page-side-detail list-unstyled col m-0 p-0">
                                    <li class="mb-2 text-secondary">
                                        <i class="la la-clock-o"></i>
                                        در تاریخ
                                        ۲۶ شهریور ۱۳۹۹
                                    </li>
                                    <li class="text-secondary">
                                        <i class="la la-th-large"></i>
                                        در دسته‌بندی
                                        <a href="#" class="btn-link-black mr-1">
                                            اطلاعیه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="#" class="page-side-title btn-link">
                                این مطلب فاقد اهمیت است
                            </a>
                        </div>
                        <div class="page-side__wrapper">
                            <div class="page-side">
                                <a href="#" class="page-side-img">
                                    <img src="<?= asset_url('fe/images/tmp/b-3.jpg'); ?>" alt="">
                                </a>
                                <ul class="page-side-detail list-unstyled col m-0 p-0">
                                    <li class="mb-2 text-secondary">
                                        <i class="la la-clock-o"></i>
                                        در تاریخ
                                        ۲۶ شهریور ۱۳۹۹
                                    </li>
                                    <li class="text-secondary">
                                        <i class="la la-th-large"></i>
                                        در دسته‌بندی
                                        <a href="#" class="btn-link-black mr-1">
                                            اطلاعیه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="#" class="page-side-title btn-link">
                                این مطلب فاقد اهمیت است
                            </a>
                        </div>
                        <div class="page-side__wrapper">
                            <div class="page-side">
                                <a href="#" class="page-side-img">
                                    <img src="<?= asset_url('fe/images/tmp/b-4.jpg'); ?>" alt="">
                                </a>
                                <ul class="page-side-detail list-unstyled col m-0 p-0">
                                    <li class="mb-2 text-secondary">
                                        <i class="la la-clock-o"></i>
                                        در تاریخ
                                        ۲۶ شهریور ۱۳۹۹
                                    </li>
                                    <li class="text-secondary">
                                        <i class="la la-th-large"></i>
                                        در دسته‌بندی
                                        <a href="#" class="btn-link-black mr-1">
                                            اطلاعیه
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <a href="#" class="page-side-title btn-link">
                                این مطلب فاقد اهمیت است
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
