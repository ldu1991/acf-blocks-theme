<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

get_header();

while (have_posts()) : the_post();

    get_template_part('template-parts/blocks/secondary_hero');

    $dmp_job_detail_form = get_field('dmp_job_detail_form', 'option');
    $job_description     = get_field('job_description');
    $reference_number    = get_field('reference_number');

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
    } ?>

    <div class="dmp-job-detail">
        <?php if (!empty($job_description)): ?>
            <div class="dmp-job-detail__description">
                <?php echo wp_kses_post($job_description); ?>
            </div>
        <?php endif; ?>

        <div class="dmp-job-detail__info">
            <div class="dmp-job-detail__ref">
                <?php echo esc_html('Ref: ' . $reference_number); ?>
            </div>

            <div>
                <?php echo $speciality; ?>
            </div>
        </div>

        <div class="dmp-job-detail__form">
            <?php echo do_shortcode('[gravityform id="' . $dmp_job_detail_form . '" title="true" description="false" ajax="true"]'); ?>
        </div>

        <a href="<?php echo get_post_type_archive_link('career'); ?>"
           class="dmp-link dmp-link_centered">
            <div>
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.75 9.5H4.25" stroke="black" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                    <path d="M9.5 14.75L4.25 9.5L9.5 4.25" stroke="black" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                </svg>
            </div>
            Back to all Jobs
        </a>
    </div>

<?php endwhile;

get_footer();
