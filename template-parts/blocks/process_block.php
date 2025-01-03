<?php
$simplified   = get_sub_field('simplified');
$eyebrow      = get_sub_field('eyebrow');
$title        = get_sub_field('title');
$image        = get_sub_field('image');
$introduction = get_sub_field('introduction');
$list         = get_sub_field('list');

if (!empty($simplified)) : ?>
    <section class="dmp-block dmp-step">
        <div class="dmp-container">
            <div class="dmp-step__wrap">
                <div class="dmp-step__head">
                    <?php if (!empty($title)): ?>
                        <h2> <?php echo esc_html($title); ?></h2>
                    <?php endif;
                    if (!empty($introduction)) :
                        echo wp_kses_post($introduction);
                    endif; ?>
                </div>

                <?php if (!empty($list)):
                    $i = 1;
                    foreach ($list as $li) : ?>
                        <div class="dmp-step__item">
                            <div class="dmp-step__item-number">
                                <h3><?php echo str_pad($i, 2, '0', STR_PAD_LEFT) . PHP_EOL ?></h3>
                            </div>
                            <div class="dmp-step__item-description">
                                <?php if (!empty($li['title'])): ?>
                                    <h6><?php echo esc_html($li['title']) ?></h6>
                                <?php endif;
                                if (!empty($li['description'])): ?>
                                    <p><?php echo wp_kses_post($li['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $i++;
                    endforeach;
                endif; ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="dmp-block dmp-block_blue dmp-process">
        <div class="dmp-container">
            <div class="dmp-process__row">
                <div class="dmp-process__col">
                    <?php if (!empty($eyebrow)): ?>
                        <div class="dmp-block__head-eyebrow">
                            <?php echo esc_html($eyebrow); ?>
                        </div>
                    <?php endif;
                    if (!empty($title)): ?>
                        <div class="dmp-block__head-tile">
                            <h2>
                                <?php echo esc_html($title); ?>
                            </h2>
                        </div>
                    <?php endif;
                    if (!empty($image)): ?>
                        <div class="dmp-process__image">
                            <?php echo wp_get_attachment_image($image, 'large'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($list)): ?>
                    <div class="dmp-process__col">
                        <?php $i = 1;
                        foreach ($list as $li) : ?>
                            <div class="dmp-step__item dmp-step__item_blue">
                                <div class="dmp-step__item-number">
                                    <h3><?php echo str_pad($i, 2, '0', STR_PAD_LEFT) . PHP_EOL ?></h3>
                                </div>
                                <div class="dmp-step__item-description">
                                    <?php if (!empty($li['title'])): ?>
                                        <h6><?php echo esc_html($li['title']) ?></h6>
                                    <?php endif;
                                    if (!empty($li['description'])): ?>
                                        <p><?php echo wp_kses_post($li['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php $i++;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif;
