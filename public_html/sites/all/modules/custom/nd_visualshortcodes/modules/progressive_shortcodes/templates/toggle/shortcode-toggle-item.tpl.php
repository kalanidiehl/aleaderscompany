<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <?php if(isset($title) && !empty($title)): ?>
    <div class="content-title <?php print !empty($class) ? $class : '' ?>">
        <i class="flaticon-arrow487 toggle-icon"></i>
        <span>
            <?php if(isset($icon) && !empty($icon)): ?>
                <i class="<?php print $icon ?> <?php print !empty($icon_class) ? $icon_class : '' ?>"></i>
            <?php endif; ?>
            <?php print $title; ?>
        </span>
    </div>
    <?php endif; ?>
    <?php if(isset($text_element) && !empty($text_element)): ?>
        <div class="content"><?php print $text_element ?></div>
    <?php endif; ?>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>