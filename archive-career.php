<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

get_header();

$args = array(
    'title'            => get_field('dmp_archive_careers_title', 'option'),
    'subtitle'         => get_field('dmp_archive_careers_subtitle', 'option'),
    'background_image' => get_field('dmp_archive_careers_background_image', 'option'),
    'filter'           => true
);
get_template_part('template-parts/blocks/secondary_hero', null, $args); ?>

<section class="dmp-careers">
    <div class="dmp-container">
        <div class="dmp-careers__wrap">
            <form class="dmp-careers__filter">
                <?php $locations = get_terms([
                    'taxonomy'   => 'locations',
                    'hide_empty' => false,
                ]);
                if (!empty($locations)) : ?>
                    <label class="dmp-form-select">
                        <select name="locations" data-placeholder="All Locations">
                            <option value="">All Locations</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?php echo esc_attr($location->slug) ?>">
                                    <?php echo esc_html($location->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                <?php endif;
                $specialities = get_terms([
                    'taxonomy'   => 'specialities',
                    'hide_empty' => false,
                ]);
                if (!empty($specialities)) : ?>
                    <label class="dmp-form-select">
                        <select name="specialities" data-placeholder="All Specialities">
                            <option value="">All Specialities</option>
                            <?php foreach ($specialities as $speciality) : ?>
                                <option value="<?php echo esc_attr($speciality->slug) ?>">
                                    <?php echo esc_html($speciality->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                <?php endif;
                $types_careers = get_terms([
                    'taxonomy'   => 'types-careers',
                    'hide_empty' => false,
                ]);
                if (!empty($types_careers)) : ?>
                    <label class="dmp-form-select">
                        <select name="types-careers" data-placeholder="All Types">
                            <option value="">All Types</option>
                            <?php foreach ($types_careers as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug) ?>">
                                    <?php echo esc_html($type->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                <?php endif;

                the_btn(
                    array('title' => __('Search Jobs', B_PREFIX)),
                    array('dmp-btn_primary', 'dmp-btn_blue'),
                    'button',
                    array('type' => 'submit')
                ); ?>
            </form>

            <?php if (have_posts()) : ?>
                <div class="dmp-careers__list">
                    <?php while (have_posts()) : the_post();
                        $specialities = get_the_terms(get_the_ID(), 'specialities');
                        if (!empty($specialities)) {
                            $speciality = '';
                            foreach ($specialities as $spec) {
                                $speciality .= the_btn(
                                    array(
                                        'title' => $spec->name,
                                        'url'   => get_post_type_archive_link('career') . '?specialities=' . $spec->slug,
                                    ),
                                    array('dmp-btn_tag'),
                                    'a',
                                    array(),
                                    true
                                );
                            }
                        }

                        $job_description  = get_field('job_description');
                        $reference_number = get_field('reference_number'); ?>
                        <div class="dmp-job-card">
                            <div class="dmp-job-card__head">
                                <?php
                                the_title('<h5>', '</h5>');
                                echo $speciality;
                                ?>
                            </div>

                            <?php if (!empty($job_description)): ?>
                                <div class="dmp-job-card__description">
                                    <?php echo wp_kses_post($job_description); ?>
                                </div>
                            <?php endif; ?>
                            <div class="dmp-job-card__footer">
                                <?php the_btn(
                                    array(
                                        'title' => __('Apply Now', B_PREFIX),
                                        'url'   => get_the_permalink()
                                    ),
                                    array('dmp-btn_secondary', 'dmp-btn_border')
                                ); ?>
                                <div class="dmp-job-card__ref">
                                    <?php echo esc_html('Ref: ' . $reference_number); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
