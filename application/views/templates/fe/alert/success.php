<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= $success; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="la la-times" aria-hidden="true"></i></span>
        </button>
    </div>
<?php endif; ?>
