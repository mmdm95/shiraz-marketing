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
                                    class="text-semibold">کیف پول من</span>
                        </h5>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url(); ?>user/dashboard"><i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li class="active">کیف پول من</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">شارژ کیف پول</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php $this->view("templates/be/alert/error", ['errors' => $deposit_errors ?? null]); ?>
                                        <?php $this->view("templates/be/alert/success", ['success' => $deposit_success ?? null]); ?>

                                        <form action="<?= base_url('user/userDeposit'); ?>" method="post">
                                            <?= $form_token_deposit; ?>

                                            <div class="form-group col-lg-12">
                                                <span class="text-danger">*</span>
                                                <label>مبلغ:</label>
                                                <input name="price" type="text" required
                                                       class="form-control" placeholder="به تومان"
                                                       value="<?= $dValues['price'] ?? ''; ?>">
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <button type="submit"
                                                        class="btn btn-success submit-button">
                                                    <i class="icon-coin-dollar position-left"></i>
                                                    افزایش اعتبار
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">دید کلی</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row mt-20 mb-20">
                                            <div class="col-md-6 text-center p-15 border border-grey-300 alert-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        واریزی:
                                                    </small>
                                                    <strong>
                                                        <?php if ($user['total_income'] != 0): ?>
                                                            <?= convertNumbersToPersian(number_format($user['total_income'])); ?>
                                                            تومان
                                                        <?php else: ?>
                                                            ندارد
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300 alert-danger">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        برداشت:
                                                    </small>
                                                    <strong>
                                                        <?php if ($user['total_outcome'] != 0): ?>
                                                            <?= convertNumbersToPersian(number_format($user['total_outcome'])); ?>
                                                            تومان
                                                        <?php else: ?>
                                                            ندارد
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-12 text-center p-15 border border-grey-300"
                                                 style="background-color: #e7e7e7;">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        موجودی:
                                                    </small>
                                                    <strong>
                                                        <?= convertNumbersToPersian(number_format($user['balance'])); ?>
                                                        تومان
                                                    </strong>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">لیست برداشت</h6>
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
                                                    <th>شماره فاکتور</th>
                                                    <th>مبلغ برداشت</th>
                                                    <th>تاریخ برداشت</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($user['transactions']['outcome'] as $key => $transaction): ?>
                                                    <tr>
                                                        <td width="50px" data-order="<?= $key + 1; ?>">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($transaction['order_id'])): ?>
                                                                <a href="<?= base_url('user/viewOrder/' . $transaction['order_id']); ?>">
                                                                    <?= $transaction['order_code'] ?>
                                                                </a>
                                                            <?php else: ?>
                                                                <?= $transaction['order_code'] ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($transaction['price'], true))) ?>
                                                            تومان
                                                        </td>
                                                        <td data-order="<?= $transaction['payment_date']; ?>">
                                                            <?= jDateTime::date('j F Y در ساعت H:i', $transaction['payment_date']); ?>
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">لیست واریزی</h6>
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
                                                    <th>واریز کننده</th>
                                                    <th>مبلغ تراکنش</th>
                                                    <th>نوع و توضیح تراکنش</th>
                                                    <th>تاریخ تراکنش</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($user['transactions']['income'] as $key => $transaction): ?>
                                                    <tr>
                                                        <td width="50px" data-order="<?= $key + 1; ?>">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($transaction['deposit_type'] == DEPOSIT_TYPE_OTHER): ?>
                                                                <?php if (!empty($transaction['payer_name'])): ?>
                                                                    <?= $transaction['payer_name'] ?? 'نامشخص'; ?>
                                                                <?php endif; ?>
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
                    </div>
                </div>
                <!-- Footer -->
                <?php $this->view("templates/be/copyright", $data); ?>
                <!-- /footer -->
            </div>
            <!-- /main content -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->