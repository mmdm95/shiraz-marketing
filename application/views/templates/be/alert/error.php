<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (isset($errors) && count($errors)): ?>
    <div class="alert alert-danger alert-styled-left alert-bordered no-border-top no-border-right no-border-bottom">
        <ul class="list-unstyled">
            <?php foreach ($errors as $err): ?>
                <li>
                    <i class="icon-dash" aria-hidden="true"></i>
                    <?= $err; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif; ?>
