<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <?php if(!empty($text_button)): ?>
    <a href="<?php print !empty($link) ? $link : '#' ?>" class="cws-button <?php print !empty($class_button) ? $class_button : '' ?> <?php print !empty($icon) ? 'with-icon' : ''  ?> ">
        <?php print $text_button ?>
        <?php if(isset($icon) && !empty($icon)): ?>
        <i class="<?php print $icon ?>"></i>
        <?php endif; ?>
    </a>
    <?php endif; ?>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>