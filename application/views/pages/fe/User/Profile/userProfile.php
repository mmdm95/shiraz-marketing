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
                    <div class="col-lg-2 col-lg-push-0 col-sm-4 col-sm-push-4 col-xs-4 col-xs-push-4">
                        <div class="thumbnail">
                            <div class="thumb">
                                <img src="<?= base_url($user['image']); ?>" alt="<?= $user['mobile']; ?>">
                            </div>
                        </div>
                    </div>

                    <?php if (!$auth->hasUserRole(AUTH_ROLE_MARKETER, $user['id'])): ?>
                        <div class="col-xs-12 col-md-12 col-lg-10">
                            <?php $this->view("templates/fe/user/alert/error", ['errors' => $errors ?? null]); ?>
                            <?php $this->view("templates/fe/user/alert/success", ['success' => $success ?? null]); ?>

                            <div class="panel panel-body border-top-primary text-left">
                                <h6 class="no-margin text-semibold display-inline-block">
                                    ارتقاء
                                    <small class="text-muted content-group-sm display-block no-margin-bottom">
                                        برای ارتقاء به بازاریاب، ابتدا باید تمام اطلاعات مربوط را تکمیل شود.
                                    </small>
                                </h6>

                                <?php if ($user['flag_info'] == 1 && $user['flag_marketer_request'] == 0): ?>
                                    <form action="<?= base_url('user/userProfile/' . $user['id']); ?>"
                                          method="post">
                                        <?= $form_token; ?>

                                        <button type="submit"
                                                class="btn btn-primary display-inline-block pull-right mt-5">
                                            <i class="icon-statistics position-left"></i>
                                            درخواست ارتقاء به بازاریاب
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <?php if ($user['flag_info'] != 1): ?>
                                    <a href="<?= base_url('user/editUser/' . $user['id']); ?>"
                                       class="btn btn-warning display-inline-block pull-right mt-5">
                                        <i class="icon-pencil position-left"></i>
                                        تکمیل اطلاعات کاربر
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-xs-12">
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
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>بازاریاب معرف:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?php if (!empty($user['superset_first_name']) || !empty($user['superset_last_name'])): ?>
                                                        <?= $user['superset_first_name'] . ' ' . $user['superset_last_name']; ?>
                                                    <?php else: ?>
                                                        <?= convertNumbersToPersian($user['superset_username'] ?? '') ?? '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                    <?php endif; ?>
                                                    <i class="icon-minus2 text-danger" aria-hidden="true"></i>
                                                    با کد
                                                    <?= $user['subset_of'] ?? '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>نام:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['first_name']) ? $user['first_name'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>نام خانوادگی:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['last_name']) ? $user['last_name'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>کد ملی:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['n_code']) ? convertNumbersToPersian($user['n_code']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>نام پدر:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['father_name']) ? $user['father_name'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>شماره شناسنامه:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 rtl">
                                                    <?= !empty($user['birth_certificate_code']) ? convertNumbersToPersian($user['birth_certificate_code']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>محل صدور شناسنامه:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['birth_certificate_code_place']) ? $user['birth_certificate_code_place'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>تاریخ تولد:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['birth_date']) ? jDateTime::date('j F Y در ساعت H:i', $user['birth_date']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>شماره تلفن همراه:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= convertNumbersToPersian($user['mobile']); ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>شماره کارت:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['credit_card_number']) ? convertNumbersToPersian($user['credit_card_number']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>جنسیت:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?php if ($user['gender'] == GENDER_MALE): ?>
                                                        مرد
                                                    <?php elseif ($user['gender'] == GENDER_FEMALE): ?>
                                                        زن
                                                    <?php else: ?>
                                                        <i class="icon-minus2 text-danger" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>وضعیت سربازی:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?php if (in_array($user['military_status'], array_keys(MILITARY_STATUS))): ?>
                                                        <?= MILITARY_STATUS[$user['military_status']]; ?>
                                                    <?php else: ?>
                                                        <i class="icon-minus2 text-danger" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>استان:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['province']) ? $user['province'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>شهر:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['city']) ? $user['city'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="col-lg-6">
                                        <strong>کد پستی:</strong>
                                    </div>
                                    <div class="col-lg-6">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['postal_code']) ? convertNumbersToPersian($user['postal_code']) : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-8">
                                    <div class="col-lg-3">
                                        <strong>آدرس:</strong>
                                    </div>
                                    <div class="col-lg-5">
                                                <span class="text-primary-600 ltr">
                                                    <?= !empty($user['address']) ? $user['address'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 mt-20">
                                    <?php $this->view('templates/fe/user/title', ['header_title' => 'سؤالات مربوط به بازاریابان']) ?>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label>شرکت‌هایی که با آن‌ها همکاری داشته‌اید:</label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question1']) ? $user['question1'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label>زمینه‌های شغلی که تا به حال تجربه کرده‌اید:</label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question2']) ? $user['question2'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                        <div class="form-group col-md-12 mt-10">
                                            <label>
                                                توضیحات:
                                            </label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['description']) ? $user['description'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label class="display-block">
                                                حدودا در زندگی با چند نفر در ارتباط هستید؟ (دوست، فامیل و
                                                ...)
                                            </label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question3']) ? $user['question3'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label>چرا بازاریابی را انتخاب می‌کنید؟</label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question4']) ? $user['question4'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label>در روز چند ساعت را حاضر هستید برای بازاریابی وقت
                                                بگذارید؟</label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question5']) ? $user['question5'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label>تمایل دارید در محل کار بازاریابی کنید یا به صورت
                                                آزاد؟</label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question6']) ? $user['question6'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
                                        </div>
                                        <div class="form-group col-md-6 col-lg-6">
                                            <label>تمایل دارید در محل کار از یونی‌فرم استفاده کنید یا پوشش
                                                آزاد؟</label>
                                            <span class="display-block text-primary-600">
                                                    <?= !empty($user['question7']) ? $user['question7'] : '<i class="icon-minus2 text-danger" aria-hidden="true"></i>'; ?>
                                                </span>
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