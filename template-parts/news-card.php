<?php
$categories = get_the_category();
if ($categories) {
    $cat = '';
    foreach ($categories as $category) {
        $cat .= $category->name . ', ';
    }
}
?>
<a href="<?php the_permalink(); ?>"
   class="dmp-news-card">
    <div class="dmp-news-card__image">
        <?php echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'large');
        if (!empty($cat) && (empty($args['simple']) || $args['simple'] !== 'yes')): ?>
            <div class="dmp-btn dmp-btn_tag dmp-btn_tag_white">
                <?php echo trim($cat, ', '); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="dmp-news-card__content">
        <?php if (empty($args['simple']) || $args['simple'] !== 'yes') : ?>
            <time datetime="<?php the_time('Y-M-d') ?>">
                <?php the_time('d M Y') ?>
            </time>
        <?php endif;
        the_title('<h5>', '</h5>'); ?>
        <div class="dmp-link">
            Read more
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.70697 16.9496L15.414 11.2426L9.70697 5.53564L8.29297 6.94964L12.586 11.2426L8.29297 15.5356L9.70697 16.9496Z"
                          fill="black"/>
                </svg>
            </div>
        </div>
    </div>
</a>
