<!doctype html>
<html lang="fa">
<head>
    <title>Document</title>
    <link rel="stylesheet" href="<?= asset_url('fe/css/pdfExport.css'); ?>">
</head>
<body>
<div class="section">
    <div class="section-header">
        <strong>
            وضعیت سفارش
        </strong>
    </div>
    <div class="section-body section-important">
        <strong>
            <?= $order['send_status_name']; ?>
        </strong>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <strong>
            مشخصات پرداخت
        </strong>
    </div>
    <div class="section-body">
        <div>
            <div class="section-half">
                <small>
                    کد فاکتور:
                </small>
                <strong>
                    <?= $order['order_code']; ?>
                </strong>
            </div>
            <div class="section-half">
                <small>
                    نحوه پرداخت:
                </small>
                <strong>
                    <?php if (in_array($order['payment_method'], array_keys(PAYMENT_METHODS))): ?>
                        <?= PAYMENT_METHODS[$order['payment_method']]; ?>
                    <?php else: ?>
                        نامشخص
                    <?php endif; ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div>
            <div class="section-half">
                <small>
                    تاریخ پرداخت فیش واریزی:
                </small>
                <strong>
                    <?php if ($order['payment_method'] == PAYMENT_METHOD_RECEIPT && !empty($order['receipt_date'])): ?>
                        <?= jDateTime::date('j F Y در ساعت H:i', $order['receipt_date']); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </strong>
            </div>
            <div class="section-half">
                <small>
                    شماره فیش واریزی:
                </small>
                <strong>
                    <?php if ($order['payment_method'] == PAYMENT_METHOD_RECEIPT && !empty($order['receipt_code'])): ?>
                        <?= $order['receipt_code']; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div>
            <div class="section-half">
                <small>
                    کد رهگیری:
                </small>
                <strong>
                    <?php if (isset($order['payment_info']['payment_code'])): ?>
                        <?= convertNumbersToPersian($order['payment_info']['payment_code']); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div class="section-body bg-gray">
            <small>
                وضعیت پرداخت:
            </small>
            <strong>
                <?php if (in_array($order['payment_status'], array_keys(OWN_PAYMENT_STATUSES))): ?>
                    <?= OWN_PAYMENT_STATUSES[$order['payment_status']]; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </strong>
        </div>
    </div>
    <div class="section-body">
        <div>
            <div class="section-half">
                <small>
                    مبلغ کل:
                </small>
                <strong>
                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['amount'], true))); ?>
                    تومان
                </strong>
            </div>
            <div class="section-half">
                <small>
                    مبلغ تخفیف:
                </small>
                <strong>
                    <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['discount_price'], true))); ?>
                    تومان
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div>
            <div class="section-half">
                <small>
                    عنوان کد تخفیف:
                </small>
                <strong>
                    <?php if (!empty($order['coupon_title'])): ?>
                        <?= $order['coupon_title']; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </strong>
            </div>
            <div class="section-half">
                <small>
                    مبلغ کد تخفیف:
                </small>
                <strong>
                    <?php if (!empty($order['coupon_amount'])): ?>
                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['coupon_amount'], true))); ?>
                        تومان
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div>
            <div class="section-half">
                <small>
                    هزینه ارسال:
                </small>
                <strong>
                    <?php if ($order['shipping_price'] != 0): ?>
                        <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['shipping_price'], true))); ?>
                        تومان
                    <?php else: ?>
                        رایگان
                    <?php endif; ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div class="section-body bg-gray">
            <small>
                مبلغ قابل پرداخت:
            </small>
            <strong>
                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($order['final_price'], true))); ?>
                تومان
            </strong>
        </div>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <strong>
            مشخصات ثبت کننده سفارش
        </strong>
    </div>
    <div class="section-body">
        <div>
            <div class="section-half">
                <small>
                    نام و نام خانوادگی:
                </small>
                <strong>
                    <?php if (!empty($order['first_name']) || !empty($order['last_name'])): ?>
                        <?= $order['first_name'] . ' ' . $order['last_name']; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </strong>
            </div>
            <div class="section-half">
                <small>
                    شماره موبایل:
                </small>
                <strong>
                    <?= convertNumbersToPersian($order['mobile']); ?>
                </strong>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="section-header">
        <strong>
            مشخصات گیرنده سفارش
        </strong>
    </div>
    <div class="section-body">
        <div>
            <div class="section-half">
                <small>
                    شماره تماس:
                </small>
                <strong>
                    <?= convertNumbersToPersian($order['receiver_phone']); ?>
                </strong>
            </div>
            <div class="section-half">
                <small>
                    استان:
                </small>
                <strong>
                    <?= $order['province']; ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div>
            <div class="section-half">
                <small>
                    شهر:
                </small>
                <strong>
                    <?= $order['city']; ?>
                </strong>
            </div>
            <div class="section-half">
                <small>
                    کد پستی:
                </small>
                <strong>
                    <?= convertNumbersToPersian($order['postal_code']); ?>
                </strong>
            </div>
        </div>
        <div class="section-sep"></div>
        <div>
            <small>
                آدرس:
            </small>
            <strong>
                <?= $order['address']; ?>
            </strong>
        </div>
    </div>
</div>
</body>
</html>