<?php
$subtitle         = get_field('subtitle', get_the_ID());
$related_services = get_field('related_services', get_the_ID());

$services_args = array(
    'post_type'      => 'service',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $related_services
);

$services_query = new WP_Query($services_args);
?>
<section class="dmp-block dmp-related-services">
    <div class="dmp-container">
        <?php if (!empty($subtitle)): ?>
            <div class="dmp-block__head-title">
                <h3><?php echo esc_html($subtitle); ?></h3>
            </div>
        <?php endif; ?>

        <?php if (!empty($related_services)): ?>
        <div class="dmp-related-services__row">
            <?php if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    echo '<div class="dmp-related-services__col">';
                    get_template_part('template-parts/services-card');
                    echo '</div>';
                endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
