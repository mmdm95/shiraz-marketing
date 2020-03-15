<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<header class="header-main">
    <div class="header-top-shadow"></div>
    <div class="container">
        <div class="row">
            <a href="javascript:void(0);" class="menu-btn">
                <i class="la la-bars" aria-hidden="true"></i>
            </a>
            <div class="logo-container">
                <a href="<?= base_url('index'); ?>" class="logo-wrapper">
                    <img src="<?= asset_url('fe/images/logo.png'); ?>" alt="لوگو">
                    <h1 class="irentezar">
                        شیراز مارکتینگ
                    </h1>
                </a>
            </div>
            <form class="search-container col" method="get" action="<?= base_url('search'); ?>">
                <button type="submit" class="btn btn-primary-main search-button">
                    جستجو
                </button>
                <div class="search-input">
                    <span class="search-icon">
                        <i class="la la-search" aria-hidden="true"></i>
                    </span>
                    <input type="text" name="q" placeholder="جستجو محصول و خدمات" class="form-control rtl">
                </div>
            </form>
            <div class="extra-container">
                <div class="login-register">
                    <a href="<?= base_url('login'); ?>" class="btn login">
                        ورود
                    </a>
                    <a href="<?= base_url('register'); ?>" class="btn register">
                        عضویت
                    </a>
                </div>
                <div class="basket-container">
                    <div class="basket-icon dropdown-toggle" id="shoppingCart" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="false" data-target="basketDropdown">
                        <i class="la la-shopping-cart" id="cart"></i>
                        <span class="basket-number badge">۰</span>
                    </div>
                    <div class="basket-items-container dropdown-menu" id="basketDropdown"
                         aria-labelledby="shoppingCart">
                        <!--                        <span class="rtl-text empty-text">-->
                        <!--                            سبد خرید خالی است-->
                        <!--                        </span>-->
                        <div class="basket-items-info">
                            <div class="col p-0">
                                مبلغ کل:
                                <span class="basket-items-price">
                                    ۲۵۰،۰۰۰
                                    تومان
                                </span>
                            </div>
                            <div>
                                <a href="<?= base_url('cart'); ?>" class="btn btn-outline-secondary border-0">
                                    سبد خرید
                                </a>
                            </div>
                        </div>
                        <ul class="basket-items custom-scrollbar">
                            <li class="basket-item">
                                <a href="#" class="basket-item-img">
                                    <img src="<?= asset_url('fe/images/desk.jpg'); ?>" alt="">
                                </a>
                                <div class="col p-0">
                                    <a href="#" class="basket-item-link">
                                        عروسک روسی
                                    </a>
                                    <span class="basket-item-count">
                                        ۲
                                        عدد
                                    </span>
                                </div>
                                <button type="button" class="btn btn-outline-dark basket-item-delete">
                                    <i class="la la-times" aria-hidden="true"></i>
                                </button>
                            </li>
                            <li class="basket-item">
                                <a href="#" class="basket-item-img">
                                    <img src="<?= asset_url('fe/images/networking.jpg'); ?>" alt="">
                                </a>
                                <div class="col p-0">
                                    <a href="#" class="basket-item-link">
                                        بلیط برنامه دورهمی
                                    </a>
                                    <span class="basket-item-count">
                                        ۲
                                        عدد
                                    </span>
                                </div>
                                <button type="button" class="btn btn-outline-dark basket-item-delete">
                                    <i class="la la-times" aria-hidden="true"></i>
                                </button>
                            </li>
                            <li class="basket-item">
                                <a href="#" class="basket-item-img">
                                    <img src="<?= asset_url('fe/images/desk.jpg'); ?>" alt="">
                                </a>
                                <div class="col p-0">
                                    <a href="#" class="basket-item-link">
                                        عروسک روسی
                                    </a>
                                    <span class="basket-item-count">
                                        ۲
                                        عدد
                                    </span>
                                </div>
                                <button type="button" class="btn btn-outline-dark basket-item-delete">
                                    <i class="la la-times" aria-hidden="true"></i>
                                </button>
                            </li>
                            <li class="basket-item">
                                <a href="#" class="basket-item-img">
                                    <img src="<?= asset_url('fe/images/networking.jpg'); ?>" alt="">
                                </a>
                                <div class="col p-0">
                                    <a href="#" class="basket-item-link">
                                        بلیط برنامه دورهمی
                                    </a>
                                    <span class="basket-item-count">
                                        ۲
                                        عدد
                                    </span>
                                </div>
                                <button type="button" class="btn btn-outline-dark basket-item-delete">
                                    <i class="la la-times" aria-hidden="true"></i>
                                </button>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-info btn-block btn-lg rounded-0">
                            ثبت سفارش
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row sms-number-container">
            <div class="col-12 py-2">
                <span class="text-white">
                    شماره پیامک:
                    ۰۹۱۳۹۵۱۸۰۵۵
                </span>
            </div>
        </div>
    </div>
</header>