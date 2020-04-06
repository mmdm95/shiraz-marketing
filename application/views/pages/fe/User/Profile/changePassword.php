<!-- Main navbar -->
<?php $this->view("templates/fe/user/mainnavbar", $data); ?>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <input type="hidden" id="BASE_URL" value="<?= base_url(); ?>">
        <!-- Main sidebar -->
        <?php $this->view("templates/fe/user/mainsidebar", $data); ?>
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
                                    class="text-semibold">تغییر رمز عبور</span>
                        </h5>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url(); ?>user/dashboard"><i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li class="active">تغییر رمز عبور</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url('user/changePassword/' . $param[0]); ?>" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">تغییر کلمه عبور</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php $this->view("templates/fe/user/alert/error", ['errors' => $errors ?? null]); ?>
                                            <?php $this->view("templates/fe/user/alert/success", ['success' => $success ?? null]); ?>

                                            <div class="alert alert-info alert-styled-left alert-bordered">
                                                <p>
                                                    <i class="icon-dash"></i>
                                                    کلمه عبور باید شامل حروف و اعداد انگلیسی و حداقل ۹ کاراکتر باشد.
                                                </p>
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>رمز عبور جدید:</label>
                                                <input name="password" type="password"
                                                       class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>تکرار رمز عبور جدید:</label>
                                                <input name="re_password" type="password"
                                                       class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                                       value="">
                                            </div>

                                            <div class="text-right col-md-12">
                                                <a href="<?= base_url('user/dashboard'); ?>"
                                                   class="btn btn-default mr-5">
                                                    بازگشت
                                                </a>
                                                <button type="submit"
                                                        class="btn btn-success submit-button submit-button">
                                                    تغییر کلمه عبور
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