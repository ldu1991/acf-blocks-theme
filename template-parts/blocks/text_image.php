<?php
$direction = get_sub_field('direction');
$content   = get_sub_field('content');
$image     = get_sub_field('image');

$class   = array('dmp-text-image-block');
$class[] = 'dmp-text-image-block_' . $direction;
?>
<section class="<?php echo esc_attr(trim(implode(' ', $class))) ?>">
    <div class="dmp-container">
        <div class="dmp-text-image-block__row">
            <div class="dmp-text-image-block__col">
                <div class="dmp-text-image-block__content">
                    <?php echo wp_kses_post($content); ?>
                </div>
            </div>
            <div class="dmp-text-image-block__col">
                <div class="dmp-text-image-block__media">
                    <?php echo wp_get_attachment_image($image, '1536x1536'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
