<?php if (!$label_hidden) : ?>
    <?php print $label ?>:
<?php endif; ?>
<span>
<?php
foreach ($items as $delta => $item) : ?>
    <?php
    print render($item);
    ?>
<?php endforeach; ?>
</span>
