<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <div class="service-item clearfix <?php print !empty($position) ? 'icon-'.$position : '' ?>">
        <?php if(!empty($icon)): ?>
        <i <?php print !empty($color_icon) ? 'style="color:'.$color_icon.'"' : '' ?> class="cws-icon <?php print $icon ?> <?php print !empty($icon_class) ? $icon_class : '' ?>"></i>
        <?php endif; ?>
        <?php if(!empty($title)): ?>
        <<?php print $tag_title ?> <?php print !empty($title_class) ? 'class="'.$title_class.'"' : '' ?> ><?php print $title ?></<?php print $tag_title ?>>
        <?php endif; ?>
        <?php print !empty($text_element) ? $text_element : '' ?>
    </div>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>