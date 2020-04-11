<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (count($items)): ?>
    <div class="row">
        <div class="col-lg-8 order-2 order-lg-1">
            <div class="card overflow-visible">
                <div class="shopping-cart-container">
                    <?php foreach ($items as $item): ?>
                        <div class="shopping-cart-item" data-product-id="<?= $item['id']; ?>">
                            <button type="button" class="btn btn-danger checkout-btn-remove"
                                    data-toggle="tooltip" data-placement="left" title="حذف محصول">
                                <i class="la la-times" aria-hidden="true"></i>
                            </button>
                            <div class="shopping-cart-item-main">
                                <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>">
                                    <img src="<?= base_url($item['image']); ?>" alt="<?= $item['title']; ?>">
                                </a>
                                <div class="shopping-cart-item-title col">
                                    <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>"
                                       class="btn-link-black">
                                        <?= $item['title']; ?>
                                    </a>
                                </div>
                                <div class="shopping-cart-item-count__wrapper">
                                    <select class="shopping-cart-item-count input-select2 form-control">
                                        <?php for ($i = 1; $i <= $item['max_cart_count'] && $i <= $item['stock_count']; $i++): ?>
                                            <option value="<?= $i; ?>" <?= $i == $item['quantity'] ? 'selected' : ''; ?>>
                                                <?= convertNumbersToPersian($i); ?>
                                                عدد
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="shopping-cart-item-info">
                                <div class="text-secondary">
                                    در دسته‌بندی
                                    <a href="<?= base_url('product/all/category/' . $item['category_slug']); ?>"
                                       class="btn-link-black">
                                        <?= $item['category_name']; ?>
                                    </a>
                                </div>
                                <div class="card-info">
                                    <?php if ($item['discount_percentage'] != 0): ?>
                                        <span class="card-price-off">
                                            <?php if ($item['discount_percentage'] == 100): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['discount_price'], true) * $item['quantity'])); ?>
                                                تومان
                                            <?php endif; ?>
                                        </span>
                                        <span class="card-price">
                                            <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['price'], true) * $item['quantity'])); ?>
                                            تومان
                                        </span>
                                    <?php else: ?>
                                        <span class="card-price-off">
                                            <?php if (convertNumbersToPersian($item['price'], true) == 0): ?>
                                                رایگان
                                            <?php else: ?>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['price'], true) * $item['quantity'])); ?>
                                                تومان
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

        <div class="col-lg-4 col-md-6 order-1 order-lg-2 mx-auto">
            <div class="box">
                <div class="box-body">
                    <div class="shopping-cart-container">
                        <div class="shopping-cart-info">
                            <div class="shopping-cart-info-item">
                                <div>
                                    مبلغ کل (
                                    <?= convertNumbersToPersian(count($items)); ?>
                                    کالا) :
                                </div>
                                <div class="text-dark">
                                    <?php if ($totalAmount == 0): ?>
                                        رایگان
                                    <?php else: ?>
                                        <?= convertNumbersToPersian(number_format($totalAmount)); ?>
                                        تومان
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="shopping-cart-info-item">
                                <div class="text-primary">
                                    مبلغ تخفیف :
                                </div>
                                <div class="text-primary">
                                    <?php
                                    $discount = $totalAmount - $totalDiscountedAmount;
                                    ?>
                                    <?php if ($discount == 0): ?>
                                        <i class="la la-minus" aria-hidden="true"></i>
                                    <?php else: ?>
                                        <?= convertNumbersToPersian(number_format($discount)); ?>
                                        تومان
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="shopping-cart-info-item">
                                <div>
                                    هزینه ارسال :
                                </div>
                                <div class="text-dark">
                                    <?php if ($totalDiscountedAmount > (int)$setting['cart']['shipping_free_price']): ?>
                                        رایگان
                                    <?php else: ?>
                                        وابسته به آدرس
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="shopping-cart-continue">
                            <div class="text-secondary mb-2">
                                مبلغ کل‌ :
                            </div>
                            <div class="text-danger font-size-21px mb-4">
                                <?= convertNumbersToPersian(number_format($totalDiscountedAmount)); ?>
                                تومان
                            </div>
                            <a href="<?= !$auth->isLoggedIn() ? base_url('login?back_url=' . base_url('shopping')) : base_url('shopping'); ?>"
                               class="btn btn-success btn-block">
                                ادامه ثبت سفارش
                                <i class="la la-angle-left font-size-21px mr-3 float-left" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($setting['cart']['description']) && !empty($setting['cart']['description'])): ?>
                <div class="box">
                    <div class="box-body">
                        <?= $setting['cart']['description'] ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="box">
        <div class="box-body">
            <div class="shopping-cart-container">
                <div class="empty-cart">
                    <i class="la la-shopping-cart" aria-hidden="true"></i>
                    <span class="empty-text">
                            سبد خرید شما خالی است
                        </span>
                    <a href="<?= base_url('product/all'); ?>" class="btn btn-info">
                        <i class="la la-arrow-right float-right font-size-21px ml-3" aria-hidden="true"></i>
                        ادامه خرید
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
