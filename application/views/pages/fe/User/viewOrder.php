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
                                جزئیات سفارش به کد
                                <?= $order['order_code']; ?>
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
                            <a href="<?= base_url(); ?>user/manageOrders">
                                سفارش‌های من
                            </a>
                        </li>
                        <li class="active">جزئیات سفارش</li>
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
                                                    وضعیت سفارش
                                                </strong>
                                            </div>
                                            <div class="col-md-12 text-center p-15 border border-grey-300 text-white <?= $order['send_status_badge']; ?>">
                                                <h6 class="no-margin">
                                                    <strong>
                                                        <?= $order['send_status_name']; ?>
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
                                                        <?= $order['order_code']; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300 text-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        نحوه پرداخت:
                                                    </small>
                                                    <strong>
                                                        <?php if (in_array($order['payment_method'], array_keys(PAYMENT_METHODS))): ?>
                                                            <?= PAYMENT_METHODS[$order['payment_method']]; ?>
                                                        <?php else: ?>
                                                            نامشخص
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300 text-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        تاریخ پرداخت فیش واریزی:
                                                    </small>
                                                    <strong>
                                                        <?php if ($order['payment_method'] == PAYMENT_METHOD_RECEIPT && !empty($order['receipt_date'])): ?>
                                                            <?= jDateTime::date('j F Y در ساعت H:i', $order['receipt_date']); ?>
                                                        <?php else: ?>
                                                            <i class="icon-dash text-danger" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300 text-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        شماره فیش واریزی:
                                                    </small>
                                                    <strong>
                                                        <?php if ($order['payment_method'] == PAYMENT_METHOD_RECEIPT && !empty($order['receipt_code'])): ?>
                                                            <?= $order['receipt_code']; ?>
                                                        <?php else: ?>
                                                            <i class="icon-dash text-danger" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300 alert-primary">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        کد رهگیری:
                                                    </small>
                                                    <strong>
                                                        <?php if (isset($order['payment_info']['payment_code'])): ?>
                                                            <?= convertNumbersToPersian($order['payment_info']['payment_code']); ?>
                                                        <?php else: ?>
                                                            <i class="icon-dash text-danger" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <?php
                                            $statusType = '';
                                            $statusText = 'نامشخص';
                                            ?>
                                            <?php if ($order['payment_status'] == OWN_PAYMENT_STATUS_SUCCESSFUL): ?>
                                                <?php
                                                $statusType = 'alert-success';
                                                ?>
                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_FAILED): ?>
                                                <?php
                                                $statusType = 'alert-danger';
                                                ?>
                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED): ?>
                                                <?php
                                                $statusType = 'alert-warning';
                                                ?>
                                            <?php elseif ($order['payment_status'] == OWN_PAYMENT_STATUS_WAIT): ?>
                                                <?php
                                                $statusType = 'alert-info';
                                                ?>
                                            <?php endif; ?>
                                            <?php if (in_array($order['payment_status'], array_keys(OWN_PAYMENT_STATUSES))): ?>
                                                <?php
                                                $statusText = OWN_PAYMENT_STATUSES[$order['payment_status']];
                                                ?>
                                            <?php endif; ?>
                                            <div class="col-md-12 text-center p-15 border border-grey-300 <?= $statusType; ?>">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        وضعیت پرداخت :
                                                    </small>
                                                    <strong>
                                                        <?= $statusText; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        مبلغ کل :
                                                    </small>
                                                    <strong>
                                                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['amount'], true))); ?>
                                                        تومان
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        مبلغ تخفیف :
                                                    </small>
                                                    <strong>
                                                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['discount_price'], true))); ?>
                                                        تومان
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        عنوان کد تخفیف :
                                                    </small>
                                                    <strong>
                                                        <?php if (!empty($order['coupon_title'])): ?>
                                                            <?= $order['coupon_title']; ?>
                                                        <?php else: ?>
                                                            <i class="icon-dash text-danger" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        مبلغ کد تخفیف :
                                                    </small>
                                                    <strong>
                                                        <?php if (!empty($order['coupon_amount'])): ?>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['coupon_amount'], true))); ?>
                                                            تومان
                                                        <?php else: ?>
                                                            <i class="icon-dash text-danger" aria-hidden="true"></i>
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        هزینه ارسال :
                                                    </small>
                                                    <strong>
                                                        <?php if ($order['shipping_price'] != 0): ?>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['shipping_price'], true))); ?>
                                                            تومان
                                                        <?php else: ?>
                                                            رایگان
                                                        <?php endif; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <!--                                            <div class="col-md-6 text-center p-10 border-grey-300">-->
                                            <!--                                                <form action="-->
                                            <? //= base_url('user/viewOrder/' . $order['id']); ?><!--"-->
                                            <!--                                                      method="post">-->
                                            <!--                                                    --><? //= $form_token_pdf; ?>
                                            <!---->
                                            <!--                                                    <h6 class="no-margin">-->
                                            <!--                                                        <label class="no-margin">-->
                                            <!--                                                            <button type="submit" class="btn btn-danger btn-sm no-margin">-->
                                            <!--                                                                <i class="icon-file-pdf position-left" aria-hidden="true">-->
                                            <!--                                                                </i>-->
                                            <!--                                                                چاپ فاکتور-->
                                            <!--                                                            </button>-->
                                            <!--                                                        </label>-->
                                            <!--                                                    </h6>-->
                                            <!--                                                </form>-->
                                            <!--                                            </div>-->
                                            <div class="col-md-12 text-center p-15 border border-grey-300"
                                                 style="background-color: #e7e7e7;">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        مبلغ قابل پرداخت :
                                                    </small>
                                                    <strong>
                                                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['final_price'], true))); ?>
                                                        تومان
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
                                        <div class="row mt-20 mb-20"></div>
                                        <div class="row mb-20">
                                            <div class="col-sm-12 mb-5 text-teal">
                                                <strong>
                                                    <i class="icon-circle-left2 mr-5"></i>
                                                    مشخصات گیرنده سفارش
                                                </strong>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        شماره تماس :
                                                    </small>
                                                    <strong>
                                                        <?= convertNumbersToPersian($order['receiver_phone']); ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        استان :
                                                    </small>
                                                    <strong>
                                                        <?= $order['province']; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        شهر :
                                                    </small>
                                                    <strong>
                                                        <?= $order['city']; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-6 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        کد پستی :
                                                    </small>
                                                    <strong>
                                                        <?= convertNumbersToPersian($order['postal_code']); ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                            <div class="col-md-12 text-center p-15 border border-grey-300">
                                                <h6 class="no-margin">
                                                    <small class="text-grey-800">
                                                        آدرس :
                                                    </small>
                                                    <strong>
                                                        <?= $order['address']; ?>
                                                    </strong>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">محصولات خریداری شده</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr class="bg-primary">
                                                    <th>#</th>
                                                    <th>تصویر</th>
                                                    <th>نام محصول</th>
                                                    <th>تعداد</th>
                                                    <th>قیمت پایه</th>
                                                    <th>مبلغ کل</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($order['products'] as $key => $item): ?>
                                                    <tr>
                                                        <td width="50px" data-order="<?= $key + 1; ?>">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td width="120px">
                                                            <?php if (file_exists($item['image'])): ?>
                                                                <a data-url="<?= base_url($item['image']); ?>"
                                                                   data-popup="lightbox">
                                                                    <img src=""
                                                                         data-src="<?= base_url($item['image']); ?>"
                                                                         alt="تصویر محصول"
                                                                         class="img-rounded img-preview lazy img-responsive">
                                                                </a>
                                                            <?php else: ?>
                                                                <i class="icon-minus2 text-danger"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?= $item['title'] ?: '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                        </td>
                                                        <td>
                                                            <?= convertNumbersToPersian($item['product_count']); ?>
                                                        </td>
                                                        <td>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['product_unit_price'], true))); ?>
                                                            تومان
                                                        </td>
                                                        <td>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['product_price'], true))); ?>
                                                            تومان
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