<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade in alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
        <button type="button" class="close" data-dismiss="alert">
            <span>×</span>
            <span class="sr-only">Close</span>
        </button>
        <p class="no-margin-bottom">
            <?= $success; ?>
        </p>
    </div>
<?php endif; ?>
