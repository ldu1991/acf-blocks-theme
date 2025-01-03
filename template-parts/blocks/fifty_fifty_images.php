<?php
$left_image  = get_sub_field('left_image');
$right_image = get_sub_field('right_image');

?>
<section class="dmp-fifty-fifty-images">
    <?php
    echo wp_get_attachment_image($left_image, 'large');
    echo wp_get_attachment_image($right_image, 'large');
    ?>
</section>
