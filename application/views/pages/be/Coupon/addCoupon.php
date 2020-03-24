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
<!--                            --><?//= $data['form_token']; ?>

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

                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>کد کوپن:</label>
                                                <input name="code" type="text" class="form-control"
                                                       placeholder="اجباری" maxlength="20"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <span class="text-danger">*</span>
                                                <label>عنوان:</label>
                                                <input name="title" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-7">
                                                <span class="text-danger">*</span>
                                                <label>قیمت:</label>
                                                <input name="amount" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-5">
                                                <span class="text-danger">*</span>
                                                <label>انتخاب واحد:</label>
                                                <select class="select-no-search" name="unit">
                                                    <option value="1">
                                                        تومان
                                                    </option>
                                                    <option value="2">
                                                        درصد
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>حداقل قیمت اعمال تخفیف:</label>
                                                <input name="min-price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>حداکثر قیمت اعمال تخفیف:</label>
                                                <input name="max-price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>تاریخ انقضا:</label>
                                                <input type="hidden" name="expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly data-alt-field="#altDateField"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-12 text-right">
                                                <label for="coStatus">وضعیت فعالسازی:</label>
                                                <input type="checkbox" name="status" id="coStatus"
                                                       class="switchery" />
                                            </div>


                                            <div class="text-right col-md-12 mt-20">
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