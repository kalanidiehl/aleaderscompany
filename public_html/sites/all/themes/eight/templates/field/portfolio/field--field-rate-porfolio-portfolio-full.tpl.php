<div class="rate-portfolio">
    <?php if (!$label_hidden) : ?>
        <?php print $label ?>:
    <?php endif; ?>
    <div class="pull-right">
    <?php
    foreach ($items as $delta => $item) : ?>
        <?php
        print render($item);
        ?>
    <?php endforeach; ?>
    </div>
</div>