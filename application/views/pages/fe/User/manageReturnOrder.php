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
                            <i class="icon-circle position-left"></i> <span
                                    class="text-semibold">سفارشات مرجوعی</span>
                        </h5>
                    </div>
                </div>
                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url(); ?>user/dashboard">
                                <i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li class="active">سفارشات مرجوعی</li>
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
                                        <h6 class="panel-title">لیست درخواست‌های مرجوعی</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered datatable-highlight">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>کد سفارش</th>
                                                    <th>تاریخ درخواست</th>
                                                    <th>شماره فاکتور</th>
                                                    <th>نحوه پرداخت</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- Load categories data -->
                                                    <tr>
                                                        <td width="50px">
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td align="center">
<!--                                                            --><?php //if ($factor['payment_status'] == OWN_PAYMENT_STATUS_SUCCESSFUL): ?>
<!--                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
<!--                                                                 border-left-lg border-left-success">-->
<!--                                                                    موفق-->
<!--                                                                </span>-->
<!--                                                            --><?php //elseif ($factor['payment_status'] == OWN_PAYMENT_STATUS_FAILED): ?>
<!--                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
<!--                                                                 border-left-lg border-left-danger">-->
<!--                                                                    ناموفق-->
<!--                                                                </span>-->
<!--                                                            --><?php //elseif ($factor['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED): ?>
<!--                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
<!--                                                                 border-left-lg border-left-grey-300">-->
<!--                                                                    در انتظار پرداخت-->
<!--                                                                </span>-->
<!--                                                            --><?php //elseif ($factor['payment_status'] == OWN_PAYMENT_STATUS_WAIT): ?>
<!--                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
<!--                                                                 border-left-lg border-left-info">-->
<!--                                                                    --><?//= $factor['payment_title']; ?>
<!--                                                                </span>-->
<!--                                                            --><?php //else: ?>
<!--                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
<!--                                                                 border-left-lg border-left-grey-800">-->
<!--                                                                    نامشخص-->
<!--                                                                </span>-->
<!--                                                            --><?php //endif; ?>
                                                        </td>
                                                        <td style="width: 115px;" class="text-center">
                                                            <ul class="icons-list">
                                                                <li class="text-black">
                                                                    <a href="<?= base_url(); ?>user/viewReturnOrder/"
                                                                       title="مشاهده" data-popup="tooltip">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="text-danger-600">
                                                                    <a class="deleteFactorBtn"
                                                                       title="حذف" data-popup="tooltip">
                                                                        <input type="hidden"
                                                                               value="">
                                                                        <i class="icon-trash"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
<!--                                                --><?php //endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
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