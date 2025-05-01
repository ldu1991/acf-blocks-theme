<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

// get_template_directory();        D:/OpenServer/domains/site/wp-content/themes/my-PARENT-theme
// get_template_directory_uri();    http://site/wp-content/themes/my-PARENT-theme
// get_stylesheet_directory();      D:/OpenServer/domains/site/wp-content/themes/my-CHILD-theme
// get_stylesheet_directory_uri();  http://site/wp-content/themes/my-CHILD-theme


function tcl_get_global_settings()
{
    $json_path = get_stylesheet_directory() . '/theme.json';

    if (!file_exists($json_path)) {
        return null;
    }

    $json_data = file_get_contents($json_path);
    $parsed    = json_decode($json_data, true);

    return $parsed['settings'] ?? null;
}


function get_prefix()
{
    $json = tcl_get_global_settings();

    return $json['custom']['prefix'] ?? 'tcl';
}


function add_block_category($categories, $post): array
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

function register_acf_blocks(): void
{
    $subdirectories = glob(get_stylesheet_directory() . '/blocks/*', GLOB_ONLYDIR);

    foreach ($subdirectories as $subdirectory) {
        register_block_type($subdirectory);
    }
}

add_action('init', 'register_acf_blocks');

add_action('enqueue_block_assets', function () {
    $folders = glob(get_stylesheet_directory() . '/blocks/*', GLOB_ONLYDIR);

    foreach ($folders as $folder) {
        $folder = wp_normalize_path($folder);
        if (file_exists(trailingslashit($folder) . 'block.json')) {
            $metadata = wp_json_file_decode(trailingslashit($folder) . 'block.json', array('associative' => true));

            $deps_style = array();
            if (isset($metadata['dependencies']) &&
                isset($metadata['dependencies']['style']) &&
                is_array($metadata['dependencies']['style'])) {
                $deps_style = $metadata['dependencies']['style'];
            }

            $deps_script = array();
            if (isset($metadata['dependencies']) &&
                isset($metadata['dependencies']['script']) &&
                is_array($metadata['dependencies']['script'])) {
                $deps_script = $metadata['dependencies']['script'];
            }

            if (has_block($metadata['name'])) {
                // Style
                if (file_exists(trailingslashit($folder) . 'style.css')) {
                    wp_enqueue_style(
                        str_replace('/', '-', $metadata['name']),
                        get_stylesheet_directory_uri() . '/blocks/' . basename($folder) . '/style.css',
                        $deps_style,
                        wp_get_theme()->get('Version')
                    );
                }

                // Script
                if (file_exists(trailingslashit($folder) . 'script.js')) {
                    wp_enqueue_script(
                        str_replace('/', '-', $metadata['name']),
                        get_stylesheet_directory_uri() . '/blocks/' . basename($folder) . '/script.js',
                        $deps_script,
                        wp_get_theme()->get('Version'),
                        true
                    );
                }
            }
        }
    }
});


include_once('include/helper-functions.php');
include_once('include/action-config.php');
foreach (glob(get_stylesheet_directory() . '/include/components/ui-*.php') as $component_file) {
    require_once $component_file;
}

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

