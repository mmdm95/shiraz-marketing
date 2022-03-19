<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

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
                                    class="text-semibold">مشاهده محصولات</span>
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
                        <li class="active">مشاهده محصولات</li>
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
                            <div class="col-sm-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">محصولات</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (in_array(AUTH_ROLE_SUPER_USER, $identity->role_id) ||
                                            in_array(AUTH_ROLE_ADMIN, $identity->role_id)): ?>
                                            <?php $dtColumns = '[{"data":"chk"},{"data":"id"},{"data":"image"},{"data":"title"},{"data":"category"},{"data":"type"},{"data":"stock"},{"data":"sold"},{"data":"publish"},{"data":"availability"},{"data":"creator"},{"data":"operations"}]'; ?>
                                        <?php else: ?>
                                            <?php $dtColumns = '[{"data":"chk"},{"data":"id"},{"data":"image"},{"data":"title"},{"data":"category"},{"data":"type"},{"data":"stock"},{"data":"sold"},{"data":"publish"},{"data":"availability"},{"data":"operations"}]'; ?>
                                        <?php endif; ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered datatable-product"
                                                   data-columns='<?= $dtColumns; ?>'
                                                   data-ajax-url="<?= base_url('admin/shop/getProductPaginatedTable'); ?>">
                                                <thead>
                                                <tr>
                                                    <th id="chks">
                                                        <label class="checkbox-switch no-margin-bottom">
                                                            <input type="checkbox" class="styled">
                                                        </label>
                                                    </th>
                                                    <th>#</th>
                                                    <th>تصویر</th>
                                                    <th>عنوان</th>
                                                    <th>دسته‌بندی</th>
                                                    <th>نوع کالا</th>
                                                    <th>تعداد موجود</th>
                                                    <th>تعداد فروخته شده</th>
                                                    <th>وضعیت نمایش</th>
                                                    <th>وضعیت موجودی</th>
                                                    <?php if (in_array(AUTH_ROLE_SUPER_USER, $identity->role_id) ||
                                                        in_array(AUTH_ROLE_ADMIN, $identity->role_id)): ?>
                                                        <th>ثبت کننده</th>
                                                    <?php endif; ?>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>#</th>
                                                    <th>تصویر</th>
                                                    <th>عنوان</th>
                                                    <th>دسته‌بندی</th>
                                                    <th>نوع کالا</th>
                                                    <th>تعداد موجود</th>
                                                    <th>تعداد فروخته شده</th>
                                                    <th>وضعیت نمایش</th>
                                                    <th>وضعیت موجودی</th>
                                                    <?php if (in_array(AUTH_ROLE_SUPER_USER, $identity->role_id) ||
                                                        in_array(AUTH_ROLE_ADMIN, $identity->role_id)): ?>
                                                        <th>ثبت کننده</th>
                                                    <?php endif; ?>
                                                    <th>عملیات</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /form centered -->

                <ul id="multiOperationMenu" class="fab-menu fab-menu-fixed fab-menu-bottom-right hide"
                    data-fab-toggle="click">
                    <li>
                        <a class="fab-menu-btn btn bg-teal-400 btn-float btn-rounded btn-icon">
                            <i class="fab-icon-open icon-paragraph-justify3"></i>
                            <i class="fab-icon-close icon-cross2"></i>
                        </a>

                        <ul class="fab-menu-inner">
                            <li>
                                <form action="" method="post" id="multiEditForm">
                                    <div data-fab-label="تغییر دسته‌جمعی">
                                        <button type="submit"
                                                class="btn btn-default btn-rounded btn-icon btn-float">
                                            <i class="icon-pencil"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

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