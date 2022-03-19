<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (count($updated_items_in_cart)): ?>
    <div class="always-show-modal modal fade" tabindex="-1" role="dialog"
         aria-labelledby="Removed/Updated product(s)" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        کالاهایی که وضعیت موجودی آنها ناموجود بود، حذف شده/تعداد کالاهای برخی کالاها در سبد خرید،
                        بروز شده
                        است.
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">
                        <i class="la la-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="row modal-product-item__wrapper">
                        <?php foreach ($updated_items_in_cart as $item): ?>
                            <div class="col-md-6">
                                <div class="modal-product-item"
                                     title="<?= $item['title']; ?>">
                                    <div class="modal-product-item-img">
                                        <?= $this->view('templates/fe/parser/image-placeholder', [
                                            'url' => base_url($item['image']),
                                            'alt' => '',
                                        ], true); ?>
                                    </div>
                                    <p class="modal-product-item-title normal-line-height">
                                        <?= character_limiter($item['title'], 50); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>