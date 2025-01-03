<?php
$title       = !empty($args['title']) ? $args['title'] : get_sub_field('title');
$blue_title  = !empty($args['blue_title']) ? $args['blue_title'] : get_sub_field('blue_title');
$content     = !empty($args['content']) ? $args['content'] : get_sub_field('content');
$display_cta = !empty($args['display_cta']) ? $args['display_cta'] : get_sub_field('display_cta');
$cta_version = !empty($args['cta_version']) ? $args['cta_version'] : get_sub_field('cta_version');


if (is_single() && get_post_type() === 'post') {
    $breadcrumbs = true;
    $date        = get_the_time('d M Y', get_the_ID());

    $categories = get_the_category();
    if ($categories) {
        $cat = '';
        foreach ($categories as $category) {
            $cat .= '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>, ';
        }
    }

    $posttags = get_the_tags();
    if ($posttags) {
        $tag = '';
        $tag_attr = '';
        foreach ($posttags as $posttag) {
            $tag .= the_btn(
                array(
                    'title' => $posttag->name,
                    'url'   => get_tag_link($posttag->term_id)
                ),
                array('dmp-btn_tag'),
                'a',
                array(),
                true
            );
            $tag_attr = $posttag->name . ', ';
        }
    }

    $title      = get_the_title();
    $blue_title = true;

    $display_cta = true;
    $cta_version = 'free';
}

if (!empty($display_cta)) {
    $cta_text = get_field('cta_text_' . $cta_version, 'option');
}

$class_container = array('dmp-basic-text-section__container');
if (!empty($display_cta)) {
    $class_container[] = 'dmp-basic-text-section__container_is-cta';
}
?>

<section class="dmp-basic-text-section">
    <div class="<?php echo esc_attr(trim(implode(' ', $class_container))); ?>">
        <?php if (!empty($display_cta)): ?>
            <div class="dmp-basic-text-section__sidebar">
                <?php $class_sidebar_block = array('dmp-sidebar-block');
                if ($cta_version === 'paid') {
                    $class_sidebar_block[] = 'dmp-sidebar-block_red';
                } ?>
                <div class="<?php echo esc_attr(trim(implode(' ', $class_sidebar_block))); ?>">
                    <?php if (!empty($cta_text['title'])): ?>
                        <h5>
                            <?php echo esc_html($cta_text['title']); ?>
                        </h5>
                    <?php endif; ?>
                    <div class="dmp-sidebar-block__row">
                        <?php if (!empty($cta_text['text'])) : ?>
                            <div class="dmp-sidebar-block__text">
                                <?php echo wp_kses_post($cta_text['text']); ?>
                            </div>
                        <?php endif;
                        if (!empty($cta_text['badge_image'])) : ?>
                            <div class="dmp-sidebar-block__logo">
                                <?php echo wp_get_attachment_image($cta_text['badge_image'], 'large'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php
                    $class_btn = $cta_version === 'paid' ? array('dmp-btn_primary', 'dmp-btn_white-red', 'dmp-btn_w-100') : array('dmp-btn_primary', 'dmp-btn_yellow', 'dmp-btn_w-100');
                    the_btn($cta_text['button'], $class_btn) ?>

                    <?php if (!empty($cta_text['supporting_text'])): ?>
                        <div class="dmp-sidebar-block__text-small">
                            <?php echo esc_html($cta_text['supporting_text']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="dmp-basic-text-section__content">
            <?php if (!empty($breadcrumbs) && function_exists('rank_math_the_breadcrumbs')) {
                rank_math_the_breadcrumbs();
            } ?>

            <?php if (!empty($title)):
                $class_title = array('dmp-basic-text-section__title');
                if (!empty($blue_title)) {
                    $class_title[] = 'dmp-basic-text-section__title_blue';
                } ?>
                <h2 class="<?php echo esc_attr(trim(implode(' ', $class_title))); ?>">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if (!empty($date) || !empty($cat)): ?>
                <div class="dmp-basic-text-section__info">
                    <?php if (!empty($date)): ?>
                        <time><?php echo esc_html($date); ?></time>
                    <?php endif;
                    if (!empty($date) & !empty($cat)) {
                        echo '|';
                    }
                    if (!empty($cat)) : ?>
                        <div class="dmp-basic-text-section__info-cat">
                            <?php echo trim($cat, ', '); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (is_single() && get_post_type() === 'post') : ?>
                <?php the_content(); ?>

                <div class="dmp-basic-text-section__footer">
                    <div class="dmp-share">
                        <div class="dmp-share__title">
                            Share this post
                        </div>
                        <div class="dmp-share__row">
                            <button class="dmp-copy-button"
                                    value="<?php the_permalink(); ?>">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.22172 17.778C2.68559 18.2425 3.23669 18.6108 3.84334 18.8617C4.44999 19.1126 5.10023 19.2411 5.75672 19.24C6.41335 19.2411 7.06374 19.1125 7.67054 18.8617C8.27735 18.6108 8.82863 18.2425 9.29272 17.778L12.1207 14.949L10.7067 13.535L7.87872 16.364C7.31519 16.925 6.55239 17.2399 5.75722 17.2399C4.96205 17.2399 4.19925 16.925 3.63572 16.364C3.07422 15.8007 2.75892 15.0378 2.75892 14.2425C2.75892 13.4471 3.07422 12.6842 3.63572 12.121L6.46472 9.29296L5.05072 7.87896L2.22172 10.707C1.28552 11.6454 0.759766 12.9169 0.759766 14.2425C0.759766 15.568 1.28552 16.8395 2.22172 17.778ZM17.7777 9.29296C18.7134 8.35425 19.2388 7.08288 19.2388 5.75746C19.2388 4.43204 18.7134 3.16068 17.7777 2.22196C16.8393 1.28577 15.5678 0.76001 14.2422 0.76001C12.9166 0.76001 11.6452 1.28577 10.7067 2.22196L7.87872 5.05096L9.29272 6.46496L12.1207 3.63596C12.6842 3.07495 13.447 2.75999 14.2422 2.75999C15.0374 2.75999 15.8002 3.07495 16.3637 3.63596C16.9252 4.19923 17.2405 4.96213 17.2405 5.75746C17.2405 6.55279 16.9252 7.31569 16.3637 7.87896L13.5347 10.707L14.9487 12.121L17.7777 9.29296Z"
                                          fill="white"/>
                                    <path d="M6.46371 14.95L5.04871 13.536L13.5357 5.05005L14.9497 6.46505L6.46371 14.95Z"
                                          fill="white"/>
                                </svg>
                            </button>
                            <button data-sharer="linkedin"
                                    data-url="<?php the_permalink(); ?>">
                                <svg width="18" height="19" viewBox="0 0 18 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M1.5 0.242676C0.67157 0.242676 0 0.914246 0 1.74268V16.7427C0 17.5711 0.67157 18.2427 1.5 18.2427H16.5C17.3284 18.2427 18 17.5711 18 16.7427V1.74268C18 0.914246 17.3284 0.242676 16.5 0.242676H1.5ZM5.52076 4.2454C5.52639 5.20165 4.81061 5.79087 3.96123 5.78665C3.16107 5.78243 2.46357 5.1454 2.46779 4.24681C2.47201 3.40165 3.13998 2.72243 4.00764 2.74212C4.88795 2.76181 5.52639 3.40728 5.52076 4.2454ZM9.2797 7.00444H6.75971H6.7583V15.5643H9.4217V15.3646C9.4217 14.9847 9.4214 14.6047 9.4211 14.2246C9.4203 13.2108 9.4194 12.1959 9.4246 11.1824C9.426 10.9363 9.4372 10.6804 9.5005 10.4455C9.7381 9.56798 10.5271 9.00128 11.4074 9.14058C11.9727 9.22908 12.3467 9.55678 12.5042 10.0898C12.6013 10.423 12.6449 10.7816 12.6491 11.129C12.6605 12.1766 12.6589 13.2242 12.6573 14.2719C12.6567 14.6417 12.6561 15.0117 12.6561 15.3815V15.5629H15.328V15.3576C15.328 14.9056 15.3278 14.4537 15.3275 14.0018C15.327 12.8723 15.3264 11.7428 15.3294 10.6129C15.3308 10.1024 15.276 9.59898 15.1508 9.10538C14.9638 8.37128 14.5771 7.76378 13.9485 7.32508C13.5027 7.01287 13.0133 6.81178 12.4663 6.78928C12.404 6.78669 12.3412 6.7833 12.2781 6.77989C11.9984 6.76477 11.7141 6.74941 11.4467 6.80334C10.6817 6.95662 10.0096 7.30678 9.5019 7.92408C9.4429 7.99488 9.3852 8.06678 9.2991 8.17408L9.2797 8.19838V7.00444ZM2.68164 15.5671H5.33242V7.01001H2.68164V15.5671Z"
                                          fill="white"/>
                                </svg>
                            </button>
                            <button data-sharer="x"
                                    data-title="<?php the_title_attribute() ?>"
                                    data-hashtags="<?php echo trim($tag_attr, ', ') ?>"
                                    data-url="<?php the_permalink(); ?>">
                                <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.1761 0.242676H16.9362L10.9061 7.02008L18 16.2427H12.4456L8.0951 10.6493L3.11723 16.2427H0.35544L6.80517 8.99348L0 0.242676H5.69545L9.6279 5.3553L14.1761 0.242676ZM13.2073 14.6181H14.7368L4.86441 1.78196H3.2232L13.2073 14.6181Z"
                                          fill="white"/>
                                </svg>
                            </button>
                            <button data-sharer="facebook"
                                    data-hashtag="<?php echo trim($tag_attr, ', ') ?>"
                                    data-url="<?php the_permalink(); ?>">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 10.3038C20 4.74719 15.5229 0.242676 10 0.242676C4.47715 0.242676 0 4.74719 0 10.3038C0 15.3255 3.65684 19.4879 8.4375 20.2427V13.2121H5.89844V10.3038H8.4375V8.0872C8.4375 5.56564 9.9305 4.1728 12.2146 4.1728C13.3088 4.1728 14.4531 4.36931 14.4531 4.36931V6.84529H13.1922C11.95 6.84529 11.5625 7.6209 11.5625 8.41658V10.3038H14.3359L13.8926 13.2121H11.5625V20.2427C16.3432 19.4879 20 15.3257 20 10.3038Z"
                                          fill="white"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <?php if (!empty($tag)): ?>
                        <div class="dmp-basic-text-section__tags">
                            <?php echo $tag; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="dmp-basic-text-section__pagination">
                    <?php
                    $prev_post      = get_adjacent_post();
                    if ($prev_post) :
                        $prev_link = get_permalink($prev_post->ID);
                        $prev_title = $prev_post->post_title; ?>
                        <a href="<?php echo esc_url($prev_link) ?>"
                           class="dmp-basic-text-section__pagination-item">
                            <div class="dmp-basic-text-section__pagination-item-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                                          fill="black"/>
                                </svg>
                            </div>
                            <div class="dmp-basic-text-section__pagination-item-text">
                                <strong>Previous</strong>
                                <p><?php echo esc_html($prev_title) ?></p>
                            </div>
                        </a>
                    <?php else :
                        $first = new WP_Query('posts_per_page=1&order=DESC');
                        if ($first->have_posts()) :
                            $first->the_post(); ?>
                            <a href="<?php the_permalink(); ?>"
                               class="dmp-basic-text-section__pagination-item">
                                <div class="dmp-basic-text-section__pagination-item-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 11H7.83L13.42 5.41L12 4L4 12L12 20L13.41 18.59L7.83 13H20V11Z"
                                              fill="black"/>
                                    </svg>
                                </div>
                                <div class="dmp-basic-text-section__pagination-item-text">
                                    <strong>Previous</strong>
                                    <p><?php echo get_the_title() ?></p>
                                </div>
                            </a>
                            <?php wp_reset_postdata();
                        endif;
                    endif;

                    $next_post      = get_adjacent_post(false, '', false);
                    if ($next_post) :
                        $next_link = get_permalink($next_post->ID);
                        $next_title = $next_post->post_title; ?>
                        <a href="<?php echo esc_url($next_link) ?>"
                           class="dmp-basic-text-section__pagination-item">
                            <div class="dmp-basic-text-section__pagination-item-text">
                                <strong>Next</strong>
                                <p><?php echo esc_html($next_title) ?></p>
                            </div>
                            <div class="dmp-basic-text-section__pagination-item-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                          d="M12 4.88892L10.59 6.29892L16.17 11.8889H4V13.8889H16.17L10.59 19.4789L12 20.8889L20 12.8889L12 4.88892Z"
                                          fill="black"/>
                                </svg>
                            </div>
                        </a>
                    <?php else :
                        $last = new WP_Query('posts_per_page=1&order=ASC');
                        if ($last->have_posts()) :
                            $last->the_post(); ?>
                            <a href="<?php the_permalink(); ?>"
                               class="dmp-basic-text-section__pagination-item">
                                <div class="dmp-basic-text-section__pagination-item-text">
                                    <strong>Next</strong>
                                    <p><?php echo get_the_title() ?></p>
                                </div>
                                <div class="dmp-basic-text-section__pagination-item-icon">
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                              d="M12 4.88892L10.59 6.29892L16.17 11.8889H4V13.8889H16.17L10.59 19.4789L12 20.8889L20 12.8889L12 4.88892Z"
                                              fill="black"/>
                                    </svg>
                                </div>
                            </a>
                            <?php wp_reset_postdata();
                        endif;
                    endif; ?>
                </div>
            <?php else :
                echo wp_kses_post($content);
            endif; ?>
        </div>
    </div>
</section>
