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

/**
 * @return string[] List of block directories.
 */
function theme_get_block_folders(): array
{
    return glob(get_stylesheet_directory() . '/blocks/*', GLOB_ONLYDIR) ?: array();
}

add_action('init', function () {
    foreach (theme_get_block_folders() as $folder) {
        register_block_type($folder);
    }
});

add_action('wp_enqueue_scripts', function () {
    foreach (theme_get_block_folders() as $folder) {
        $folder    = wp_normalize_path($folder);
        $meta_file = trailingslashit($folder) . 'block.json';
        if (!file_exists($meta_file)) {
            continue;
        }

        $metadata   = wp_json_file_decode($meta_file, ['associative' => true]);
        $block_name = $metadata['name'] ?? '';
        if (!$block_name || !has_block($block_name)) {
            continue;
        }

        $handle_base = str_replace('/', '-', $block_name);
        $uri_base    = get_stylesheet_directory_uri() . '/blocks/' . basename($folder) . '/';

        // dependencies
        $deps_style  = $metadata['dependencies']['style'] ?? array();
        $deps_script = $metadata['dependencies']['script'] ?? array();

        // style.css
        $style_file = trailingslashit($folder) . 'style.css';
        if (file_exists($style_file)) {
            wp_enqueue_style(
                $handle_base,
                $uri_base . 'style.css',
                $deps_style,
                filemtime($style_file)
            );
        }

        // script.js
        $script_file = trailingslashit($folder) . 'script.js';
        if (file_exists($script_file)) {
            wp_enqueue_script(
                $handle_base,
                $uri_base . 'script.js',
                $deps_script,
                filemtime($script_file),
                true
            );
        }
    }
});

add_action('enqueue_block_editor_assets', function () {
    foreach (theme_get_block_folders() as $folder) {
        $folder    = wp_normalize_path($folder);
        $meta_file = trailingslashit($folder) . 'block.json';
        if (!file_exists($meta_file)) {
            continue;
        }

        $metadata   = wp_json_file_decode($meta_file, ['associative' => true]);
        $block_name = $metadata['name'] ?? '';
        if (!$block_name) {
            continue;
        }

        $handle_base = 'editor-' . str_replace('/', '-', $block_name);
        $uri_base    = get_stylesheet_directory_uri() . '/blocks/' . basename($folder) . '/';

        $deps_style  = $metadata['dependencies']['style'] ?? array();
        $deps_script = $metadata['dependencies']['script'] ?? array();

        $editor_style = trailingslashit($folder) . 'style.css';
        if (file_exists($editor_style)) {
            wp_enqueue_style(
                $handle_base,
                $uri_base . 'style.css',
                $deps_style,
                filemtime($editor_style)
            );
        }

        $editor_script = trailingslashit($folder) . 'script.js';
        if (file_exists($editor_script)) {
            wp_enqueue_script(
                $handle_base,
                $uri_base . 'script.js',
                $deps_script,
                filemtime($editor_script),
                true
            );
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


