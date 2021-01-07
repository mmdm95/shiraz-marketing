<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-product-detail">
    <div class="container">
        <div class="card-gap"></div>
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url('product/all'); ?>" class="btn-link-black">همه محصولات</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $product['title']; ?>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xl-7 stretch-card">
                <div class="box d-flex flex-column justify-content-between">
                    <div class="thumbnail-slider-carousel owl-carousel" id="thumbnailSliderCarousel">
                        <?php if (count($product['gallery'])): ?>
                            <?php foreach ($product['gallery'] as $img): ?>
                                <div>
                                    <a href="javascript:void(0);">
                                        <img src="<?= base_url($img['image']); ?>" alt="">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div>
                                <a href="javascript:void(0);">
                                    <img src="<?= base_url($product['image']); ?>" alt="">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="owl-thumb owl-carousel" data-owl-carousel-thumb-id="thumbnailSliderCarousel">
                        <?php if (count($product['gallery'])): ?>
                            <?php foreach ($product['gallery'] as $img): ?>
                                <div>
                                    <a href="javascript:void(0);">
                                        <img src="<?= base_url($img['image']); ?>" alt="" class="owl-thumb-image">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div>
                                <a href="javascript:void(0);">
                                    <img src="<?= base_url($product['image']); ?>" alt="" class="owl-thumb-image">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 stretch-card">
                <div class="card justify-content-between">
                    <div>
                        <div class="box-body">
                            <?php if ($product['is_special'] == 1): ?>
                                <div class="off-label">
                                    ویژه
                                </div>
                            <?php endif; ?>
                            <div class="product-detail-side">
                                <h1 class="product-detail-side-title">
                                    <?= $product['title']; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <?php
                    $discount = (is_null($product['discount_until']) || $product['discount_until'] > time()) ? convertNumbersToPersian($product['discount_price'], true) : convertNumbersToPersian($product['price'], true);
                    $discountPercentage = floor(((convertNumbersToPersian($product['price'], true) - $discount) / convertNumbersToPersian($product['price'], true)) * 100);
                    ?>
                    <div class="box-body pt-0">
                        <div class="product-detail-side">
                            <div class="card-info col">
                                <?php if ($product['available'] == 1 && $product['stock_count'] > 0): ?>
                                    <?php if ($discountPercentage != 0): ?>
                                        <div class="card-price-off">
                                            <?php if ($discountPercentage == 100): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($product['discount_price'], true))); ?>
                                                تومان
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-price">
                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($product['price'], true))); ?>
                                            تومان
                                        </div>
                                    <?php else: ?>
                                        <div class="card-price-off">
                                            <?php if (convertNumbersToPersian($product['price'], true) == 0): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($product['price'], true))); ?>
                                                تومان
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="unavailable">
                                        ناموجود
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($discountPercentage != 0): ?>
                                <div class="text-center mr-2">
                                    <span class="badge badge-danger">
                                        <?= convertNumbersToPersian($discountPercentage); ?>
                                        ٪ تخفیف
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <div class="box-body pt-0">
                            <div class="mb-4 row justify-content-center">
                                <div class="col-lg-8 col-md-6 col-sm-12">
                                    <?php
                                    $cartCount = $product['max_cart_count'] > $product['stock_count'] ? $product['stock_count'] : $product['max_cart_count'];
                                    ?>
                                    <div class="product-detail-cart-count">
                                        <div class="product-detail-cart-count-btn product-detail-cart-count-btn-minus">
                                            <i class="la la-minus" aria-hidden="true"></i>
                                        </div>
                                        <div class="product-detail-cart-count-input">
                                            <input type="number" value="<?= $cartCount > 0 ? 1 : 0; ?>"
                                                   min="<?= $cartCount <= 0 ? 0 : 1; ?>"
                                                   max="<?= $cartCount <= 0 ? 0 : $cartCount; ?>"
                                                   class="form-control cartAddCountInput"
                                                   placeholder="" autocomplete="false"
                                                   data-cart-quantity-for="#addToCartBtn">
                                        </div>
                                        <div class="product-detail-cart-count-btn product-detail-cart-count-btn-plus">
                                            <i class="la la-plus" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-detail-side justify-content-center">
                                <button type="button" id="addToCartBtn"
                                        class="btn btn-success col-lg-8 col-md-6 col-sm-12 add-to-cart-btn"
                                        data-item-id="<?= $product['id']; ?>"
                                        data-item-quantity="<?= count($curCartItem) ? $curCartItem[0]['quantity'] : '1'; ?>">
                                    <i class="la la-shopping-cart font-size-21px float-right ml-2"
                                       aria-hidden="true"></i>
                                    <?php if (count($curCartItem)): ?>
                                        تغییر تعداد در سبد خرید
                                    <?php else: ?>
                                        افزودن به سبد خرید
                                    <?php endif; ?>
                                </button>
                            </div>
                        </div>
                        <div class="product-detail-side flex-column">
                            <?php
                            $reward = ((int)convertNumbersToPersian($product['reward'], true) * (int)convertNumbersToPersian($discount, true)) / 100;
                            ?>
                            <?php if ($reward != 0): ?>
                                <div class="product-detail-side-item product-detail-side-location alert-primary">
                                    <i class="la la-dollar-sign" aria-hidden="true"></i>
                                    <div>
                                        پاداش خرید
                                        <?= convertNumbersToPersian(number_format($reward)); ?>
                                        تومان (به ازای هر محصول)
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="product-detail-side-item product-detail-side-location">
                                <i class="la la-map-marker" aria-hidden="true"></i>
                                <div>
                                    <?= $product['province_name']; ?>
                                    ،
                                    <?= $product['city_name']; ?>
                                    ،
                                    <?= $product['place']; ?>
                                </div>
                            </div>
                            <?php if (!is_null($product['discount_until']) && $product['discount_until'] > time() && $discountPercentage != 0): ?>
                                <div class="product-detail-side-item product-detail-side-time">
                                    <i class="la la-clock-o" aria-hidden="true"></i>
                                    <div countdown
                                         data-date="<?= date('Y-m-d H:i:s', $product['discount_until']); ?>">
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
                            <?php endif; ?>
                            <div class="product-detail-side-item justify-content-between align-items-center">
                                <span class="mx-3 text-secondary">
                                    اشتراک گذاری در
                                </span>
                                <?php
                                $shareLink = str_replace('\\', '/', URITracker::get_last_uri());
                                ?>
                                <ul class="list-unstyled product-detail-side-share col p-0">
                                    <li class="list-inline-item">
                                        <a href="https://t.me/share/url?url=<?= $shareLink; ?>"
                                           onClick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                           class="btn-link-black-reverse" target="_blank"
                                           title="اشتراک گذاری در تلگرام">
                                            <i class="la la-telegram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://www.instagram.com/?url=<?= $shareLink; ?>" target="_blank"
                                           onClick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                           class="btn-link-black-reverse" title="اشتراک گذاری در اینستاگرام">
                                            <i class="la la-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="whatsapp://send?text=<?= $shareLink; ?>" class="btn-link-black-reverse"
                                           data-action="share/whatsapp/share"
                                           onClick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                                           target="_blank" title="اشتراک گذاری در واتس‌اَپ">
                                            <i class="la la-whatsapp" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header">
                        <i class="la la-file-text float-right ml-2" aria-hidden="true"></i>
                        <h5>
                            توضیحات
                        </h5>
                    </div>
                    <div class="box-body normal-line-height">
                        <?= $product['description']; ?>
                    </div>
                </div>
            </div>

            <?php if ($product['keywords'] != ''): ?>
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-body">
                            <?php
                            $keywords = explode(',', $product['keywords']);
                            ?>
                            <?php foreach ($keywords as $keyword): ?>
                                <a href="<?= base_url('product/all/tag/' . trim($keyword)); ?>"
                                   class="btn btn-outline-secondary m-2">
                                    <?= trim($keyword); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($product['related'])): ?>
                <div class="col-lg-12">
                    <div class="section-header align-items-center">
                        <div class="section-title-icon"></div>
                        <h1 class="section-title">
                            محصولات مرتبط
                        </h1>
                    </div>
                    <div class="items-slider-col-3 owl-carousel">
                        <?php foreach ($product['related'] as $related): ?>
                            <div class="card-wrapper semi-col-3">
                                <div class="card">
                                    <?php if ($related['is_special'] == 1): ?>
                                        <div class="off-label">
                                            ویژه
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-side-top-right">
                                        <button class="btn bg-white text-success rounded-pill add-to-cart-btn" data-item-id="<?= $related['id']; ?>"
                                                data-toggle="tooltip" data-placement="left" title="افزودن به سبد خرید">
                                            <i class="la la-cart-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="card-img">
                                        <div class="img-placeholder">
                                            <i class="la la-image" aria-hidden="true"></i>
                                        </div>
                                        <a href="<?= base_url('product/detail/' . $related['id'] . '/' . $related['slug']); ?>">
                                            <img src="<?= base_url($related['image']); ?>"
                                                 alt="<?= $related['title']; ?>">
                                        </a>
                                        <span class="card-location">
                                            <i class="la la-map-marker card-location-icon" aria-hidden="true"></i>
                                            <?= $related['province_name']; ?>
                                            ،
                                            <?= $related['city_name']; ?>
                                            ،
                                            <?= $related['place']; ?>
                                        </span>
                                    </div>
                                    <div class="card-title">
                                        <a href="<?= base_url('product/detail/' . $related['id'] . '/' . $related['slug']); ?>"
                                           title="<?= $related['title']; ?>">
                                            <?= $related['title']; ?>
                                        </a>
                                    </div>

                                    <?php
                                    $discount = (is_null($related['discount_until']) || $related['discount_until'] > time()) ? convertNumbersToPersian($related['discount_price'], true) : convertNumbersToPersian($related['price'], true);
                                    $discountPercentage = floor(((convertNumbersToPersian($related['price'], true) - $discount) / convertNumbersToPersian($related['price'], true)) * 100);
                                    ?>
                                    <div class="card-info">
                                        <div>
                                            <?php if ($discountPercentage != 0 && $related['available'] == 1 && $related['stock_count'] > 0): ?>
                                                <span class="btn rounded-pill card-off-percentage">
                                                    <?= convertNumbersToPersian($discountPercentage); ?>
                                                    ٪
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if ($related['available'] == 1 && $related['stock_count'] > 0): ?>
                                                <?php if ($discountPercentage != 0): ?>
                                                    <div class="card-price-off">
                                                        <?php if ($discountPercentage == 100): ?>
                                                            رایگان
                                                        <?php else: ?>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($related['discount_price'], true))); ?>
                                                            تومان
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="card-price">
                                                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($related['price'], true))); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="card-price-off">
                                                        <?php if (convertNumbersToPersian($related['price'], true) == 0): ?>
                                                            رایگان
                                                        <?php else: ?>
                                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($related['price'], true))); ?>
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
            <?php endif; ?>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
