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
                            <a href="<?= base_url('admin/index'); ?>">
                                <i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(); ?>admin/shop/manageReturnOrders">
                                نمایش سفارشات مرجوعی
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
                        <?php $this->view("templates/be/alert/error", ['errors' => $answer_errors ?? null]); ?>
                        <?php $this->view("templates/be/alert/success", ['success' => $answer_success ?? null]); ?>

                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">مشخصات سفارش</h6>
                                <div class="heading-elements">
                                    <?php if ($order['status'] != 4): ?>
                                        <a href="javascript:void(0);"
                                           id="closeReturnOrderBtn"
                                           class="btn btn-default btn-rounded heading-btn-group border-orange-600 text-orange-600 p-10"
                                           title="بستن" data-popup="tooltip">
                                            <input type="hidden" value="<?= $order['return_order_id']; ?>">
                                            <i class="icon-cross2" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a id="delReturnOrderBtn"
                                       class="btn btn-default btn-rounded heading-btn-group border-danger-600 text-danger-600 p-10"
                                       title="حذف" data-popup="tooltip">
                                        <input type="hidden" value="<?= $order['return_order_id']; ?>">
                                        <i class="icon-trash" aria-hidden="true"></i>
                                    </a>
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
                                            <strong>
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
                                                <?= $order['first_name'] . ' ' . $order['last_name']; ?>
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

                                <div class="row mt-20 mb-20"></div>

                                <div class="row">
                                    <div class="col-lg-12 pr-20 pl-20">
                                        <?php if (!empty($order['respond_at'])): ?>
                                            <h6 class="mb-15">
                                                تاریخ پاسخ:
                                                <span class="text-grey">
                                                    <?= jDateTime::date('j F Y در ساعت H:i', $order['respond_at']); ?>
                                                </span>
                                            </h6>
                                        <?php endif; ?>
                                        <?php if ($order['status'] != 4): ?>
                                            <form action="<?= base_url('admin/shop/viewReturnOrder/' . $param[0]); ?>"
                                                  method="post">
                                                <?= $form_token_answer; ?>

                                                <textarea rows="5" cols="12" class="form-control"
                                                          name="answer"
                                                          style="min-height: 100px; resize: vertical;"
                                                          placeholder="پاسخ"><?= $order['respond'] ?? ''; ?></textarea>
                                                <div class="text-right mt-20">
                                                    <button type="submit" class="btn btn-primary">
                                                        ذخیره پاسخ
                                                    </button>
                                                </div>
                                            </form>
                                        <?php else: ?>
                                            <textarea rows="5" cols="12" class="form-control"
                                                      name="answer" readonly
                                                      style="min-height: 100px; resize: vertical;"
                                                      placeholder="پاسخ"><?= $order['respond'] ?? ''; ?></textarea>
                                        <?php endif; ?>
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