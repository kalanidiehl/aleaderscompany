<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
<div class="full-width-box">
    <div class="fwb-bg <?php print isset($background) ? 'fwb-'.$background  : '' ?>" <?php print $inner_attributes ?>></div>
    <?php print !empty($overlay) ? $overlay : '' ?>
    <?php print $text_element  ?>
</div>
    <?php if(!empty($attributes_shortcode)): ?>
    </div>

<?php endif; ?>