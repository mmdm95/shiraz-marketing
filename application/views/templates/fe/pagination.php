<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php
$pageBefore = $pageBefore ?? 4;
$pageAfter = $pageAfter ?? 4;
?>

<!-- Pagination -->
<?php if ($total && ($lastPage - $firstPage) != 0): ?>
    <nav aria-label="صفحه‌بندی آیتم‌ها">
        <ul class="pagination flex-row-reverse justify-content-center">
            <li class="page-item <?= $firstPage != $pageNo ? 'disabled' : ''; ?>">
                <a class="page-link" <?= $firstPage != $pageNo ? 'href="' . $href . '/page/' . $firstPage . '"' : ''; ?> >
                    <i class="la la-angle-double-left" aria-hidden="true"></i>
                </a>
            </li>

            <?php if (($pageNo - $pageBefore) > $firstPage): ?>
                <li class="page-item disabled">
                    <a>
                        ...
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = $pageNo - $pageBefore; $i < $pageNo; $i++): ?>
                <?php if ($i <= 0) continue; ?>
                <li class="page-item <?= $pageNo == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="<?= $href . '/page/' . $i; ?>">
                        <?= convertNumbersToPersian($i); ?>
                    </a>
                </li>
            <?php endfor; ?>
            <?php for ($i = $pageNo; $i <= $pageNo + $pageAfter && $i <= $lastPage; $i++): ?>
                <li class="page-item <?= $pageNo == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="<?= $href . '/page/' . $i; ?>">
                        <?= convertNumbersToPersian($i); ?>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if (($pageNo + $pageAfter) < $lastPage): ?>
                <li class="page-item disabled">
                    <a>
                        ...
                    </a>
                </li>
            <?php endif; ?>

            <li class="page-item <?= $lastPage != $pageNo ? 'disabled' : ''; ?>">
                <a class="page-link" <?= $lastPage != $pageNo ? 'href="' . $href . '/page/' . $lastPage . '"' : ''; ?> >
                    <i class="la la-angle-double-right" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
<!-- /Pagination -->
