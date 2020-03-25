<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- Main navbar -->
<?php $this->view("templates/be/mainnavbar", $data); ?>
<!-- /main navbar -->
<!-- Page container -->
<script>
    (function ($) {
        'use strict';
        $(function () {
            var showColor = function (color) {
                var originalOption = color.element;
                if (!color.id) return color.text;
                var $color = "<span class='display-inline-block img-xxs img-rounded shadow-depth2 pull-right'" +
                    " style='background-color: " + $(originalOption).attr('data-color') + "'></span>" + color.text;

                return $color;
            };

            $('.my-custom-select').each(function () {
                var $this = $(this);
                if ($this.data('select2')) $this.select2("destroy");
                $this.select2({
                    containerCssClass: 'rtl',
                    dropdownCssClass: 'rtl',
                    templateResult: showColor,
                    templateSelection: showColor,
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
                            <i class="icon-circle position-left"></i> <span class="text-semibold">افزودن محصول</span>
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
                        <li class="active">افزودن محصول</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url(); ?>admin/addProduct" method="post">
                            <!--                            --><?//= $data['form_token']; ?>
                            <div class="row">
                                <div class="col-lg-12">
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
                                </div>
                                <div class="col-lg-8">
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
                                            <div class="col-lg-12 mb-15">
                                                <div class="cursor-pointer pick-file border border-lg border-default"
                                                     data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border-style: dashed; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="image"
                                                           value="<?= set_value($pVals['image'] ?? ''); ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img
                                                                            src="<?= set_value($pVals['image'] ?? '', '', base_url($pVals['image'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
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
                                                                    انتخاب تصویر شاخص:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename(set_value($pVals['image'] ?? '')); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-8 col-sm-12">
                                                <span class="text-danger">*</span>
                                                <label>عنوان محصول:</label>
                                                <input name="title" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="<?= set_value($pVals['title'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <span class="text-danger">*</span>
                                                <label>دسته‌بندی محصول:</label>
                                                <select class="select-rtl" name="category">
                                                    <?php foreach ($categories as $key => $category): ?>
                                                        <option value="<?= $category['id']; ?>"
                                                            <?= set_value($pVals['category'] ?? '', $category['id'], 'selected', '', '=='); ?>>
                                                            <?php for ($i = 1; $i < $category['level']; $i++): ?>
                                                                -
                                                            <?php endfor; ?>
                                                            <?= $category['category_name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group pt-15 col-lg-2 col-md-2 col-sm-12">
                                                <div class="form-check form-check-right">
                                                    <label class="form-check-label ltr">
                                                                <span class="rtl">
                                                                    خدمات
                                                                </span>
                                                        <input type="radio" class="control-custom"
                                                               name="product_type" value="1">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-right">
                                                    <label class="form-check-label ltr">
                                                                <span class="rtl">
                                                                    کالا
                                                                </span>
                                                        <input type="radio" class="control-custom"
                                                               name="product_type" value="2">
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <span class="text-danger">*</span>
                                                <label>شهر:</label>
                                                <input name="city" type="text" class="form-control"
                                                       placeholder="شهر"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <span class="text-danger">*</span>
                                                <label>محل:</label>
                                                <input name="place" type="text" class="form-control"
                                                       placeholder="محل"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <span class="text-danger">*</span>
                                                <label>قیمت:</label>
                                                <input name="price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="<?= set_value($pVals['guarantee-price'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <span class="text-danger">*</span>
                                                <label>مقدار تخفیف:</label>
                                                <input name="off" type="text" class="form-control"
                                                       placeholder="درصد"
                                                       value="<?= set_value($pVals['discount'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>زمان تخفیف:</label>
                                                <input type="hidden" name="expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly data-alt-field="#altDateField"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <label>پاداش خرید:</label>
                                                <input name="reward" type="text" class="form-control"
                                                       placeholder="درصد"
                                                       value="<?= set_value($pVals['discount'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <label>تعداد موجود:</label>
                                                <input name="stock_count" type="text" class="form-control"
                                                       placeholder="عدد"
                                                       value="<?= set_value($pVals['discount'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <label>حداکثر تعداد در یک خرید:</label>
                                                <input name="max_basket_count" type="text" class="form-control"
                                                       placeholder="عدد"
                                                       value="<?= set_value($pVals['discount'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>کلمات کلیدی:</label>
                                                <input name="keywords" type="text"
                                                       class="form-control" placeholder="Press Enter"
                                                       data-role="tagsinput"
                                                       value="<?= set_value($pVals['keywords'] ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-white">
                                        <div class="panel-body">
                                            <div class="col-lg-12 text-right mb-20">
                                                <label for="pStatus" class="pull-left">
                                                    وضعیت انتشار:
                                                </label>
                                                <input type="checkbox" name="status" id="pStatus"
                                                       class="switchery" <?= set_value($pVals['status'] ?? '', 'off', '', 'checked', '=='); ?> />
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <label for="pStatus" class="pull-left">
                                                    ویژه:
                                                </label>
                                                <input type="checkbox" name="is_special" id="pStatus"
                                                       class="switchery" <?= set_value($pVals['status'] ?? '', 'off', '', 'checked', '=='); ?> />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">گالری تصاویر</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body slide-items">
                                            <div class="col-sm-12 mb-20 text-left">
                                                <div class="display-inline-block alert alert-primary
                                                no-border-right no-border-top no-border-bottom border-lg p-10 no-margin-bottom"
                                                     style="width: calc(100% - 50px);">
                                                    حداقل یک تصویر اجباری
                                                </div>
                                                <a href="javascript:void(0);"
                                                   class="btn btn-primary btn-icon add-slide-image ml-5"
                                                   title="اضافه کردن تصویر جدید" data-popup="tooltip">
                                                    <i class="icon-plus2" aria-hidden="true"></i>
                                                </a>
                                            </div>

                                            <?php if (count($errors)): ?>
                                                <?php foreach ($pVals['imageGallery'] as $key => $img): ?>
                                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-15 slide-item">
                                                        <div class="cursor-pointer pick-file border border-lg border-default"
                                                             data-toggle="modal"
                                                             data-target="#modal_full"
                                                             style="border-style: dashed; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                            <input class="image-file" type="hidden"
                                                                   name="imageGallery[]"
                                                                   value="<?= set_value($img ?? ''); ?>">
                                                            <div class="media stack-media-on-mobile">
                                                                <div class="media-left">
                                                                    <div class="thumb">
                                                                        <a class="display-inline-block"
                                                                           style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                            <img
                                                                                    src="<?= set_value($img ?? '', '', base_url($img ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                                    class="img-rounded" alt=""
                                                                                    style="width: 100px; height: 100px; object-fit: contain;"
                                                                                    data-base-url="<?= base_url(); ?>">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h6 class="media-heading">
                                                                        <a class="io-image-lbl text-grey-300">
                                                                            انتخاب تصویر <?= ($key + 1); ?>
                                                                        </a>
                                                                        <a class="io-image-name display-block">
                                                                            <?= basename($img); ?>
                                                                        </a>
                                                                    </h6>
                                                                    <?php if ($key == 0): ?>
                                                                        <small class="clear-img-val">&times;</small>
                                                                    <?php else: ?>
                                                                        <small class="delete-new-image btn btn-danger">
                                                                            &times;
                                                                        </small>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="col-lg-12 col-md-6 col-sm-12 mb-15 slide-item">
                                                    <div class="cursor-pointer pick-file border border-lg border-default"
                                                         data-toggle="modal"
                                                         data-target="#modal_full"
                                                         style="border-style: dashed; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                        <input class="image-file" type="hidden"
                                                               name="imageGallery[]"
                                                               value="<?= set_value($pVals['image'] ?? ''); ?>">
                                                        <div class="media stack-media-on-mobile">
                                                            <div class="media-left">
                                                                <div class="thumb">
                                                                    <a class="display-inline-block"
                                                                       style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                        <img
                                                                                src="<?= set_value($pVals['image'] ?? '', '', base_url($pVals['image'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                                class="img-rounded" alt=""
                                                                                style="width: 100px; height: 100px; object-fit: contain;"
                                                                                data-base-url="<?= base_url(); ?>">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading">
                                                                    <a class="io-image-lbl text-grey-300">
                                                                        انتخاب تصویر 1
                                                                    </a>
                                                                    <a class="io-image-name display-block">
                                                                        <?= basename(set_value($pVals['image'] ?? '')); ?>
                                                                    </a>
                                                                </h6>
                                                                <small class="clear-img-val">&times;</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">محصولات مرتبط</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <select class="select-rtl" multiple="multiple"
                                                        name="related[]" data-placeholder="انتخاب کنید">
                                                    <?php foreach ($products as $product): ?>
                                                        <option value="<?= $product['id']; ?>"
                                                            <?= in_array($product['id'], $pVals['related'] ?? []) ? 'selected' : ''; ?>>
                                                            <?= $product['product_title']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">توضیحات محصول</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group col-md-12 mt-10">
                                                <textarea
                                                        class="form-control"
                                                        style="width: 100%; min-width: 100%; max-width: 100%; min-height: 300px;"
                                                        name="description" placeholder="متن توضیحات محصول"
                                                        rows="10"><?= set_value($pVals['description'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-lg-push-4 col-sm-push-3">
                                    <button type="submit"
                                            class="btn btn-success btn-block submit-button pt-15 pb-15 mb-20">
                                        افزودن محصول
                                        <i class="icon-arrow-left12 position-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Standard width modal -->
                <div id="modal_full" class="modal fade lazyContainer">
                    <div class="modal-dialog modal-full">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">
                                    انتخاب فایل
                                </h5>
                            </div>

                            <div id="files-body" class="modal-body">
                                <?php $this->view("templates/be/efm-view", $data); ?>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="icon-cancel-circle2 position-left" aria-hidden="true"></i>
                                    لغو
                                </button>
                                <button id="file-ok" type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="icon-checkmark-circle position-left" aria-hidden="true"></i>
                                    انتخاب
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /standard width modal -->

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