<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container">
    <?php if (count($mainSlides)): ?>
        <div class="container">
            <div class="card-gap"></div>
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="main-slider-carousel owl-carousel">
                            <?php foreach ($mainSlides as $slide): ?>
                                <div>
                                    <a href="<?= $slide['link']; ?>">
                                        <img src="<?= base_url($slide['image']); ?>" alt="<?= $slide['link']; ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (count($offers)): ?>
        <div class="container card-container">
            <div class="section-header align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="section-title-icon"></div>
                    <h1 class="section-title">
                        محصولات ویژه
                    </h1>
                </div>
                <a href="<?= base_url('product/all/offers'); ?>" class="btn btn-secondary rounded-pill">
                    مشاهده همه
                    <i class="la la-arrow-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                </a>
            </div>
            <div class="items-slider-col-4 owl-carousel">
                <div class="card-wrapper semi-col-4">
                    <?php foreach ($offers as $offer): ?>
                        <div class="card">
                            <div class="off-label">
                                ویژه
                            </div>
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="<?= base_url('product/detail/' . $offer['id'] . '/' . $offer['slug']); ?>">
                                    <img src="<?= base_url($offer['image']); ?>"
                                         alt="<?= $offer['title']; ?>">
                                </a>
                                <span class="card-location">
                                    <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                                    <?= $offer['place']; ?>
                                </span>
                            </div>
                            <div class="card-title">
                                <a href="<?= base_url('product/detail/' . $offer['id'] . '/' . $offer['slug']); ?>"
                                   title="<?= $offer['title']; ?>">
                                    <?= $offer['title']; ?>
                                </a>
                            </div>

                            <?php
                            $discount = $offer['discount_until'] > time() ? convertNumbersToPersian($offer['discount_price'], true) : convertNumbersToPersian($offer['price'], true);
                            $discountPercentage = floor(((convertNumbersToPersian($offer['price'], true) - $discount) / convertNumbersToPersian($offer['price'], true)) * 100);
                            ?>
                            <div class="card-info">
                                <div>
                                    <?php if ($discountPercentage != 0): ?>
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
                                    <?php if ($discountPercentage != 0): ?>
                                        <div class="card-price-off">
                                            <?php if ($discountPercentage == 100): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($offer['discount_price'], true))); ?>
                                                تومان
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-price">
                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($offer['price'], true))); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-price-off">
                                            <?php if (convertNumbersToPersian($offer['price'], true) == 0): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($offer['price'], true))); ?>
                                                تومان
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-timer">
                                <div countdown
                                     data-date="<?= date('Y-m-d H:i:s', $offer['discount_until']); ?>">
                                    <div class="col">
                                        <span data-days>0</span>
                                        روز
                                    </div>
                                    <div class="col">
                                        <span data-hours>0</span>
                                        ساعت
                                    </div>
                                    <div class="col">
                                        <span data-minutes>0</span>
                                        دقیقه
                                    </div>
                                    <div class="col">
                                        <span data-seconds>0</span>
                                        ثانیه
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (count($newestProducts)): ?>
        <div class="container card-container">
            <div class="section-header align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="section-title-icon"></div>
                    <h1 class="section-title">
                        جدیدترین تخفیف‌ها
                    </h1>
                </div>
                <a href="<?= base_url('product/all'); ?>" class="btn btn-secondary rounded-pill">
                    مشاهده همه
                    <i class="la la-arrow-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                </a>
            </div>
            <div class="row">
                <?php foreach ($newestProducts as $item): ?>
                    <div class="card-wrapper col-lg-3 col-md-6 col-12">
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
                                    <?= $item['place']; ?>
                                </span>
                            </div>
                            <div class="card-title">
                                <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>"
                                   title="<?= $item['title']; ?>">
                                    <?= $item['title']; ?>
                                </a>
                            </div>

                            <?php
                            $discount = $item['discount_until'] > time() ? convertNumbersToPersian($item['discount_price'], true) : convertNumbersToPersian($item['price'], true);
                            $discountPercentage = floor(((convertNumbersToPersian($item['price'], true) - $discount) / convertNumbersToPersian($item['price'], true)) * 100);
                            ?>
                            <div class="card-info">
                                <div>
                                    <?php if ($discountPercentage != 0): ?>
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
                                    <?php if ($discountPercentage != 0): ?>
                                        <div class="card-price-off">
                                            <?php if ($discountPercentage == 100): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['discount_price'], true))); ?>
                                                تومان
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-price">
                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['price'], true))); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-price-off">
                                            <?php if (convertNumbersToPersian($item['price'], true) == 0): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['price'], true))); ?>
                                                تومان
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (count($lastNews)): ?>
        <div class="container card-container">
            <div class="section-header align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="section-title-icon"></div>
                    <h1 class="section-title">
                        آخرین اخبار شیراز مارکتینگ
                    </h1>
                </div>
                <a href="<?= base_url('blog/all'); ?>" class="btn btn-secondary rounded-pill">
                    مشاهده همه
                    <i class="la la-arrow-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                </a>
            </div>
            <div class="row">
                <?php foreach ($lastNews as $news): ?>
                    <div class="card-wrapper col-lg-4 col-md-6 col-12">
                        <div class="card card-news">
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="<?= base_url('blog/detail/' . $news['id'] . '/' . $news['slug']); ?>">
                                    <img src="<?= base_url($news['image']); ?>" alt="<?= $news['title']; ?>">
                                </a>
                                <div class="card-date">
                                    <?php
                                    $day = jDateTime::date('d', $news['created_at']);
                                    $month = jDateTime::date('F', $news['created_at']);
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
                                <a href="<?= base_url('blog/detail/' . $news['id'] . '/' . $news['slug']); ?>">
                                    <?= $news['title']; ?>
                                </a>
                            </div>
                            <p class="card-abstract">
                                <?= $news['abstract']; ?>
                            </p>
                            <div class="card-info">
                                <ul class="list-unstyled">
                                    <li class="list-inline-item">
                                        <i class="la la-list"></i>
                                        <a href="<?= base_url('blog/all/category/' . $news['category_id']); ?>"
                                           class="btn-link-secondary">
                                            <?= $news['category_name']; ?>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="la la-eye"></i>
                                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($news['view_count']), true)); ?>
                                        بازدید
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (count($ourTeam)): ?>
        <div class="container">
            <div class="section-header justify-content-center align-items-center">
                <h1 class="section-title">
                    با تیم ما آشنا شوید
                </h1>
                <div class="separator solid primary my-0 mr-4 col"></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="our-team owl-carousel">
                        <?php foreach ($ourTeam as $team): ?>
                            <div>
                                <div class="box">
                                    <div class="box-body">
                                        <img src="<?= base_url($team['image']); ?>"
                                             alt="" class="our-team-img">
                                        <h1 class="our-team-name">
                                            <?= $team['first_name'] . ' ' . $team['last_name']; ?>
                                        </h1>
                                        <span class="our-team-geo">
                                            <?= $team['city']; ?>
                                            ،
                                            <?= $team['province']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
