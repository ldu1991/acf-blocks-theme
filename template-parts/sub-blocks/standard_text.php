<?php
$text = get_sub_field('text');
if (!empty($text)) {
    echo wp_kses_post($text);
}
