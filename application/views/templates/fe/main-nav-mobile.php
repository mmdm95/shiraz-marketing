<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<nav class="nav-main-mobile custom-scrollbar-y js-offcanvas" id="offCanvasMenu">
    <div class="nav-main-mobile-header ltr">
        <button type="button" class="menu-icon menu-btn btn js-offcanvas-close">
            <i class="la la-times" aria-hidden="true"></i>
        </button>
    </div>
    <div class="login-register col align-content-around">
        <div class="row">
            <?php if ($auth->isLoggedIn()): ?>
                <a href="<?= base_url('user/dashboard'); ?>" class="btn login col">
                    داشبورد
                </a>
                <a href="<?= base_url('logout'); ?>" class="btn register col">
                    خروج
                </a>
            <?php else: ?>
                <a href="<?= base_url('login'); ?>" class="btn login col">
                    ورود
                </a>
                <a href="<?= base_url('register'); ?>" class="btn register col">
                    عضویت
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="nav-main-mobile-items rtl-text">
        <?php if (count($menuNavigation)): ?>
            <nav class="nav flex-column">
                <?php foreach ($menuNavigation as $item): ?>
                    <a class="nav-item active" href="<?= base_url('product/all/category/' . $item['slug']); ?>">
                        <i class="<?= $item['icon']; ?> nav-item-icon"></i>
                        <span class="nav-item-text"><?= $item['name']; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
    </div>
</nav>
