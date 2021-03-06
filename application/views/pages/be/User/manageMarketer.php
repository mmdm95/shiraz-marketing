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
                                    class="text-semibold">مدیریت کاربران</span>
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
                        <li class="active">مدیریت کاربران</li>
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
                            <div class="col-sm-12 col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">لیست کاربران</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
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
                                                    <th>تاریخ ثبت</th>
                                                    <th>فعال/غیرفعال</th>
                                                    <th>تیم ما</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($marketers as $key => $marketer): ?>
                                                    <tr>
                                                        <td width="50px" data-order="<?= $key + 1; ?>">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($marketer['first_name']) || !empty($marketer['last_name'])): ?>
                                                                <?= $marketer['first_name'] . ' ' . $marketer['last_name']; ?>
                                                            <?php else: ?>
                                                                <i class="icon-minus2 text-danger"
                                                                   aria-hidden="true"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?= $marketer['username']; ?>
                                                        </td>
                                                        <td data-order="<?= $marketer['created_at']; ?>">
                                                            <?= jDateTime::date('j F Y در ساعت H:i', $marketer['created_at']); ?>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" value="<?= $marketer['id']; ?>">
                                                            <input type="checkbox"
                                                                   class="switchery uActiveDeactiveBtn"
                                                                <?= set_value($marketer['active'] ?? '', 1, 'checked', '', '=='); ?> />
                                                        </td>
                                                        <td>
                                                            <input type="hidden" value="<?= $marketer['id']; ?>">
                                                            <input type="checkbox"
                                                                   class="switchery inOurTeamBtn"
                                                                <?= set_value($marketer['is_in_team'] ?? '', 1, 'checked', '', '=='); ?> />
                                                        </td>
                                                        <td style="width: 115px;" class="text-center">
                                                            <ul class="icons-list">
                                                                <li class="text-green-800 mr-5">
                                                                    <a href="<?= base_url('admin/user/userProfile/' . $marketer['id']); ?>"
                                                                       title="مشاهده" data-popup="tooltip">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="text-black-600">
                                                                    <a href="<?= base_url('admin/user/changePassword/' . $marketer['id']); ?>"
                                                                       title="تغییر رمز عبور" data-popup="tooltip">
                                                                        <i class="icon-key"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="text-warning-800">
                                                                    <a href="<?= base_url('admin/user/userDeposit/' . $marketer['id']); ?>"
                                                                       title="کیف پول" data-popup="tooltip">
                                                                        <i class="icon-wallet"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <ul class="icons-list mt-10">
                                                                <li class="text-primary-600 mr-5">
                                                                    <a href="<?= base_url('admin/user/editUser/' . $marketer['id']); ?>"
                                                                       title="ویرایش" data-popup="tooltip">
                                                                        <i class="icon-pencil7"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="text-danger-600">
                                                                    <a class="deleteMarketerBtn"
                                                                       title="حذف از لیست بازاریابان" data-popup="tooltip">
                                                                        <input type="hidden"
                                                                               value="<?= $marketer['id']; ?>">
                                                                        <i class="icon-trash"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->