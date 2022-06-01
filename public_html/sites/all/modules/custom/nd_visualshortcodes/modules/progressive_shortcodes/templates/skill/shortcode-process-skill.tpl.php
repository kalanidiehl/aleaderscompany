
<?php if(!empty($attributes_shortcode)): ?>
<div <?php print $attributes_shortcode ?>>
    <?php endif; ?>
    <div class="skill-bar">
        <?php if(isset($title) && !empty($title)): ?>
        <div class="name"><?php print $title ?><span class="skill-bar-perc"></span></div>
        <div class="bar"><span data-value="<?php print isset($percent) ? $percent : '0' ?>" <?php print !empty($color_skill) ? 'data-color="'.$color_skill.'"' : '' ?> class="cp-bg-color skill-bar-progress"></span></div>
        <?php endif; ?>
    </div>
    <?php if(!empty($attributes_shortcode)): ?>
</div>
<?php endif; ?>