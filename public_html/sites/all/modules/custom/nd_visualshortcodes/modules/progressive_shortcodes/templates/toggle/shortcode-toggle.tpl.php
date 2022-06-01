<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <div class="toggle <?php print !empty($class_toggle) ? $class_toggle : '' ?>">
        <?php if(isset($items)): ?>
            <?php print $items ?>
        <?php endif; ?>
    </div>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>