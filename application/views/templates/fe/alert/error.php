<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($errors) && count($errors)): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="m-0 list-persian">
            <?php foreach ($errors as $err): ?>
                <li>
                    <?= $err; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="la la-times" aria-hidden="true"></i></span>
        </button>
    </div>
<?php endif; ?>
