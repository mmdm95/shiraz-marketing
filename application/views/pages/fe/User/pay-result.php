<!-- Main navbar -->
<?php $this->view("templates/fe/user/mainnavbar", $data); ?>
<!-- /main navbar -->

<script>
    (function ($) {
        'use strict';

        $(function() {
            setTimeout(function () {
                window.location.href = baseUrl + "user/userDeposit";
            }, 5000);
        });
    })(jQuery);
</script>

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
                                    class="text-semibold">کیف پول من</span>
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
                        <li class="active">کیف پول من</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">نتیجه افزایش اعتبار</h6>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                $alertType = isset($is_success) && $is_success === true ? 'bg-success' : 'bg-danger';
                                $alertTextType = isset($is_success) && $is_success === true ? 'text-success' : 'text-danger';
                                ?>
                                <div class="alert <?= $alertType; ?> alert-styled-left">
                                    <?php if (isset($is_success) && $is_success === true): ?>
                                        <span class="text-semibold">پرداخت موفق</span>
                                    <?php else: ?>
                                        <span class="text-semibold">پرداخت ناموفق</span>
                                        <?php if (isset($have_ref_id) && $have_ref_id === true): ?>
                                            -
                                            شماره پیگیری
                                            <?= $ref_id ?: '<i class="icon-minus2" aria-hidden="true"></i>'; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <p class="h6 text-center <?= $alertTextType; ?>">
                                    <?php if (isset($is_success) && $is_success === true): ?>
                                        کیف پول شما شارژ شد.
                                    <?php else: ?>
                                        <?= $error ?? ''; ?>
                                    <?php endif; ?>
                                </p>
                                <p class="h6 text-center mt-20">
                                    در صورت کسر شدن مبلغ از حساب شما و عدم بازگشت تا ۷۲ ساعت، به بانک خود مراجعه کنید.
                                </p>
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