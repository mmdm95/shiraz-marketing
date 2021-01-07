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
                                    class="text-semibold">ویرایش دسته‌ای محصول</span>
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
                            <a href="<?= base_url(); ?>admin/shop/manageProduct">
                                محصولات
                            </a>
                        </li>
                        <li class="active">ویرایش دسته‌ای محصول</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url('admin/shop/multiEditProduct/' . implode('/', $param)); ?>"
                              method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-lg-10">
                                    <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                    <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>
                                </div>

                                <div class="col-lg-10">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">مشخصات محصول</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="alert alert-info fade in alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
                                                <ul>
                                                    <li>
                                                        در صورت خالی گذاشتن فیلدهای نوشتاری، مقادیر آنها تغییر نخواهد کرد.
                                                    </li>
                                                    <li>
                                                        در صورتی میخواهید زمان تخفیف تغییر نکند، تیک مربوط به عدم تغییر زمان تغییر را فعال نمایید.
                                                    </li>
                                                    <li>
                                                        در صورتی میخواهید وضعیت انتشار تغییر نکند، تیک مربوط به عدم تغییر وضعیت انتشار را فعال نمایید.
                                                    </li>
                                                    <li>
                                                        در صورتی میخواهید وضعیت ویژه تغییر نکند، تیک مربوط به عدم تغییر وضعیت ویژه را فعال نمایید.
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label>دسته‌بندی محصول:</label>
                                                <select class="select-rtl" name="category">
                                                    <option value="-1">
                                                        انتخاب کنید
                                                    </option>
                                                    <?php foreach ($categories as $key => $category): ?>
                                                        <option value="<?= $category['id']; ?>"
                                                            <?= set_value($pValues['category'] ?? '', $category['id'], 'selected', '', '=='); ?>>
                                                            <?= $category['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group pt-15 col-lg-2 col-md-2 col-sm-12">
                                                <div class="form-check form-check-right">
                                                    <label class="form-check-label ltr">
                                                        <span class="rtl">
                                                            عدم تغییر
                                                        </span>
                                                        <input type="radio" class="control-custom"
                                                            <?= set_value($pValues['product_type'] ?? '', -1, 'checked', 'checked', '=='); ?>
                                                               name="product_type" value="-1">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-right">
                                                    <label class="form-check-label ltr">
                                                        <span class="rtl">
                                                            خدمات
                                                        </span>
                                                        <input type="radio" class="control-custom"
                                                            <?= set_value($pValues['product_type'] ?? '', PRODUCT_TYPE_SERVICE, 'checked', '', '=='); ?>
                                                               name="product_type" value="<?= PRODUCT_TYPE_SERVICE ?>">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-right">
                                                    <label class="form-check-label ltr">
                                                        <span class="rtl">
                                                            کالا
                                                        </span>
                                                        <input type="radio" class="control-custom"
                                                            <?= set_value($pValues['product_type'] ?? '', PRODUCT_TYPE_ITEM, 'checked', '', '=='); ?>
                                                               name="product_type" value="<?= PRODUCT_TYPE_ITEM ?>">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label>شهر:</label>
                                                <select class="select-rtl" name="city">
                                                    <option value="-1">
                                                        انتخاب کنید
                                                    </option>
                                                    <?php foreach ($cities as $key => $city): ?>
                                                        <option value="<?= $city['id']; ?>"
                                                            <?= set_value($pValues['city'] ?? '', $city['id'], 'selected', '', '=='); ?>>
                                                            <?= $city['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label>محل:</label>
                                                <input name="place" type="text" class="form-control"
                                                       placeholder="محل"
                                                       value="<?= $pValues['place'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label>قیمت:</label>
                                                <input name="price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="<?= $pValues['price'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label>قیمت با تخفیف:</label>
                                                <input name="discount_price" type="text" class="form-control"
                                                       placeholder="تومان"
                                                       value="<?= $pValues['discount_price'] ?? ''; ?>">
                                            </div>

                                            <div class="col-sm-12"></div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 pt-10">
                                                <div class="alert-warning p-10">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" class="styled" name="no_expire"
                                                            <?= set_value($pValues['no_expire'] ?? '', 'on', 'checked', '', '=='); ?>>
                                                        عدم تغییر زمان تخفیف
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label>زمان تخفیف:</label>
                                                <input type="hidden" name="discount_expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly data-alt-field="#altDateField"
                                                       value="<?= date('Y/m/d H:i', (int)($pValues['discount_expire'] ?? time())); ?>">
                                            </div>

                                            <div class="col-sm-12"></div>

                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <label>پاداش خرید:</label>
                                                <input name="reward" type="text" class="form-control"
                                                       placeholder="درصد"
                                                       value="<?= $pValues['reward'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <label>تعداد موجود:</label>
                                                <input name="stock_count" type="text" class="form-control"
                                                       placeholder="عدد"
                                                       value="<?= $pValues['stock_count'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <label>حداکثر تعداد در یک خرید:</label>
                                                <input name="max_basket_count" type="text" class="form-control"
                                                       placeholder="عدد"
                                                       value="<?= $pValues['max_basket_count'] ?? ''; ?>">
                                            </div>
                                            <div class="col-sm-12 alert-primary mb-20">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="p-10">
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" class="styled" name="no_publish_change"
                                                                    <?= set_value($pValues['no_publish_change'] ?? '', 'on', 'checked', '', '=='); ?>>
                                                                عدم تغییر وضعیت انتشار
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                                        <div class="p-10">
                                                            <label for="pStatus" class="pull-left">
                                                                وضعیت انتشار:
                                                            </label>
                                                            <input type="checkbox" name="publish" id="pStatus"
                                                                   class="switchery" <?= set_value($pValues['publish'] ?? '', 1, 'checked', '', '=='); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 alert-danger">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="p-10">
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" class="styled" name="no_special_change"
                                                                    <?= set_value($pValues['no_special_change'] ?? '', 'on', 'checked', '', '=='); ?>>
                                                                عدم تغییر وضعیت ویژه
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                                        <div class="p-10">
                                                            <label for="pSpecial" class="pull-left">
                                                                ویژه:
                                                            </label>
                                                            <input type="checkbox" name="is_special" id="pSpecial"
                                                                   class="switchery" <?= set_value($pValues['is_special'] ?? '', 1, 'checked', '', '=='); ?>>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-lg-push-3 col-sm-push-3">
                                    <button type="submit"
                                            class="btn btn-success btn-block submit-button pt-15 pb-15 mb-20">
                                        ویرایش محصول
                                        <i class="icon-arrow-left12 position-right"></i>
                                    </button>
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