<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

get_header();

$args = array(
    'title'            => get_field('dmp_archive_blog_title', 'option'),
    'subtitle'         => get_field('dmp_archive_blog_subtitle', 'option'),
    'background_image' => get_field('dmp_archive_blog_background_image', 'option')
);
get_template_part('template-parts/blocks/secondary_hero', null, $args);

if (have_posts()) : ?>

    <div class="dmp-archive-blog">

        <div class="dmp-archive-blog__row">
            <?php $i = 1;
            while (have_posts()) : the_post();

                get_template_part('template-parts/news-card'); ?>

                <?php if ($i === 6) :
                    $cta_text = get_field('cta_text_free', 'option'); ?>
                    <div class="dmp-request-block">
                        <?php if (!empty($cta_text['badge_image'])) : ?>
                            <div class="dmp-request-block__icon">
                                <?php echo wp_get_attachment_image($cta_text['badge_image'], 'large'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="dmp-request-block__text">
                            <?php if (!empty($cta_text['title'])): ?>
                                <h5>
                                    <?php echo esc_html($cta_text['title']); ?>
                                </h5>
                            <?php endif;
                            if (!empty($cta_text['text'])) : ?>
                                <p class="dmp-sidebar-block__text">
                                    <?php echo wp_kses_post($cta_text['text']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="dmp-request-block__btn">
                            <?php the_btn($cta_text['button'], array('dmp-btn_primary', 'dmp-btn_yellow', 'dmp-btn_w-100'));
                            if (!empty($cta_text['supporting_text'])): ?>
                                <p>
                                    <?php echo esc_html($cta_text['supporting_text']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php $i++;
            endwhile; ?>
        </div>

        <?php the_btn(
            array('title' => 'Load more'),
            array('dmp-btn_primary', 'dmp-btn_border-black', 'dmp-btn_centered'),
            'button',
            array('data-page' => 1)
        ) ?>
    </div>

<?php endif; ?>

<?php get_footer(); ?>
