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
                                    class="text-semibold">تنظیمات سایت</span>
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
                        <li class="active">تنظیمات سایت</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">

                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">تنظیمات</h6>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="active">
                                        <a href="#mainPanel" data-toggle="tab">اصلی</a>
                                    </li>
                                    <li>
                                        <a href="#imagesPanel" data-toggle="tab">تنظیمات تصویر صفحات</a>
                                    </li>
                                    <li>
                                        <a href="#indexPanel" data-toggle="tab">تنظیمات صفحه اصلی</a>
                                    </li>
                                    <li>
                                        <a href="#smsPanel" data-toggle="tab">تنظیمات پیامک</a>
                                    </li>
                                    <li>
                                        <a href="#cartPanel" data-toggle="tab">تنظیمات خرید</a>
                                    </li>
                                    <li>
                                        <a href="#contactPanel" data-toggle="tab">اطلاعات تماس</a>
                                    </li>
                                    <li>
                                        <a href="#footerPanel" data-toggle="tab">تنظیمات فوتر</a>
                                    </li>
                                    <li>
                                        <a href="#otherPanel" data-toggle="tab">سایر تنظیمات</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane active" id="mainPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_main ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_main ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#mainPanel" method="post">
                                        <?= $data['form_token_main']; ?>

                                        <div class="row">
                                            <div class="pl-20 pr-20">
                                                <div class="col-lg-6 form-group">
                                                    <div class="mb-20">
                                                        <span class="h4 pb-5">
                                                            <i class="position-left text-pink">*</i>
                                                            آیکون بالای صفحات سایت (favIcon)
                                                        </span>
                                                    </div>
                                                    <div class="cursor-pointer pick-file" data-toggle="modal"
                                                         data-target="#modal_full"
                                                         style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                        <input class="image-file" type="hidden"
                                                               name="fav"
                                                               value="<?= $values_main['fav'] ?? $setting['main']['favIcon'] ?? ''; ?>">
                                                        <div class="media stack-media-on-mobile">
                                                            <div class="media-left">
                                                                <div class="thumb">
                                                                    <a class="display-inline-block"
                                                                       style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                        <img
                                                                                src="<?= set_value($values_main['fav'] ?? $setting['main']['favIcon'] ?? '', '', base_url($values_main['fav'] ?? $setting['main']['favIcon'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                                class="img-rounded" alt=""
                                                                                style="width: 100px; height: 100px; object-fit: contain;"
                                                                                data-base-url="<?= base_url(); ?>">
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class="media-body">
                                                                <h6 class="media-heading">
                                                                    <a class="text-grey-300">
                                                                        انتخاب تصویر:
                                                                    </a>
                                                                    <a class="io-image-name display-block">
                                                                        <?= basename($values_main['fav'] ?? $setting['main']['favIcon'] ?? ''); ?>
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pl-20 pr-20">
                                                <div class="col-lg-6 form-group">
                                                    <div class="mb-20">
                                                        <span class="h4 pb-5">
                                                            <i class="position-left text-pink">*</i>
                                                            لوگوی سایت
                                                        </span>
                                                    </div>
                                                    <div class="cursor-pointer pick-file" data-toggle="modal"
                                                         data-target="#modal_full"
                                                         style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                        <input class="image-file" type="hidden"
                                                               name="logo"
                                                               value="<?= $values_main['logo'] ?? $setting['main']['logo'] ?? ''; ?>">
                                                        <div class="media stack-media-on-mobile">
                                                            <div class="media-left">
                                                                <div class="thumb">
                                                                    <a class="display-inline-block"
                                                                       style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                        <img src="<?= set_value($values_main['logo'] ?? $setting['main']['logo'] ?? '', '', base_url($values_main['logo'] ?? $setting['main']['logo'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                             class="img-rounded" alt=""
                                                                             style="width: 100px; height: 100px; object-fit: contain;"
                                                                             data-base-url="<?= base_url(); ?>">
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class="media-body">
                                                                <h6 class="media-heading">
                                                                    <a class="text-grey-300">
                                                                        انتخاب تصویر:
                                                                    </a>
                                                                    <a class="io-image-name display-block">
                                                                        <?= basename($values_main['logo'] ?? $setting['main']['logo'] ?? ''); ?>
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <hr>
                                            </div>

                                            <div class="pl-20 pr-20">
                                                <div class="col-lg-12">
                                                    <label class="m-0 pt-5 pb-5 pl-10 pr-10 display-block bg-white btn-default border-left
                                                    border-left-info border-left-xlg shadow-depth1 btn-rounded text-right"
                                                           for="showMenuIcon">
                                                        <span class="pull-left h5 no-margin">
                                                            <i class="icon-switch2 position-left text-info"></i>
                                                            نمایش آیکون دسته‌بندی‌ها
                                                        </span>
                                                        <input type="checkbox" name="showMenuIcon" id="showMenuIcon"
                                                               class="switchery" <?= set_value($values_main['showMenuIcon'] ?? $setting['main']['showMenuIcon'] ?? '', 1, 'checked', '', '=='); ?> />
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <hr>
                                            </div>

                                            <div class="pl-20 pr-20">
                                                <div class="form-group col-lg-12">
                                                    <div class="mb-20">
                                                        <span class="h4 pb-5">
                                                            <i class="position-left text-pink">*</i>
                                                            عنوان سایت
                                                        </span>
                                                    </div>
                                                    <input name="title" type="text"
                                                           class="form-control" placeholder="" maxlength="20"
                                                           value="<?= $values_main['title'] ?? $setting['main']['title'] ?? ''; ?>">
                                                    <span class="help-block alert alert-warning no-border-right no-border-top no-border-bottom border-lg pt-5 pb-5">
                                                        یک یا دو کلمه کلیدی و تا حداکثر ۲۰ کاراکتر
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <hr>
                                            </div>

                                            <div class="pl-20 pr-20">
                                                <div class="col-md-12">
                                                    <div class="mb-20">
                                                        <span class="h4 pb-5">
                                                            <i class="icon-dash text-pink"></i>
                                                            توضیح مختصر درباره سایت
                                                        </span>
                                                    </div>
                                                    <div class="alert alert-primary no-border-right no-border-top no-border-bottom border-lg">
                                                        توضیح مختصر و کلمات کلیدی، برای موتورهای جستجوگر است.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <textarea class="form-control col-md-12 p-10"
                                                              style="min-height: 100px; resize: vertical;"
                                                              name="desc"
                                                              rows="4"
                                                              cols="10"><?= $values_main['desc'] ?? $setting['main']['description'] ?? ''; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>کلمات کلیدی:</label>
                                                    <input name="keywords" type="text"
                                                           class="form-control" placeholder="Press Enter"
                                                           data-role="tagsinput"
                                                           value="<?= $values_main['keywords'] ?? $setting['main']['keywords'] ?? ''; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="imagesPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_images ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_images ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#imagesPanel" method="post">
                                        <?= $data['form_token_images']; ?>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تصویر بالای صفحه محصولات']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-12 mt-10 mb-10">
                                                <div class="cursor-pointer pick-file" data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="imgProduct"
                                                           value="<?= $values_images['imgProduct'] ?? $setting['pages']['product']['topImage'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($values_images['imgProduct'] ?? $setting['pages']['product']['topImage'] ?? '', '', base_url($values_images['imgProduct'] ?? $setting['pages']['product']['topImage'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                         class="img-rounded" alt=""
                                                                         style="width: 100px; height: 100px; object-fit: contain;"
                                                                         data-base-url="<?= base_url(); ?>">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a class="text-grey-300">
                                                                    انتخاب تصویر:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename($values_images['imgProduct'] ?? $setting['pages']['product']['topImage'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تصویر بالای صفحه بلاگ']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-12 mt-10 mb-10">
                                                <div class="cursor-pointer pick-file" data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="imgBlog"
                                                           value="<?= $values_images['imgBlog'] ?? $setting['pages']['blog']['topImage'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($values_images['imgBlog'] ?? $setting['pages']['blog']['topImage'] ?? '', '', base_url($values_images['imgBlog'] ?? $setting['pages']['blog']['topImage'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                         class="img-rounded" alt=""
                                                                         style="width: 100px; height: 100px; object-fit: contain;"
                                                                         data-base-url="<?= base_url(); ?>">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a class="text-grey-300">
                                                                    انتخاب تصویر:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename($values_images['imgBlog'] ?? $setting['pages']['blog']['topImage'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تصویر بالای صفحه سؤالات متداول']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-12 mt-10 mb-10">
                                                <div class="cursor-pointer pick-file" data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="imgFAQ"
                                                           value="<?= $values_images['imgFAQ'] ?? $setting['pages']['faq']['topImage'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($values_images['imgFAQ'] ?? $setting['pages']['faq']['topImage'] ?? '', '', base_url($values_images['imgFAQ'] ?? $setting['pages']['faq']['topImage'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                         class="img-rounded" alt=""
                                                                         style="width: 100px; height: 100px; object-fit: contain;"
                                                                         data-base-url="<?= base_url(); ?>">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a class="text-grey-300">
                                                                    انتخاب تصویر:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename($values_images['imgFAQ'] ?? $setting['pages']['faq']['topImage'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تصویر بالای صفحه تماس با ما']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-12 mt-10 mb-10">
                                                <div class="cursor-pointer pick-file" data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="imgContact"
                                                           value="<?= $values_images['imgContact'] ?? $setting['pages']['contactUs']['topImage'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($values_images['imgContact'] ?? $setting['pages']['contactUs']['topImage'] ?? '', '', base_url($values_images['imgContact'] ?? $setting['pages']['contactUs']['topImage'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                         class="img-rounded" alt=""
                                                                         style="width: 100px; height: 100px; object-fit: contain;"
                                                                         data-base-url="<?= base_url(); ?>">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a class="text-grey-300">
                                                                    انتخاب تصویر:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename($values_images['imgContact'] ?? $setting['pages']['contactUs']['topImage'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تصویر بالای صفحه شکایات']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-12 mt-10 mb-10">
                                                <div class="cursor-pointer pick-file" data-toggle="modal"
                                                     data-target="#modal_full"
                                                     style="border: dashed 2px #ddd; padding: 0 10px 10px 0; box-sizing: border-box;">
                                                    <input class="image-file" type="hidden"
                                                           name="imgComplaint"
                                                           value="<?= $values_images['imgComplaint'] ?? $setting['pages']['complaint']['topImage'] ?? ''; ?>">
                                                    <div class="media stack-media-on-mobile">
                                                        <div class="media-left">
                                                            <div class="thumb">
                                                                <a class="display-inline-block"
                                                                   style="-webkit-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.4);">
                                                                    <img src="<?= set_value($values_images['imgComplaint'] ?? $setting['pages']['complaint']['topImage'] ?? '', '', base_url($values_images['imgComplaint'] ?? $setting['pages']['complaint']['topImage'] ?? ''), asset_url('be/images/placeholder.jpg')); ?>"
                                                                         class="img-rounded" alt=""
                                                                         style="width: 100px; height: 100px; object-fit: contain;"
                                                                         data-base-url="<?= base_url(); ?>">
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a class="text-grey-300">
                                                                    انتخاب تصویر:
                                                                </a>
                                                                <a class="io-image-name display-block">
                                                                    <?= basename($values_images['imgComplaint'] ?? $setting['pages']['complaint']['topImage'] ?? ''); ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="indexPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_index ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_index ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#indexPanel" method="post">
                                        <?= $data['form_token_index']; ?>

                                        <div class="row">
                                            <div class="pl-20 pr-20">
                                                <div class="col-lg-12">
                                                    <label class="m-0 pt-5 pb-5 pl-10 pr-10 display-block bg-white btn-default border-left
                                                    border-left-info border-left-xlg shadow-depth1 btn-rounded text-right"
                                                           for="showOurTeam">
                                                        <span class="pull-left h5 no-margin">
                                                            <i class="icon-switch2 position-left text-info"></i>
                                                            نمایش تیم ما
                                                        </span>
                                                        <input type="checkbox" name="showOurTeam" id="showOurTeam"
                                                               class="switchery" <?= set_value($values_main['showOurTeam'] ?? $setting['pages']['index']['showOurTeam'] ?? '', 1, 'checked', '', '=='); ?> />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit" name="indexPagePanel"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="smsPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_sms ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_sms ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#smsPanel" method="post">
                                        <?= $data['form_token_sms']; ?>

                                        <?php $this->view('templates/be/title', ['header_title' => 'پیامک کد فعالسازی']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control col-md-12 p-10"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="smsActivation"
                                                          placeholder="متن پیامک"
                                                          rows="4"
                                                          cols="10"><?= $values_sms['smsActivation'] ?? $setting['sms']['activationCodeMsg'] ?? ''; ?></textarea>
                                                <span class="help-block col-md-12">
                                                    می‌توانید از
                                                    <code>
                                                        @code@
                                                    </code>
                                                    برای قرار دادن محل کد و از
                                                    <code>
                                                        @mobile@
                                                    </code>
                                                    برای قرار دادن محل شماره موبایل، استفاده کنید.
                                                </span>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'پیامک کد فراموشی کلمه عبور']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control col-md-12 p-10"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="smsForgetPassword"
                                                          placeholder="متن پیامک"
                                                          rows="4"
                                                          cols="10"><?= $values_sms['smsForgetPassword'] ?? $setting['sms']['forgetPasswordCodeMsg'] ?? ''; ?></textarea>
                                                <span class="help-block col-md-12">
                                                    می‌توانید از
                                                    <code>
                                                        @code@
                                                    </code>
                                                    برای قرار دادن محل کد و از
                                                    <code>
                                                        @mobile@
                                                    </code>
                                                    برای قرار دادن محل شماره موبایل، استفاده کنید.
                                                </span>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'پیامک خرید کالا']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control col-md-12 p-10"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="smsProductReg"
                                                          placeholder="متن پیامک"
                                                          rows="4"
                                                          cols="10"><?= $values_sms['smsProductReg'] ?? $setting['sms']['productRegistrationMsg'] ?? ''; ?></textarea>
                                                <span class="help-block col-md-12">
                                                    می‌توانید از
                                                    <code>
                                                        @orderCode@
                                                    </code>
                                                    برای قرار دادن محل شماره سفارش و از
                                                    <code>
                                                        @mobile@
                                                    </code>
                                                    برای قرار دادن محل شماره موبایل، استفاده کنید.
                                                </span>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'پیامک تغییر وضعیت سفارش']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control col-md-12 p-10"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="smsStatus"
                                                          placeholder="متن پیامک"
                                                          rows="4"
                                                          cols="10"><?= $values_sms['smsStatus'] ?? $setting['sms']['changeStatusMsg'] ?? ''; ?></textarea>
                                                <span class="help-block col-md-12">
                                                    می‌توانید از
                                                    <code>
                                                        @orderCode@
                                                    </code>
                                                    برای قرار دادن محل شماره سفارش و از
                                                    <code>
                                                        @mobile@
                                                    </code>
                                                    برای قرار دادن محل شماره موبایل و از
                                                    <code>
                                                        @status@
                                                    </code>
                                                    برای قرار دادن وضعیت سفارش، استفاده کنید.
                                                </span>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="cartPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_cart ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_cart ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#cartPanel" method="post">
                                        <?= $data['form_token_cart']; ?>

                                        <?php $this->view('templates/be/title', ['header_title' => 'هزینه‌ها و توضیحات']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-lg-4 mt-10">
                                                <div class="form-group">
                                                    <label>قیمت در مناطق داخل شیراز(به تومان):</label>
                                                    <input name="cart_priceArea1" type="text"
                                                           class="form-control" placeholder=""
                                                           value="<?= set_value($values_cart['cart_priceArea1'] ?? $setting['cart']['shipping_price']['area1'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mt-10">
                                                <div class="form-group">
                                                    <label>قیمت در مناطق خارج از شیراز(به تومان):</label>
                                                    <input name="cart_priceArea2" type="text"
                                                           class="form-control" placeholder=""
                                                           value="<?= set_value($values_cart['cart_priceArea2'] ?? $setting['cart']['shipping_price']['area2'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mt-10">
                                                <div class="form-group">
                                                    <label>حداقل قیمت رایگان شدن هزینه ارسال(به تومان):</label>
                                                    <input name="cart_priceFree" type="text"
                                                           class="form-control" placeholder=""
                                                           value="<?= set_value($values_cart['cart_priceFree'] ?? $setting['cart']['shipping_free_price'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>توضیحات بیشتر:</label>
                                                <textarea class="form-control col-md-12 p-10"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="cart_desc"
                                                          rows="4"
                                                          cols="10"><?= $values_cart['cart_desc'] ?? $setting['cart']['description'] ?? ''; ?></textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="contactPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_contact ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_contact ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#contactPanel" method="post">
                                        <?= $data['form_token_contact']; ?>

                                        <?php $this->view('templates/be/title', ['header_title' => 'اطلاعات تماس']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="form-group col-md-12">
                                                <label>آدرس:</label>
                                                <textarea class="form-control col-md-12 p-10"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="contact_desc"
                                                          rows="4"
                                                          cols="10"><?= $values_contact['contact_desc'] ?? $setting['contact']['description'] ?? ''; ?></textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <label>شماره‌های تماس:</label>
                                                <input name="contact_mobile" type="text"
                                                       class="form-control" placeholder="Press Enter"
                                                       data-role="tagsinput"
                                                       value="<?= $values_contact['contact_mobile'] ?? $setting['contact']['mobiles'] ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="footerPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_footer ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_footer ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#footerPanel" method="post">
                                        <?= $data['form_token_footer']; ?>

                                        <?php $this->view('templates/be/title', ['header_title' => 'مدیریت لینک‌ها']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-lg-6 mb-10">
                                                <div class="border border-dashed border-grey-300 border-radius p-10">
                                                    <div class="form-group col-md-12">
                                                        <label>عنوان بخش اول:</label>
                                                        <input name="footer_1_title[]" type="text" class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_title'][0] ?? $setting['footer']['sections']['section_1']['title'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][0][0] ?? $setting['footer']['sections']['section_1']['links'][0]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][0][0] ?? $setting['footer']['sections']['section_1']['links'][0]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][0][1] ?? $setting['footer']['sections']['section_1']['links'][1]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][0][1] ?? $setting['footer']['sections']['section_1']['links'][1]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][0][2] ?? $setting['footer']['sections']['section_1']['links'][2]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][0][2] ?? $setting['footer']['sections']['section_1']['links'][2]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][0][3] ?? $setting['footer']['sections']['section_1']['links'][3]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][0][3] ?? $setting['footer']['sections']['section_1']['links'][3]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][0][4] ?? $setting['footer']['sections']['section_1']['links'][4]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][0][4] ?? $setting['footer']['sections']['section_1']['links'][4]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][0][5] ?? $setting['footer']['sections']['section_1']['links'][5]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[0][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][0][5] ?? $setting['footer']['sections']['section_1']['links'][5]['link'] ?? ''); ?>">
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-10">
                                                <div class="border border-dashed border-grey-300 border-radius p-10">
                                                    <div class="form-group col-md-12">
                                                        <label>عنوان بخش دوم:</label>
                                                        <input name="footer_1_title[]" type="text" class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_title'][1] ?? $setting['footer']['sections']['section_2']['title'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][1][0] ?? $setting['footer']['sections']['section_2']['links'][0]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][1][0] ?? $setting['footer']['sections']['section_2']['links'][0]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][1][1] ?? $setting['footer']['sections']['section_2']['links'][1]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][1][1] ?? $setting['footer']['sections']['section_2']['links'][1]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][1][2] ?? $setting['footer']['sections']['section_2']['links'][2]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][1][2] ?? $setting['footer']['sections']['section_2']['links'][2]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][1][3] ?? $setting['footer']['sections']['section_2']['links'][3]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][1][3] ?? $setting['footer']['sections']['section_2']['links'][3]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][1][4] ?? $setting['footer']['sections']['section_2']['links'][4]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][1][4] ?? $setting['footer']['sections']['section_2']['links'][4]['link'] ?? ''); ?>">
                                                    </div>

                                                    <div class="col-md-8 col-md-push-2 border-top border-top-dashed border-grey-300 mt-10 mb-20"></div>

                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>متن لینک:</label>
                                                        <input name="footer_1_text[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="متن"
                                                               value="<?= set_value($values_footer['footer_1_text'][1][5] ?? $setting['footer']['sections']['section_2']['links'][5]['text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-12">
                                                        <label>آدرس لینک:</label>
                                                        <input name="footer_1_link[1][]" type="text"
                                                               class="form-control"
                                                               placeholder="آدرس"
                                                               value="<?= set_value($values_footer['footer_1_link'][1][5] ?? $setting['footer']['sections']['section_2']['links'][5]['link'] ?? ''); ?>">
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'نمادها']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="form-group col-md-12">
                                                <label>کد نماد الکترونیکی:</label>
                                                <textarea class="form-control col-md-12 p-10 ltr"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="namad1"
                                                          rows="4"
                                                          cols="10"><?= $values_footer['namad1'] ?? html_entity_decode($setting['footer']['namad']['namad1'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>کد نشان ملی ثبت:</label>
                                                <textarea class="form-control col-md-12 p-10 ltr"
                                                          style="min-height: 100px; resize: vertical;"
                                                          name="namad2"
                                                          rows="4"
                                                          cols="10"><?= $values_footer['namad2'] ?? html_entity_decode($setting['footer']['namad']['namad2'] ?? ''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'راه‌های ارتباطی']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-lg-6 mt-10">
                                                <div class="form-group">
                                                    <label>آدرس تلگرام:</label>
                                                    <input name="telegram" type="text"
                                                           class="form-control" placeholder="Press Enter"
                                                           data-role="tagsinput"
                                                           value="<?= set_value($values_footer['telegram'] ?? $setting['footer']['socials']['telegram'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-10">
                                                <div class="form-group">
                                                    <label>آدرس اینستاگرام:</label>
                                                    <input name="instagram" type="text"
                                                           class="form-control" placeholder="Press Enter"
                                                           data-role="tagsinput"
                                                           value="<?= set_value($values_footer['instagram'] ?? $setting['footer']['socials']['instagram'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-10">
                                                <div class="form-group">
                                                    <label>آدرس واتس اَپ:</label>
                                                    <input name="whatsapp" type="text"
                                                           class="form-control" placeholder="Press Enter"
                                                           data-role="tagsinput"
                                                           value="<?= set_value($values_footer['whatsapp'] ?? $setting['footer']['socials']['whatsapp'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- ********************* -->
                                <!-- ***** TAB PANEL ***** -->
                                <!-- ********************* -->
                                <div class="tab-pane" id="otherPanel">
                                    <div class="row no-padding pl-20 pr-20">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors_other ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success_other ?? null]); ?>
                                        </div>
                                    </div>

                                    <form action="<?= base_url(); ?>admin/setting#otherPanel" method="post">
                                        <?= $data['form_token_other']; ?>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تعداد محصول در هر صفحه']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-6">
                                                <input name="productEachPage" type="text"
                                                       class="form-control" placeholder="عدد بزرگتر از صفر"
                                                       value="<?= $values_other['productEachPage'] ?? $setting['product']['itemsEachPage'] ?? ''; ?>">
                                            </div>
                                        </div>

                                        <?php $this->view('templates/be/title', ['header_title' => 'تعداد بلاگ در هر صفحه']) ?>
                                        <div class="row pl-20 pr-20 pb-20">
                                            <div class="col-md-6">
                                                <input name="blogEachPage" type="text"
                                                       class="form-control" placeholder="عدد بزرگتر از صفر"
                                                       value="<?= $values_other['blogEachPage'] ?? $setting['blog']['itemsEachPage'] ?? ''; ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <hr style="margin-bottom: 0;">
                                            <button type="submit"
                                                    class="btn btn-default btn-block pt-20 pb-20 no-border-radius-top">
                                                <span class="h5">
                                                <i class="icon-cog position-left"></i>
                                                    ذخیره تنظیمات
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /form centered -->

                    <!-- Standard width modal -->
                    <?php $this->view('templates/be/file-picker', $data); ?>
                    <!-- /standard width modal -->

                    <!-- Show active tab from url's hash -->
                    <script>
                        var hash = window.location.hash.substr(1);
                        var tabs = ['mainPanel', 'imagesPanel', 'indexPanel', 'smsPanel', 'cartPanel', 'contactPanel', 'footerPanel', 'otherPanel'];

                        if ($.inArray(hash, tabs) !== -1) {
                            $('a[href="#' + hash + '"]').tab('show');
                        }
                    </script>
                    <!-- /Show active tab from url's hash -->

                    <!-- Footer -->
                    <?php $this->view("templates/be/copyright", $data); ?>
                    <!-- /footer -->
                </div>
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->