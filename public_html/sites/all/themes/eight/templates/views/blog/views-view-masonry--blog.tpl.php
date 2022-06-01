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
<div class="row blog-columns">
    <?php $x = 1; ?>
    <?php foreach ($rows as $id => $row): ?>
        <div class="masonry-item blog-item <?php if ($classes_array[$id]) print ' ' . $classes_array[$id]; ?>">
            <?php print $row; ?>
        </div>
    <?php endforeach; ?>
    <?php if(isset($grouping) && $grouping): ?>
        <?php print $suffix ?>
    <?php endif;?>
</div>
