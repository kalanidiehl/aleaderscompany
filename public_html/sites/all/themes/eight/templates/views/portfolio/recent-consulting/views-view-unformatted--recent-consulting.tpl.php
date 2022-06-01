<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
    <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="cws-multi-col owl-slide-col three-column pagiation-carousel main-color">
    <?php foreach ($rows as $id => $row): ?>
        <div<?php if ($classes_array[$id]) { print ' class="ml-15 mr-15 ' . $classes_array[$id] .'"';  } ?>>
            <?php print $row; ?>
        </div>
    <?php endforeach; ?>
</div>
