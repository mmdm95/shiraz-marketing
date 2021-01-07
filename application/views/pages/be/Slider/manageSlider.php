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
                                    class="text-semibold">مدیریت اسلاید‌ها</span>
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
                        <li class="active">مدیریت اسلایدها</li>
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
                                <h6 class="panel-title">لیست اسلاید‌ها</h6>
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
                                            <th>لینک</th>
                                            <th>عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($slideValues as $key => $slide): ?>
                                            <tr>
                                                <td width="50px" data-order="<?= $key + 1; ?>">
                                                    <?= convertNumbersToPersian($key + 1); ?>
                                                </td>
                                                <td width="100px">
                                                    <a data-url="<?= base_url($slide['image']); ?>"
                                                       data-popup="lightbox">
                                                        <img src=""
                                                             data-src="<?= base_url() . $slide['image']; ?>"
                                                             alt="<?= $slide['link']; ?>"
                                                             class="img-rounded img-preview lazy">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?= $slide['link']; ?>" target="_blank">
                                                        <?= $slide['link']; ?>
                                                    </a>
                                                </td>
                                                <td style="width: 115px;" class="text-center">
                                                    <ul class="icons-list mt-10">
                                                        <li class="text-primary-600 mr-5">
                                                            <a href="<?= base_url('admin/editSlide/' . $slide['id']); ?>"
                                                               title="ویرایش" data-popup="tooltip">
                                                                <i class="icon-pencil7"></i>
                                                            </a>
                                                        </li>
                                                        <li class="text-danger-600">
                                                            <a class="deleteSlideBtn"
                                                               title="حذف" data-popup="tooltip">
                                                                <input type="hidden"
                                                                       value="<?= $slide['id']; ?>">
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