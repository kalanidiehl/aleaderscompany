
<?php if(!empty($attributes_shortcode)): ?>
<div <?php print $attributes_shortcode ?>>
  <?php endif; ?>
  <div class="accordion <?php print $accordion_style ?>">
    <?php print $text_element ?>
  </div>
  <?php if(!empty($attributes_shortcode)): ?>
</div>
<?php endif; ?>