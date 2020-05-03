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
                                    class="text-semibold">مدیریت نقش کاربران</span>
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
                        <li class="active">مدیریت نقش کاربران</li>
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
                            <div class="col-md-12">
                                <form action="<?= base_url('admin/user/addUserRole/' . $param[0]); ?>" method="post">
                                    <?= $form_token; ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php $this->view("templates/be/alert/error", ['errors' => $errors ?? null]); ?>
                                            <?php $this->view("templates/be/alert/success", ['success' => $success ?? null]); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="panel panel-white">
                                                <div class="panel-heading">
                                                    <h6 class="panel-title">افزودن نقش به کاربر</h6>
                                                    <div class="heading-elements">
                                                        <ul class="icons-list">
                                                            <li><a data-action="collapse"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="form-group col-lg-12">
                                                        <span class="text-danger">*</span>
                                                        <label>انتخاب نقش:</label>
                                                        <select class="select-no-search" name="role">
                                                            <option value="-1">
                                                                انتخاب کنید
                                                            </option>
                                                            <?php foreach ($roles as $role): ?>
                                                                <option value="<?= $role['id']; ?>">
                                                                    <?= $role['description']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="text-right col-md-12">
                                                        <a href="<?= base_url('admin/user/manageUser'); ?>"
                                                           class="btn btn-default mr-5">
                                                            بازگشت
                                                        </a>
                                                        <button type="submit"
                                                                class="btn btn-success submit-button submit-button">
                                                            افزودن نقش
                                                            <i class="icon-arrow-left12 position-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-sm-12 col-lg-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">لیست نقش‌های کاربر</h6>
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
                                                    <th>عنوان</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($userRoles as $key => $role): ?>
                                                    <tr>
                                                        <td width="50px">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td>
                                                            <?= $role['description']; ?>
                                                        </td>
                                                        <td style="width: 115px;" class="text-center">
                                                            <ul class="icons-list mt-10">
                                                                <li class="text-danger-600">
                                                                    <a class="deleteUserRoleBtn"
                                                                       title="حذف" data-popup="tooltip">
                                                                        <input type="hidden"
                                                                               value="<?= $param[0] . '-' . $role['id']; ?>">
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