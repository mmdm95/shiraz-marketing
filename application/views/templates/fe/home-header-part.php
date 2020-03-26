<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="<?= LANGUAGE; ?>">
<head>
    <meta charset="UTF-8">

    <link rel="apple-touch-icon" sizes="76x76" href="<?= $favIcon ?? ''; ?>">
    <link rel="icon" type="image/png" href="<?= $favIcon ?? ''; ?>">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? ''; ?></title>

    <!-- inject:css -->
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/bootstrap.min.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/fontawesome.min.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/line-awesome.min.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/jquery.mCustomScrollbar.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/js-offcanvas.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/owl.carousel.min.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/select2.css?<?= app_version(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>fe/css/main.css?<?= app_version(); ?>">
    <!-- endinject -->

    <!-- plugin css for this page -->
    <?php if (isset($css) && is_array(@$css) && count(@$css) > 0): ?>
        <?php foreach (@$css as $css): ?>
            <?= $css; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- End plugin css for this page -->

    <!-- inject:js -->
    <script src="<?= asset_url(); ?>fe/js/jquery-3.4.1.min.js?<?= app_version(); ?>"></script>
    <script src="<?= asset_url(); ?>fe/js/popper.min.js?<?= app_version(); ?>"></script>
    <script src="<?= asset_url(); ?>fe/js/bootstrap.min.js?<?= app_version(); ?>"></script>
    <!-- endinject -->
</head>
<body class="rtl-text">
<script>
    var baseUrl = '<?= base_url(); ?>';
    var siteLogo = '<?= $logo ?? ''; ?>';
    //-----
    var siteAction = '<?= ACTION; ?>';
</script>
