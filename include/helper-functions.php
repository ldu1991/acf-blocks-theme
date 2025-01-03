<?php

/**
 * @param $link_arr
 * @param array $classes
 * @param string $teg
 * @param array $atts
 * @param bool $return
 * @return string|void
 */
function the_btn($link_arr, array $classes = array(), string $teg = 'a', array $atts = array(), bool $return = false)
{
    $class_link = array('dmp-btn');
    $class_link = array_merge($class_link, $classes);

    if (!empty($link_arr)) {
        $html = '';
        $atts['class'] = esc_attr(trim(implode(' ', $class_link), " "));
        $atts['href'] = (!empty($link_arr['url']) && $teg === 'a') ? esc_url($link_arr['url']) : '';
        $atts['target'] = (!empty($link_arr['target']) && $link_arr['target'] === '_blank') ? '_blank' : '';
        $atts['aria-label'] = !empty($link_arr['title']) ? esc_attr($link_arr['title']) : 'Button';
        if($teg === 'span') $atts['role'] = 'button';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (is_scalar($value) && '' !== $value && false !== $value) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $html .= '<' . $teg . $attributes . '>';
        $html .= !empty($link_arr['title']) ? esc_html($link_arr['title']) : '';
        $html .= '</' . $teg . '>';

        if (!$return) {
            echo $html;
        } else {
            return $html;
        }
    }
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
function custom_wp_trim($content = null, int $excerpt_length = 55, string $more = ''): string
{
    if (!empty($content)) {
        $text = $content;

        $text = strip_shortcodes($text);
        $text = excerpt_remove_blocks($text);
        $text = excerpt_remove_footnotes($text);

        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);

        return wp_trim_words($text, $excerpt_length, $more);
    } else {
        return '';
    }
}

function generator_wrd() {
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ';
    $string = '';
    for ($i = 0; $i < 5; $i++)
        $string .= substr($chars, rand(1, 30) - 1, 1);
    return $string;
}
