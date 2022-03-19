<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- inject:js-->
<!-- combine of [be/js/plugins/loaders/lazy.min.js],[fe/js/select2.full.min.js], -->
<!-- [fe/js/iziToast.min.js],[fe/js/jquery.mCustomScrollbar.concat.min.js],[fe/js/js-offcanvas.js], -->
<!-- [fe/js/owl.carousel.min.js],[fe/js/countdown.min.js] -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/bundle-bottom.js?<?= app_version(); ?>"></script>
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
