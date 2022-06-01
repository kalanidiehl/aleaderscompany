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
<?php $x = 1; ?>
<?php foreach ($rows as $id => $row): ?>
    <div<?php if ($classes_array[$id]) { print ' class="blog-item ' . $classes_array[$id] .'"';  } ?>>
        <?php print $row; ?>
    </div>
    <?php if($x < count($rows)){ ?>
        <hr class="style-2"/>
    <?php } $x++; ?>
<?php endforeach; ?>