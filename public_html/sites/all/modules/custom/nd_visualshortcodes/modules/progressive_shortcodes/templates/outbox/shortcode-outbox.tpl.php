<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
<div class="call-out-box clearfix <?php print !empty($class) ? $class : '' ?> <?php print !empty($icon) ? 'with-icon' : '' ?> ">
    <?php if(isset($icon) && !empty($icon)): ?>
    <i class="flaticon-diamond7 <?php print !empty($icon_class) ? $icon_class : '' ?>"></i>
    <?php endif; ?>
    <div class="callout-content">
        <?php if(isset($title) && !empty($title)): ?>
            <h2 <?php print !empty($class_title) ? 'class="'.$class_title.'"' : '' ?>><?php print $title ?></h2>
        <?php endif; ?>
        <?php if(isset($text_element) && !empty($text_element)): ?>
            <p><?php print $text_element ?></p>
        <?php endif; ?>
    </div>
    <?php if(isset($text_link) && !empty($text_link)): ?>
    <a href="<?php print !empty($link) ? $link : '#' ?>" class="cws-button <?php print !empty($class_link) ? $class_link : '' ?>"><?php print $text_link ?></a>
    <?php endif; ?>
</div>

<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>