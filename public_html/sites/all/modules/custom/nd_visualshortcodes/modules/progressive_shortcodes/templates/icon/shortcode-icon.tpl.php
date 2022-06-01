<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <?php if(!empty($icon)): ?>
        <i class="<?php print $icon ?> <?php print !empty($icon_class) ? $icon_class : '' ?>" <?php print !empty($icon_color) ? 'style="color:'.$icon_color.'"' : '' ?>></i>
    <?php endif; ?>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>