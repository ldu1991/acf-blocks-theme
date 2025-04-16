<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

// get_template_directory();        D:/OpenServer/domains/site/wp-content/themes/my-PARENT-theme
// get_template_directory_uri();    http://site/wp-content/themes/my-PARENT-theme
// get_stylesheet_directory();      D:/OpenServer/domains/site/wp-content/themes/my-CHILD-theme
// get_stylesheet_directory_uri();  http://site/wp-content/themes/my-CHILD-theme


function get_prefix()
{
    $json_path = get_stylesheet_directory() . '/theme.json';

    if (!file_exists($json_path)) {
        return null;
    }

    $json_data = file_get_contents($json_path);
    $parsed    = json_decode($json_data, true);

    return $parsed['settings']['custom']['prefix'] ?? null;
}


function add_block_category($categories, $post)
{
    return array_merge(
        array(
            array(
                'slug'  => 'beyond-category',
                'title' => __('Beyond Blocks', get_prefix())
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

include_once('include/helper-functions.php');
include_once('include/action-config.php');

if (class_exists('acf')) {
    include_once('acf/menu-item-depth.php');
}

function include_field_types()
{
    if (class_exists('acf')) {
        include_once('acf/field-image-selector.php');
    }
}

add_action('acf/include_field_types', 'include_field_types');
