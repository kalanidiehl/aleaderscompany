<?php if (!empty($title)): ?>
    <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
    <div class="item-top-sellers clearfix"><?php print $row; ?></div>
<?php endforeach; ?>
