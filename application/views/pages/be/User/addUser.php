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
                        <form action="<?= base_url(); ?>admin/user/addUser" method="post">
                            <?= $form_token; ?>

                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h6 class="panel-title">مشخصات فردی</h6>
                                    <div class="heading-elements">
                                        <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                    <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>


                                    <div class="form-group col-lg-6 col-lg-push-6 border border-grey-300 border-dashed p-20">
                                        <label class="display-block">
                                            تصویر را انتخاب کنید:
                                        </label>
                                        <input type="file" class="file-styled form-control" name="image">
                                        <span class="help-block">فایل‌های مجاز: png, jpg, jpeg. حداکثر تا ۲ مگابایت</span>
                                    </div>
                                    <div class="form-group col-lg-6 col-lg-pull-6">
                                        <span class="text-danger">*</span>
                                        <label>
                                            شمار تلفن همراه
                                            <span class="text-danger">
                                                (نام کاربری)
                                            </span>
                                            :</label>
                                        <input name="mobile" type="text" required
                                               class="form-control"
                                               placeholder="مثال: 0913XXXXXXX"
                                               value="<?= $uValues['mobile'] ?? ''; ?>">
                                    </div>
                                    <div class="form-group col-lg-6 col-lg-pull-6">
                                        <span class="text-danger">*</span>
                                        <label>بازاریاب معرف:</label>
                                        <select class="select"
                                                name="subset_of">
                                            <option value="-1">انتخاب کنید</option>
                                            <?php foreach ($marketers as $marketer): ?>
                                                <option value="<?= $marketer['id']; ?>"
                                                    <?= set_value($uValues['subset_of'] ?? '', $marketer['id'], 'selected', '', '=='); ?>>
                                                    <?php if (!empty($marketer['first_name']) || !empty($marketer['last_name'])): ?>
                                                        <?= $marketer['first_name'] . ' ' . $marketer['last_name']; ?>
                                                    <?php else: ?>
                                                        <?= $marketer['username']; ?>
                                                    <?php endif; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-12"></div>

                                    <div class="form-group col-lg-4">
                                        <span class="text-danger">*</span>
                                        <label>رمز عبور:</label>
                                        <input name="password" type="password"
                                               class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                               value="">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <span class="text-danger">*</span>
                                        <label>تکرار رمز عبور:</label>
                                        <input name="re_password" type="password"
                                               class="form-control" placeholder="ترکیبی از حروف انگلیسی و عدد"
                                               value="">
                                    </div>

                                    <div class="col-lg-12"></div>

                                    <div class="form-group col-lg-4">
                                        <label>نام:</label>
                                        <input name="first_name" type="text"
                                               class="form-control" placeholder="حروف"
                                               value="<?= $uValues['first_name'] ?? ''; ?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>نام خانوادگی:</label>
                                        <input name="last_name" type="text"
                                               class="form-control" placeholder="حروف"
                                               value="<?= $uValues['last_name'] ?? ''; ?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label>کد ملی:</label>
                                        <input name="n_code" type="text"
                                               class="form-control" value="<?= $uValues['n_code'] ?? ''; ?>">
                                    </div>

                                    <div class="text-right col-md-12">
                                        <a href="<?= base_url('admin/user/manageUser'); ?>"
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