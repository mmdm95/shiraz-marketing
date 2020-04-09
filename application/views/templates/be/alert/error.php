<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($errors) && count($errors)): ?>
    <div class="alert alert-danger alert-dismissible alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
        <button type="button" class="close" data-dismiss="alert">
            <span>×</span>
            <span class="sr-only">Close</span>
        </button>
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
