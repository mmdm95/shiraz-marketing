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
                                    class="text-semibold">مشاهده مشخصات کاربر</span>
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
                        <li class="active">مشاهده کاربر</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="thumbnail">
                            <div class="thumb">
                                <img src="assets/images/placeholder.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <div class="panel panel-body border-top-primary text-left">
                            <h6 class="no-margin text-semibold display-inline-block">
                                ارتقاء
                                <small class="text-muted content-group-sm display-block no-margin-bottom">
                                    اگر کاربر پرچم تمام اطلاعاتش را تکمیل کرده دکمه ارتقا نمایش داده بشود. در غیر اینصورت پیام زیر به همراه دکمه تکمیل اطلاعات نمایش داده شود.
                                </small>
                            </h6>
                            <a href="" type="button" class="btn btn-primary display-inline-block pull-right mt-5">
                                <i class="icon-statistics position-left"></i>
                                ارتقاء
                            </a>
                            <a href="<?= base_url() ?>user/edituser" type="button" class="btn btn-warning display-inline-block pull-right mt-5">
                                <i class="icon-database-edit2 position-left"></i>
                                تکمیل اطلاعات کاربر
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
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
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>بازاریاب معرف:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>نام:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>نام خانوادگی:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>کد ملی:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
۴۴۲۰۴۴۰۳۹۲
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>نام پدر:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>شماره شناسنامه:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>محل صدور شناسنامه:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>تاریخ تولد:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
۲۴/۱۲/۱۳۹۸
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>شماره تلفن همراه:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
۰۹۱۳۹۵۱۸۰۵۵
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>شماره کارت:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
۶۰۳۷ ۹۹۱۸ ۹۵۶۹ ۶۲۳۹
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>جنسیت:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
۶۰۳۷ ۹۹۱۸ ۹۵۶۹ ۶۲۳۹
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>وضعیت سربازی:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
۶۰۳۷ ۹۹۱۸ ۹۵۶۹ ۶۲۳۹
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>استان:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>شهر:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <div class="col-lg-6">
                                                <strong>کد پستی:</strong>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
لورم
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-8">
                                            <div class="col-lg-3">
                                                <strong>آدرس:</strong>
                                            </div>
                                            <div class="col-lg-5">
                                                <span class="text-primary-600 ltr">
لورم اپیسوم برای این آدرس
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-8">
                                            <div class="col-lg-3">
                                                <strong>ایمیل:</strong>
                                            </div>
                                            <div class="col-lg-5">
                                                <span class="text-primary-600 ltr">
saeedgerami72@gmail.com
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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