<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

get_header();

$args = array(
    'title'            => get_field('dmp_archive_case_study_title', 'option'),
    'subtitle'         => get_field('dmp_archive_case_study_subtitle', 'option'),
    'background_image' => get_field('dmp_archive_case_study_background_image', 'option')
);
get_template_part('template-parts/blocks/secondary_hero', null, $args);

$case_study_category = get_terms([
    'taxonomy'   => 'case_study_category',
    'hide_empty' => false,
]); ?>

    <section class="dmp-case-studies">
        <div class="dmp-container">
            <?php if (!empty($case_study_category)): ?>
                <div class="dmp-case-studies__sort">
                    <?php
                    the_btn(
                        array('title' => __('All', B_PREFIX)),
                        array('dmp-btn_sort', 'active'),
                        'button',
                        array('value' => '')
                    );
                    foreach ($case_study_category as $cat) {
                        the_btn(
                            array('title' => $cat->name),
                            array('dmp-btn_sort'),
                            'button',
                            array('value' => $cat->slug)
                        );
                    } ?>
                </div>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
                <div class="dmp-case-studies__row">
                    <?php $i = 1;
                    while (have_posts()) : the_post();

                        $args = array('square' => false);
                        if ($i === 3 ||
                            $i === 4 ||
                            $i === 6 ||
                            $i === 9) {
                            $args['square'] = true;
                        }
                        get_template_part('template-parts/case-study-card', null, $args);

                        $i++;
                    endwhile; ?>
                </div>


                <?php the_btn(
                    array('title' => 'Load more'),
                    array('dmp-btn_primary', 'dmp-btn_border-black', 'dmp-btn_centered'),
                    'button',
                    array('data-page' => 1)
                ); ?>
            <?php endif; ?>
        </div>
    </section>

<?php get_footer();
