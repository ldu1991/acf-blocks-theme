<?php
$title        = get_sub_field('title');
$introduction = get_sub_field('introduction');
$image        = get_sub_field('image');
$content      = get_sub_field('content');
?>

<section class="dmp-block dmp-about-block">
    <div class="dmp-container">
        <div class="dmp-about-block__head">
            <?php if (!empty($title)): ?>
                <div class="dmp-about-block__head-title">
                    <h3><?php echo esc_html($title); ?></h3>
                </div>
            <?php endif;
            if (!empty($introduction)) : ?>
                <div class="dmp-about-block__head-description">
                    <?php echo wp_kses_post($introduction) ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="dmp-about-block__content">
            <?php echo wp_get_attachment_image($image, '1536x1536'); ?>

            <?php if (!empty($content)): ?>
                <div class="dmp-about-block__content-text">
                    <?php echo wp_kses_post($content); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
