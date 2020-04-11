<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

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
                        <?php if ($has_product_type == false): ?>
                            رایگان
                        <?php else: ?>
                            <?php if (isset($setting['cart']['shipping_free_price']) &&
                                !empty($setting['cart']['shipping_free_price']) &&
                                $totalDiscountedAmount > (int)$setting['cart']['shipping_free_price']): ?>
                                رایگان
                            <?php else: ?>
                                <!--                                --><?php //if ($identity->city == SHIRAZ_CITY): ?>
                                <!--                                    --><?php //if (isset($setting['cart']['shipping_price']['area1']) &&
//                                        !empty($setting['cart']['shipping_price']['area1'])): ?>
                                <!--                                        --><?php //$totalDiscountedAmount += (int)$setting['cart']['shipping_price']['area1']; ?>
                                <!--                                        --><? //= convertNumbersToPersian((int)$setting['cart']['shipping_price']['area1']); ?>
                                <!--                                        تومان-->
                                <!--                                    --><?php //else: ?>
                                <!--                                        رایگان-->
                                <!--                                    --><?php //endif; ?>
                                <!--                                --><?php //else: ?>
                                <?php if (isset($setting['cart']['shipping_price']['area2']) &&
                                    !empty($setting['cart']['shipping_price']['area2'])): ?>
                                    <?php $totalDiscountedAmount += (int)$setting['cart']['shipping_price']['area2']; ?>
                                    <?= convertNumbersToPersian((int)$setting['cart']['shipping_price']['area2']); ?>
                                    تومان
                                <?php else: ?>
                                    رایگان
                                <?php endif; ?>
                                <!--                                --><?php //endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                $couponSes = \HSession\Session\Session::getInstance()->get('shopping_page_session');
                ?>
                <?php if (isset($couponSes['coupon_code']) &&
                    isset($couponSes['coupon_code']['price']) &&
                    !empty($couponSes['coupon_code'])): ?>
                    <div class="shopping-cart-info-item">
                        <div class="text-primary">
                            مبلغ کد تخفیف :
                        </div>
                        <div class="text-primary">
                            <?php $totalDiscountedAmount -= (int)$couponSes['coupon_code']['price']; ?>
                            <?= convertNumbersToPersian(number_format((int)$couponSes['coupon_code']['price'])); ?>
                            تومان
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="shopping-cart-continue">
                <div class="text-secondary mb-2">
                    مبلغ کل‌ :
                </div>
                <div class="text-danger font-size-21px mb-4">
                    <?= convertNumbersToPersian(number_format($totalDiscountedAmount)); ?>
                    تومان
                </div>
                <?php if (!$auth->isLoggedIn()): ?>
                    <a href="<?= base_url('login?back_url=' . base_url('shopping')); ?>"
                       class="btn btn-success btn-block">
                        ادامه ثبت سفارش
                        <i class="la la-angle-left font-size-21px mr-3 float-left" aria-hidden="true"></i>
                    </a>
                <?php else: ?>
                    <button type="submit" class="btn btn-success btn-block">
                        ادامه ثبت سفارش
                        <i class="la la-angle-left font-size-21px mr-3 float-left"
                           aria-hidden="true"></i>
                    </button>
                <?php endif; ?>
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
