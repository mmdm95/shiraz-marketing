<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- Main navbar -->
<?php $this->view("templates/be/mainnavbar", $data); ?>
<!-- /main navbar -->
<!-- Page container -->

<script>
    (function ($) {

        'use strict';

        $(function () {
            var showIcon = function (icon) {
                var originalOption = icon.element;
                if (!icon.id) return icon.text;
                var $icon = "<span class='display-inline-block la-2x pull-right" + $(originalOption).attr('data-icon') +
                    "'></span>" + icon.text;

                return $icon;
            };

            $('.icon-select').each(function () {
                var $this = $(this);
                if ($this.data('select2')) $this.select2("destroy");
                $this.select2({
                    containerCssClass: 'rtl',
                    dropdownCssClass: 'rtl',
                    templateResult: showIcon,
                    templateSelection: showIcon,
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
            });
        });
    })(jQuery);
</script>

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
                                    class="text-semibold">افزودن دسته‌بندی</span>
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
                            <a href="<?= base_url(); ?>admin/shop/manageCategory">
                                دسته‌بندی‌ها
                            </a>
                        </li>
                        <li class="active">افزودن دسته‌بندی جدید</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url(); ?>admin/shop/addCategory" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">مشخصات دسته</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>

                                            <div class="form-group col-lg-12">
                                                <div class="cursor-pointer pick-file border border-lg border-default"
                                                     data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border-style: dashed; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="image"
                                                           value="<?= $catValues['image'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($catValues['image'] ?? '', '', base_url($catValues['image'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                         class="img-rounded" alt=""
                                                                         style="width: 100px; height: 100px; object-fit: contain;"
                                                                         data-base-url="<?= base_url(); ?>">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a class="text-grey-300">
                                                                    <span class="text-danger">*</span>
                                                                    انتخاب تصویر:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename($catValues['image'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <span class="text-danger">*</span>
                                                <label>عنوان دسته:</label>
                                                <input name="title" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="<?= $catValues['title'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <span class="text-danger">*</span>
                                                <label>آیکون دسته:</label>
                                                <select class="icon-select" name="icon">
                                                    <?php foreach ($icons as $icon): ?>
                                                        <option value="<?= $icon['id']; ?>"
                                                                data-icon="<?= $icon['name']; ?>"
                                                            <?= set_value($catValues['icon'] ?? '', $icon['id'], 'selected', '', '=='); ?>>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-12 text-right">
                                                <label for="catStatus">وضعیت نمایش:</label>
                                                <input type="checkbox" name="publish" id="catStatus"
                                                       class="switchery" <?= set_value($catValues['publish'] ?? '', 'off', '', 'checked', '=='); ?> />
                                            </div>

                                            <div class="text-right col-md-12 mt-20">
                                                <a href="<?= base_url('admin/shop/manageCategory'); ?>"
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

                <!-- file-picker -->
                <?php $this->view("templates/be/file-picker", $data); ?>
                <!-- /file-picker -->

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