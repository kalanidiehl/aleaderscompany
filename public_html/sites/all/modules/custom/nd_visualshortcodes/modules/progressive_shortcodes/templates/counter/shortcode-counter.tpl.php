<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <div class="counter_number de_count counter-block <?php print !empty($class_counter) ? $class_counter : '' ?> <?php print !empty($position) ? $position : '' ?>">
        <i class="counter-icon <?php print $num_icon ?>" <?php print isset($num_color_icon) ? 'style='.$num_color_icon : '' ?>></i>
        <div class="couting counter" data-start="<?php print isset($num_start) ? $num_start : '0' ?>" data-end="<?php print isset($num_end) ? $num_end : '0'  ?>" data-speed="<?php print isset($num_speed) ? $num_speed : '1000' ?>">
            <?php if(isset($num_prefix)){ print $num_prefix; } ?>
            <span class="number"> <?php print  $num_end   ?> </span>
            <?php if(isset($num_suffix)){ print $num_suffix; } ?>
        </div>
        <?php if(isset($text_below)): ?>
            <div class="count-divider"></div>
            <div class="counter-name text-uppercase"><?php print $text_below; ?></div>
        <?php endif; ?>
    </div>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>