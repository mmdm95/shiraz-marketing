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
                            <a href="">
                                <i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(); ?>admin/shop/viewReturnOrder">
                                نمایش سفارشات
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
                        <div class="row">
                            <div class="col-sm-12">
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
                                            <div class="col-md-12 text-center p-15 border border-grey-300 text-white">
                                                <h6 class="no-margin">
                                                    <strong>

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
                                                        کد فاکتور:
                                                    </small>
                                                    <strong>

                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300 text-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        تاریخ پرداخت:
                                                    </small>
                                                    <strong>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-12 text-center p-15 border border-grey-300 alert-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                    دلیل درخواست مرجوعی و توضیحات خریدار:
                                                    </small>
                                                    <strong>

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

                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        شماره موبایل :
                                                    </small>
                                                    <strong>

                                                    </strong>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row mt-20 mb-20"></div>
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