<?php
$testimonial = get_sub_field('testimonial');

$testimonial_args = array(
    'post_type'      => 'testimonial',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $testimonial
);

$testimonial_query = new WP_Query($testimonial_args);

if (!empty($testimonial)):
    if ($testimonial_query->have_posts()) :
        while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
            $star_rating = get_field('star_rating', get_the_ID());
            $review      = get_field('review', get_the_ID());
            $position    = get_field('position', get_the_ID());
            $company     = get_field('company', get_the_ID()); ?>
            <section class="dmp-single-testimonial">
                <div class="dmp-single-testimonial__rating">
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
                    <div class="dmp-single-testimonial__text">
                        <h5>
                            <?php echo wp_kses_post($review); ?>
                        </h5>
                    </div>
                <?php endif; ?>
                <div class="dmp-single-testimonial__author">
                    <?php the_title('<p><b>', '</b></p>'); ?>
                    <p>
                        <?php if (!empty($position)) {
                            echo esc_html($position);
                        }
                        if (!empty($company)) {
                            echo ', ' . esc_html($company);
                        } ?>
                    </p>
                </div>
            </section>
        <?php endwhile;
        wp_reset_postdata();
    endif;
else : ?>
    <p>Please choose testimonial...</p>
<?php endif;
