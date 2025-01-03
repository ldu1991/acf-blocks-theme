<?php
$text  = get_sub_field('text');
$image = get_sub_field('image');

if (!empty($text) && !empty($image)) : ?>
    <div class="dmp-text-and-image">
        <div class="dmp-text-and-image__col">
            <?php echo wp_kses_post($text); ?>
        </div>
        <div class="dmp-text-and-image__col">
            <?php echo wp_get_attachment_image($image, 'large'); ?>
        </div>
    </div>
<?php endif;
