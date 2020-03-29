<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $icon = 'la la-comment-alt'; ?>
<?php $btn = 'btn btn-dark'; ?>
<?php $color = 'text-dark'; ?>
<?php if ($flash_message['type'] == \Home\AbstractController\AbstractController::FLASH_MESSAGE_TYPE_INFO): ?>
    <?php $icon = \Home\AbstractController\AbstractController::FLASH_MESSAGE_ICON_INFO; ?>
    <?php $btn = 'btn btn-info'; ?>
    <?php $color = 'text-info'; ?>
    <?php $border_color = 'border-info'; ?>
<?php elseif ($flash_message['type'] == \Home\AbstractController\AbstractController::FLASH_MESSAGE_TYPE_WARNING): ?>
    <?php $icon = \Home\AbstractController\AbstractController::FLASH_MESSAGE_ICON_WARNING; ?>
    <?php $btn = 'btn btn-warning'; ?>
    <?php $color = 'text-warning'; ?>
    <?php $border_color = 'border-warning'; ?>
<?php elseif ($flash_message['type'] == \Home\AbstractController\AbstractController::FLASH_MESSAGE_TYPE_DANGER): ?>
    <?php $icon = \Home\AbstractController\AbstractController::FLASH_MESSAGE_ICON_DANGER; ?>
    <?php $btn = 'btn btn-danger'; ?>
    <?php $color = 'text-danger'; ?>
    <?php $border_color = 'border-danger'; ?>
<?php elseif ($flash_message['type'] == \Home\AbstractController\AbstractController::FLASH_MESSAGE_TYPE_SUCCESS): ?>
    <?php $icon = \Home\AbstractController\AbstractController::FLASH_MESSAGE_ICON_SUCCESS; ?>
    <?php $btn = 'btn btn-success'; ?>
    <?php $color = 'text-success'; ?>
    <?php $border_color = 'border-success'; ?>
<?php endif; ?>

<div class="always-show-modal modal fade" tabindex="-1" role="dialog"
     aria-labelledby="Flash message" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded <?= $border_color; ?>">
            <div class="d-flex justify-content-between ltr">
                <button type="button" class="close p-3" data-dismiss="modal"
                        aria-hidden="true">
                    <i class="la la-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <?php if ($flash_message['icon']): ?>
                    <i class="font-size-80px <?= $color; ?> <?= $icon; ?>" aria-hidden="true"></i>
                <?php endif; ?>
                <h5 class="mt-4 normal-line-height">
                    <?= $flash_message['message']; ?>
                </h5>
                <button type="button" class="btn-wd <?= $btn; ?> d-block mx-auto mt-4" data-dismiss="modal"
                        aria-hidden="true">
                    باشه
                </button>
            </div>
        </div>
    </div>
</div>
