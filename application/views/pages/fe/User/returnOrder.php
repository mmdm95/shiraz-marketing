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
            <!-- Page header -->
            <div class="page-header page-header-default"
                 style="border-top: 1px solid #ddd; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                <div class="page-header-content border-bottom border-bottom-success">
                    <div class="page-title">
                        <h5>
                            <i class="icon-circle position-left"></i> <span
                                class="text-semibold">فرم مرجوع صفارش</span>
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
                        <li class="active">مرجوع سفارش</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Centered forms -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url(); ?>admin/editUser/<?= @$data['param'][0]; ?>" method="post"
                              class="validation-form">
                            <!--                            --><? //= $data['form_token']; ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-white">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">توضیحات</h6>
                                            <div class="heading-elements">
                                                <ul class="icons-list">
                                                    <li><a data-action="collapse"></a></li>
                                                    <li><a data-action="close"></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group col-lg-4">
                                                <label>سفارش خود را انتخاب کنید:</label>
                                                <select class="select"
                                                        name="subset_of">
                                                    <option value="-1">کد سفارش</option>
                                                    <option value="1">پر کردن دیتا</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>تاریخ خرید:</label>
                                                <input type="hidden" name="expire" id="altDateField">
                                                <input type="text" class="form-control myAltDatepicker"
                                                       placeholder="تاریخ تولد" readonly data-alt-field="#altDateField"
                                                       value="">
                                            </div>
                                            <div class="form-group col-md-12 mt-10">
                                                <textarea
                                                    class="form-control"
                                                    style="width: 100%; min-width: 100%; max-width: 100%; min-height: 100px;"
                                                    name="description" placeholder="توضیحات"
                                                    rows="10"><?= set_value($pVals['description'] ?? ''); ?></textarea>
                                            </div>
                                            <div class="text-right col-md-12">
                                                <button type="submit"
                                                        class="btn btn-primary submit-button submit-button">
                                                    درخواست ارجاع
                                                    <i class="icon-arrow-left12 position-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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