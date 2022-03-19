<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- Main sidebar -->
<div class="sidebar sidebar-default sidebar-main">
    <div class="sidebar-content">
        <!-- User menu -->
        <input type="hidden" id="PLATFORM" value="<?= PLATFORM; ?>">

        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="<?= base_url() . 'user/editUser'; ?>"
                       class="media-left">
                        <?= $this->view('templates/fe/parser/image-placeholder', [
                            'url' => base_url($identity->image),
                            'alt' => '',
                            'class' => 'img-fit',
                        ], true); ?>
                    </a>
                    <div class="media-body">
                        <a href="<?= base_url() . 'user/editUser'; ?>"
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
                        <a href="<?= base_url(); ?>user/dashboard">
                            <i class="icon-home4"></i>
                            <span>داشبورد</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>user/editUser">
                            <i class="icon-pencil7"></i>
                            <span>ویرایش حساب کاربری</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>user/changePassword">
                            <i class="icon-key"></i>
                            <span>تغییر رمز عبور</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>user/userProfile">
                            <i class="icon-eye"></i>
                            <span>مشاهده اطلاعات</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>user/userDeposit">
                            <i class="icon-wallet"></i>
                            <span>کیف پول</span>
                        </a>
                    </li>
                    <li class="navigation-header"><span>فروشگاه</span> <i class="icon-menu"></i></li>
                    <li>
                        <a href="<?= base_url(); ?>user/manageOrders">
                            <i class="icon-cart"></i>
                            <span>سفارش‌های من</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>user/returnOrder">
                            <i class="icon-cancel-square"></i>
                            <span>درخواست مرجوع سفارش</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url(); ?>user/manageReturnOrder">
                            <i class="icon-cancel-circle2"></i>
                            <span>درخواست‌های مرجوع سفارش</span>
                        </a>
                    </li>
                    <!-- /main -->
                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->