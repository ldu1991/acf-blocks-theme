<?php
$title        = get_sub_field('title');
$introduction = get_sub_field('introduction');
$logos        = get_sub_field('logos');
?>
<section class="dmp-certification">
    <div class="dmp-container">
        <div class="dmp-certification__row">
            <div class="dmp-certification__text">
                <?php if (!empty($title)): ?>
                    <h5><?php echo esc_html($title); ?></h5>
                <?php endif;
                if (!empty($introduction)): ?>
                    <p><?php echo wp_kses_post($introduction); ?></p>
                <?php endif; ?>
            </div>
            <?php if (!empty($logos)): ?>
                <div class="dmp-certification__logos">
                    <?php foreach ($logos as $logo) : ?>
                        <a href="<?php echo esc_url($logo['link']) ?>"
                           class="dmp-certification__logos-item">
                            <?php echo wp_get_attachment_image($logo['logo'], 'large'); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
