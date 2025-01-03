<?php
$hero             = get_field('hero');
$hero_content     = get_field('hero_content');

if (!empty($hero)) :
    $class_hero = array('dmp-hero');
    $class_hero[] = 'dmp-hero_' . $hero_content['background_colour']; ?>

    <section class="<?php echo esc_attr(trim(implode(' ', $class_hero))); ?>">
        <div class="dmp-hero__container">
            <?php if (!empty($hero_content['tagline'])): ?>
                <div class="dmp-hero__tagline">
                    <?php echo esc_html($hero_content['tagline']); ?>
                </div>
            <?php endif;
            if (!empty($hero_content['title'])): ?>
                <h1>
                    <?php echo esc_html($hero_content['title']); ?>
                </h1>
            <?php endif;

            if (!empty($hero_content['badge'])) :
                echo '<img src="' . B_STYLE_URL . '/assets/img/certification-1.png" alt="certification" class="dmp-hero__badge" />';
            endif;

            if (!empty($hero_content['subtitle'])) : ?>
                <div class="dmp-hero__subtitle">
                    <?php echo wp_kses_post($hero_content['subtitle']); ?>
                </div>
            <?php endif;
            if (!empty($hero_content['content'])) : ?>
                <div class="dmp-hero__content">
                    <?php echo wp_kses_post($hero_content['content']); ?>
                </div>
            <?php endif; ?>

            <div class="dmp-hero__btns">
                <?php $class_btn_1 = array('dmp-btn_primary');
                switch ($hero_content['button_1_colour']) {
                    case 'white':
                        $class_btn_1[] = 'dmp-btn_white';
                        break;
                    case 'transparent' :
                        $class_btn_1[] = 'dmp-btn_border-white';
                        break;
                    case 'red':
                        $class_btn_1[] = 'dmp-btn_red';
                        break;
                }
                the_btn($hero_content['button_1'], $class_btn_1);

                $class_btn_2 = array('dmp-btn_primary');
                switch ($hero_content['button_2_colour']) {
                    case 'white':
                        $class_btn_2[] = 'dmp-btn_white';
                        break;
                    case 'transparent' :
                        $class_btn_2[] = 'dmp-btn_border-white';
                        break;
                    case 'red':
                        $class_btn_2[] = 'dmp-btn_red';
                        break;
                }
                the_btn($hero_content['button_2'], $class_btn_2); ?>
            </div>
        </div>

        <?php if (!empty($hero_content['image'])): ?>
            <div class="dmp-hero__img">
                <?php echo wp_get_attachment_image($hero_content['image'], '1536x1536', false, array('class' => 'dmp-hero__img-bg'));

                if (!empty($hero_content['badge'])) :
                    echo '<img src="' . B_STYLE_URL . '/assets/img/certification-1.png" alt="certification" class="dmp-hero__img-badge dmp-hero__img-badge_' . $hero_content['badge_position'] . '" />';
                endif; ?>
            </div>
        <?php endif; ?>
    </section>

<?php endif;
