<?php if (!$label_hidden) : ?>
    <?php print $label ?>:
<?php endif; ?>
<div class="pic">
    <?php print render($items[0]); ?>
  <?php /*
  ?><div class="hover-effect"></div>
    <div class="links"><a href="<?php print file_create_url($items[0]['#item']['uri']) ?>" class="link-icon flaticon-magnifying-glass84 fancy"></a></div>
  */ ?>
</div>
<?php /*
<div class="thumbnails clearfix">
    <?php foreach($items as $key => $item): ?>
    <div class="thumbnail pic">
        <?php print render($item); ?>
        <div class="hover-effect"></div>
        <div class="links"><a href="<?php print file_create_url($item['#item']['uri']) ?>" class="link-icon flaticon-magnifying-glass84 fancy"></a></div>
    </div>
    <?php endforeach; ?>
</div>
 */ ?>