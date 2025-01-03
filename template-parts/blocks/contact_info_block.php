<?php
$contact_section = get_sub_field('contact_section');
?>
<section class="dmp-contact-info-block">
    <div class="dmp-contact-info-block__container">
        <?php if (!empty($contact_section)):
            foreach ($contact_section as $item) : ?>
                <div class="dmp-contact-info-block__item">
                    <div class="dmp-contact-info-block__item-icon">
                        <?php echo wp_get_attachment_image($item['icon'], 'large'); ?>
                    </div>
                    <?php if (!empty($item['title'])): ?>
                        <h4><?php echo esc_html($item['title']); ?></h4>
                    <?php endif;
                    if (!empty($item['text'])) : ?>
                        <div class="dmp-contact-info-block__item-text">
                            <?php echo wp_kses_post($item['text']); ?>
                        </div>
                    <?php endif;
                    if(!empty($item['link'])) :
                        $target = (!empty($item['link']['target']) && $item['link']['target'] === '_blank') ? 'target="_blank"' : ''; ?>
                        <a href="<?php echo esc_url($item['link']['url']) ?>" <?php echo $target ?>>
                            <?php echo esc_html($item['link']['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach;
        endif; ?>
    </div>
</section>
