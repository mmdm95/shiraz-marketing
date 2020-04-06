<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta charset="UTF-8"/>
    <meta name="robots" content="noindex,nofollow">

    <link rel="apple-touch-icon" sizes="76x76" href="<?= $favIcon ?? ''; ?>">
    <link rel="icon" type="image/png" href="<?= $favIcon ?? ''; ?>">

    <title><?= $title ?? ''; ?></title>
    <!-- plugins:css -->
    <!-- inject:css -->
    <link href="<?= asset_url(); ?>be/css/icons/icomoon/styles.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/style.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/pageFont.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/bootstrap.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/myCustomCss.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/core.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/components.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset_url(); ?>be/css/colors.css?<?= app_version(); ?>" rel="stylesheet" type="text/css">

    <!---->

    <script type="application/javascript" src="<?= asset_url(); ?>be/js/core/libraries/jquery.min.js?<?= app_version(); ?>"></script>
    <script type="application/javascript" src="<?= asset_url(); ?>be/js/plugins/ui/ripple.min.js?<?= app_version(); ?>"></script>

    <!-- endinject -->
    <!-- plugin css for this page -->
    <?php if (isset($data['css']) && is_array(@$data['css']) && count(@$data['css']) > 0): ?>
        <?php foreach (@$data['css'] as $css): ?>
            <?= $css; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- End plugin css for this page -->
</head>
<body>
<script>
    var baseUrl = '<?= base_url(); ?>';
    var urlAction = '<?= ACTION; ?>';
    var urlController = '<?= CONTROLLER; ?>';
    var urlPlatform = '<?= PLATFORM; ?>';
</script>
