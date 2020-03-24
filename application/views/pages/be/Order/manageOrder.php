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
                            <form action="<?= base_url(); ?>admin/blog/addCategory" method="post">
                                <!--                            --><? //= $data['form_token']; ?>
                                <div class="col-md-12">
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
                                            <?php if (isset($errors) && count($errors)): ?>
                                                <div class="alert alert-danger alert-styled-left alert-bordered
                                                 no-border-top no-border-right no-border-bottom">
                                                    <ul class="list-unstyled">
                                                        <?php foreach ($errors as $err): ?>
                                                            <li>
                                                                <i class="icon-dash" aria-hidden="true"></i>
                                                                <?= $err; ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php elseif (isset($success)): ?>
                                                <div class="alert alert-success alert-styled-left alert-bordered
                                                 no-border-top no-border-right no-border-bottom">
                                                    <p>
                                                        <?= $success; ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>کاربر:</label>
                                                <select class="select"
                                                        name="city">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value="1"> مرد</option>
                                                    <option value="2"> زن</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>از تاریخ:</label>
                                                <input type="hidden" name="expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly data-alt-field="#altDateField"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>تا تاریخ:</label>
                                                <input type="hidden" name="expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly data-alt-field="#altDateField"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>وضعیت سفارش:</label>
                                                <select class="select"
                                                        name="send_status">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value="1"> مرد</option>
                                                    <option value="2"> زن</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>شهر:</label>
                                                <input name="city" type="text" required
                                                       class="form-control"
                                                       placeholder="کد پستی ۱۰ رقمی"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <div class="modal-footer mt-20">
                                                    <button id="file-ok" type="button" class="btn btn-primary"
                                                            data-dismiss="modal">
                                                        <i class="icon-search4 position-left"
                                                           aria-hidden="true"></i>
                                                        فیلتر کُن
                                                    </button>
                                                </div>
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">سفارشات</h6>
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
                                                <!-- Load categories data -->
                                                <tr>
                                                    <td width="50px">
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td class="">
                                                        تومان
                                                    </td>
                                                    <td align="center">
                                                        <!--                                                        --><?php //if ($factor['payment_status'] == OWN_PAYMENT_STATUS_SUCCESSFUL): ?>
                                                        <!--                                                            <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
                                                        <!--                                                                 border-left-lg border-left-success">-->
                                                        <!--                                                                    موفق-->
                                                        <!--                                                                </span>-->
                                                        <!--                                                        --><?php //elseif ($factor['payment_status'] == OWN_PAYMENT_STATUS_FAILED): ?>
                                                        <!--                                                            <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
                                                        <!--                                                                 border-left-lg border-left-danger">-->
                                                        <!--                                                                    ناموفق-->
                                                        <!--                                                                </span>-->
                                                        <!--                                                        --><?php //elseif ($factor['payment_status'] == OWN_PAYMENT_STATUS_NOT_PAYED): ?>
                                                        <!--                                                            <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
                                                        <!--                                                                 border-left-lg border-left-grey-300">-->
                                                        <!--                                                                    در انتظار پرداخت-->
                                                        <!--                                                                </span>-->
                                                        <!--                                                        --><?php //elseif ($factor['payment_status'] == OWN_PAYMENT_STATUS_WAIT): ?>
                                                        <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-info">

                                                                </span>
                                                        <!--                                                        --><?php //else: ?>
                                                        <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-grey-800">
                                                                    نامشخص
                                                                </span>
                                                        <!--                                                        --><?php //endif; ?>
                                                    </td>
                                                    <td style="width: 115px;" class="text-center">
                                                        <ul class="icons-list">
                                                            <li class="text-black">
                                                                <a href="<?= base_url(); ?>admin/shop/viewOrder"
                                                                   title="مشاهده" data-popup="tooltip">
                                                                    <i class="icon-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
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