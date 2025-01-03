<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

get_header();

while (have_posts()) : the_post();

    get_template_part('template-parts/blocks/hero');

    get_template_part('template-parts/blocks/secondary_hero');


    if (have_rows('page_content')):
        while (have_rows('page_content')) : the_row();
            get_template_part('template-parts/blocks/' . get_row_layout());
        endwhile;
    endif;

endwhile;

get_footer();
