<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- Main sidebar -->
<div class="sidebar sidebar-default sidebar-main">
    <div class="sidebar-content">
        <!-- User menu -->
        <input type="hidden" id="PLATFORM" value="<?= PLATFORM; ?>">

        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="<?= base_url('admin/user/editUser/' . @$identity->id); ?>"
                       class="media-left">
                        <img src="<?= base_url($identity->image); ?>" class="img-fit"
                             alt="">
                    </a>
                    <div class="media-body">
                        <a href="<?= base_url() . 'admin/user/editUser/' . @$identity->id; ?>"
                           class="media-heading text-semibold">
                            <?= set_value($identity->first_name ?? '', '', null, $identity->mobile); ?>
                        </a>
                        <div class="text-size-mini text-muted">
                            <div class="text-size-mini text-muted">
                                <?= $identity->role_desc[0] ?? "<i class='icon-dash text-danger'></i>"; ?>
                            </div>
                        </div>
                    </div>
                    <div class="media-right media-middle">
                        <ul class="icons-list">
                            <li>
                                <a href="<?= base_url(); ?>index" target="_blank">
                                    <i class="icon-earth"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <!-- Main -->
                    <li class="navigation-header"><span>مدیریت</span> <i class="icon-menu"></i></li>
                    <li>
                        <a href="<?= base_url(); ?>admin/index">
                            <i class="icon-home4"></i>
                            <span>داشبورد</span>
                        </a>
                    </li>

                    <?php if ($auth->isAllow('user', AUTH_ACCESS_READ) || $auth->isAllow('user', AUTH_ACCESS_CREATE)
                        || $auth->isAllow('user', AUTH_ACCESS_UPDATE)): ?>
                        <li>
                            <a>
                                <i class="icon-users4"></i>
                                <span>کاربران</span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('user', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/user/addUser">
                                            <i class="icon-user-plus"></i>
                                            <span>افزودن کاربر</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('user', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/user/manageAdminUser">
                                            <i class="icon-user-tie" style="font-size: 13px;"></i>
                                            <small>
                                                کاربران ادمین
                                            </small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/user/manageUser">
                                            <i class="icon-users" style="font-size: 13px;"></i>
                                            <small>
                                                مدیریت کاربران
                                            </small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/user/manageMarketer">
                                            <i class="icon-users" style="font-size: 13px;"></i>
                                            <small>
                                                مدیریت بازاریابان
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('user', AUTH_ACCESS_UPDATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/user/userUpgrade">
                                            <i class="icon-user-check"></i>
                                            <span>
                                                درخواست ارتقاء کاربران به بازاریاب
                                                <?php if ($count__promote_request ?? 0 != 0): ?>
                                                    <span class="label label-rounded bg-danger"><?= convertNumbersToPersian($count__promote_request); ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ) || $auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                        <li class="navigation-header"><span>نوشته‌ها</span> <i class="icon-menu"></i></li>
                    <?php endif; ?>
                    <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ) || $auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-tree6"></i>
                                <span>
                                دسته‌بندی
                            </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/blog/addCategory">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن دسته‌بندی
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/blog/manageCategory">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده دسته‌بندی‌ها
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ) || $auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-notebook"></i>
                                <span>
                                نوشته‌ها
                            </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/blog/addBlog">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن نوشته
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/blog/manageBlog">
                                            <i class="icon-pencil7" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده نوشته‌ها
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ) || $auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-archive"></i>
                                <span>
                                نوشته‌های ثابت
                            </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('blog', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/addStaticPage">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن نوشته‌ ثابت
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('blog', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/manageStaticPage">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده نوشته‌های ثابت
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('product', AUTH_ACCESS_READ) || $auth->isAllow('product', AUTH_ACCESS_CREATE) ||
                        $auth->isAllow('coupon', AUTH_ACCESS_READ) || $auth->isAllow('coupon', AUTH_ACCESS_CREATE) ||
                        $auth->isAllow('order', AUTH_ACCESS_READ) || $auth->isAllow('return_order', AUTH_ACCESS_READ)): ?>
                        <li class="navigation-header"><span>فروشگاه</span> <i class="icon-menu"></i></li>
                    <?php endif; ?>
                    <?php if ($auth->isAllow('product', AUTH_ACCESS_READ) || $auth->isAllow('product', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-tree6"></i>
                                <span>
                                دسته‌بندی
                            </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('product', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/shop/addCategory">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن دسته‌بندی
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('product', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/shop/manageCategory">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده دسته‌بندی‌ها
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('coupon', AUTH_ACCESS_READ) || $auth->isAllow('coupon', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-percent"></i>
                                <span>
                                کوپن تخفیف
                            </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('coupon', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/shop/addCoupon">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                ایجاد کوپن
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('coupon', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/shop/manageCoupon">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده کوپن‌ها
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('product', AUTH_ACCESS_READ) || $auth->isAllow('product', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-basket"></i>
                                <span>
                                محصولات
                            </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('product', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/shop/addProduct">
                                            <i class="icon-plus2" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن محصول
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('product', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/shop/manageProduct">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده محصولات
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('order', AUTH_ACCESS_READ)): ?>
                        <li>
                            <a href="<?= base_url(); ?>admin/shop/manageOrders">
                                <i class="icon-cart"></i>
                                <span>مدیریت سفارشات</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('return_order', AUTH_ACCESS_READ)): ?>
                        <li>
                            <a href="<?= base_url(); ?>admin/shop/manageReturnOrders">
                                <i class="icon-cancel-circle2"></i>
                                <span>
                                    درخواست‌های مرجوع سفارش
                                    <?php if ($count__return_order ?? 0 != 0): ?>
                                        <span class="label label-rounded bg-danger"><?= convertNumbersToPersian($count__return_order); ?></span>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- /main -->
                    <?php if ($auth->isAllow('report', AUTH_ACCESS_READ)): ?>
                        <!-- Report -->
                        <li class="navigation-header"><span>گزارش‌ها</span> <i class="icon-menu"></i></li>
                        <li>
                            <a href="<?= base_url(); ?>admin/report/orderReport">
                                <i class="icon-file-excel"></i>
                                <span>گزارش سفارشات</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(); ?>admin/report/walletReport">
                                <i class="icon-file-excel"></i>
                                <span>گزارش کیف پول</span>
                            </a>
                        </li>
                        <!-- Report -->
                    <?php endif; ?>

                    <li class="navigation-header"><span>فرعی</span> <i class="icon-menu"></i></li>
                    <?php if ($auth->isAllow('faq', AUTH_ACCESS_READ) || $auth->isAllow('faq', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-question3"></i>
                                <span>
                                    سؤالات متداول
                                </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('faq', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/addFAQ">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن سؤال
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('faq', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/manageFAQ">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده سؤالات
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('slider', AUTH_ACCESS_READ) || $auth->isAllow('slider', AUTH_ACCESS_CREATE)): ?>
                        <li>
                            <a>
                                <i class="icon-images2"></i>
                                <span>
                                    مدیریت اسلایدر
                                </span>
                            </a>
                            <ul>
                                <?php if ($auth->isAllow('slider', AUTH_ACCESS_CREATE)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/addSlide">
                                            <i class="icon-add-to-list" style="font-size: 13px;"></i>
                                            <small>
                                                افزودن اسلاید
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ($auth->isAllow('slider', AUTH_ACCESS_READ)): ?>
                                    <li>
                                        <a href="<?= base_url(); ?>admin/manageSlider">
                                            <i class="icon-table2" style="font-size: 13px;"></i>
                                            <small>
                                                مشاهده اسلایدها
                                            </small>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('contact', AUTH_ACCESS_READ)): ?>
                        <li>
                            <a href="<?= base_url(); ?>admin/manageContactUs">
                                <i class="icon-envelop"></i>
                                <span>
                                تماس با ما
                                <?php if ($count__contact ?? 0 != 0): ?>
                                    <span class="label label-rounded bg-danger"><?= convertNumbersToPersian($count__contact); ?></span>
                                <?php endif; ?>
                            </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('complaint', AUTH_ACCESS_READ)): ?>
                        <li>
                            <a href="<?= base_url(); ?>admin/manageComplaints">
                                <i class="icon-balance"></i>
                                <span>
                                شکایات
                                <?php if ($count__complaint ?? 0 != 0): ?>
                                    <span class="label label-rounded bg-danger"><?= convertNumbersToPersian($count__complaint); ?></span>
                                <?php endif; ?>
                            </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('file', AUTH_ACCESS_READ)): ?>
                        <li>
                            <a href="<?= base_url(); ?>admin/fileUpload">
                                <i class="icon-stack"></i>
                                <span>
                                مدیریت فایل‌ها
                            </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isAllow('setting', AUTH_ACCESS_READ)): ?>
                        <li>
                            <a href="<?= base_url(); ?>admin/setting">
                                <i class="icon-cogs"></i>
                                <span>
                                تنظیمات سایت
                            </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= base_url(); ?>admin/guide">
                            <i class="icon-help"></i>
                            <span>
                                راهنمای اندازه تصاویر
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>admin/logout">
                            <i class="icon-switch2"></i>
                            <span>
                                خروج
                            </span>
                        </a>
                    </li>
                    <!--                    فرعی-->
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->