<?php
$hero = !empty($args['hero']) ? $args['hero'] : get_field('hero');

$title            = !empty($args['title']) ? '<h1>' . $args['title'] . '</h1>' : '<h1>' . get_the_title() . '</h1>';
$subtitle         = !empty($args['subtitle']) ? $args['subtitle'] : get_field('subtitle');
$page_background  = !empty($args['page_background']) ? $args['page_background'] : get_field('page_background');
$background_image = !empty($args['background_image']) ? $args['background_image'] : get_field('background_image');

$class_secondary_hero = array('dmp-secondary-hero');
if (!empty($args['filter'])) {
    $class_secondary_hero[] = 'dmp-secondary-hero_filter';
}
$bg = '';
if (!empty($background_image) && empty($page_background)) {
    $class_secondary_hero[] = 'dmp-secondary-hero_img';
    $bg                     = 'style=" background-image: url(' . $background_image['sizes']['2048x2048'] . ')"';
}
if (!empty($page_background)) {
    $class_secondary_hero[] = 'dmp-secondary-hero_transparent';
}

if (empty($hero)) : ?>
    <section class="<?php echo esc_attr(trim(implode(' ', $class_secondary_hero))); ?>"
        <?php echo $bg; ?>>
        <div class="dmp-secondary-hero__container">
            <?php if (function_exists('rank_math_the_breadcrumbs')) {
                rank_math_the_breadcrumbs();
            }

            echo $title;

            if (!empty($subtitle)) {
                echo '<div class="dmp-secondary-hero__subtitle">' . esc_html($subtitle) . '</div>';
            } ?>
        </div>
    </section>
<?php endif;
