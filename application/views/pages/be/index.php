<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- Main navbar -->
<?php $this->view("templates/be/mainnavbar", $data); ?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <input type="hidden" id="BASE_URL" value="<?= base_url(); ?>">
        <!-- Main sidebar -->
        <?php $this->view("templates/be/mainsidebar", $data); ?>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <label class="label label-default border-left border-left-xlg border-left-green-800 bg-green-600 p-10 mb-15">
                                <h6 class="no-margin">
                                    تاریخ امروز :
                                    <?= $todayDate; ?>
                                </h6>
                            </label>
                            <label class="mb-15"
                                   title="پیام‌های خوانده نشده" data-popup="tooltip" data-placement="bottom">
                                <a href="<?= base_url(); ?>admin/manageContactUs"
                                   class="text-white p-10 label bg-orange-600">
                                    <h6 class="no-margin">
                                        <i class="icon-envelop5 position-left" aria-hidden="true"></i>
                                        <?php if ($unreadContacts != 0): ?>
                                            <?= convertNumbersToPersian($unreadContacts); ?>
                                            عدد
                                        <?php else: ?>
                                            ندارید
                                        <?php endif; ?>
                                    </h6>
                                </a>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div>
                                    <h5 class="mb-15 text-grey-400">
                                        <i class="icon-circle-left2"></i>
                                        دسترسی سریع
                                    </h5>
                                </div>
                                <div class="pt-15 text-center my-main-page">
                                    <ul class="list-unstyled list-inline row">
                                        <?php if ($auth->isAllow('user', AUTH_ACCESS_READ)): ?>
                                            <li class="col-xs-6 col-sm-4 col-md-3">
                                                <a href="<?= base_url(); ?>admin/user/manageUser"
                                                   style="min-width: 130px;"
                                                   class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                    <i class="icon-users4" aria-hidden="true"></i>
                                                    <span>
                                                    مدیریت کاربران
                                                </span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>admin/shop/manageOrders"
                                               style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-basket" aria-hidden="true"></i>
                                                <span>
                                                    مشاهده سفارش‌ها
                                                </span>
                                            </a>
                                        </li>
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>admin/manageContactUs" style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-envelop5" aria-hidden="true"></i>
                                                <span>
                                                    تماس با ما
                                                </span>
                                            </a>
                                        </li>
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>admin/fileUpload" style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-stack" aria-hidden="true"></i>
                                                <span>
                                                    مدیریت فایل
                                                </span>
                                            </a>
                                        </li>
                                        <?php if ($auth->isAllow('setting', AUTH_ACCESS_READ)): ?>
                                            <li class="col-xs-6 col-sm-4 col-md-3">
                                                <a href="<?= base_url(); ?>admin/setting" style="min-width: 130px;"
                                                   class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                    <i class="icon-cogs" aria-hidden="true"></i>
                                                    <span>
                                                    تنظیمات
                                                </span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>

                        <!-- Quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-12 mb-10">
                                <h5 class="mb-15 text-grey-400">
                                    <i class="icon-circle-left2"></i>
                                    دید کلی
                                </h5>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="panel text-indigo-400 border-top-lg border-top-indigo-400">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian($staticPageCount); ?>
                                                </h3>
                                                نوشته‌ ثابت
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="panel text-indigo-800 border-top-lg border-top-indigo-800">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian($categoryCount); ?>
                                                </h3>
                                                دسته‌بندی
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <?php if (in_array(AUTH_ROLE_SUPER_USER, $identity->role_id) ||
                                        in_array(AUTH_ROLE_ADMIN, $identity->role_id)): ?>
                                        <div class="col-sm-6 col-md-3 col-lg-3">
                                            <div class="panel text-pink-400 border-top-lg border-top-pink-400">
                                                <div class="panel-body">
                                                    <h3 class="no-margin">
                                                        <?= convertNumbersToPersian($userAllCount); ?>
                                                    </h3>
                                                    کاربر
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 col-lg-3">
                                            <div class="panel text-pink-400 border-top-lg border-top-pink-400">
                                                <div class="panel-body">
                                                    <h3 class="no-margin">
                                                        <?= convertNumbersToPersian($userCount); ?>
                                                    </h3>
                                                    کاربر عادی
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 col-lg-3">
                                            <div class="panel text-pink-400 border-top-lg border-top-pink-400">
                                                <div class="panel-body">
                                                    <h3 class="no-margin">
                                                        <?= convertNumbersToPersian($marketerCount); ?>
                                                    </h3>
                                                    کاربر بازاریاب
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-3 col-lg-3">
                                            <div class="panel text-pink-400 border-top-lg border-top-pink-400">
                                                <div class="panel-body">
                                                    <h3 class="no-margin">
                                                        <?= convertNumbersToPersian($userAllDeactiveCount); ?>
                                                    </h3>
                                                    کاربر غیرفعال
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="panel text-teal-400 border-top-lg border-top-teal-400">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian($serviceCount); ?>
                                                </h3>
                                                تعداد خدمات
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="panel text-teal-800 border-top-lg border-top-teal-600">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian($productCount); ?>
                                                </h3>
                                                تعداد کالا
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="panel text-indigo-400 border-top-lg border-top-indigo-400">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($orderCount, true))); ?>
                                                </h3>
                                                کل سفارش‌ها
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="panel text-indigo-600 border-top-lg border-top-indigo-600">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($todayOrderCount, true))); ?>
                                                </h3>
                                                سفارش‌های امروز
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="panel text-indigo-800 border-top-lg border-top-indigo-800">
                                            <div class="panel-body">
                                                <h3 class="no-margin">
                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian((int)$totalPaid, true))); ?>
                                                    تومان
                                                </h3>
                                                پرداختی‌ها تا کنون
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <?php foreach ($status as $k => $st): ?>
                                        <div class="col-sm-6 col-md-3 col-lg-3">
                                            <a href="<?= base_url('admin/report/orderReport/send_status/' . $st[0]['id']); ?>"
                                               class="panel display-block text-white <?= $st[0]['badge']; ?>">
                                                <div class="panel-body">
                                                    <h3 class="no-margin">
                                                        <?= convertNumbersToPersian(${'statusCount' . $k} ?? ''); ?>
                                                    </h3>
                                                    <?= $st[0]['name']; ?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /quick stats boxes -->
                    </div>
                </div>
                <!-- /dashboard content -->

                <!-- Footer -->
                <?php $this->view("templates/be/copyright", $data); ?>
                <!-- /footer -->
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->