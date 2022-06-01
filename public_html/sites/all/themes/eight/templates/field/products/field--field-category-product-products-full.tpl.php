<?php if (!$label_hidden) : ?>
    <?php print $label ?>:
<?php endif; ?>
<?php foreach ($items as $delta => $item) : ?>
    <?php
    print render($item);
    if ($delta < (count($items) - 1)) {
        print ',';
    }
    ?>
<?php endforeach; ?>
