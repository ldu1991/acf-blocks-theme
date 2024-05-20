<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

$theme_json = WP_Theme_JSON_Resolver::get_merged_data()->get_settings();

/**
 * Define constants.
 */
if (!defined('B_PREFIX')) define('B_PREFIX', $theme_json['custom']['prefix']);
if (!defined('B_TEMP_PATH')) define('B_TEMP_PATH', get_template_directory());
if (!defined('B_TEMP_URL')) define('B_TEMP_URL', get_template_directory_uri());
if (!defined('B_STYLE_PATH')) define('B_STYLE_PATH', get_stylesheet_directory());
if (!defined('B_STYLE_URL')) define('B_STYLE_URL', get_stylesheet_directory_uri());


/**
 * Include
 */
include_once('include/helper-functions.php');
include_once('include/action-config.php');


function add_block_category($categories, $post)
{
    return array_merge(
        array(
            array(
                'slug'  => 'beyond-category',
                'title' => __('Beyond Blocks', B_PREFIX)
            )
        ),
        $categories
    );
}
add_filter('block_categories_all', 'add_block_category', 10, 2);

function register_acf_blocks()
{
    $subdirectories = glob(__DIR__ . '/blocks/*', GLOB_ONLYDIR);

    foreach ($subdirectories as $subdirectory) {
        register_block_type($subdirectory);
    }
}

add_action('init', 'register_acf_blocks');


function set_library()
{
    $style_library = array(
        //'swiper' => B_STYLE_URL . '/assets/css/lib/swiper.css'
    );

    $script_library = array(
        //'swiper' => B_TEMP_URL . '/assets/lib/swiper-bundle.min.js'
    );

    if(!empty($style_library)) {
        foreach ($style_library as $handle => $src) {
            wp_register_style($handle, $src);
        }
    }

    if(!empty($script_library)) {
        foreach ($script_library as $handle => $src) {
            wp_register_script($handle, $src, array('jquery'), wp_get_theme()->get('Version'));
        }
    }

    /* *** LOCAL SCRIPTS *** */
    wp_localize_script('jquery', 'wp_ajax',
        array(
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wpajax-noncecode'),
            'prefix' => B_PREFIX
        )
    );
}
add_action( 'enqueue_block_editor_assets', 'set_library' );
add_action('wp_enqueue_scripts', 'set_library');
