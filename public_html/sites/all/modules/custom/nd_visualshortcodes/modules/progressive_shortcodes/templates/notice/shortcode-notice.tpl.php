<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <div role="alert" class="alert <?php print 'alert-'.$type ?> alert-dismissible fade in  <?php print print !empty($class_notice) ? $class_notice : ''; ?>">
        <button type="button" data-dismiss="alert" aria-label="Close" class="close">
            <span aria-hidden="true">×</span>
        </button>
        <?php if(isset($icon) && !empty($icon)): ?>
            <i class="alert-icon <?php print $icon ?>   <?php print !empty($icon_class) ? $icon_class : '' ?>"></i>
        <?php endif; ?>
        <?php if(isset($title) && !empty($title)): ?>
        <strong <?php print !empty($class_title) ? 'class="'.$class_title.'"' : '' ?> ><?php print $title ?></strong>
        <?php endif; ?>
        <br>
        <?php if(isset($message) && !empty($message)): ?>
            <?php print $message ?>
        <?php endif; ?>
    </div>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>