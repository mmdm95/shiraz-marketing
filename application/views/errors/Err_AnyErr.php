<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>خطا در بارگذاری صفحه</title>

    <style>
        @font-face {
            font-family: "IRANSansWeb";
            font-style: normal;
            font-weight: 400;
            src: local("IRANSansWeb"), local("../fonts/IRANSansWeb"),
            url("<?= base_url('framework'); ?>/fonts/IRANSansWeb.woff") format("woff"),
            url("<?= base_url('framework'); ?>/fonts/IRANSansWeb.ttf") format("truetype")
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #fdfdfd;
            font-family: IRANSansWeb, sans-serif;
            direction: rtl;
            text-align: right;
        }

        .message-box {
            width: 90%;
            margin-right: 5%;
            margin-top: 15px;
            background-color: #fff;
            border-radius: 7px;
            -webkit-box-shadow: 0 5px 15px 0 rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 5px 15px 0 rgba(0, 0, 0, 0.2);
            box-shadow: 0 5px 15px 0 rgba(0, 0, 0, 0.2);
        }

        .message-header {
            border-bottom: 1px solid #eee;
            font-size: 16px;
            padding: 15px 20px;
        }

        .message-content {
            font-size: 13px;
            color: #666;
            padding: 15px;
            margin: 0;
            line-height: 21px;
        }
    </style>
</head>
<body>
<div class="message-box">
    <div class="message-header">
        <?= $Exceptions_detail['typeStr']; ?>
    </div>
    <p class="message-content">
        خطای
        <?= $Exceptions_detail['message']; ?>
        در فایل
        <strong><?= $Exceptions_detail['file']; ?></strong>
        در خط
        <strong><?= $Exceptions_detail['line']; ?></strong>
    </p>
</div>
</body>
</html>