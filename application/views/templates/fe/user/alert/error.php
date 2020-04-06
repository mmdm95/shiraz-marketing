<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($errors) && count($errors)): ?>
    <div class="alert alert-danger alert-dismissible alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="top: 4px; left: -15px;">&times;</a>
        <ul class="list-unstyled">
            <?php foreach ($errors as $err): ?>
                <li>
                    <i class="icon-dash" aria-hidden="true"></i>
                    <?= $err; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
