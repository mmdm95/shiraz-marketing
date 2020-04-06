<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php if (count($menuNavigation)): ?>
    <div class="nav-main">
        <div class="container">
            <div class="row">
                <nav class="nav nav-items">
                    <?php foreach ($menuNavigation as $item): ?>
                        <a class="nav-item" href="<?= base_url('product/all/category/' . $item['slug']); ?>">
                            <?php if ($setting['main']['showMenuIcon']): ?>
                                <i class="<?= $item['icon']; ?> nav-item-icon"></i>
                            <?php endif; ?>
                            <span class="nav-item-text"><?= $item['name']; ?></span>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>
    </div>
<?php endif; ?>
