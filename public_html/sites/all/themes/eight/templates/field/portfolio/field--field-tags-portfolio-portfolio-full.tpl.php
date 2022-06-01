<?php if (!$label_hidden) : ?>
    <?php print $label ?>:
<?php endif; ?>
<span>
<?php
foreach ($items as $delta => $item) : ?>
    <?php
    $item['#options']['attributes']['class'][] = 'tag';
    print render($item);
    if ($delta < (count($items) - 1)) {
        print ',';
    }
    ?>
<?php endforeach; ?>
</span>
