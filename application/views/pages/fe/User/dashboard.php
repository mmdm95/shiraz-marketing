<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

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
            <!-- Content area -->
            <div class="content">
                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <label class="label label-default border-left border-left-xlg border-left-green-800 bg-green-600 p-10 mb-15">
                                <h6 class="no-margin">
                                    تاریخ امروز :
                                    <?= $todayDate; ?>
                                </h6>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div>
                                    <h5 class="mb-15 text-grey-400">
                                        <i class="icon-circle-left2"></i>
                                        دسترسی سریع
                                    </h5>
                                </div>
                                <div class="pt-15 text-center my-main-page">
                                    <ul class="list-unstyled list-inline row">
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>user/editUser" style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-pencil7" aria-hidden="true"></i>
                                                <span>
                                                    ویرایش حساب
                                                </span>
                                            </a>
                                        </li>
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>user/userProfile" style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-eye" aria-hidden="true"></i>
                                                <span>
                                                    مشاهده حساب
                                                </span>
                                            </a>
                                        </li>
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>user/manageOrders" style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-cart" aria-hidden="true"></i>
                                                <span>
                                                    سفارشات من
                                                </span>
                                            </a>
                                        </li>
                                        <li class="col-xs-6 col-sm-4 col-md-3">
                                            <a href="<?= base_url(); ?>user/userDeposit" style="min-width: 130px;"
                                               class="btn btn-info btn-float btn-float-lg border-left border-grey-300
                                        border-left-info-300 bg-white border-left-lg display-block panel no-border-radius">
                                                <i class="icon-wallet" aria-hidden="true"></i>
                                                <span>
کیف پول
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <hr>
                        </div>
                    </div>
                </div>
                <!-- /dashboard content -->

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