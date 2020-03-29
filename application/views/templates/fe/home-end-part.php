<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($flash_message)): ?>
    <?php $this->view('templates/fe/modal/message', $data); ?>
<?php endif; ?>

<a href="javascript:void(0);" class="back-to-top" id="backToTop">
    <i class="la la-rocket" aria-hidden="true"></i>
</a>

</body>
</html>
