<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade in alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="top: 4px; left: -15px;">&times;</a>
        <p class="no-margin-bottom">
            <?= $success; ?>
        </p>
    </div>
<?php endif; ?>
