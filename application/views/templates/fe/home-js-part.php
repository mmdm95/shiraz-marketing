<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- inject:js-->
<!-- select2 Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/select2.full.min.js?<?= app_version(); ?>"></script>
<!-- iziToast Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/iziToast.min.js?<?= app_version(); ?>"></script>
<!-- mCustomScrollbar Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/jquery.mCustomScrollbar.concat.min.js?<?= app_version(); ?>"></script>
<!-- off-canvas Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/js-offcanvas.js?<?= app_version(); ?>"></script>
<!-- owl-carousel Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/owl.carousel.min.js?<?= app_version(); ?>"></script>
<!-- countdown Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/countdown.min.js?<?= app_version(); ?>"></script>
<!-- main Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/main.js?<?= app_version(); ?>"></script>
<!-- cart Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/cartJs.js?<?= app_version(); ?>"></script>
<!-- endinject-->

<!-- plugins:js -->
<?php if (isset($data['js']) && is_array(@$data['js']) && count(@$data['js']) > 0): ?>
    <?php foreach (@$data['js'] as $js): ?>
        <?= $js; ?>
    <?php endforeach; ?>
<?php endif; ?>
<!-- endinject -->
