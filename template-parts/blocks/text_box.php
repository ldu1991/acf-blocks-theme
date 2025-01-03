<?php
$pop_out_image = get_sub_field('pop_out_image');
$content       = get_sub_field('content');

$class_text_box   = array('dmp-text-box');
$class_text_box[] = 'dmp-text-box_out-image';
?>
<section class="<?php echo esc_attr(trim(implode(' ', $class_text_box))); ?>">
    <div class="dmp-text-box__container">
        <?php
        if(!empty($pop_out_image)) {
            echo '<div class="dmp-text-box__img">' . wp_get_attachment_image($pop_out_image, 'large') . '</div>';
        }
        echo wp_kses_post($content);
        ?>
    </div>
</section>
