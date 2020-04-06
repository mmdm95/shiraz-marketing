<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!-- inject:js -->
<!-- Core JS files -->
<script type="text/javascript" src="<?= asset_url(); ?>be/js/plugins/loaders/pace.min.js?<?= app_version(); ?>"></script>

<script type="text/javascript" src="<?= asset_url(); ?>be/js/plugins/notifications/pnotify.min.js?<?= app_version(); ?>"></script>

<script type="text/javascript" src="<?= asset_url(); ?>be/js/core/libraries/bootstrap.min.js?<?= app_version(); ?>"></script>
<!-- /core JS files -->
<!-- Theme JS files -->
<script type="text/javascript" src="<?= asset_url(); ?>be/js/plugins/forms/selects/select2.min.js?<?= app_version(); ?>"></script>
<script type="text/javascript" src="<?= asset_url(); ?>be/js/plugins/forms/styling/uniform.min.js?<?= app_version(); ?>"></script>
<script type="text/javascript" src="<?= asset_url(); ?>be/js/plugins/forms/styling/switchery.min.js?<?= app_version(); ?>"></script>
<script type="text/javascript" src="<?= asset_url(); ?>be/js/pages/form_layouts.js?<?= app_version(); ?>"></script>
<script type="text/javascript" src="<?= asset_url(); ?>be/js/pages/form_checkboxes_radios.js?<?= app_version(); ?>"></script>
<script type="text/javascript" src="<?= asset_url(); ?>be/js/plugins/loaders/lazy.min.js?<?= app_version(); ?>"></script>
<!-- /theme JS files -->
<!-- plugins:js -->
<?php if (isset($data['js']) && is_array(@$data['js']) && count(@$data['js']) > 0): ?>
    <?php foreach (@$data['js'] as $js): ?>
        <?= $js; ?>
    <?php endforeach; ?>
<?php endif; ?>
<!-- endinject -->

<script type="text/javascript" src="<?= asset_url(); ?>be/js/core/app.js?<?= app_version(); ?>"></script>