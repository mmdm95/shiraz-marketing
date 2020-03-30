<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
        <p class="no-margin-bottom">
            <?= $success; ?>
        </p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif; ?>
