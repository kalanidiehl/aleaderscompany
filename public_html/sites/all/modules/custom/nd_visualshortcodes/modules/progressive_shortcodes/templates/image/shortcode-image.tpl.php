
<?php if(!empty($attributes_shortcode)): ?>
<div <?php print $attributes_shortcode ?>>
    <?php endif; ?>
    <?php if(isset($fancy) && $fancy == true){ ?>
            <div class="pic">
                <img <?php print !empty($class_image) ? 'class="'.$class_image.'"' : '' ?> src="<?php print $path ?>" alt="<?php print $alt ?>" title="<?php print $title ?>"/>
                <div class="hover-effect alt"></div>
                <div class="links">
                    <a href="<?php print $path ?>" rel="fancy_image_shortcode" class="link-icon alt flaticon-magnifying-glass84 fancy"></a>
                </div>
            </div>
    <?php } else{ ?>
    <img <?php print !empty($class_image) ? 'class="'.$class_image.'"' : '' ?> src="<?php print $path ?>" alt="<?php print $alt ?>" title="<?php print $title ?>"/>
    <?php } ?>

    <?php if(!empty($attributes_shortcode)): ?>
</div>
<?php endif; ?>
