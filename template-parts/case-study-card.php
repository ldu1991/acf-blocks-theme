<?php
$class_case_study_card = array('dms-case-study-card');
$class_case_study_card[] = !empty($args['square']) ? 'dms-case-study-card_square' : ''; ?>
<a href="<?php the_permalink(); ?>"
   class="<?php echo esc_attr(trim(implode(' ', $class_case_study_card))); ?>">
    <div class="dms-case-study-card__image">
        <?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'large'); ?>
    </div>
    <div class="dms-case-study-card__content">
        <?php the_title('<h5>', '</h5>'); ?>
        <div class="dmp-link">
            View project
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.70697 16.9496L15.414 11.2426L9.70697 5.53564L8.29297 6.94964L12.586 11.2426L8.29297 15.5356L9.70697 16.9496Z"
                          fill="black"></path>
                </svg>
            </div>
        </div>
    </div>
</a>
