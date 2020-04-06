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
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered datatable-highlight">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>تصویر</th>
                                                    <th>عنوان</th>
                                                    <th>دسته‌بندی</th>
                                                    <th>تعداد موجود</th>
                                                    <th>تعداد فروخته شده</th>
                                                    <th>وضعیت نمایش</th>
                                                    <th>وضعیت موجودی</th>
                                                    <th>ثبت کننده</th>
                                                    <th>عملیات</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($products as $key => $product): ?>
                                                    <tr>
                                                        <td width="50px">
                                                            <?= convertNumbersToPersian($key + 1); ?>
                                                        </td>
                                                        <td width="100px">
                                                            <a data-url="<?= base_url($product['image']); ?>"
                                                               data-popup="lightbox">
                                                                <img src=""
                                                                     data-src="<?= base_url() . $product['image']; ?>"
                                                                     alt="<?= $product['title']; ?>"
                                                                     class="img-rounded img-preview lazy">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('product/detail/' . $product['id'] . '/' . $product['slug']); ?>"
                                                               target="_blank">
                                                                <?= $product['title']; ?>
                                                            </a>
                                                            <?php if ($product['is_special'] == 1): ?>
                                                                <span class="label label-danger ml-5">ویژه</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?= $product['category_name']; ?>
                                                        </td>
                                                        <td class="success" align="center">
                                                            <?= convertNumbersToPersian($product['stock_count']); ?>
                                                        </td>
                                                        <td class="info" align="center">
                                                            <?= convertNumbersToPersian($product['sold_count']); ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($product['publish'] == 1): ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                 border-left-lg border-left-success">فعال</span>
                                                            <?php else: ?>
                                                                <span class="label label-striped no-border-top no-border-right no-border-bottom border-left
                                                                border-left-lg border-left-danger">غیر فعال</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td width="100px">
                                                            <input type="hidden" value="<?= $product['id']; ?>">
                                                            <input type="checkbox"
                                                                   class="switchery productAvailability"
                                                                <?= set_value($product['available'] ?? '', 1, 'checked', '', '=='); ?> />
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($product['username'])): ?>
                                                                <?php if (!empty($product['user_first_name']) || !empty($product['user_last_name'])): ?>
                                                                    <?= $product['user_first_name'] . ' ' . $product['user_last_name']; ?>
                                                                <?php else: ?>
                                                                    <?= $product['username']; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <i class="icon-minus2 text-danger"
                                                                   aria-hidden="true"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td style="width: 115px;" class="text-center">
                                                            <ul class="icons-list">
                                                                <li class="text-primary-600">
                                                                    <a href="<?= base_url('admin/shop/editProduct/' . $product['id']); ?>"
                                                                       title="ویرایش" data-popup="tooltip">
                                                                        <i class="icon-pencil7"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="text-danger-600">
                                                                    <a class="deleteProductBtn"
                                                                       title="حذف" data-popup="tooltip">
                                                                        <input type="hidden"
                                                                               value="<?= $product['id']; ?>">
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