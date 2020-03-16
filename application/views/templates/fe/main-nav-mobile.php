<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<nav class="nav-main-mobile custom-scrollbar js-offcanvas" id="offCanvasMenu">
    <div class="nav-main-mobile-header ltr">
        <button type="button" class="menu-icon menu-btn btn js-offcanvas-close">
            <i class="la la-times" aria-hidden="true"></i>
        </button>
    </div>
    <div class="login-register col align-content-around">
        <div class="row">
            <a href="<?= base_url('login'); ?>" class="btn login col">
                ورود
            </a>
            <a href="<?= base_url('register'); ?>" class="btn register col">
                عضویت
            </a>
        </div>
    </div>
    <div class="nav-main-mobile-items rtl-text">
        <nav class="nav flex-column">
            <a class="nav-item active" href="#">
                <i class="la la-building-o nav-item-icon"></i>
                <span class="nav-item-text">
                    رستوران و کافی شاپ
                </span>
            </a>
            <a class="nav-item" href="#">
                <i class="la la-heartbeat nav-item-icon"></i>
                <span class="nav-item-text">
                    سلامتی و پزشکی
                </span>
            </a>
            <a class="nav-item" href="#">
                <i class="la la-graduation-cap nav-item-icon"></i>
                <span class="nav-item-text">
                    آموزش
                </span>
            </a>
            <a class="nav-item disabled" href="#" tabindex="-1" aria-disabled="true">
                <i class="la la-smile-o nav-item-icon"></i>
                <span class="nav-item-text">
                    تفریحی و ورزشی
                </span>
            </a>
        </nav>
    </div>
</nav>
