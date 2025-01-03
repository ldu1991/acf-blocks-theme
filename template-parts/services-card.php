<?php
$hero         = get_field('hero', get_the_ID());
$hero_content = get_field('hero_content', get_the_ID());

$thumb   = !empty($hero) && !empty($hero_content['image']) ? $hero_content['image'] : get_post_thumbnail_id(get_the_ID());
$content = !empty($hero) && !empty($hero_content['content']) ? custom_wp_trim($hero_content['content'], 20) : custom_wp_trim_excerpt(get_the_ID(), 20);
?>

<a href="<?php the_permalink(); ?>"
   class="dmp-services-card">
    <div class="dmp-services-card__image">
        <?php echo wp_get_attachment_image($thumb, 'large'); ?>
    </div>
    <div class="dmp-services-card__content">
        <?php the_title('<h5>', '</h5>'); ?>

        <p>
            <?php echo $content; ?>
        </p>

        <div class="dmp-link">
            Learn more
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.70697 16.9496L15.414 11.2426L9.70697 5.53564L8.29297 6.94964L12.586 11.2426L8.29297 15.5356L9.70697 16.9496Z" fill="black"/></svg>
            </div>
        </div>
    </div>
</a>
