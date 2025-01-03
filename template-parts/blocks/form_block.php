<?php
$title        = get_sub_field('title');
$introduction = get_sub_field('introduction');
$gravity_form = get_sub_field('gravity_form');


?>
<section class="dmp-form-block">
    <div class="dmp-form-block__container">
        <?php echo do_shortcode('[gravityform id="' . $gravity_form . '" title="false" description="false" ajax="true"]'); ?>
    </div>
</section>
