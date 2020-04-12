<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-faq">
    <?php $this->view('templates/fe/each-page-header', $data); ?>

    <div class="container">
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    سؤالات متداول
                </li>
            </ol>
        </nav>

        <div class="accordion" id="faqAccordion">
            <?php foreach ($faq as $k => $aq): ?>
                <div class="">
                    <div class="accordion-link" id="heading<?= ($k + 1); ?>" data-toggle="collapse"
                         data-target="#collapse<?= ($k + 1); ?>"
                         aria-expanded="<?= $k == 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?= ($k + 1); ?>">
                        <h2 class="mb-0">
                            <?= $aq['question']; ?>
                        </h2>
                    </div>
                    <div id="collapse<?= ($k + 1); ?>" class="collapse <?= $k == 0 ? 'show' : ''; ?>"
                         aria-labelledby="heading<?= ($k + 1); ?>" data-parent="#faqAccordion">
                        <div class="box-body normal-line-height">
                            <?= $aq['answer']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="card-gap"></div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
