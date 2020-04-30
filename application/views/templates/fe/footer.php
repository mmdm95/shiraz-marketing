<?php defined('BASE_PATH') OR exit('No direct script access allowed'); ?>

<footer class="main-footer">
    <div class="container footer-top">
        <div class="row">
            <?php if (isset($setting['footer']['sections'])): ?>
                <?php foreach ($setting['footer']['sections'] as $section): ?>
                    <?php if (!empty($section['title'])): ?>
                        <div class="col-md-3 col-sm-6">
                            <h4 class="footer-section-header">
                                <?= $section['title'] ?? ''; ?>
                            </h4>
                            <?php if (isset($section['links'])): ?>
                                <ul class="list-unstyled m-0 p-0">
                                    <?php foreach ($section['links'] as $link): ?>
                                        <?php if (!empty($link['text'])): ?>
                                            <li>
                                                <a href="<?= $link['link'] ?? '#'; ?>" class="footer-section-link">
                                                    <?= $link['text'] ?? ''; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (isset($setting['contact'])): ?>
                <?php if (isset($setting['contact']['description']) && !empty($setting['contact']['description']) ||
                    isset($setting['contact']['mobiles']) && !empty($setting['contact']['mobiles'])): ?>
                    <div class="col-md-3 col-sm-6">
                        <h4 class="footer-section-header">
                            تماس با ما
                        </h4>

                        <?php if (isset($setting['contact']['mobiles']) && !empty($setting['contact']['mobiles'])): ?>
                            <div class="mb-3">
                                <?php
                                $mobiles = '';
                                foreach (explode(',', $setting['contact']['mobiles']) as $mobile) {
                                    $mobiles .= convertNumbersToPersian($mobile) . ' و ';
                                }
                                $mobiles = trim(trim($mobiles, 'و '));
                                ?>
                                <?= $mobiles; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($setting['contact']['description']) && !empty($setting['contact']['description'])): ?>
                            <div>
                                <address class="normal-line-height">
                                    <?= nl2br($setting['contact']['description']); ?>
                                </address>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($setting['footer']['namad'])): ?>
                <?php if (isset($setting['footer']['namad']['namad1']) && !empty($setting['footer']['namad']['namad1']) ||
                    isset($setting['footer']['namad']['namad2']) && !empty($setting['footer']['namad']['namad2'])): ?>
                    <div class="col-md-3 col-sm-6 namad">
                        <div class="namad-carousel owl-carousel">
                            <?php if (isset($setting['footer']['namad']['namad1']) && !empty($setting['footer']['namad']['namad1'])): ?>
                                <div>
                                    <?= html_entity_decode($setting['footer']['namad']['namad1']); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($setting['footer']['namad']['namad2']) && !empty($setting['footer']['namad']['namad2'])): ?>
                                <div>
                                    <?= html_entity_decode($setting['footer']['namad']['namad2']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="separator mt-0 mb-3"></div>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="footer-socials col-sm-6 text-center mb-4 text-sm-right mb-sm-0">
                    <?php if (isset($setting['footer']['socials'])): ?>
                        <?php if (isset($setting['footer']['socials']['telegram']) && !empty($setting['footer']['socials']['telegram']) ||
                            isset($setting['footer']['socials']['instagram']) && !empty($setting['footer']['socials']['instagram']) ||
                            isset($setting['footer']['socials']['whatsapp']) && !empty($setting['footer']['socials']['whatsapp'])): ?>
                            <ul class="list-unstyled m-0 p-0">
                                <?php if (isset($setting['footer']['socials']['telegram']) && !empty($setting['footer']['socials']['telegram'])): ?>
                                    <?php foreach (explode(',', $setting['footer']['socials']['telegram']) as $telegram): ?>
                                        <li class="list-inline-item">
                                            <a href="<?= trim($telegram); ?>" class="socials social-telegram"
                                               target="_blank"
                                               data-toggle="tooltip" data-placement="top" title="تلگرام">
                                                <i class="la la-telegram"></i>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if (isset($setting['footer']['socials']['instagram']) && !empty($setting['footer']['socials']['instagram'])): ?>
                                    <?php foreach (explode(',', $setting['footer']['socials']['instagram']) as $instagram): ?>
                                        <li class="list-inline-item">
                                            <a href="<?= trim($instagram); ?>" class="socials social-instagram"
                                               target="_blank"
                                               data-toggle="tooltip" data-placement="top" title="اینستاگرام">
                                                <i class="la la-instagram"></i>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if (isset($setting['footer']['socials']['whatsapp']) && !empty($setting['footer']['socials']['whatsapp'])): ?>
                                    <?php foreach (explode(',', $setting['footer']['socials']['whatsapp']) as $whatsapp): ?>
                                        <li class="list-inline-item">
                                            <a href="<?= trim($whatsapp); ?>" class="socials social-whatsapp"
                                               target="_blank"
                                               data-toggle="tooltip" data-placement="top" title="واتس اَپ">
                                                <i class="la la-whatsapp"></i>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <p class="copyright col-sm-6 text-center text-sm-left">
                    طراحی و توسعه توسط شرکت
                    <a href="http://www.spsroham.ir" class="text-orange" target="_blank">داده افزار رهام</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<?= $popup_save_us ?>
