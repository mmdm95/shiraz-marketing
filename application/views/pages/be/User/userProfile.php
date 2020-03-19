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
                                    class="text-semibold">مشاهده مشخصات کاربر</span>
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
                        <li class="active">مشاهده کاربر</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
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

                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">سفارش‌ها</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                                <li><a data-action="close"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered datatable-highlight">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>شماره فاکتور</th>
                                                    <th>تاریخ ثبت سفارش</th>
                                                    <th>وشعیت سفارش</th>
                                                    <th>مبلغ سفارش</th>
                                                    <th>وضعیت پرداخت</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- Load users data -->
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    <td align="center">
                                                        <!--                                                            --><?php //if (!empty($factor['payed_amount'])): ?>
                                                        <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-success">
                                                                    پرداخت شده
                                                                </span>
                                                        <!--                                                            --><?php //else: ?>
                                                        <!--                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left-->
                                                        <!--                                                                 border-left-lg border-left-danger">-->
                                                        <!--                                                                    پرداخت نشده-->
                                                        <!--                                                                </span>-->
                                                        <!--                                                            --><?php //endif; ?>
                                                    </td>
                                                    </td>
                                                    <td style="width: 115px;" class="text-center">
                                                        <ul class="icons-list">
                                                            <li class="text-info-800 mr-5">
                                                                <a href="<?= base_url(); ?>/admin/user/userProfileAction"
                                                                   title="مشاهده" data-popup="tooltip">
                                                                    <i class="icon-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /form centered -->
                <!-- Footer -->
                <?php $this->view("templates/be/copyright", $data); ?>
                <!-- /footer -->
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">زیرمجموعه‌ها</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                                <li><a data-action="close"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered datatable-highlight">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>نام و نام خانوادگی</th>
                                                    <th>نام کاربری</th>
                                                    <th>معرف</th>
                                                    <th>تاریخ ثبت</th>
                                                    <th>فعال/غیرفعال</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- Load users data -->
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" value="">
                                                        <input type="checkbox"
                                                               class="switchery uActiveDeactiveBtn"/>
                                                    </td>
                                                    <td style="width: 115px;" class="text-center">
                                                        <ul class="icons-list">
                                                            <li class="text-green-800 mr-5">
                                                                <a href="<?= base_url(); ?>/admin/user/userProfileAction"
                                                                   title="مشاهده" data-popup="tooltip">
                                                                    <i class="icon-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li class="text-black-600">
                                                                <a href="<?= base_url(); ?>/admin/user/changePassword"
                                                                   title="تغییر رمز عبور" data-popup="tooltip">
                                                                    <i class="icon-key"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="icons-list mt-10">
                                                            <li class="text-primary-600 mr-5">
                                                                <a href="<?= base_url(); ?>/admin/user/editUser"
                                                                   title="ویرایش" data-popup="tooltip">
                                                                    <i class="icon-pencil7"></i>
                                                                </a>
                                                            </li>
                                                            <li class="text-danger-600">
                                                                <a class="deleteUserBtn"
                                                                   title="حذف" data-popup="tooltip">
                                                                    <input type="hidden"
                                                                           value="">
                                                                    <i class="icon-trash"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->