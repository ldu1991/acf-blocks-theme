<?php
$icons  = get_sub_field('icons');
$layout = get_sub_field('layout');

$class   = array('dmp-priorities');
$class[] = 'dmp-priorities_' . $layout;
?>

<section class="<?php echo esc_attr(trim(implode(' ', $class))) ?>">
    <div class="dmp-container-full">
        <div class="dmp-priorities__row">
            <?php if (!empty($icons)):
                foreach ($icons as $icon) : ?>
                    <div class="dmp-priorities__col">
                        <div class="dmp-priorities__item">
                            <div class="dmp-priorities__item-icon">
                                <?php echo wp_get_attachment_image($icon['icon_image']); ?>
                            </div>
                            <div class="dmp-priorities__item-text">
                                <h5><?php echo esc_html($icon['title']) ?></h5>
                                <p><?php echo esc_html($icon['text']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
