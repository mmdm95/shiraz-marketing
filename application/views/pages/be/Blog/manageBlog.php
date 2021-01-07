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
                                    class="text-semibold">نوشته‌ها</span>
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
                        <li class="active">نوشته‌ها</li>
                    </ul>
                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h6 class="panel-title">نوشته‌ها</h6>
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
                                            <th>تصویر</th>
                                            <th>عنوان نوشته</th>
                                            <th>نویسنده</th>
                                            <th>دسته‌بندی</th>
                                            <th>تعداد بازدید</th>
                                            <th>وضعیت نمایش</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($blog as $key => $b): ?>
                                            <tr>
                                                <td width="50px" data-order="<?= $key + 1; ?>">
                                                    <?= convertNumbersToPersian($key + 1); ?>
                                                </td>
                                                <td width="100px">
                                                    <a data-url="<?= base_url($b['image']); ?>"
                                                       data-popup="lightbox">
                                                        <img src=""
                                                             data-src="<?= base_url() . $b['image']; ?>"
                                                             alt="<?= $b['title']; ?>"
                                                             class="img-rounded img-preview lazy">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('blog/detail/' . $b['id'] . '/' . $b['slug']); ?>"
                                                       target="_blank">
                                                        <?= $b['title']; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if (!empty($b['username'])): ?>
                                                        <?php if (!empty($b['user_first_name']) || !empty($b['user_last_name'])): ?>
                                                            <?= $b['user_first_name'] . ' ' . $b['user_last_name']; ?>
                                                        <?php else: ?>
                                                            <?= $b['username']; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <i class="icon-minus2 text-danger" aria-hidden="true"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= $b['category_name']; ?>
                                                </td>
                                                <td>
                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($b['view_count'], true))); ?>
                                                </td>
                                                <td>
                                                    <?php if ($b['publish'] == 1): ?>
                                                        <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-success">فعال</span>
                                                    <?php else: ?>
                                                        <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-danger">غیر فعال</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="width: 115px;" class="text-center">
                                                    <ul class="icons-list">
                                                        <li class="text-primary-600">
                                                            <a href="<?= base_url('admin/blog/editBlog/' . $b['id']); ?>"
                                                               title="ویرایش" data-popup="tooltip">
                                                                <i class="icon-pencil7"></i>
                                                            </a>
                                                        </li>
                                                        <li class="text-danger-600">
                                                            <a class="deleteBlogBtn"
                                                               title="حذف" data-popup="tooltip">
                                                                <input type="hidden"
                                                                       value="<?= $b['id']; ?>">
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