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
                            <i class="icon-circle position-left"></i> <span
                                    class="text-semibold">مدیریت سفارشات</span>
                        </h5>
                    </div>
                </div>
                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url(); ?>admin/index">
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
                            <form action="<?= base_url('admin/report/orderReport'); ?>" method="post">
                                <?= $form_token; ?>

                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">جست و جو بر اساس:</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group col-lg-4">
                                            <label>کاربر:</label>
                                            <select class="select"
                                                    name="user">
                                                <option value="-1">انتخاب کنید</option>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?= $user['id']; ?>"
                                                        <?= set_value($filters['user'] ?? '', $user['id'], 'selected', '', '=='); ?>>
                                                        <?php if (!empty($user['first_name']) || !empty($user['last_name'])): ?>
                                                            <?= $user['username']; ?>
                                                            -
                                                            <?= $user['first_name'] . ' ' . $user['last_name']; ?>
                                                        <?php else: ?>
                                                            <?= $user['username']; ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>از تاریخ:</label>
                                            <input type="hidden" name="from_date" id="altDateField">
                                            <input type="text" class="form-control range-from"
                                                   placeholder="" readonly data-alt-field="#altDateField"
                                                   value="<?= date('Y/m/d H:i', (int)($filters['from_date'] ?? time())); ?>">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>تا تاریخ:</label>
                                            <input type="hidden" name="to_date" id="altDateField2">
                                            <input type="text" class="form-control range-to"
                                                   placeholder="تاریخ انقضا" readonly
                                                   data-alt-field="#altDateField2"
                                                   value="<?= date('Y/m/d H:i', (int)($filters['to_date'] ?? time())); ?>">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>وضعیت سفارش:</label>
                                            <select class="select"
                                                    name="send_status">
                                                <option value="-1">انتخاب کنید</option>
                                                <?php foreach ($status as $st): ?>
                                                    <option value="<?= $st['id']; ?>"
                                                        <?= set_value($filters['send_status'] ?? '', $st['id'], 'selected', '', '=='); ?>>
                                                        <?= $st['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>استان:</label>
                                            <input name="province" type="text"
                                                   class="form-control"
                                                   placeholder="نام استان"
                                                   value="<?= $filters['province'] ?? '' ?>">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>شهر:</label>
                                            <input name="city" type="text"
                                                   class="form-control"
                                                   placeholder="نام شهر"
                                                   value="<?= $filters['city'] ?? '' ?>">
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <div class="modal-footer mt-20">
                                                <?php if (($hasFilter ?? false) === true): ?>
                                                    <a href="<?= base_url('admin/shop/manageOrders'); ?>"
                                                       class="btn btn-warning">
                                                        <i class="icon-close2 position-left"
                                                           aria-hidden="true"></i>
                                                        حذف فیلتر
                                                    </a>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icon-search4 position-left"
                                                       aria-hidden="true"></i>
                                                    فیلتر کُن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">نمایش نتایج</h6>
                                <div class="heading-elements">
                                    <ul class="list-unstyled">
                                        <li>
                                            <form action="<?= base_url('admin/report/orderReport'); ?>"
                                                  method="post">
                                                <?= $form_token_export; ?>

                                                <button type="submit" name="excelExport"
                                                        class="btn btn-success">
                                                    <i class="icon-file-excel position-left"
                                                       aria-hidden="true"></i>
                                                    فایل اکسل
                                                </button>
                                            </form>
                                        </li>
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
                                                <td width="50px">
                                                    <?= convertNumbersToPersian($key + 1); ?>
                                                </td>
                                                <td>
                                                    <?= $order['order_code']; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($order['first_name']) || !empty($order['last_name'])): ?>
                                                        <?= $order['first_name'] . ' ' . $order['last_name']; ?>
                                                    <?php else: ?>
                                                        <i class="icon-minus2 text-danger"
                                                           aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= jDateTime::date('j F Y در ساعت H:i', $order['order_date']); ?>
                                                </td>
                                                <td>
                                                    <?php if (in_array($order['payment_method'], array_keys(PAYMENT_METHODS))): ?>
                                                        <?= PAYMENT_METHODS[$order['payment_method']]; ?>
                                                    <?php else: ?>
                                                        <i class="icon-minus2 text-danger"
                                                           aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= !empty($order['payment_date']) ? jDateTime::date('j F Y در ساعت H:i', $order['payment_date']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </td>
                                                <td>
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
                                                            <a href="<?= base_url('admin/shop/viewOrder/' . $order['id']); ?>"
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