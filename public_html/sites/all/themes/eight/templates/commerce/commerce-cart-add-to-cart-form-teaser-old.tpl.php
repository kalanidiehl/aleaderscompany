
<?php if(isset($form['quantity'])): ?>
    <?php print render($form['quantity']) ?>
<?php endif; ?>
<?php print render($form['submit']) ?>
<div class="js-hide"><?php print drupal_render_children($form); ?></div>