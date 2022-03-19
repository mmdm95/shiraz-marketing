<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container">
    <?php $this->view('templates/fe/each-page-header', $data); ?>

    <div class="container">
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url('blog/all'); ?>" class="btn-link-black">همه اخبار و اطلاعیه‌ها</a>
                </li>
                <?php if (!empty($tagParam)): ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        برچسب
                        <?= $tagParam; ?>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $orderText; ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container card-container">
        <div class="section-header section-header-low-gap d-md-flex d-block align-items-center justify-content-between mb-0">
            <div class="d-flex mb-4">
                <div class="section-title-icon"></div>
                <h1 class="section-title">
                    <?= $orderText; ?>
                    -
                    <small>
                        <?= convertNumbersToPersian($pagination['total']); ?>
                        مورد
                    </small>
                </h1>
            </div>
            <div class="d-sm-flex d-block align-items-center mb-4 justify-content-end">
                <?php if (count($categories)): ?>
                    <div class="d-sm-flex d-block align-items-center ml-sm-4 ml-0 mb-3">
                        <label for="sortByCategorySelect" class="text-nowrap ml-3 mb-0">
                            دسته‌بندی:
                        </label>
                        <button type="button" class="btn btn-light dropdown-toggle form-control" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <?= $categoryText; ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item <?= empty($categoryParam) ? 'active' : ''; ?>"
                               href="<?= base_url('blog/all/order/' . $orderParam); ?>">
                                همه
                            </a>
                            <?php foreach ($categories as $category): ?>
                                <a class="dropdown-item <?= $category['slug'] == $categoryParam || $category['id'] == $categoryParam ? 'active' : ''; ?>"
                                   href="<?= base_url('blog/all/category/' . $category['slug'] . '/order/' . $orderParam); ?>">
                                    <?= $category['name']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="d-sm-flex d-block align-items-center mb-3">
                    <label for="sortBySelect" class="text-nowrap ml-3 mb-0">
                        مرتب سازی:
                    </label>
                    <button type="button" class="btn btn-light dropdown-toggle form-control" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?= $orderText; ?>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= $orderParam == 'newest' ? 'active' : ''; ?>"
                           href="<?= base_url('blog/all'); ?><?= !empty($categoryParam) ? '/category/' . $categoryParam : ''; ?><?= !empty($tagParam) ? '/tag/' . $tagParam : ''; ?>/order/newest">
                            جدیدترین
                        </a>
                        <a class="dropdown-item <?= $orderParam == 'most_view' ? 'active' : ''; ?>"
                           href="<?= base_url('blog/all'); ?><?= !empty($categoryParam) ? '/category/' . $categoryParam : ''; ?><?= !empty($tagParam) ? '/tag/' . $tagParam : ''; ?>/order/most_view">
                            پربازدیدترین
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (count($blog)): ?>
            <div class="row">
                <?php foreach ($blog as $b): ?>
                    <div class="card-wrapper col-lg-4 col-md-6 col-12">
                        <div class="card card-news">
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="<?= base_url('blog/detail/' . $b['id'] . '/' . $b['slug']); ?>">
                                    <?= $this->view('templates/fe/parser/image-placeholder', [
                                        'url' => base_url($b['image']),
                                        'alt' => $b['title'],
                                    ], true); ?>
                                </a>
                                <div class="card-date">
                                    <?php
                                    $day = jDateTime::date('d', $b['created_at']);
                                    $month = jDateTime::date('F', $b['created_at']);
                                    ?>
                                    <span class="day">
                                        <?= $day; ?>
                                    </span>
                                    <span class="month">
                                        <?= $month; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="card-title">
                                <a href="<?= base_url('blog/detail/' . $b['id'] . '/' . $b['slug']); ?>">
                                    <?= $b['title']; ?>
                                </a>
                            </div>
                            <p class="card-abstract">
                                <?= $b['abstract']; ?>
                            </p>
                            <div class="card-info">
                                <ul class="list-unstyled">
                                    <li class="list-inline-item">
                                        <i class="la la-list"></i>
                                        <a href="<?= base_url('blog/all/category/' . $b['category_id']); ?>"
                                           class="btn-link-secondary">
                                            <?= $b['category_name']; ?>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="la la-eye"></i>
                                        <?= convertNumbersToPersian(number_format($b['view_count'])); ?>
                                        بازدید
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php $this->view('templates/fe/pagination', [
                'total' => $pagination['total'],
                'firstPage' => $pagination['firstPage'],
                'lastPage' => $pagination['lastPage'],
                'pageNo' => $pagination['page'],
                'href' => base_url('blog/all') . (!empty($categoryParam) ? '/category/' . $categoryParam : '') . (!empty($tagParam) ? '/tag/' . $tagParam : '') . '/order/' . $orderParam,
            ]); ?>
        <?php else: ?>
            <div class="box">
                <div class="box-body text-center text-secondary">
                    <p class="empty-text">
                        هیچ موردی پیدا نشد!
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
