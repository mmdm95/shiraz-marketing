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
                                    class="text-semibold">تغییر رمز عبور</span>
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
                            <a href="<?= base_url(); ?>admin/user/manageUser">
                                مدیریت کاربران
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
                        <form action="<?= base_url(); ?>admin/editUser/<?= @$data['param'][0]; ?>" method="post"
                              class="validation-form">
                            <!--                            --><? //= $data['form_token']; ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">مشخصات فردی</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                    <li><a data-action="close"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php //if (isset($data['errors']) && count($data['errors'])): ?>
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <?php //foreach ($data['errors'] as $err): ?>
                                                    <li>
                                                        <? //= $err; ?><!--</li>-->
                                               <?php //endforeach; ?>
                                                </ul>

                                            </div>
                                            <?php //elseif (isset($data['success'])): ?>
                                            <div class="alert alert-success">
                                                <p>
                                                    <? //= $data['success']; ?>
                                                </p>
                                            </div>

                                            <?php //endif; ?>
                                            <div class="alert alert-info alert-styled-left alert-bordered">
                                                <p>
                                                    <i class="icon-dash"></i>
                                                    در صورت عدم تغییر رمز عبور، این مقدار تغییر نخواهد کرد.
                                                </p>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>رمز عبور جدید:</label>
                                                <input name="password" type="text"
                                                       class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                                       value=""">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>تکرار رمز عبور جدید:</label>
                                                <input name="re_password" type="text"
                                                       class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                                       value=""">
                                            </div>

                                            <div class="text-right col-md-12">
                                                <a href="<?= base_url('admin/manageUser'); ?>"
                                                   class="btn btn-default mr-5">
                                                    بازگشت
                                                </a>
                                                <button type="submit"
                                                        class="btn btn-primary submit-button submit-button">
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