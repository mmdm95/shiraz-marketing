<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($warning) && count($warning)): ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <ul class="m-0 list-persian">
            <?php foreach ($warning as $warn): ?>
                <li>
                    <?= $warn; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="la la-times" aria-hidden="true"></i></span>
        </button>
    </div>
<?php endif; ?>
