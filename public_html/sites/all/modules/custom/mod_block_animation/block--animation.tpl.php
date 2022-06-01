<?php if(isset($prefix_block)): print $prefix_block; endif; ?>
    <div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

        <?php if(isset($title_raw_check) && isset($title_raw) && $title_raw_check == 1){ ?>
            <?php print check_markup($title_raw['value'],$title_raw['markup'])?>
        <?php } else{ ?>
            <?php print render($title_prefix); ?>
            <?php if ($block->subject): ?>
                <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
            <?php endif;?>
            <?php print render($title_suffix); ?>
        <?php } ?>
        <div class="content"<?php print $content_attributes; ?>>
            <?php print $content ?>
        </div>
    </div>
<?php if(isset($suffix_block)): print $suffix_block; endif; ?>