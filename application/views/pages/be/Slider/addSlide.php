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
                            <span class="text-semibold">مشاهده اسلاید‌ها</span>
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
                        <li>
                            <a href="<?= base_url(); ?>admin/manageSlider">
                                مدیریت اسلاید‌ها
                            </a>
                        </li>
                        <li class="active">افزودن اسلاید</li>
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
                            <div class="col-lg-12">
                                <form action="" method="post">

                                    <div class="panel panel-body border-top-primary">
                                        <h6 class="no-margin text-semibold text-center">
                                            افزودن اسلاید
                                        </h6>
                                        <p class="text-muted content-group-sm text-center">
                                        </p>
                                        <div class="row">
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <li>

                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="alert alert-success">
                                                <p>
                                                </p>
                                            </div>

                                            <div class="col-md-8 col-md-push-2 mt-10">
                                                <div class="cursor-pointer pick-file" data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="s-image" value="">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img
                                                                            src=""
                                                                            class="img-rounded" alt=""
                                                                            style="width: 100px; height: 100px; object-fit: contain;"
                                                                            data-base-url="">
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
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12"></div>
                                            <div class="form-group col-md-5 mt-10">
                                                <label>
                                                    آدرس لینک:
                                                </label>
                                                <input name="s-btn-url"
                                                       type="url"
                                                       class="form-control"
                                                       placeholder="مثال: www.spsroham.ir/contactUs"
                                                       value="">
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit" class="btn btn-primary">
                                                    افزودن
                                                    <i class="icon-arrow-left12 position-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Standard width modal -->
                                <div id="modal_full" class="modal fade">
                                    <div class="modal-dialog modal-full">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h5 class="modal-title">
                                                    انتخاب فایل
                                                </h5>
                                            </div>

                                            <div id="files-body" class="modal-body">
                                                <?php include VIEW_PATH . 'templates/efm-view.php'; ?>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    <i class="icon-cancel-circle2 position-left" aria-hidden="true"></i>
                                                    لغو
                                                </button>
                                                <button id="file-ok" type="button" class="btn btn-primary"
                                                        data-dismiss="modal">
                                                    <i class="icon-checkmark-circle position-left"
                                                       aria-hidden="true"></i>
                                                    انتخاب
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /standard width modal -->
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