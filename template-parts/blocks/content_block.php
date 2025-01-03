<?php
$title           = get_sub_field('title');
$content         = get_sub_field('content');
$button          = get_sub_field('button');
$grey_background = get_sub_field('grey_background');

$class_content_block = array('dmp-content-block');
if (!empty($grey_background)) {
    $class_content_block[] = 'dmp-content-block_grey-bg';
} ?>
<section class="<?php echo esc_attr(trim(implode(' ', $class_content_block))); ?>">
    <div class="dmp-content-block__container">
        <?php if (!empty($title)): ?>
            <h2 class="dmp-content-block__title">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif;

        if (have_rows('content')):
            while (have_rows('content')) : the_row();
                get_template_part('template-parts/sub-blocks/' . get_row_layout());
            endwhile;
        endif;

        the_btn($button, array('dmp-btn_primary', 'dmp-btn_red')); ?>
    </div>
</section>
