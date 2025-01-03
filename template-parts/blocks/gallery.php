<?php
$gallery_layout = get_sub_field('gallery_layout');
$gallery_images = get_sub_field('gallery_images');

if (!empty($gallery_images)) :
    $id_fancybox = generator_wrd(); ?>
    <section class="dmp-gallery">
        <div class="dmp-gallery__container">
            <?php if ($gallery_layout === 'layout-1') : ?>
                <div class="dmp-gallery__layout-1">
                    <?php foreach ($gallery_images as $img) : ?>
                        <a href="<?php echo esc_url($img['url']) ?>"
                           data-fancybox="<?php echo $id_fancybox ?>"
                           aria-label="Gallery">
                            <?php echo wp_get_attachment_image($img['ID'], 'large') ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($gallery_layout === 'layout-2'):
                $i = 1; ?>
                <div class="dmp-gallery__layout-2">
                    <div class="dmp-gallery__col">
                        <?php foreach ($gallery_images as $img) : ?>
                            <a href="<?php echo esc_url($img['url']) ?>"
                               data-fancybox="<?php echo $id_fancybox ?>"
                               aria-label="Gallery">
                                <?php echo wp_get_attachment_image($img['ID'], 'large') ?>
                            </a>
                            <?php
                            if($i === 1) {
                                echo '</div><div class="dmp-gallery__col-max">';
                            }
                            $i++;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif;
