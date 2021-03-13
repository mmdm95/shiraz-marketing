<div>
    <input type="hidden" value="<?= $id; ?>">
    <input type="checkbox"
           class="switchery productAvailability"
        <?= set_value($status ?? '', 1, 'checked', '', '=='); ?> />
</div>