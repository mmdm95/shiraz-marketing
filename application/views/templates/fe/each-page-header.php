<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="page-all-header__wrapper card">
        <div class="page-img">
            <img src="<?= base_url(isset($page_image) && !empty($page_image) ? $page_image : ''); ?>" alt="">
        </div>

        <div class="page-all-header">
            <h1>
                <?= $page_title ?? ''; ?>
            </h1>
            <?php if (isset($page_sub_title) && !empty($page_sub_title)): ?>
                <h5 class="mt-4 mb-0">
                    <?= $page_sub_title; ?>
                </h5>
            <?php endif; ?>
        </div>

        <?php if (isset($page_has_search)): ?>
            <form action="<?= $page_has_search['action'] ?>" method="get">
                <div class="row justify-content-center m-0">
                    <div class="col-md-6">
                        <div class="main-input__wrapper mt-5">
                            <input type="text" class="form-control" name="q"
                                   placeholder="<?= $page_has_search['placeholder'] ?? ''; ?>"
                                   value="<?= $_GET['q'] ?? ''; ?>">
                            <span class="input-icon right">
                        <i class="la la-search"></i>
                    </span>
                            <span class="input-icon left clear-icon">
                        <i class="la la-times"></i>
                    </span>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
