<?php

if (!function_exists('normalize_classes')) {
  function normalize_classes($classes): array
  {
    if (is_array($classes)) {
      return $classes;
    }

    return preg_split('/\s+/', trim((string)$classes)) ?: array();
  }
}

/**
 * @param float $min_size
 * @param float $max_size
 * @param float $min_viewport
 * @param float $max_viewport
 * @param string $unit
 * @return string
 */
function math_clamp(
  float  $min_size,
  float  $max_size,
  float  $min_viewport = 768,
  float  $max_viewport = 1400,
  string $unit = 'rem'
): string
{
  $to_unit = function (float $size) use ($unit): string {
    $context = 16;
    return match ($unit) {
      'rem' => round($size / $context, 6) . 'rem',
      'em' => round($size / $context, 6) . 'em',
      default => $size . 'px',
    };
  };

  if ($min_size === $max_size) {
    return $to_unit($min_size);
  }

  $view_port_width_offset = $to_unit($min_viewport / 100);
  $size_difference = $max_size - $min_size;
  $viewport_difference = $max_viewport - $min_viewport;
  $linear_factor = round((100 * ($size_difference / $viewport_difference)) * 1000) / 1000;

  $fluid = "{$to_unit($min_size)} + ((1vw - {$view_port_width_offset}) * {$linear_factor})";

  [$clamp_min, $clamp_max] = $min_size > $max_size
    ? [$to_unit($max_size), $to_unit($min_size)]
    : [$to_unit($min_size), $to_unit($max_size)];

  return "clamp({$clamp_min}, {$fluid}, {$clamp_max})";
}

/**
 * @param string $general_class
 * @param array $block
 * @param bool $is_preview
 * @return array
 */
function get_section_options(string $general_class = '', array $block = array(), bool $is_preview = false): array
{

  $result = array();

  if (!empty($block['anchor'])) {
    $result['id_attr'] = 'id="' . esc_attr($block['anchor']) . '" ';
    $result['id'] = $block['anchor'];
  } elseif (!empty($block['id'])) {
    $result['id_attr'] = 'id="' . esc_attr($block['id']) . '" ';
    $result['id'] = $block['id'];
  } else {
    $result['id_attr'] = '';
    $result['id'] = '';
  }

  $result['class'] = array();
  $result['class'][] = $general_class;

  if (!empty($block['className'])) $result['class'][] = $block['className'];

  if (!empty($block['align'])) $result['class'][] = 'align-' . $block['align'];

  if (!empty($is_preview)) $result['class'][] = $general_class . '_is-preview';

  $result['class'][] = get_prefix() . '-section-element';

  return $result;
}

/**
 * @param array $block
 * @param string $src
 * @return bool
 */
function has_preview_screenshot(array $block = array(), string $src = ''): bool
{
  $screenshot = get_field('screenshot');
  $filename = str_replace('acf/', '', $block['name']);
  $screenshot_src = !empty($src) ? $src : '/assets/img/screenshots/' . $filename . '.jpg';

  if (!empty($screenshot) && file_exists(get_stylesheet_directory() . $screenshot_src)) {
    echo '<img width="100%" height="100%" style="object-fit: contain;object-position: center" src="' . get_stylesheet_directory_uri() . $screenshot_src . '" alt="' . $filename . '">';

    return true;
  }

  return false;
}

/**
 * @param $block_name
 * @return bool
 */
function has_first_block($block_name): bool
{
  global $post;

  if (!$post) {
    return false;
  }

  $content = $post->post_content;

  if (has_blocks($content)) {
    $blocks = parse_blocks($content);

    if (!empty($blocks)) {
      $first_block = reset($blocks);
      $first_block_name = !empty($first_block['blockName']) ? $first_block['blockName'] : '';

      if (is_array($block_name)) {
        return in_array($first_block_name, $block_name);
      } else {
        return $first_block_name === $block_name;
      }
    }
  }

  return false;
}

/**
 * @param $block_name
 * @return bool
 */
function has_last_block($block_name): bool
{
  global $post;

  if (!$post) {
    return false;
  }

  $content = $post->post_content;

  if (has_blocks($content)) {
    $blocks = parse_blocks($content);

    if (!empty($blocks)) {
      $last_block = end($blocks);
      $last_block_name = !empty($last_block['blockName']) ? $last_block['blockName'] : '';

      if (is_array($block_name)) {
        return in_array($last_block_name, $block_name);
      } else {
        return $last_block_name === $block_name;
      }
    }
  }

  return false;
}

/**
 * @param $post_id
 * @param int $excerpt_length
 * @param string $more
 * @return string
 */
function custom_wp_trim_excerpt($post_id = null, int $excerpt_length = 55, string $more = ''): string
{
  if ($post_id === null) {
    global $post;
    $post_id = $post->ID;
  }

  if (has_excerpt($post_id)) {
    return get_the_excerpt($post_id);
  } else {
    $post = get_post($post_id);
    $text = get_the_content('', false, $post);

    $text = strip_shortcodes($text);
    $text = excerpt_remove_blocks($text);
    $text = excerpt_remove_footnotes($text);

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);

    return wp_trim_words($text, $excerpt_length, $more);
  }
}

