<?php if (!$label_hidden) : ?>
    <?php print $label ?>:
<?php endif; ?>
<div class="pic">
<?php print render($items[0]); ?>
    <div class="hover-effect"></div>
    <div class="links">
        <?php foreach($items as $delta => $item): ?>
        <a href="<?php print file_create_url($item['#item']['uri']) ?>" rel="fancy_img" class="<?php if($delta == 0){ echo 'link-icon flaticon-magnifying-glass84';}else{echo 'js-hide';} ?> fancy"></a>
       <?php endforeach; ?>
    </div>
</div>

