<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-cart">
    <div class="container">
        <div class="text-center">
            <div class="box-header-simple">
                <h1>
                    سبد خرید
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="step-container">
                    <div class="step-item active" title="سبد خرید">
                        <i class="la la-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <div class="step-separator active"></div>
                    <div class="step-item" title="اطلاعات ارسال"></div>
                    <div class="step-separator"></div>
                    <div class="step-item" title="پرداخت"></div>
                    <div class="step-separator"></div>
                    <div class="step-item" title="اتمام خرید"></div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <div class="shopping-cart-container">
                    <div class="empty-cart">
                        <i class="la la-shopping-cart" aria-hidden="true"></i>
                        <span class="empty-text">
                            سبد خرید شما خالی است
                        </span>
                        <a href="#" class="btn btn-info">
                            <i class="la la-arrow-right float-right font-size-21px ml-3" aria-hidden="true"></i>
                            ادامه خرید
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="card overflow-visible">
                    <div class="shopping-cart-container">
                        <div class="shopping-cart-item">
                            <button type="button" class="btn btn-danger shopping-cart-delete"
                                    data-toggle="tooltip" data-placement="left" title="حذف محصول">
                                <i class="la la-times" aria-hidden="true"></i>
                            </button>
                            <div class="shopping-cart-item-main">
                                <a href="#">
                                    <img src="<?= asset_url('fe/images/tmp/c-1.jpg'); ?>" alt="">
                                </a>
                                <div class="shopping-cart-item-title col">
                                    <a href="#" class="btn-link-black">
                                        بلیط رایگان سفر و اقامت در چین تا روز قیامت
                                    </a>
                                </div>
                                <div class="shopping-cart-item-count__wrapper">
                                    <select class="shopping-cart-item-count input-select2 form-control">
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
                            <div class="shopping-cart-item-info">
                                <div class="text-secondary">
                                    در دسته‌بندی
                                    <a href="#" class="btn-link-black">
                                        کالاهای پر جنب و جوش
                                    </a>
                                </div>
                                <div class="card-info">
                                    <span class="card-price-off">
                                        رایگان
                                    </span>
                                    <span class="card-price">
                                        ۱،۲۰۰،۰۰۰
                                        تومان
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="shopping-cart-item">
                            <button type="button" class="btn btn-danger shopping-cart-delete"
                                    data-toggle="tooltip" data-placement="left" title="حذف محصول">
                                <i class="la la-times" aria-hidden="true"></i>
                            </button>
                            <div class="shopping-cart-item-main">
                                <a href="#">
                                    <img src="<?= asset_url('fe/images/tmp/c-2.jpg'); ?>" alt="">
                                </a>
                                <div class="shopping-cart-item-title col">
                                    <a href="#" class="btn-link-black">
                                        بلیط یک طرفه به جهنم برای بازدید از حال و احوال دوستان و آشنایان و رزرو تخت برای
                                        اقامت دائمی
                                    </a>
                                </div>
                                <div class="shopping-cart-item-count__wrapper">
                                    <select class="shopping-cart-item-count input-select2 form-control">
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
                            <div class="shopping-cart-item-info">
                                <div class="text-secondary">
                                    در دسته‌بندی
                                    <a href="#" class="btn-link-black">
                                        کالاهای پر جنب و جوش
                                    </a>
                                </div>
                                <div class="card-info">
                                    <span class="card-price-off">
                                        رایگان
                                    </span>
                                    <span class="card-price">
                                        ۱،۲۰۰،۰۰۰
                                        تومان
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 order-1 order-lg-2 mx-auto">
                <div class="box">
                    <div class="box-body">
                        <div class="shopping-cart-container">
                            <div class="shopping-cart-info">
                                <div class="shopping-cart-info-item">
                                    <div>
                                        مبلغ کل (۱ کالا) :
                                    </div>
                                    <div class="text-dark">
                                        ۸۵۰،۰۰۰
                                        تومان
                                    </div>
                                </div>
                                <div class="shopping-cart-info-item">
                                    <div class="text-primary">
                                        مبلغ تخفیف :
                                    </div>
                                    <div class="text-primary">
                                        ۲۰۰،۰۰۰
                                        تومان
                                    </div>
                                </div>
                                <div class="shopping-cart-info-item">
                                    <div>
                                        هزینه ارسال :
                                    </div>
                                    <div class="text-dark">
                                        وابسته به آدرس
                                    </div>
                                </div>
                            </div>
                            <div class="shopping-cart-continue">
                                <div class="text-secondary mb-2">
                                    مبلغ کل‌ :
                                </div>
                                <div class="text-danger font-size-21px mb-4">
                                    ۶۵۰،۰۰۰
                                    تومان
                                </div>
                                <a href="#" class="btn btn-success btn-block">
                                    ادامه ثبت سفارش
                                    <i class="la la-angle-left font-size-21px mr-3 float-left" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
