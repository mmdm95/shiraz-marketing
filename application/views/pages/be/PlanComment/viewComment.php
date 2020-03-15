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
                                    class="text-semibold">نظرات</span>
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
                            <a href="<?= base_url(); ?>admin/managePlanComment">
                                مدیریت نظرات
                            </a>
                        </li>
                        <li class="active">مشاهده نظر</li>
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
                                <?php if (isset($answerErrors) && count($answerErrors)): ?>
                                    <div class="alert alert-danger alert-styled-left alert-bordered
                                                 no-border-top no-border-right no-border-bottom">
                                        <ul class="list-unstyled">
                                            <?php foreach ($answerErrors as $err): ?>
                                                <li>
                                                    <i class="icon-dash" aria-hidden="true"></i>
                                                    <?= $err; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php elseif (isset($answerSuccess)): ?>
                                    <div class="alert alert-success alert-styled-left alert-bordered
                                                 no-border-top no-border-right no-border-bottom">
                                        <p>
                                            <?= $answerSuccess; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title ">مشاهده نظر</h6>
                                        <div class="heading-elements">
                                            <?php if ($comment['publish'] < 2): ?>
                                                <a href="javascript:void(0);"
                                                   id="acceptPlanCommentBtn"
                                                   class="btn btn-default btn-rounded heading-btn-group border-success-600 text-success-600 p-10"
                                                   title="تایید" data-popup="tooltip">
                                                    <input type="hidden" value="<?= $comment['id']; ?>">
                                                    <i class="icon-check" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($comment['publish'] == 2): ?>
                                                <a href="javascript:void(0);"
                                                   id="declinePlanCommentBtn"
                                                   class="btn btn-default btn-rounded heading-btn-group border-orange-600 text-orange-600 p-10"
                                                   title="عدم تأیید" data-popup="tooltip">
                                                    <input type="hidden" value="<?= $comment['id']; ?>">
                                                    <i class="icon-cross2" aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a id="delPlanCommentBtn"
                                               class="btn btn-default btn-rounded heading-btn-group border-danger-600 text-danger-600 p-10"
                                               title="حذف" data-popup="tooltip">
                                                <input type="hidden" value="<?= $comment['id']; ?>">
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
                                                    <a href="" class="display-inline-block">
                                                        <div class="text-small display-inline-block">
                                                            <?php if ($comment['publish'] == 1): ?>
                                                                <span class="label label-primary">
                                                                    در حال بررسی
                                                                </span>
                                                            <?php elseif ($comment['publish'] == 2): ?>
                                                                <span class="label label-success">
                                                                    تایید شده
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <?= $comment['name']; ?>
                                                        </div>
                                                    </a>
                                                    <span class="text-muted text-small display-inline-block">
                                                        <i class="icon-dash" aria-hidden="true"></i>
                                                        <?= jDateTime::date('j F Y', $comment['created_on']); ?>
                                                    </span>
                                                </h5>
                                                <ul class="list-unstyled text-muted mb-5 p-10">
                                                    <?php if (!empty($comment['mobile'])): ?>
                                                        <li class="text-indigo mb-10">
                                                            <i class="icon-mobile position-left"></i>
                                                            موبایل -
                                                            <?= convertNumbersToPersian($comment['mobile']); ?>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li class="text-indigo">
                                                        <i class="icon-location3 position-left"></i>
                                                        آی پی آدرس -
                                                        <?= $comment['ip_address']; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-12 mt-15"></div>

                                            <!-- Product-->
                                            <div class="col-lg-6 col-md-6">
                                                <div class="panel panel-body">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <a href="<?= base_url($event['image']); ?>"
                                                               data-popup="lightbox">
                                                                <img src="<?= base_url($event['image']); ?>"
                                                                     style="width: 70px; height: 70px;"
                                                                     class="img-circle" alt="">
                                                            </a>
                                                        </div>

                                                        <div class="media-body">
                                                            <h6 class="media-heading">
                                                                <a href="<?= base_url('event/detail/' . $event['slug']); ?>"
                                                                   target="_blank">
                                                                    <?= $event['title']; ?>
                                                                </a>
                                                            </h6>
                                                            <p class="mt-15">
                                                                <span class="label label-success">
                                                                    هزینه طرح:
                                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($event['total_price'], true))); ?>
                                                                    تومان
                                                                </span>
                                                                <span class="label label-info">
                                                                    هزینه ورودی:
                                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($event['base_price'], true))); ?>
                                                                    تومان
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="col-lg-12 jumbotron pr-20 pl-20">
                                                    <p><?= $comment['body'] ?? ''; ?></p>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="col-lg-12 pr-20 pl-20">
                                                    <?php if (!empty($comment['respond_on'])): ?>
                                                        <h6 class="mb-15">
                                                            تاریخ پاسخ:
                                                            <span class="text-grey">
                                                                <?= jDateTime::date('j F Y در ساعت H:i', $comment['respond_on']); ?>
                                                            </span>
                                                        </h6>
                                                    <?php endif; ?>
                                                    <form action="<?= base_url('admin/viewPlanComment/' . $param[0]); ?>"
                                                          method="post">
                                                        <?= $form_token_plan_answer; ?>

                                                        <textarea rows="5" cols="12" class="form-control"
                                                                  name="answer"
                                                                  style="min-height: 100px; resize: vertical;"
                                                                  placeholder="پاسخ"><?= $comment['respond'] ?? ''; ?></textarea>
                                                        <div class="text-right mt-20">
                                                            <button type="submit" class="btn btn-primary">
                                                                ذخیره پاسخ
                                                            </button>
                                                        </div>
                                                    </form>
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