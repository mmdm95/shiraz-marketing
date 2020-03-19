<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container">
    <div class="container">
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">محصولات</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    بلیط رایگان هواپیما به چین
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">

    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
