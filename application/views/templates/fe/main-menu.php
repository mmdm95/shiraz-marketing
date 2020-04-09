<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<header class="header-main">
    <div class="header-top-shadow"></div>
    <div class="container">
        <div class="row">
            <button type="button" id="menuBtn" class="menu-icon menu-btn btn">
                <i class="la la-bars" aria-hidden="true"></i>
            </button>
            <div class="logo-container">
                <a href="<?= base_url('index'); ?>" class="logo-wrapper">
                    <img src="<?= base_url($logo); ?>" alt="<?= $setting['main']['title']; ?>">
                    <h1 class="irentezar">
                        شیراز مارکتینگ
                    </h1>
                </a>
            </div>
            <div class="search-container col">
                <form class="search-form" id="mobileSearchForm" method="get" action="<?= base_url('product/all'); ?>">
                    <button type="submit" class="btn btn-primary-main search-button">
                        جستجو
                    </button>
                    <div class="search-input">
                        <span class="search-icon">
                            <i class="la la-search float-right" aria-hidden="true"></i>
                        </span>
                        <input type="text" name="q" placeholder="جستجو محصول و خدمات" class="form-control rtl">
                    </div>
                    <button class="menu-icon search-form-close btn" id="closeMobileSearchForm" type="button">
                        <i class="la la-times"></i>
                    </button>
                </form>
            </div>
            <div class="extra-container">
                <div class="login-register">
                    <?php if ($auth->isLoggedIn()): ?>
                        <a href="<?= base_url('user/dashboard'); ?>" class="btn login">
                            داشبورد
                        </a>
                        <a href="<?= base_url('logout'); ?>" class="btn register">
                            خروج
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login'); ?>" class="btn login">
                            ورود
                        </a>
                        <a href="<?= base_url('register'); ?>" class="btn register">
                            عضویت
                        </a>
                    <?php endif; ?>
                </div>
                <div class="basket-container">
                    <div class="menu-icon mobile-search-icon" id="mobileSearchIcon">
                        <i class="la la-search" id="cart"></i>
                    </div>
                    <div class="menu-icon basket-icon dropdown-toggle" id="shoppingCart" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="false" data-target="basketDropdown">
                        <i class="la la-shopping-cart" id="cart"></i>
                        <span class="basket-number badge"><?= convertNumbersToPersian($cart_items[1]); ?></span>
                    </div>
                    <div class="basket-items-container dropdown-menu" id="basketDropdown"
                         aria-labelledby="shoppingCart">
                        <?= $cart_items[0]; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>