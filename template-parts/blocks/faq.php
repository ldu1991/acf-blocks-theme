<?php
$title                   = get_sub_field('title');
$introduction            = get_sub_field('introduction');
$columns                 = get_sub_field('columns');
$faqs                    = get_sub_field('faqs');
$additional_text         = get_sub_field('additional_text');
$additional_text_content = get_sub_field('additional_text_content');

$class_faq   = array('dmp-faq');
$class_faq[] = 'dmp-faq_' . $columns;

$faqs_args = array(
    'post_type'      => 'faq',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'post__in',
    'post__in'       => $faqs
);

$faqs_query = new WP_Query($faqs_args); ?>
<section class="<?php echo esc_attr(trim(implode(' ', $class_faq))); ?>">
    <div class="dmp-faq__container">
        <?php if (!empty($title) || !empty($introduction)): ?>
            <div class="dmp-faq__head">
                <?php if (!empty($title)): ?>
                    <div class="h2">
                        <?php echo esc_html($title); ?>
                    </div>
                <?php endif;
                if (!empty($introduction)) : ?>
                    <div class="dmp-faq__head-introduction">
                        <?php echo wp_kses_post($introduction); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($faqs_query->have_posts()) :
            $count_faqs = round(count($faqs) / 2);
            $i = 1; ?>
            <div class="dmp-faq__accordion">
                <?php if ($columns === 'col-2') {
                    echo '<div class="dmp-faq__accordion-col">';
                }

                while ($faqs_query->have_posts()) : $faqs_query->the_post(); ?>
                    <div class="dmp-faq__accordion-item">
                        <?php the_title('<div class="dmp-faq__accordion-item-head">', '<div class="icon"></div></div>'); ?>
                        <div class="dmp-faq__accordion-item-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php if ($columns === 'col-2' && $i === (int)$count_faqs) {
                        echo '</div><div class="dmp-faq__accordion-col">';
                    }
                    $i++;
                endwhile;

                if ($columns === 'col-2') {
                    echo '</div>';
                }
                wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($additional_text)): ?>
            <div class="dmp-faq__additional">
                <?php if (!empty($additional_text_content['title'])): ?>
                    <div class="h4">
                        <?php echo esc_html($additional_text_content['title']); ?>
                    </div>
                <?php endif;
                if (!empty($additional_text_content['text'])): ?>
                    <div class="dmp-faq__additional-text">
                        <?php echo wp_kses_post($additional_text_content['text']); ?>
                    </div>
                <?php endif;
                the_btn(
                    $additional_text_content['button'],
                    array('dmp-btn_primary', 'dmp-btn-border')
                ); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
