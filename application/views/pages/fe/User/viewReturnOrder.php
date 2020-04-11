<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- Main navbar -->
<?php $this->view("templates/fe/user/mainnavbar", $data); ?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <input type="hidden" id="BASE_URL" value="<?= base_url(); ?>">

        <!-- Main sidebar -->
        <?php $this->view("templates/fe/user/mainsidebar", $data); ?>
        <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Page header -->
            <div class="page-header page-header-default"
                 style="border-top: 1px solid #ddd; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                <div class="page-header-content border-bottom border-bottom-success">
                    <div class="page-title">
                        <h5>
                            <i class="icon-circle position-left"></i>
                            <span class="text-semibold">
                                مشاهده سفارش مرجوعی
                            </span>
                        </h5>
                    </div>
                </div>
                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url('user/dashboard'); ?>">
                                <i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(); ?>user/manageReturnOrder">
                                نمایش درخواست‌های مرجوعی
                            </a>
                        </li>
                        <li class="active">جزئیات</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">مشخصات سفارش</h6>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row mb-20">
                                    <div class="col-lg-12 mb-5 text-teal">
                                        <strong>
                                            <i class="icon-circle-left2 mr-5"></i>
                                            شماره سفارش
                                        </strong>
                                    </div>
                                    <div class="col-md-12 text-center p-15 border border-grey-300">
                                        <h6 class="no-margin">
                                            <strong>
                                                <?= $order['order_code']; ?>
                                            </strong>
                                        </h6>
                                    </div>
                                </div>

                                <div class="row mt-20 mb-20"></div>

                                <div class="row mb-20">
                                    <div class="col-sm-12 mb-5 text-teal">
                                        <strong>
                                            <i class="icon-circle-left2 mr-5"></i>
                                            مشخصات پرداخت
                                        </strong>
                                    </div>
                                    <div class="col-md-6 text-center p-15 border border-grey-300 text-primary">
                                        <h6 class="no-margin">
                                            <small class="text-grey-800">
                                                تاریخ پرداخت:
                                            </small>
                                            <strong>
                                                <?= jDateTime::date('j F Y در ساعت H:i', $order['payment_date']); ?>
                                            </strong>
                                        </h6>
                                    </div>
                                    <div class="col-md-12 text-center p-15 border border-grey-300 alert-primary">
                                        <h6 class="no-margin">
                                            <small class="text-grey-800">
                                                دلیل درخواست مرجوعی و توضیحات خریدار:
                                            </small>
                                            <strong class="display-block mt-10">
                                                <?= $order['description']; ?>
                                            </strong>
                                        </h6>
                                    </div>
                                </div>

                                <div class="row mt-20 mb-20"></div>

                                <div class="row mb-20">
                                    <div class="col-sm-12 mb-5 text-teal">
                                        <strong>
                                            <i class="icon-circle-left2 mr-5"></i>
                                            مشخصات ثبت کننده سفارش
                                        </strong>
                                    </div>
                                    <div class="col-md-6 text-center p-15 border border-grey-300">
                                        <h6 class="no-margin">
                                            <small class="text-grey-800">
                                                نام و نام خانوادگی :
                                            </small>
                                            <strong>
                                                <?php if (!empty($order['first_name']) || !empty($order['last_name'])): ?>
                                                    <?= $order['first_name'] . ' ' . $order['last_name']; ?>
                                                <?php else: ?>
                                                    <i class="icon-minus2 text-danger"
                                                       aria-hidden="true"></i>
                                                <?php endif; ?>
                                            </strong>
                                        </h6>
                                    </div>
                                    <div class="col-md-6 text-center p-15 border border-grey-300">
                                        <h6 class="no-margin">
                                            <small class="text-grey-800">
                                                شماره موبایل :
                                            </small>
                                            <strong>
                                                <?= convertNumbersToPersian($order['mobile']); ?>
                                            </strong>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /form centered -->
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