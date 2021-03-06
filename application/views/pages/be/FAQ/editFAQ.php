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
                                    class="text-semibold">ویرایش سؤال</span>
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
                            <a href="<?= base_url(); ?>admin/manageFAQ">
                                مدیریت سؤالات متداول
                            </a>
                        </li>
                        <li class="active">ویرایش سؤال</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url('admin/editFAQ/' . $param[0]); ?>" method="post">
                            <?= $form_token; ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">ویرایش سؤال</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel panel-body border-top-primary text-center">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>

                                            <h6 class="no-margin text-semibold">
                                                ویرایش سؤال
                                            </h6>
                                            <p class="text-muted content-group-sm">
                                            </p>
                                            <div class="row">
                                                <div class="form-group col-md-12 mt-10">
                                                    <textarea rows="5" cols="12" class="form-control"
                                                              name="question"
                                                              style="min-height: 100px; resize: vertical;"
                                                              placeholder="سؤال"><?= $faqValues['question'] ?? $faqCurValues['question'] ?? ''; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12 mt-10">
                                                    <textarea rows="5" cols="12" class="form-control"
                                                              name="answer"
                                                              style="min-height: 100px; resize: vertical;"
                                                              placeholder="پاسخ"><?= $faqValues['answer'] ?? $faqCurValues['answer'] ?? ''; ?></textarea>
                                                </div>
                                                <div class="text-right col-md-12">
                                                    <a href="<?= base_url('admin/manageFAQ'); ?>"
                                                       class="btn btn-default mr-5">
                                                        بازگشت
                                                    </a>
                                                    <button type="submit" class="btn btn-success">
                                                        ویرایش
                                                        <i class="icon-arrow-left12 position-right"></i>
                                                    </button>
                                                </div>
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