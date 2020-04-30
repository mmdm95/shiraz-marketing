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
                    <a href="<?= base_url('product/all'); ?>" class="btn-link-black">همه محصولات</a>
                </li>
                <?php if (!empty($tagParam)): ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        برچسب
                        <?= $tagParam; ?>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $orderText; ?>
                    محصولات
                    <?= !empty($specialParam) ? 'ویژه' : ''; ?>
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
                    <?= !empty($specialParam) ? 'ویژه‌ها' : ''; ?>
                    -
                    <small>
                        <?= convertNumbersToPersian($pagination['total']); ?>
                        مورد
                    </small>
                </h1>
            </div>
            <div class="d-sm-flex d-block align-items-center mb-4 justify-content-end">
                <div class="d-sm-flex d-block align-items-center ml-sm-4 ml-0 mb-3">
                    <label for="sortBySelect" class="text-nowrap ml-3 mb-0">
                        مرتب سازی:
                    </label>
                    <button type="button" class="btn btn-light dropdown-toggle form-control" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <?= $orderText; ?>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item <?= $orderParam == 'newest' ? 'active' : ''; ?>"
                           href="<?= base_url('product/all'); ?><?= !empty($categoryParam) ? '/category/' . $categoryParam : ''; ?><?= !empty($tagParam) ? '/tag/' . $tagParam : ''; ?><?= !empty($specialParam) ? '/offers' : ''; ?>/order/newest">
                            جدیدترین
                        </a>
                        <a class="dropdown-item <?= $orderParam == 'most_discount' ? 'active' : ''; ?>"
                           href="<?= base_url('product/all'); ?><?= !empty($categoryParam) ? '/category/' . $categoryParam : ''; ?><?= !empty($tagParam) ? '/tag/' . $tagParam : ''; ?><?= !empty($specialParam) ? '/offers' : ''; ?>/order/most_discount">
                            پرتخفیفترین
                        </a>
                        <a class="dropdown-item <?= $orderParam == 'most_view' ? 'active' : ''; ?>"
                           href="<?= base_url('product/all'); ?><?= !empty($categoryParam) ? '/category/' . $categoryParam : ''; ?><?= !empty($tagParam) ? '/tag/' . $tagParam : ''; ?><?= !empty($specialParam) ? '/offers' : ''; ?>/order/most_view">
                            پربازدیدترین
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (count($products)): ?>
            <div class="row">
                <?php foreach ($products as $item): ?>
                    <div class="card-wrapper col-lg-4 col-md-6 col-12">
                        <div class="card">
                            <?php if ($item['is_special'] == 1): ?>
                                <div class="off-label">
                                    ویژه
                                </div>
                            <?php endif; ?>
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>">
                                    <img src="<?= base_url($item['image']); ?>" alt="<?= $item['title']; ?>">
                                </a>
                                <span class="card-location">
                                    <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                                    <?= $item['province_name']; ?>
                                    ،
                                    <?= $item['city_name']; ?>
                                    ،
                                    <?= $item['place']; ?>
                                </span>
                            </div>
                            <div class="card-title">
                                <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>"
                                   title="<?= $item['title']; ?>">
                                    <?= $item['title']; ?>
                                </a>
                            </div>
                            <div class="card-info">
                                <div>
                                    <?php
                                    $discount = $item['discount_until'] > time() ? convertNumbersToPersian($item['discount_price'], true) : convertNumbersToPersian($item['price'], true);
                                    $discountPercentage = floor(((convertNumbersToPersian($item['price'], true) - $discount) / convertNumbersToPersian($item['price'], true)) * 100);
                                    ?>
                                    <?php if ($discountPercentage != 0 && $item['available'] == 1 && $item['stock_count'] > 0): ?>
                                        <span class="btn rounded-pill card-off-percentage">
                                        <?= convertNumbersToPersian($discountPercentage); ?>
                                            ٪
                                            <span class="card-off-percentage-takhfif">
                                                تخفیف
                                            </span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php if ($item['available'] == 1 && $item['stock_count'] > 0): ?>
                                        <?php if ($discountPercentage != 0): ?>
                                            <span class="card-price-off">
                                                <?php if ($discountPercentage == 100): ?>
                                                    رایگان
                                                <?php else: ?>
                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['discount_price'], true))); ?>
                                                    تومان
                                                <?php endif; ?>
                                            </span>
                                            <span class="card-price">
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['price'], true))); ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="card-price-off">
                                                <?php if (convertNumbersToPersian($item['price'], true) == 0): ?>
                                                    رایگان
                                                <?php else: ?>
                                                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['price'], true))); ?>
                                                    تومان
                                                <?php endif; ?>
                                            </span>
                                            <!-- This div is not empty. have half space in it -->
                                            <div class="card-price">‌</div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="unavailable">
                                            ناموجود
                                        </div>
                                        <!-- This div is not empty. have half space in it -->
                                        <div class="card-price">‌</div>
                                    <?php endif; ?>
                                </div>
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
                'href' => base_url('product/all') . (!empty($categoryParam) ? '/category/' . $categoryParam : '') . (!empty($tagParam) ? '/tag/' . $tagParam : '') . (!empty($specialParam) ? '/offers' : '') . '/order/' . $orderParam,
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
