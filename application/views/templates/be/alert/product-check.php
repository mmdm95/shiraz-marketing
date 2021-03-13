<script type="text/javascript">
    (function ($) {

        'use strict';

        $(function () {
            <?php if((bool)$checkProductsCount && $checkProductsCount > 0): ?>
            setTimeout(function () {
                new PNotify({
                    text: 'تعداد ' + '<?= convertNumbersToPersian($checkProductsCount); ?>' + ' سفارش در صف بررسی قرار دارند.',
                    icon: 'icon-info22',
                    type: "info",
                    hide: false,
                    addclass: 'border-slate bg-slate stack-custom-top full-width-force no-border-radius',
                    buttons: {
                        sticker: false,
                    },
                });
            }, 1500);
            <?php endif; ?>
        });
    })(jQuery);
</script>