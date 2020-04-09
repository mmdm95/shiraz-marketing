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
                                    class="text-semibold">تغییر مشخصات کاربر</span>
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
                        <li class="active">ویرایش حساب کاربری</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url('user/editUser'); ?>" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-lg-3 col-sm-6">
                                    <div class="thumbnail">
                                        <div class="thumb">
                                            <img src="<?= base_url($uTrueValues['image']); ?>"
                                                 alt="<?= $uTrueValues['mobile']; ?>">
                                            <div class="caption-overflow">
                                                <span>
                                                    <a href="<?= base_url('admin/user/userProfile/' . $uTrueValues['id']); ?>"
                                                       class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i
                                                                class="icon-link2"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="caption">
                                            <a href="<?= base_url('admin/user/userProfile/' . $uTrueValues['id']); ?>"
                                               class="text-default">
                                                <?php if (!empty($uTrueValues['first_name']) || !empty($uTrueValues['last_name'])): ?>
                                                    <?= $uTrueValues['first_name'] . ' ' . $uTrueValues['last_name']; ?>
                                                <?php else: ?>
                                                    <?= convertNumbersToPersian($uTrueValues['mobile']); ?>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
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
                                            <?php $this->view("templates/fe/user/alert/error", ['errors' => $errors ?? null]); ?>
                                            <?php $this->view("templates/fe/user/alert/success", ['success' => $success ?? null]); ?>

                                            <!-- Guide -->
                                            <div class="form-group">
                                                <div style="background-color: #f9f9f9;"
                                                     class="alert border-top border-top-lg border-top-info">
                                                    <ul>
                                                        <li class="mb-10">
                                                            موارد ضروری برای تکمیل خرید با رنگ
                                                            <span class="img-xxs bg-green display-inline-block border-radius"></span>
                                                            مشخص شده‌اند.
                                                        </li>
                                                        <li>
                                                            موارد ضروری برای درخواست بازاریابی با رنگ
                                                            <span class="img-xxs bg-blue display-inline-block border-radius"></span>
                                                            مشخص شده‌اند.
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- /Guide -->

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
                                                       value="<?= $uValues['mobile'] ?? $uTrueValues['mobile'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-6 col-lg-pull-6">
                                                <label>بازاریاب معرف:</label>
                                                <select class="select"
                                                        name="subset_of">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <?php foreach ($marketers as $marketer): ?>
                                                        <option value="<?= $marketer['id']; ?>"
                                                            <?= set_value($uValues['subset_of'] ?? $uTrueValues['subset_of'] ?? '', $marketer['id'], 'selected', '', '=='); ?>>
                                                            <?php if (!empty($marketer['first_name']) || !empty($marketer['last_name'])): ?>
                                                                <?= $marketer['first_name'] . ' ' . $marketer['last_name']; ?>
                                                                -
                                                                <?= $marketer['username']; ?>
                                                            <?php else: ?>
                                                                ناشناس
                                                            <?php endif; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-12"></div>

                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>نام:</label>
                                                <input name="first_name" type="text"
                                                       class="form-control" placeholder="حروف"
                                                       value="<?= $uValues['first_name'] ?? $uTrueValues['first_name'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>نام خانوادگی:</label>
                                                <input name="last_name" type="text"
                                                       class="form-control" placeholder="حروف"
                                                       value="<?= $uValues['last_name'] ?? $uTrueValues['last_name'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>نام پدر:</label>
                                                <input name="father_name" type="text"
                                                       class="form-control" placeholder="حروف"
                                                       value="<?= $uValues['father_name'] ?? $uTrueValues['father_name'] ?? '' ?>">
                                            </div>

                                            <div class="col-lg-12"></div>

                                            <div class="form-group col-lg-3">
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>کد ملی:</label>
                                                <input name="n_code" type="text"
                                                       class="form-control"
                                                       value="<?= $uValues['n_code'] ?? $uTrueValues['n_code'] ?? ''; ?>">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>شماره شناسنامه:</label>
                                                <input name="birth_certificate_code" type="text"
                                                       class="form-control" placeholder="عدد"
                                                       value="<?= $uValues['birth_certificate_code'] ?? $uTrueValues['birth_certificate_code'] ?? '' ?>">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>محل صدور شناسنامه:</label>
                                                <input name="birth_certificate_code_place" type="text"
                                                       class="form-control" placeholder="شهر محل صدور شناسنامه"
                                                       value="<?= $uValues['birth_certificate_code_place'] ?? $uTrueValues['birth_certificate_code_place'] ?? '' ?>">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>تاریخ تولد:</label>
                                                <input type="hidden" name="birth_date" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ تولد" readonly data-alt-field="#altDateField"
                                                       value="<?= date('Y/m/d H:i', $uValues['birth_date'] ?? $uTrueValues['birth_date'] ?? time()); ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>استان:</label>
                                                <select class="select cityLoader" data-target-for="#citySelect"
                                                        name="province">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <?php foreach ($provinces as $province): ?>
                                                        <option value="<?= $province['id']; ?>"
                                                            <?= set_value($uValues['province'] ?? $uTrueValues['province'] ?? '', $province['id'], 'selected', '', '=='); ?>>
                                                            <?= $province['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>شهر:</label>
                                                <select class="select" id="citySelect"
                                                        name="city">
                                                    <option value="-1">انتخاب کنید</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-8">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>آدرس:</label>
                                                <input name="address" type="text" required
                                                       class="form-control"
                                                       placeholder="اینجا وارد کنید ..."
                                                       value="<?= $uValues['address'] ?? $uTrueValues['address'] ?? '' ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>کدپستی:</label>
                                                <input name="postal_code" type="text" required
                                                       class="form-control"
                                                       placeholder="کد پستی ۱۰ رقمی"
                                                       value="<?= $uValues['postal_code'] ?? $uTrueValues['postal_code'] ?? '' ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>شماره کارت:</label>
                                                <input name="credit_card_number" type="text" required
                                                       class="form-control"
                                                       placeholder="شماره کارت ۱۶ رقمی"
                                                       value="<?= $uValues['credit_card_number'] ?? $uTrueValues['credit_card_number'] ?? '' ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <span class="note-size bg-green mr-5 mt-5 pull-lef"></span>
                                                <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                <label>جنسیت:</label>
                                                <select class="select-no-search"
                                                        name="gender">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <option value="<?= GENDER_MALE; ?>"
                                                        <?= set_value($uValues['gender'] ?? $uTrueValues['gender'] ?? '', GENDER_MALE, 'selected', '', '=='); ?>>
                                                        مرد
                                                    </option>
                                                    <option value="<?= GENDER_FEMALE; ?>"
                                                        <?= set_value($uValues['gender'] ?? $uTrueValues['gender'] ?? '', GENDER_FEMALE, 'selected', '', '=='); ?>>
                                                        زن
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>وضعیت سربازی:</label>
                                                <select class="select-no-search"
                                                        name="military_status">
                                                    <option value="-1">انتخاب کنید</option>
                                                    <?php foreach (MILITARY_STATUS as $id => $text): ?>
                                                        <option value="<?= $id; ?>"
                                                            <?= set_value($uValues['military_status'] ?? $uTrueValues['military_status'] ?? '', $id, 'selected', '', '=='); ?>>
                                                            <?= $text; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
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
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>شرکت‌هایی که با آن‌ها همکاری داشته‌اید:</label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question1" style="height: 70px;
                                                          resize: none;"><?= $uValues['question1'] ?? $uTrueValues['question1'] ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6">
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>زمینه‌های شغلی که تا به حال تجربه کرده‌اید:</label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question2" style="height: 70px;
                                                          resize: none;"><?= $uValues['question2'] ?? $uTrueValues['question2'] ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-12 mt-10">
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>
                                                            توضیحات:
                                                        </label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="description"
                                                                  style="min-height: 100px; resize: vertical;"
                                                                  placeholder="یادداشت کنید ..."><?= $uValues['description'] ?? $uTrueValues['description'] ?? ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group col-md-6 col-lg-6">
                                                        <label class="display-block">
                                                            <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                            حدودا در زندگی با چند نفر در ارتباط هستید؟ (دوست، فامیل و
                                                            ...)
                                                        </label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question3" style="height: 70px;
                                                          resize: none;"><?= $uValues['question3'] ?? $uTrueValues['question3'] ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6">
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>چرا بازاریابی را انتخاب می‌کنید؟</label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question4" style="height: 70px;
                                                          resize: none;"><?= $uValues['question4'] ?? $uTrueValues['question4'] ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6">
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>در روز چند ساعت را حاضر هستید برای بازاریابی وقت
                                                            بگذارید؟</label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question5" style="height: 70px;
                                                          resize: none;"><?= $uValues['question5'] ?? $uTrueValues['question5'] ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6">
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>تمایل دارید در محل کار بازاریابی کنید یا به صورت
                                                            آزاد؟</label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question6" style="height: 70px;
                                                          resize: none;"><?= $uValues['question6'] ?? $uTrueValues['question6'] ?? ''; ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6 col-lg-6">
                                                        <span class="note-size bg-blue mr-5 mt-5 pull-left"></span>
                                                        <label>تمایل دارید در محل کار از یونی‌فرم استفاده کنید یا پوشش
                                                            آزاد؟</label>
                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="question7" style="height: 70px;
                                                          resize: none;"><?= $uValues['question7'] ?? $uTrueValues['question7'] ?? ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-right col-md-12">
                                                <a href="<?= base_url('user/dashboard'); ?>"
                                                   class="btn btn-default mr-5">
                                                    بازگشت
                                                </a>
                                                <button type="submit"
                                                        class="btn btn-success submit-button">
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