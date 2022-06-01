<?php $class_title = !empty($title_class) ? $title_class : '' ?>
<?php if(!empty($attributes_shortcode)): ?>
<div <?php print $attributes_shortcode ?>>
    <?php endif; ?>
    <?php if(isset($tag)): ?>
        <?php if(isset($check_underline) && $check_underline == true && $position_underline == 'before'): ?>
            <span class="divider gray mb-20 mt-25 <?php print isset($align) ? $align : '' ?>"></span>
        <?php endif; ?>
        <?php print '<'.$tag.' class="title-section '. $class_title .' " >' ?>
        <?php print $title ?>
        <?php if(isset($bold_title) && !empty($bold_title)): ?>
            <span><?php print $bold_title ?></span>
        <?php endif; ?>
        <?php print '</'.$tag.'>' ?>
        <?php if(isset($check_underline) && $check_underline == true && $position_underline == 'after'): ?>
            <span class="divider gray mb-20 mt-25 <?php print isset($align) ? $align : '' ?>"></span>
        <?php endif; ?>
        <?php if(isset($subtitle) && !empty($subtitle)): ?>
            <p class="sub-title"><?php print $subtitle ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(!empty($attributes_shortcode)): ?>
</div>
<?php endif; ?>
