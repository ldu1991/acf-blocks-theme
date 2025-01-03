<?php
$tagline      = get_sub_field('tagline');
$title        = get_sub_field('title');
$introduction = get_sub_field('introduction');
$guides       = get_sub_field('guides');

$guides_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $guides
);

$guides_query = new WP_Query($guides_args); ?>

<section class="dmp-block dmp-guide-block">
    <div class="dmp-container">
        <div class="dmp-block__head">
            <div class="dmp-block__head-col">
                <?php if (!empty($tagline)): ?>
                    <div class="dmp-block__head-eyebrow">
                        <?php echo esc_html($tagline); ?>
                    </div>
                <?php endif;
                if (!empty($title)) : ?>
                    <div class="dmp-block__head-title">
                        <h2><?php echo esc_html($title); ?></h2>
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

        <?php if (!empty($guides)): ?>
            <div class="dmp-guide-block__slider swiper_nav-dark">
                <div class="swiper guide-swiper">
                    <div class="swiper-wrapper">
                        <?php if ($guides_query->have_posts()) :
                            while ($guides_query->have_posts()) : $guides_query->the_post(); ?>
                                <div class="swiper-slide">
                                    <?php get_template_part('template-parts/news-card', '', array('simple' => 'yes')); ?>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata();
                        endif; ?>
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                  d="M20 11.8889H7.83L13.42 6.29892L12 4.88892L4 12.8889L12 20.8889L13.41 19.4789L7.83 13.8889H20V11.8889Z"
                                  fill="white"/>
                        </svg>
                    </div>
                    <div class="swiper-button-next">
                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                  d="M12 4.88892L10.59 6.29892L16.17 11.8889H4V13.8889H16.17L10.59 19.4789L12 20.8889L20 12.8889L12 4.88892Z"
                                  fill="white"/>
                        </svg>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

