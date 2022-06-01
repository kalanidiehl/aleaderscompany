<div class="content-title">
    <span <?php print ($active_expand == true) ? 'class="active"' : '' ?>><i class="<?php print !empty($icon_expand) ? $icon_expand : '' ?> accordion-icon"></i> <?php print $title_accordion ?></span>
</div>
<div class="content">
    <?php print $text_element ?>
</div>