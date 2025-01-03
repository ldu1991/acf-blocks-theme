<?php
$image = get_sub_field('image');

if (!empty($image)) : ?>
    <section class="dmp-large-image">
        <?php echo wp_get_attachment_image($image, '1536x1536'); ?>
    </section>
<?php endif;
