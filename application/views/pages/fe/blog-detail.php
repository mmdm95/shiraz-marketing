<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<?php $this->view('templates/fe/main-menu', $data); ?>
<?php $this->view('templates/fe/main-nav', $data); ?>
<?php $this->view('templates/fe/main-nav-mobile', $data); ?>

<main class="main-container page-blog-detail">
    <div class="container">
        <div class="card-gap"></div>
        <nav class="page-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('index'); ?>" class="btn-link-black">خانه</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('blog/all'); ?>" class="btn-link-black">اخبار و
                        اطلاعیه‌ها</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    این مطلب فاقد اهمیت است
                </li>
            </ol>
        </nav>
    </div>

    <?php if (count($nextBlog)): ?>
        <a href="<?= base_url('blog/detail/' . $nextBlog['id'] . '/' . $nextBlog['slug']) ?>"
           class="fast-navigation-link fast-next-navigation">
            <i class="la la-angle-right fast-navigation-link-icon" aria-hidden="true"></i>
            <div class="d-flex">
                <h1 class="fast-navigation-link-title col">
                    <?= $nextBlog['title']; ?>
                </h1>
                <img src="<?= base_url($nextBlog['image']); ?>" alt="<?= $nextBlog['title']; ?>">
            </div>
        </a>
    <?php endif; ?>
    <?php if (count($prevBlog)): ?>
        <a href="<?= base_url('blog/detail/' . $prevBlog['id'] . '/' . $prevBlog['slug']) ?>"
           class="fast-navigation-link fast-prev-navigation">
            <i class="la la-angle-left fast-navigation-link-icon" aria-hidden="true"></i>
            <div class="d-flex">
                <img src="<?= base_url($prevBlog['image']); ?>" alt="<?= $prevBlog['title']; ?>">
                <h1 class="fast-navigation-link-title col">
                    <?= $prevBlog['title']; ?>
                </h1>
            </div>
        </a>
    <?php endif; ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="box overflow-hidden">
                    <img src="<?= base_url($blog['image']); ?>" alt="<?= $blog['title']; ?>" class="img-fluid">
                </div>
                <div class="section-header section-header-low-gap">
                    <h1 class="section-title">
                        <?= $blog['title']; ?>
                    </h1>
                </div>
                <ul class="blog-info list-unstyled">
                    <li class="list-inline-item">
                        در تاریخ
                        <?= jDateTime::date('j F Y', $blog['created_at']); ?>
                    </li>
                    <li class="list-inline-item">
                        آپدیت شده در تاریخ
                        <?= jDateTime::date('j F Y', $blog['updated_at']); ?>
                    </li>
                    <li class="list-inline-item">
                        در دسته‌بندی
                        <a href="<?= base_url('blog/all/category/' . $blog['category_id']); ?>"
                           class="btn-link-black mr-1">
                            <?= $blog['category_name']; ?>
                        </a>
                    </li>
                </ul>

                <div class="box">
                    <div class="normal-line-height box-body">
                        <?= $blog['body']; ?>
                    </div>
                </div>

                <?php if ($blog['keywords'] != ''): ?>
                    <div class="box">
                        <div class="box-body">
                            <ul class="list-unstyled m-0 p-0">
                                <?php
                                $keywords = explode(',', $blog['keywords']);
                                ?>
                                <?php foreach ($keywords as $keyword): ?>
                                    <li class="list-inline-item">
                                        <a href="<?= base_url('blog/all/tag/' . trim($keyword)); ?>"
                                           class="btn btn-outline-secondary">
                                            <?= trim($keyword); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($related): ?>
                    <div class="row">
                        <?php foreach ($related as $item): ?>
                            <div class="card-wrapper col-lg-4 col-md-6 col-12">
                                <div class="card card-news">
                                    <div class="card-img">
                                        <div class="img-placeholder">
                                            <i class="la la-image" aria-hidden="true"></i>
                                        </div>
                                        <a href="<?= base_url('blog/detail/' . $item['id'] . '/' . $item['slug']); ?>">
                                            <img src="<?= base_url($item['image']); ?>" alt="<?= $item['title']; ?>">
                                        </a>
                                        <div class="card-date">
                                            <?php
                                            $day = jDateTime::date('d', $item['created_at']);
                                            $month = jDateTime::date('F', $item['created_at']);
                                            ?>
                                            <span class="day">
                                                <?= $day; ?>
                                            </span>
                                            <span class="month">
                                                <?= $month; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-title">
                                        <a href="<?= base_url('blog/detail/' . $item['id'] . '/' . $item['slug']); ?>">
                                            <?= $item['title']; ?>
                                        </a>
                                    </div>
                                    <p class="card-abstract">
                                        <?= $item['abstract']; ?>
                                    </p>
                                    <div class="card-info">
                                        <ul class="list-unstyled">
                                            <li class="list-inline-item">
                                                <i class="la la-list"></i>
                                                <a href="<?= base_url('blog/all/category/' . $item['category_id']); ?>"
                                                   class="btn-link-secondary">
                                                    <?= $item['category_name']; ?>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <i class="la la-eye"></i>
                                                <?= convertNumbersToPersian(number_format(convertNumbersToPersian($item['view_count']), true)); ?>
                                                بازدید
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <div class="box">
                    <form action="<?= base_url('blog/search'); ?>" method="get">
                        <div class="main-input__wrapper">
                            <input type="text" class="form-control box" name="q" placeholder="جستجو در بلاگ">
                            <span class="input-icon right">
                                <i class="la la-search"></i>
                            </span>
                            <span class="input-icon left clear-icon">
                                <i class="la la-times"></i>
                            </span>
                        </div>
                    </form>
                </div>

                <?php if (count($categories)): ?>
                    <div class="box">
                        <div class="box-header">
                            <i class="la la-th-large float-right ml-2" aria-hidden="true"></i>
                            <h5>
                                دسته‌بندی‌ها
                            </h5>
                        </div>
                        <div class="box-body">
                            <ul class="list-unstyled m-0 p-0">
                                <?php foreach ($categories as $category): ?>
                                    <li class="mb-3">
                                        <a href="<?= base_url('blog/all/category/' . $category['slug']); ?>"
                                           class="btn-link-black-reverse">
                                            <i class="la la-arrow-left ml-2" aria-hidden="true"></i>
                                            <?= $category['name']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (count($lastPosts)): ?>
                    <div class="box">
                        <div class="box-header">
                            <i class="la la-list-alt float-right ml-2" aria-hidden="true"></i>
                            <h5>
                                جدیدترین‌ها
                            </h5>
                        </div>
                        <div class="box-body">
                            <?php foreach ($lastPosts as $post): ?>
                                <div class="page-side__wrapper">
                                    <div class="page-side">
                                        <a href="<?= base_url('blog/detail/' . $post['id'] . '/' . $post['slug']) ?>"
                                           class="page-side-img">
                                            <img src="<?= base_url($post['image']); ?>" alt="<?= $post['title']; ?>">
                                        </a>
                                        <ul class="page-side-detail list-unstyled col m-0 p-0">
                                            <li class="mb-2 text-secondary">
                                                <i class="la la-clock-o"></i>
                                                در تاریخ
                                                <?= jDateTime::date('j F Y', $post['created_at']); ?>
                                            </li>
                                            <li class="text-secondary">
                                                <i class="la la-th-large"></i>
                                                در دسته‌بندی
                                                <a href="<?= base_url('blog/all/category/' . $post['category_id']); ?>"
                                                   class="btn-link-black mr-1">
                                                    <?= $post['category_name']; ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="<?= base_url('blog/detail/' . $post['id'] . '/' . $post['slug']) ?>"
                                       class="page-side-title btn-link">
                                        <?= $post['title']; ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php $this->view('templates/fe/footer', $data); ?>
