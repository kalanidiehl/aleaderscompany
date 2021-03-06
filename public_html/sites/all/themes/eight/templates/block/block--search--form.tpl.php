<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php if(isset($prefix_block)): print $prefix_block; endif; ?>
    <?php if(isset($title_raw_check) && isset($title_raw) && $title_raw_check == 1){ ?>
        <?php print check_markup($title_raw['value'],$title_raw['markup'])?>
    <?php } else{ ?>
        <?php print render($title_prefix); ?>
        <?php if ($block->subject): ?>
            <h3 <?php print $title_attributes; ?>><?php print $block->subject ?></h3>
        <?php endif;?>
        <?php print render($title_suffix); ?>
    <?php } ?>

    <div class="content"<?php print $content_attributes; ?>>
        <div class="search-header search">
            <div class="main_menu_link_wrapper mn-has-sub"><a href="#" class="mn-has-sub">
                <i class="flaticon-magnifying-glass34 search-icon"></i>
            </a></div>
            <ul class="search-sub">
                <li>
                    <div class="container">
                        <div class="mn-wrap">
                            <?php print $content ?>
                        </div>
                        <div class="close-button flaticon-cancel30"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php if(isset($suffix_block)): print $suffix_block; endif; ?>
</div>

