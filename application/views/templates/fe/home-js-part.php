<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<!-- inject:js-->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/select2.full.min.js"></script>
<!-- iziToast Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/iziToast.min.js"></script>
<!-- mCustomScrollbar Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- off-canvas Js -->
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/js-offcanvas.min.js"></script>
<script type="text/javascript" src="<?= asset_url(); ?>fe/js/main.js"></script>
<!-- endinject-->

<!-- plugins:js -->
<?php if (isset($data['js']) && is_array(@$data['js']) && count(@$data['js']) > 0): ?>
    <?php foreach (@$data['js'] as $js): ?>
        <?= $js; ?>
    <?php endforeach; ?>
<?php endif; ?>
<!-- endinject -->
