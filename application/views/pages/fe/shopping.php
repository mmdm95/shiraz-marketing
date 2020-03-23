<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

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

        <div class="row">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="box-header-info">
                    آدرس تحویل سفارش
                </div>
                <div class="box box-info">
                    <div class="box-body text-secondary">
                        <div>
                            گیرنده :
                            <span>
                                محمد مهدی دهقان منشادی
                            </span>
                            <a href="#" class="btn btn-light mr-2">
                                اصلاح آدرس
                            </a>
                        </div>
                        <div class="mt-4">
                            شماره تماس :
                            <span>
                                ۰۹۱۷۹۵۱۶۲۷۱
                            </span>
                            <span class="mx-2">
                                |
                            </span>
                            کد پستی :
                            <span>
                                ۹۹۹۹۹۹۹۹۹۹
                            </span>
                        </div>
                        <div class="mt-4">
                            استان
                            <span>
                                فارس،
                            </span>
                            شهر
                            <span>
                                آباده،
                            </span>
                            <span>
                                بلوار جام جم کوچه دهم پلاک ۱۴
                            </span>
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
                                        ۶،۰۰۰
                                        تومان
                                    </div>
                                </div>
                            </div>
                            <div class="shopping-cart-continue">
                                <div class="text-secondary mb-2">
                                    مبلغ کل‌ :
                                </div>
                                <div class="text-danger font-size-21px mb-4">
                                    ۶۵۶،۰۰۰
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
