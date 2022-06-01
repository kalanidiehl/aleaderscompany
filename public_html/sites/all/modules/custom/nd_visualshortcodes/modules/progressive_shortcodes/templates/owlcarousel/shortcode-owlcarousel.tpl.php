<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <?php /** Class 'jvCarousel' this call in javascript to working owlcarousel */ ?>
    <div class="jvCarousel <?php print !empty($class_owlcarousel) ? $class_owlcarousel : '' ?>" id="<?php print $id ?>" <?php print !empty($option_carousel) ? $option_carousel : '' ?>>
        <?php print $text_element ?>
    </div>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>