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
                                        <img src="<?= $slide['image']; ?>" alt="<?= $slide['link']; ?>">
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
            <div class="section-header justify-content-between flex-column flex-sm-row">
                <div class="d-flex align-items-center">
                    <div class="section-title-icon"></div>
                    <h1 class="section-title">
                        پیشنهادهای شگفت انگیز
                    </h1>
                </div>
                <a href="<?= base_url('product/all/offers'); ?>" class="btn btn-secondary rounded-pill my-2">
                    مشاهده همه
                    <i class="la la-arrow-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                </a>
            </div>
            <div class="items-slider-col-4 owl-carousel">
                <?php foreach ($offers as $offer): ?>
                    <div class="card-wrapper semi-col-4">
                        <div class="card">
                            <div class="off-label">
                                ویژه
                            </div>
                            <div class="card-side-top-right">
                                <button class="btn bg-white text-success rounded-pill add-to-cart-btn"
                                        data-item-id="<?= $offer['id']; ?>"
                                        data-toggle="tooltip" data-placement="left" title="افزودن به سبد خرید">
                                    <i class="la la-cart-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="card-img">
                                <div class="img-placeholder">
                                    <i class="la la-image" aria-hidden="true"></i>
                                </div>
                                <a href="<?= base_url('product/detail/' . $offer['id'] . '/' . $offer['slug']); ?>">
                                    <img src="<?= base_url($offer['image']); ?>" alt="<?= $offer['title']; ?>">
                                </a>
                                <span class="card-location">
                                    <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                                    <?= $offer['province_name']; ?>
                                    ،
                                    <?= $offer['city_name']; ?>
                                    ،
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
                            $discount = (is_null($offer['discount_until']) || $offer['discount_until'] > time()) ? convertNumbersToPersian($offer['discount_price'], true) : convertNumbersToPersian($offer['price'], true);
                            $discountPercentage = floor(((convertNumbersToPersian($offer['price'], true) - $discount) / convertNumbersToPersian($offer['price'], true)) * 100);
                            ?>
                            <div class="card-info">
                                <div>
                                    <?php if ($discountPercentage != 0 && $offer['available'] == 1 && $offer['stock_count'] > 0): ?>
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
                                    <?php if ($offer['available'] == 1 && $offer['stock_count'] > 0): ?>
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
                            <div class="card-timer">
                                <div countdown
                                     data-date="<?= date('Y-m-d H:i:s', !is_null($offer['discount_until']) ? $offer['discount_until'] : (time() - 86400)); ?>">
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
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (count($productsSliders ?? [])): ?>
        <?php foreach ($productsSliders as $sliderItem): ?>
            <?php
            $slider = $sliderItem['items'] ?? [];
            $info = $sliderItem['info'] ?? [];
            $col_1 = 'col-xl-3';
            $col_2 = 'col-xl-9';
            $hasSideImage = true;

            if (!isset($info['image']) || empty($info['image'])) {
                $col_1 = '';
                $col_2 = 'col-xl-12';
                $hasSideImage = false;
            }
            ?>

            <?php if (count($slider ?? [])): ?>
                <div class="container">
                    <div class="row align-items-center">
                        <?php if ($hasSideImage): ?>
                            <div class="<?= $col_1; ?> d-none d-xl-block">
                                <a href="<?= $info['image_link']; ?>">
                                    <img src="<?= base_url($info['image']); ?>"
                                         alt="<?= $info['image']; ?>" width="100%" height="auto"
                                         style="border-radius: .5rem;">
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="<?= $col_2; ?>">
                            <?php if (!empty($info['title'] ?? []) || !empty($info['link'] ?? [])): ?>
                                <div class="section-header justify-content-between flex-column flex-sm-row">
                                    <?php if (!empty($info['title'] ?? [])): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="section-title-icon"></div>
                                            <h1 class="section-title">
                                                <?= $info['title']; ?>
                                            </h1>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($info['link'] ?? [])): ?>
                                        <a href="<?= base_url($info['link']); ?>"
                                           class="btn btn-secondary rounded-pill my-2">
                                            مشاهده همه
                                            <i class="la la-arrow-left float-left font-size-21px mr-3"
                                               aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="container card-container">
                                <div class="items-slider-col-3 owl-carousel">
                                    <?php foreach ($slider as $item): ?>
                                        <div class="card-wrapper semi-col-3">
                                            <div class="card">
                                                <?php if ($item['is_special'] == 1): ?>
                                                    <div class="off-label">
                                                        ویژه
                                                    </div>
                                                <?php endif; ?>
                                                <div class="card-side-top-right">
                                                    <button class="btn bg-white text-success rounded-pill add-to-cart-btn"
                                                            data-item-id="<?= $item['id']; ?>"
                                                            data-toggle="tooltip" data-placement="left"
                                                            title="افزودن به سبد خرید">
                                                        <i class="la la-cart-plus" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="card-img">
                                                    <div class="img-placeholder">
                                                        <i class="la la-image" aria-hidden="true"></i>
                                                    </div>
                                                    <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>">
                                                        <img src="<?= base_url($item['image']); ?>"
                                                             alt="<?= $item['title']; ?>">
                                                    </a>
                                                    <span class="card-location">
                                                        <i class="la la-map-marker card-location-icon"
                                                           aria-hidden="true"></i>
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

                                                <?php
                                                $discount = (is_null($item['discount_until']) || $item['discount_until'] > time()) ? convertNumbersToPersian($item['discount_price'], true) : convertNumbersToPersian($item['price'], true);
                                                $discountPercentage = floor(((convertNumbersToPersian($item['price'], true) - $discount) / convertNumbersToPersian($item['price'], true)) * 100);
                                                ?>
                                                <div class="card-info">
                                                    <div>
                                                        <?php if ($discountPercentage != 0 && $item['available'] == 1 && $item['stock_count'] > 0): ?>
                                                            <span class="btn rounded-pill card-off-percentage">
                                                                <?= convertNumbersToPersian($discountPercentage); ?>
                                                                ٪
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <?php if ($item['available'] == 1 && $item['stock_count'] > 0): ?>
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
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (count($lastNews)): ?>
        <div class="container card-container">
            <div class="section-header justify-content-between flex-column flex-sm-row">
                <div class="d-flex align-items-center">
                    <div class="section-title-icon"></div>
                    <h1 class="section-title">
                        آخرین مطالب
                    </h1>
                </div>
                <a href="<?= base_url('blog/all'); ?>" class="btn btn-secondary rounded-pill my-2">
                    مشاهده همه
                    <i class="la la-arrow-left float-left font-size-21px mr-3" aria-hidden="true"></i>
                </a>
            </div>
            <div class="items-slider-col-3 owl-carousel">
                <?php foreach ($lastNews as $news): ?>
                    <div class="card-wrapper semi-col-3">
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
                                        <?= convertNumbersToPersian(number_format($news['view_count'])); ?>
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
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($team['image']),
                                            'alt' => '',
                                            'class' => 'our-team-img'
                                        ], true); ?>
                                        <h1 class="our-team-name">
                                            <?= $team['first_name'] . ' ' . $team['last_name']; ?>
                                        </h1>
                                        <?php if (!empty($team['city']) || !empty($team['province'])): ?>
                                            <span class="our-team-geo">
                                                <?php if (empty($team['city'])): ?>
                                                    <?= $team['province']; ?>
                                                <?php elseif (empty($team['province'])): ?>
                                                    <?= $team['city']; ?>
                                                <?php else: ?>
                                                    <?= $team['city']; ?>
                                                    ،
                                                    <?= $team['province']; ?>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
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
