<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

/* Action */
add_action('wp_enqueue_scripts', 'set_styles_scripts');
add_action('after_setup_theme', 'add_theme_supports');


/* Filter */
//add_filter('acf/settings/show_admin', '__return_false'); // Hide ACF field group menu item
add_filter('use_block_editor_for_post', '__return_false', 5);
add_filter('big_image_size_threshold', '__return_false');
add_filter('pre_option_rg_gforms_disable_css', '__return_true');

function custom_inline_menu_styles()
{
    global $pagenow;

    if ($pagenow === 'nav-menus.php') {
        echo '<style>#wpbody-content #menu-settings-column{display: block;position:sticky;top: 32px;}</style>';
    }
}

add_action('admin_head', 'custom_inline_menu_styles');

/**
 * Connection styles/scripts
 */
function set_styles_scripts()
{
    /* *** STYLES *** */
    wp_enqueue_style(B_PREFIX . '-poppins', '//fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style(B_PREFIX . '-inter', '//fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style(B_PREFIX . '-roboto', '//fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', array(), wp_get_theme()->get('Version'));

    wp_enqueue_style(B_PREFIX . '-select2', '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), wp_get_theme()->get('Version'));

    wp_enqueue_style(B_PREFIX . '-style', B_STYLE_URL . '/assets/css/style.css', array(), wp_get_theme()->get('Version'));


    /* *** SCRIPTS *** */
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script(B_PREFIX . '-select2', '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script(B_PREFIX . '-sharer', '//cdn.jsdelivr.net/npm/sharer.js@0.5.2/sharer.min.js', array('jquery'), wp_get_theme()->get('Version'), true);

    wp_enqueue_script(B_PREFIX . '-script', B_TEMP_URL . '/assets/js/script.js', array('jquery'), wp_get_theme()->get('Version'), true);


    /* *** LOCAL SCRIPTS *** */
    wp_localize_script('jquery', 'wp_ajax',
        array(
            'url'    => admin_url('admin-ajax.php'),
            'nonce'  => wp_create_nonce('wpajax-noncecode'),
            'prefix' => B_PREFIX
        )
    );
}


/**
 * Register supports
 */
function add_theme_supports()
{

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register navigation menus.
    register_nav_menus(array(
        'top_bar_menu'        => __('Top Bar Menu', B_PREFIX),
        'header_menu'         => __('Menu Header', B_PREFIX),
        'landing_header_menu' => __('Landing Menu Header', B_PREFIX),
        'footer_menu_1'       => __('Menu Footer 1', B_PREFIX),
        'footer_menu_2'       => __('Menu Footer 2', B_PREFIX),
        'footer_copyright'    => __('Menu Copyright', B_PREFIX)
    ));

    // Add image sizes.
    //add_image_size('thumbnail-once', 200, 200, true);
}

add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_post_type_archive('case-study')) {
            $query->set('posts_per_page', 9);
        }

        if (is_post_type_archive('career')) {
            $query->set('posts_per_page', -1);
        }
    }
});


add_filter('flexible_layout_preview-image_for_acf_images_path', function () {
    return 'assets/img/acf-flexible';
}, 10, 2);

