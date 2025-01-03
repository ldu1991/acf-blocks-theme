<?php
$background_image = get_sub_field('background_image');
$title            = get_sub_field('title');
$case_studies     = get_sub_field('case_studies');

$case_studies_args = array(
    'post_type'      => 'case-study',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $case_studies
);

$case_studies_query = new WP_Query($case_studies_args);
?>
<section class="dmp-block dmp-studies">
    <div class="dmp-studies__bg">
        <?php echo wp_get_attachment_image($background_image, '2048×2048'); ?>
    </div>

    <div class="dmp-studies__content">
        <div class="dmp-container">
            <?php if (!empty($title)): ?>
                <div class="dmp-studies__head">
                    <h2>
                        <?php echo esc_html($title); ?>
                    </h2>
                </div>
            <?php endif; ?>

            <?php if (!empty($case_studies)): ?>
                <div class="dmp-studies__slider">
                    <div class="swiper studies-swiper">
                        <div class="swiper-wrapper">
                            <?php if ($case_studies_query->have_posts()) :
                                while ($case_studies_query->have_posts()) : $case_studies_query->the_post(); ?>
                                    <div class="swiper-slide">
                                        <a href="<?php the_permalink(); ?>"
                                           class="dmp-studies-card">
                                            <div class="dmp-studies-card__image">
                                                <?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'large'); ?>
                                            </div>

                                            <div class="dmp-studies-card__content">
                                                <?php the_title('<h5>', '</h5>'); ?>

                                                <div class="dmp-studies-card__more">Read more
                                                    <span>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                  d="M9.70697 16.9496L15.414 11.2426L9.70697 5.53564L8.29297 6.94964L12.586 11.2426L8.29297 15.5356L9.70697 16.9496Z"
                                                  fill="black"/>
                                            </svg>
                                        </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                            endif; ?>
                        </div>

                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                      d="M20 11.8889H7.83L13.42 6.29892L12 4.88892L4 12.8889L12 20.8889L13.41 19.4789L7.83 13.8889H20V11.8889Z"
                                      fill="white"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                      d="M12 4.88892L10.59 6.29892L16.17 11.8889H4V13.8889H16.17L10.59 19.4789L12 20.8889L20 12.8889L12 4.88892Z"
                                      fill="white"/>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

