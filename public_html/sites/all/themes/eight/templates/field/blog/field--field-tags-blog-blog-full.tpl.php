<?php if (!$label_hidden) : ?>
    <span class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</span>
<?php endif; ?>
<?php 
foreach ($items as $delta => $item) : ?>
    <?php
        print render($item);
        if ($delta < (count($items) - 1)) {
            print ',';
        }
    ?>
<?php endforeach; ?>
