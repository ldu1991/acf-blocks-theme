<?php

/*
 * $block (array) The block settings and attributes.
 * $content (string) The block inner HTML (empty).
 * $is_preview (boolean) True during backend preview render.
 * $context (array) The context provided to the block by the post or its parent block.
 */

$general_class = 'ga-page-hero';
$attr = get_section_options($general_class, $block, $is_preview);

$title = get_field('title');
$text = get_field('text');
$background_color = get_field('background_color');
$style = get_field('style');
$image = get_field('image');

if ( $style == 'small' ) {
    $attr['class'][] = 'ga-page-hero_min';
}
if ( $background_color == 'dark' ) {
    $attr['class'][] = 'ga-page-hero_green';
}
?>

<section class="<?php echo esc_attr(trim(implode(' ', $attr['class']))) ?>">
    <?php if ( $style == 'big' && ! empty( $image ) ): ?>
        <div class="ga-page-hero__bg">
            <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
        </div>
    <?php endif ?>
    <div class="ga-page-hero__content">
        <div class="ga-container">
            <div class="ga-page-hero__text">
                <?php if ( ! empty( $title ) ): ?>
                    <h2><?php echo $title; ?></h2>
                <?php endif ?>

                <?php if ( ! empty( $text ) ): ?>
                    <p><?php echo $text; ?></p>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
