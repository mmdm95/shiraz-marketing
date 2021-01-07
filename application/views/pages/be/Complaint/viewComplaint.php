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
                                    class="text-semibold">شکایت</span>
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
                        <li>
                            <a href="<?= base_url(); ?>admin/manageComplaints">
                                مدیریت شکایات
                            </a>
                        </li>
                        <li class="active">مشاهده شکایت</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title ">مشاهده شکایت</h6>
                                        <div class="heading-elements">
                                            <a id="delComplaintBtn"
                                               class="btn btn-default btn-rounded heading-btn-group border-danger-600 text-danger-600 p-10"
                                               title="حذف" data-popup="tooltip">
                                                <input type="hidden" value="<?= $complaint['id']; ?>">
                                                <i class="icon-trash" aria-hidden="true"></i>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>
                                                    <i class="icon-envelop5 position-left bg-orange btn-rounded p-10"
                                                       style="width: 45px; height: 45px; font-size: 24px;"></i>
                                                    <a class="display-inline-block text-blue">
                                                        <div>
                                                            <?= $complaint['first_name'] . ' ' . ($complaint['last_name'] ?? ''); ?>
                                                        </div>
                                                    </a>
                                                    <span class="text-muted text-small display-inline-block">
                                                        <i class="icon-dash" aria-hidden="true"></i>
                                                    </span>
                                                </h5><ul class="media-list content-group">
                                                    <li class="media stack-media-on-mobile">
                                                        <div class="media-body text-light">
                                                            <ul class="list-unstyled text-muted mb-5">
                                                                <li class="text-teal-800">
                                                                    <i class="icon-mobile position-left"></i>
                                                                    <?= convertNumbersToPersian($complaint['mobile']); ?>
                                                                </li>
                                                                <li class="text-teal-800">
                                                                    <i class="icon-calendar position-left"></i>
                                                                    <?= jDateTime::date('j F Y در ساعت H:i', $complaint['created_at']); ?>
                                                                </li>
                                                                <?php if (!empty($complaint['email'])): ?>
                                                                    <li class="text-teal-800">
                                                                        <i class="icon-envelop position-left"></i>
                                                                        <?= $complaint['email']; ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="col-lg-12 alert-info p-15">
                                                    <?= $complaint['title'] ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-lg-12 jumbotron pr-20 pl-20">
                                                    <p class="text-black text-light"
                                                       style="font-size: 15px; line-height: 26px;">
                                                        <?= nl2br($complaint['body']); ?>
                                                    </p>
                                                </div>
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
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->