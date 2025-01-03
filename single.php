<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

get_header(); ?>

<?php while (have_posts()) : the_post();

    get_template_part('template-parts/blocks/basic_text_section');

    get_template_part('template-parts/blocks/related_services');

endwhile; ?>

<?php get_footer(); ?>
