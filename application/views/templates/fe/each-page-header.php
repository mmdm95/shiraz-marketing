<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="page-all-header__wrapper card">
        <div class="page-img">
            <img src="<?= base_url(isset($page_image) && empty($page_image) ? $page_image : ''); ?>" alt="">
        </div>

        <div class="page-all-header">
            <h1>
                <?= $page_title ?? ''; ?>
            </h1>
        </div>
    </div>
</div>
