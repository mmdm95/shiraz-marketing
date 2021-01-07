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
                                    class="text-semibold">مدیریت سفارشات</span>
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
                        <li class="active">سفارشات</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">سفارشات من</h6>
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
                                                    <th>خریدار</th>
                                                    <th>تاریخ ثبت سفارش</th>
                                                    <th>نحوه پرداخت</th>
                                                    <th>تاریخ پرداخت</th>
                                                    <th>مبلغ قابل پرداخت</th>
                                                    <th>وضعیت پرداخت</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($orders as $key => $order): ?>
                                                    <tr>
                                                        <td width="50px" data-order="<?= $key + 1; ?>">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td>
                                                            <?= $order['order_code']; ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($order['first_name']) || !empty($order['last_name'])): ?>
                                                                <?= $order['first_name'] . ' ' . $order['last_name']; ?>
                                                            <?php else: ?>
                                                                <?= $order['mobile']; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?= jDateTime::date('j F Y در ساعت H:i', $order['order_date']); ?>
                                                        </td>
                                                        <td>
                                                            <?= PAYMENT_METHODS[$order['payment_method']] ?: 'نامشخص'; ?>
                                                        </td>
                                                        <td data-order="<?= $order['payment_date']; ?>">
                                                            <?= !empty($order['payment_date']) ? jDateTime::date('j F Y در ساعت H:i', $order['payment_date']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                        </td>
                                                        <td class="info">
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['final_price'], true))); ?>
                                                            تومان
                                                        </td>
                                                        <td align="center">
                                                            <?php if ($order['payment_status'] == OWN_PAYMENT_STATUS_SUCCESSFUL): ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                border-left-lg border-left-success">
                                                                    <?= OWN_PAYMENT_STATUSES[OWN_PAYMENT_STATUS_SUCCESSFUL]; ?>
                                                                </span>
                                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_FAILED): ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-danger">
                                                                    <?= OWN_PAYMENT_STATUSES[OWN_PAYMENT_STATUS_FAILED]; ?>
                                                                </span>
                                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED): ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-danger">
                                                                    <?= OWN_PAYMENT_STATUSES[OWN_PAYMENT_STATUS_NOT_PAYED]; ?>
                                                                </span>
                                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_WAIT): ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-orange-400">
                                                                    <?= OWN_PAYMENT_STATUSES[OWN_PAYMENT_STATUS_WAIT]; ?>
                                                                </span>
                                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_WAIT_VERIFY): ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-orange-400">
                                                                    <?= OWN_PAYMENT_STATUSES[OWN_PAYMENT_STATUS_WAIT_VERIFY]; ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-grey-800">
                                                                    نامشخص
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="width: 115px;" class="text-center">
                                                            <ul class="icons-list">
                                                                <li class="text-black">
                                                                    <a href="<?= base_url('user/viewOrder/' . $order['id']); ?>"
                                                                       title="مشاهده" data-popup="tooltip">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php $this->view("templates/be/copyright", $data); ?>
            <!-- /footer -->
        </div>
        <!-- /content area -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
<!-- /page container -->