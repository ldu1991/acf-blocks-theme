<?php
$title  = get_sub_field('title');
$text   = get_sub_field('text');
$button = get_sub_field('button');
?>

<section class="dmp-services-banner">
    <section class="dmp-callback dmp-callback_gray">
        <div class="dmp-callback__wrap">
            <div class="dmp-container">
                <div class="dmp-callback__content">
                    <?php if (!empty($title)): ?>
                        <h2><?php echo esc_html($title); ?></h2>
                    <?php endif;
                    echo wp_kses_post($text);
                    the_btn($button, array('dmp-btn_primary', 'dmp-btn_blue')) ?>
                </div>
            </div>
        </div>
        <div class="dmp-callback__bg">
            <img src="<?php echo esc_url(B_TEMP_URL . '/assets/img/callback-1.jpg') ?>"
                 alt="<?php echo esc_attr($title); ?>">
        </div>
    </section>
</section>
