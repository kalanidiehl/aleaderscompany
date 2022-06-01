<div id="<?php print $block_html_id; ?>" class="lang-wrap <?php print $classes; ?>"<?php print $attributes; ?>>
    <?php if(isset($prefix_block)): print $prefix_block; endif; ?>

        <?php print render($title_prefix); ?>
        <?php if ($block->subject): ?>
            <i class="icon-lang flaticon-earth-globe21"></i>
            <?php print $block->subject ?>
        <?php endif;?>
        <?php print render($title_suffix); ?>
    <div class="content"<?php print $content_attributes; ?>>
        <?php print $content ?>
    </div>
    <?php if(isset($suffix_block)): print $suffix_block; endif; ?>
</div>