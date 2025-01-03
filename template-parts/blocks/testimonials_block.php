<?php
$background_image = get_sub_field('background_image');
$title            = get_sub_field('title');
$introduction     = get_sub_field('introduction');
$testimonials     = get_sub_field('testimonials');

$testimonials_args = array(
    'post_type'      => 'testimonial',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $testimonials
);

$testimonials_query = new WP_Query($testimonials_args);
?>

<section class="dmp-testimonials">
    <div class="dmp-testimonials__bg">
        <?php echo wp_get_attachment_image($background_image, '2048×2048'); ?>
    </div>

    <div class="dmp-testimonials__content">
        <div class="dmp-container">
            <div class="dmp-testimonials__head">
                <?php if (!empty($title)): ?>
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif;
                if (!empty($introduction)) : ?>
                    <p><?php echo wp_kses_post($introduction) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($testimonials)): ?>
                <div class="dmp-testimonials__body">
                    <div class="swiper testimonials-swiper">
                        <div class="swiper-wrapper">
                            <?php if ($testimonials_query->have_posts()) :
                                while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                                    $star_rating = get_field('star_rating', get_the_ID());
                                    $review      = get_field('review', get_the_ID()); ?>
                                    <div class="swiper-slide">
                                        <div class="dmp-testimonials-card">
                                            <div class="dmp-testimonials-card__rating">
                                                <?php for ($i = 1; $i <= $star_rating; $i++) : ?>
                                                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                              d="M9.07088 0.612343C9.41462 -0.204115 10.5854 -0.204114 10.9291 0.612346L12.9579 5.43123C13.1029 5.77543 13.4306 6.01061 13.8067 6.0404L19.0727 6.45748C19.9649 6.52814 20.3267 7.62813 19.6469 8.2034L15.6348 11.5987C15.3482 11.8412 15.223 12.2218 15.3106 12.5843L16.5363 17.661C16.744 18.5211 15.7969 19.201 15.033 18.7401L10.5245 16.0196C10.2025 15.8252 9.7975 15.8252 9.47548 16.0196L4.96699 18.7401C4.20311 19.201 3.25596 18.5211 3.46363 17.661L4.68942 12.5843C4.77698 12.2218 4.65182 11.8412 4.36526 11.5987L0.353062 8.2034C-0.326718 7.62813 0.0350679 6.52814 0.927291 6.45748L6.19336 6.0404C6.5695 6.01061 6.89716 5.77543 7.04207 5.43123L9.07088 0.612343Z"
                                                              fill="#EEB420"/>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                            <?php if (!empty($review)): ?>
                                                <div class="dmp-testimonials-card__text">
                                                    <?php echo wp_kses_post($review); ?>
                                                </div>
                                            <?php endif;

                                            the_title('<div class="dmp-testimonials-card__author">', '</div>'); ?>
                                        </div>
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
