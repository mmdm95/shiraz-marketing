<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

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

        <div class="page_cart__wrapper">
            <?= $cart_content; ?>
        </div>
    </div>
</main>

<!-- Removed/Updated products modal -->
<?php $this->view('templates/fe/modal/modified-items', $data); ?>
<!-- Removed/Updated products modal -->

<?php $this->view('templates/fe/footer', $data); ?>
