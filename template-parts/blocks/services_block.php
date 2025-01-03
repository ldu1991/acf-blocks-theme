<?php
$tagline      = get_sub_field('tagline');
$title        = get_sub_field('title');
$introduction = get_sub_field('introduction');
$services     = get_sub_field('services');

$services_args = array(
    'post_type'      => 'service',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $services
);

$services_query = new WP_Query($services_args);

$class = array('dmp-block', 'dmp-services-block'); ?>

<section class="<?php echo esc_attr(trim(implode(' ', $class))) ?>">
    <div class="dmp-container">
        <div class="dmp-block__head">
            <div class="dmp-block__head-col">
                <?php if (!empty($tagline)): ?>
                    <div class="dmp-block__head-eyebrow">
                        <?php echo esc_html($tagline); ?>
                    </div>
                <?php endif;
                if (!empty($title)): ?>
                    <div class="dmp-block__head-title">
                        <h2>
                            <?php echo esc_html($title); ?>
                        </h2>
                    </div>
                <?php endif; ?>
            </div>

            <div class="dmp-block__head-col">
                <?php if (!empty($introduction)): ?>
                    <div class="dmp-block__head-description">
                        <?php echo wp_kses_post($introduction); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($services)): ?>
            <div class="dmp-services__row">
                <?php if ($services_query->have_posts()) :
                    while ($services_query->have_posts()) : $services_query->the_post();
                        echo '<div class="dmp-services__col">';
                        get_template_part('template-parts/services-card');
                        echo '</div>';
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
