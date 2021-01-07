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
                        <li class="active">کیف پول</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="<?= base_url('admin/report/walletReport'); ?>" method="post">
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
                                        <label>نحوه پرداخت:</label>
                                        <select class="select"
                                                name="deposit_type">
                                            <option value="-1">انتخاب کنید</option>
                                            <option value="<?= DEPOSIT_TYPE_SELF; ?>">پرداخت توسط خود شخص</option>
                                            <option value="<?= DEPOSIT_TYPE_OTHER; ?>">پرداخت توسط شخص دیگر</option>
                                            <option value="<?= DEPOSIT_TYPE_REWARD; ?>">پاداش خرید</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <div class="modal-footer mt-20">
                                            <?php if (($hasFilter ?? false) === true): ?>
                                                <a href="<?= base_url('admin/report/walletReport'); ?>"
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">نمایش نتایج</h6>
                                <div class="heading-elements">
                                    <ul class="list-unstyled">
                                        <li>
                                            <form action="<?= base_url('admin/report/walletReport'); ?>"
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
                                            <th>کاربر</th>
                                            <th>واریز کننده</th>
                                            <th>مبلغ تراکنش</th>
                                            <th>توضیح تراکنش</th>
                                            <th>تاریخ تراکنش</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($transactions as $key => $transaction): ?>
                                            <tr>
                                                <td width="50px" data-order="<?= $key + 1; ?>">
                                                    <?= convertNumbersToPersian($key + 1); ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($transaction['first_name']) || !empty($transaction['last_name'])): ?>
                                                        <?= $transaction['first_name'] . ' ' . $transaction['last_name']; ?>
                                                        -
                                                    <?php endif; ?>
                                                    <?= convertNumbersToPersian($transaction['mobile']) ?? ''; ?>
                                                </td>
                                                <td>
                                                    <?php if ($transaction['deposit_type'] == DEPOSIT_TYPE_OTHER): ?>
                                                        <?php if (!empty($transaction['payer_name'])): ?>
                                                            <?= $transaction['payer_name']; ?>
                                                            -
                                                        <?php endif; ?>
                                                        <?= convertNumbersToPersian($transaction['payer_mobile']) ?? ''; ?>
                                                    <?php elseif ($transaction['deposit_type'] == DEPOSIT_TYPE_SELF): ?>
                                                        کاربر
                                                    <?php elseif ($transaction['deposit_type'] == DEPOSIT_TYPE_REWARD): ?>
                                                        پاداش خرید
                                                    <?php else: ?>
                                                        <i class="icon-minus2 text-danger"
                                                           aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= convertNumbersToPersian(number_format($transaction['deposit_price'])); ?>
                                                    تومان
                                                </td>
                                                <td>
                                                    <?= $transaction['description'] ?: '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </td>
                                                <td data-order="<?= $transaction['deposit_date']; ?>">
                                                    <?= jDateTime::date('j F Y در ساعت H:i', $transaction['deposit_date']); ?>
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

                <!-- Footer -->
                <?php $this->view("templates/be/copyright", $data); ?>
                <!-- /footer -->
            </div>
        </div>
        <!-- /content area -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->
<!-- /page container -->