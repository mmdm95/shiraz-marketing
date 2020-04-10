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
                                    class="text-semibold">ویرایش نوشته</span>
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
                            <a href="<?= base_url(); ?>admin/blog/manageBlog">
                                نوشته‌ها
                            </a>
                        </li>
                        <li class="active">ویرایش نوشته</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url('admin/blog/editBlog/' . $param[0]); ?>" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">مشخصات نوشته</h6>
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
                                                           value="<?= set_value($blogValues['image'] ?? $blogTrueValues['image'] ?? ''); ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($blogValues['image'] ?? $blogTrueValues['image'] ?? '', '', base_url($blogValues['image'] ?? $blogTrueValues['image'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
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
                                                                    <?= basename($blogValues['image'] ?? $blogTrueValues['image'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <span class="text-danger">*</span>
                                                <label>عنوان نوشته:</label>
                                                <input name="title" type="text" class="form-control"
                                                       placeholder="اجباری"
                                                       value="<?= set_value($blogValues['title'] ?? $blogTrueValues['title'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>دسته‌بندی:</label>
                                                <select class="select-rtl" name="category">
                                                    <?php foreach ($categories as $key => $category): ?>
                                                        <option value="<?= $category['id']; ?>"
                                                            <?= set_value($blogValues['category'] ?? $blogTrueValues['category_id'] ?? '', $category['id'], 'selected', '', '=='); ?>>
                                                            <?= $category['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <span class="text-danger">*</span>
                                                <label>خلاصه نوشته:</label>
                                                <textarea rows="5" cols="12" class="form-control"
                                                          name="abstract"
                                                          style="min-height: 100px; resize: vertical;"
                                                          placeholder="خلاصه"><?= $blogValues['abstract'] ?? $blogTrueValues['abstract'] ?? ''; ?></textarea>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <span class="text-danger">*</span>
                                                <label>کلمات کلیدی:</label>
                                                <input name="keywords" type="text"
                                                       class="form-control" placeholder="Press Enter"
                                                       data-role="tagsinput"
                                                       value="<?= set_value($blogValues['keywords'] ?? $blogTrueValues['keywords'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-12 text-right">
                                                <label for="catStatus">وضعیت انتشار:</label>
                                                <input type="checkbox" name="publish" id="catStatus"
                                                       class="switchery" <?= set_value($blogValues['publish'] ?? $blogTrueValues['publish'] ?? '', 1, 'checked', '', '=='); ?> />
                                            </div>
                                            <div class="row pt-20 no-padding-top">
                                                <div class="form-group col-md-12 mt-12">
                                                    <span class="text-danger">*</span>
                                                    <label>متن توضیحات:</label>
                                                    <textarea
                                                            id="cntEditor"
                                                            class="form-control"
                                                            name="body"
                                                            rows="10"><?= set_value($blogValues['body'] ?? $blogTrueValues['body'] ?? ''); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="text-right col-md-12 mt-20">
                                                <a href="<?= base_url('admin/blog/manageBlog'); ?>"
                                                   class="btn btn-default mr-5">
                                                    بازگشت
                                                </a>
                                                <button type="submit" class="btn btn-success submit-button">
                                                    ویرایش
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