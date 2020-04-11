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
                                    class="text-semibold">افزودن کوپن تخفیف</span>
                        </h5>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url(); ?>admin/index"><i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url(); ?>admin/shop/manageCoupon">
                                کوپن‌های تخفیف
                            </a>
                        </li>
                        <li class="active">افزودن کوپن تخفیف</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url(); ?>admin/shop/addCoupon" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">مشخصات کوپن تخفیف</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>

                                            <div class="form-group col-lg-3">
                                                <span class="text-danger">*</span>
                                                <label>کد کوپن:</label>
                                                <input name="code" type="text" class="form-control"
                                                       placeholder="اجباری" maxlength="20"
                                                       value="<?= $coValues['code'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <span class="text-danger">*</span>
                                                <label>عنوان:</label>
                                                <input name="title" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="<?= $coValues['title'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>قیمت (تومان):</label>
                                                <input name="price" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="<?= $coValues['price'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>حداقل قیمت اعمال تخفیف (تومان):</label>
                                                <input name="min_price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="<?= $coValues['min_price'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>حداکثر قیمت اعمال تخفیف (تومان):</label>
                                                <input name="max_price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="<?= $coValues['max_price'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>تاریخ انقضا:</label>
                                                <input type="hidden" name="expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly
                                                       data-alt-field="#altDateField" data-time="true"
                                                       value="<?= date('Y/m/d H:i', (int)$coValues['expire'] ?? time()); ?>">
                                            </div>
                                            <div class="form-group col-lg-12 text-right">
                                                <label for="coStatus">وضعیت فعالسازی:</label>
                                                <input type="checkbox" name="publish" id="coStatus"
                                                       class="switchery" <?= set_value($coValues['publish'] ?? '', 'off', '', 'checked', '=='); ?> />
                                            </div>

                                            <div class="text-right col-md-12 mt-20">
                                                <a href="<?= base_url('admin/shop/manageCoupon'); ?>"
                                                   class="btn btn-default mr-5">
                                                    بازگشت
                                                </a>
                                                <button type="submit" class="btn btn-primary submit-button">
                                                    ذخیره
                                                    <i class="icon-arrow-left12 position-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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