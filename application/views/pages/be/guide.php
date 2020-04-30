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
                                    class="text-semibold">راهنمای استفاده</span>
                        </h5>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?= base_url(); ?>admin/index"><i class="icon-home2 position-left"></i>
                                داشبورد
                            </a>
                        </li>
                        <li class="active">راهنما</li>
                    </ul>

                </div>
            </div>
            <!-- /page header -->
            <!-- Page container -->
            <div class="page-container">
                <!-- Page content -->
                <div class="page-content">
                    <!-- Main content -->
                    <div class="content-wrapper">
                        <!-- Content area -->
                        <div class="content">
                            <!-- Color options -->
                            <h6 class="content-group text-semibold">
                                راهنمای اندازه تصاویر
                            </h6>
                            <div class="row">

                                <div class="col-sm-6">
                                    <!-- Line and border. Partial, filled -->
                                    <div class="panel panel-body border-top-blue">
                                        <ul class="list-feed list-feed-solid">
                                            <li class="border-warning-400">
                                                <h5 class="no-margin-top">
                                                    اندازه لوگو و فاوآیکون
                                                </h5>
                                                اندازه لوگو و فاوآیکون باید به صورت مربعی باشند که به معنای هم اندازه
                                                بودن طول و عرض آنها است.
                                                <br>
                                                <br>
                                                <strong>
                                                    نکته:
                                                </strong>
                                                اندازه فاوآیکون باید یکی از ابعاد زیر باشند:
                                                <br>
                                                <ul>
                                                    <li>
                                                        طول و عرض
                                                        <code>
                                                            32px
                                                        </code>
                                                    </li>
                                                    <li>
                                                        طول و عرض
                                                        <code>
                                                            64px
                                                        </code>
                                                    </li>
                                                    <li>
                                                        طول و عرض
                                                        <code>
                                                            128px
                                                        </code>
                                                    </li>
                                                    <li>
                                                        طول و عرض
                                                        <code>
                                                            256px
                                                        </code>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="border-info-400">
                                                <h5 class="no-margin-top">
                                                    اندازه تصاویر اسلاید
                                                </h5>
                                                در حالت کلی تصاویر اسلاید صفحه اصلی باید هم‌اندازه باشند، ولی به عنوان
                                                پیشنهاد بهتر تصاویر در طول
                                                <code>
                                                    1200px
                                                </code>
                                                و عرض
                                                <code>
                                                    380px
                                                </code>
                                                اندازه مناسبی است.
                                            </li>

                                            <li class="border-pink-400">
                                                <h5 class="no-margin-top">
                                                    اندازه تصاویر محصولات
                                                </h5>
                                                تصاویر محصولات میبایست در طول
                                                <code>
                                                    600px
                                                </code>
                                                و عرض
                                                <code>
                                                    372px
                                                </code>
                                                و یا ضریبی از این اندازه باشد برای مثال طول
                                                <code>
                                                    1200px
                                                </code>
                                                و عرض
                                                <code>
                                                    744px
                                                </code>
                                                که ضریب ۲ اندازه معیار است.
                                            </li>

                                            <li class="border-slate-600">
                                                <h5 class="no-margin-top">
                                                    اندازه تصاویر گالری محصولات
                                                </h5>
                                                اندازه تصاویر برای گالری محصولات بهتر است در طول
                                                <code>
                                                    680px
                                                </code>
                                                و عرض
                                                <code>
                                                    400px
                                                </code>
                                                باشند.
                                            </li>

                                            <li class="border-teal-400">
                                                <h5 class="no-margin-top">
                                                    اندازه تصاویر بلاگ
                                                </h5>
                                                به طور معمول تصویر بلاگ مورد قابل توجهی نیست ولی برای یکسان شدن نمایش
                                                تصاویر بهتر است آنها در یک اندازه باشند.
                                                اندازه پیشنهادی، اندازه تصاویر محصول می‌باشد.
                                            </li>

                                            <li class="border-danger-400">
                                                <h5 class="no-margin-top">
                                                    اندازه تصاویر بالای صفحات
                                                </h5>
                                                تصاویر بالای صفحه در هر صورت دچار بیرون‌زدگی می‌شوند ولی برای یکسان شدن
                                                اندازه تصاویر بهتر است آنها در طول
                                                <code>
                                                    1200px
                                                </code>
                                                و عرض
                                                <code>
                                                    250px
                                                </code>
                                                باشند.
                                            </li>

                                            <li class="border-danger-400">
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /line and border. Partial, filled -->

                                </div>
                            </div>
                            <!-- /color options -->
                            <!-- Footer -->
                            <?php $this->view("templates/be/copyright", $data); ?>
                            <!-- /footer -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->