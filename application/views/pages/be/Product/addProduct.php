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
                        <form action="<?= base_url('admin/shop/addProduct'); ?>" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-lg-12">
                                    <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                    <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>
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
                                                           value="<?= $pValues['image'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($pValues['image'] ?? '', '', base_url($pValues['image'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
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
                                                                    <?= basename($pValues['image'] ?? ''); ?>
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
                                                       value="<?= $pValues['title'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <span class="text-danger">*</span>
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
                                                            خدمات
                                                        </span>
                                                        <input type="radio" class="control-custom"
                                                            <?= set_value($pValues['product_type'] ?? '', PRODUCT_TYPE_SERVICE, 'checked', 'checked', '=='); ?>
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
                                                <span class="text-danger">*</span>
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
                                                <span class="text-danger">*</span>
                                                <label>محل:</label>
                                                <input name="place" type="text" class="form-control"
                                                       placeholder="محل"
                                                       value="<?= $pValues['place'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                                <span class="text-danger">*</span>
                                                <label>قیمت:</label>
                                                <input name="price" type="text" class="form-control"
                                                       placeholder="به تومان"
                                                       value="<?= $pValues['price'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <span class="text-danger">*</span>
                                                <label>قیمت با تخفیف:</label>
                                                <input name="discount_price" type="text" class="form-control"
                                                       placeholder="تومان"
                                                       value="<?= $pValues['discount_price'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>زمان تخفیف:</label>
                                                <input type="hidden" name="discount_expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ انقضا" readonly data-alt-field="#altDateField"
                                                       value="<?= date('Y/m/d H:i', $pValues['discount_expire'] ?? time()); ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <label>پاداش خرید:</label>
                                                <input name="reward" type="text" class="form-control"
                                                       placeholder="درصد"
                                                       value="<?= $pValues['reward'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <label>تعداد موجود:</label>
                                                <input name="stock_count" type="text" class="form-control"
                                                       placeholder="عدد"
                                                       value="<?= $pValues['stock_count'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-7">
                                                <label>حداکثر تعداد در یک خرید:</label>
                                                <input name="max_basket_count" type="text" class="form-control"
                                                       placeholder="عدد"
                                                       value="<?= $pValues['max_basket_count'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label>کلمات کلیدی:</label>
                                                <input name="keywords" type="text"
                                                       class="form-control" placeholder="Press Enter"
                                                       data-role="tagsinput"
                                                       value="<?= $pValues['keywords'] ?? ''; ?>">
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
                                                <input type="checkbox" name="publish" id="pStatus"
                                                       class="switchery" <?= set_value($pValues['publish'] ?? '', 'off', '', 'checked', '=='); ?>>
                                            </div>
                                            <div class="col-lg-12 text-right">
                                                <label for="pSpecial" class="pull-left">
                                                    ویژه:
                                                </label>
                                                <input type="checkbox" name="is_special" id="pSpecial"
                                                       class="switchery" <?= set_value($pValues['is_special'] ?? '', 'off', '', 'checked', '=='); ?>>
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
                                                <?php foreach ($pValues['imageGallery'] as $key => $img): ?>
                                                    <div class="col-lg-12 col-md-6 col-sm-12 mb-15 slide-item">
                                                        <div class="cursor-pointer pick-file border border-lg border-default"
                                                             data-toggle="modal"
                                                             data-target="#modal_full"
                                                             style="border-style: dashed; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                            <input class="image-file" type="hidden"
                                                                   name="imageGallery[]"
                                                                   value="<?= $img ?? ''; ?>">
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
                                                               value="<?= $pValues['imageGallery'][0] ?? ''; ?>">
                                                        <div class="media stack-media-on-mobile">
                                                            <div class="media-left">
                                                                <div class="thumb">
                                                                    <a class="display-inline-block"
                                                                       style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                        <img
                                                                                src="<?= set_value($pValues['imageGallery'][0] ?? '', '', base_url($pValues['image'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
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
                                                                        <?= basename($pValues['imageGallery'][0] ?? ''); ?>
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
                                                            <?= in_array($product['id'], $pValues['related'] ?? []) ? 'selected' : ''; ?>>
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
                                        <div class="panel-body no-padding">
                                            <textarea
                                                    id="cntEditor"
                                                    class="form-control"
                                                    style="width: 100%; min-width: 100%; max-width: 100%; min-height: 300px;"
                                                    name="description" placeholder="متن توضیحات محصول"
                                                    rows="10"><?= $pValues['description'] ?? ''; ?></textarea>
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
                <?php $this->view('templates/be/file-picker', $data) ?>
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