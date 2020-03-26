<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (count($items)): ?>
    <div class="basket-items-info align-items-center">
        <div class="col p-0">
            مبلغ کل:
            <span class="basket-items-price">
                <?= convertNumbersToPersian(number_format($totalAmount)); ?>
                تومان
            </span>
        </div>
        <div>
            <a href="<?= base_url('cart'); ?>" class="btn btn-outline-secondary border-0">
                سبد خرید
            </a>
        </div>
    </div>
    <ul class="basket-items custom-scrollbar-y">
        <?php foreach ($items as $item): ?>
            <li class="basket-item">
                <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>"
                   class="basket-item-img">
                    <img src="<?= base_url($item['image']); ?>" alt="<?= $item['title']; ?>">
                </a>
                <div class="col p-0">
                    <a href="<?= base_url('product/detail/' . $item['id'] . '/' . $item['slug']); ?>"
                       class="basket-item-link">
                        <?= $item['title']; ?>
                    </a>
                    <span class="basket-item-count">
                        <?= convertNumbersToPersian($item['quantity']); ?>
                        عدد
                    </span>
                </div>
                <button type="button" class="btn btn-outline-danger remove-from-cart-btn"
                        data-item-id="<?= $item['id']; ?>">
                    <i class="la la-times" aria-hidden="true"></i>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="<?= base_url('cart'); ?>" class="btn btn-info btn-block btn-lg rounded-0">
        ثبت سفارش
    </a>
<?php else: ?>
    <span class="rtl-text empty-text">
        سبد خرید خالی است
    </span>
<?php endif; ?>
