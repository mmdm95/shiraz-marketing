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
                                    class="text-semibold">افزودن کاربر جدید</span>
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
                        <li class="active">افزودن کاربر</li>
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
                                                <label>بازاریاب معرف:</label>
                                                <select class="select"
                                                        name="subset_of">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value="1">پر کردن دیتا</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>رمز عبور:</label>
                                                <input name="password" type="text"
                                                       class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                                       value=""">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>تکرار رمز عبور:</label>
                                                <input name="re_password" type="text"
                                                       class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                                       value=""">
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <label>کد ملی:</label>
                                                <input name="n_code" type="text"
                                                       class="form-control" placeholder="غیرقابل تغییر"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>نام:</label>
                                                <input name="first_name" type="text"
                                                       class="form-control" placeholder="حروف"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>نام خانوادگی:</label>
                                                <input name="last_name" type="text"
                                                       class="form-control" placeholder="حروف"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>نام پدر:</label>
                                                <input name="father_name" type="text"
                                                       class="form-control" placeholder="حروف"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>شماره شناسنامه:</label>
                                                <input name="birth_certificate_code" type="text"
                                                       class="form-control" placeholder="عدد"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>محل صدور شناسنامه:</label>
                                                <input name="birth_certificate_code_place" type="text"
                                                       class="form-control" placeholder="شهر محل صدور شناسنامه"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>تاریخ تولد:</label>
                                                <input type="hidden" name="" id="altDateFieldExpire">
                                                <input type="text" class="form-control range-to"
                                                       placeholder="تاریخ انقضا" readonly data-time="true"
                                                       data-alt-field="#altDateFieldExpire"
                                                       data-format="YYYY/MM/DD - HH:mm"
                                                       value="<?= set_value($fesVals['expire'] ?? ''); ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>شمار تلفن همراه:</label>
                                                <input name="mobile" type="text" required
                                                       class="form-control"
                                                       placeholder="مثال: 0913XXXXXXX"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>ایمیل:</label>
                                                <input name="email" type="text" required
                                                       class="form-control"
                                                       placeholder="مثال: user@example.com"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>استان:</label>
                                                <select class="select"
                                                        name="province">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value=""
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>شهر:</label>
                                                <input name="city" type="text" required
                                                       class="form-control"
                                                       placeholder=""
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <label>آدرس:</label>
                                                <input name="address" type="text" required
                                                       class="form-control"
                                                       placeholder="اینجا وارد کنید ..."
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>کدپستی:</label>
                                                <input name="postal_code" type="text" required
                                                       class="form-control"
                                                       placeholder="کد پستی ۱۰ رقمی"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>شماره کارت:</label>
                                                <input name="credit_card_number" type="text" required
                                                       class="form-control"
                                                       placeholder="شماره کارت ۱۶ رقمی"
                                                       value="">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>جنسیت:</label>
                                                <select class="select"
                                                        name="gender">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value="1"> مرد</option>
                                                    <option value="2"> زن</option>
                                                    <option value="2"> زن</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="text-danger">*</span>
                                                <label>وضعیت سربازی:</label>
                                                <select class="select"
                                                        name="military_status">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value="1"> مرد</option>
                                                    <option value="2"> زن</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="display-block">
                                                    <span class="text-danger">*</span>
                                                    تصویر را انتخاب کنید:
                                                </label>
                                                <input type="file" class="file-styled" name="image">
                                                <span class="help-block">فایل‌های مجاز: png, jpg, jpeg. حداکثر تا ۴ مگابایت</span>
                                            </div>
                                            <div class="text-right col-md-12">
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