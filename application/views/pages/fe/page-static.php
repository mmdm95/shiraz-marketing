<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-static-pages">
    <div class="container">
        <div class="card-gap"></div>
        <div class="box">
            <div class="box-body">
                <h1 class="box-header-simple">
                    <?= $page['title']; ?>
                </h1>
                <div class="normal-line-height">
                    <?= $page['body']; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
