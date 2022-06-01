<?php
/** Order Line Item Cart */
global $user;
$quantity = 0;
//if(module_enable(array('commerce_cart'))) {
    $order = commerce_cart_order_load($user->uid);
    if ($order) :
        $wrapper                    = entity_metadata_wrapper('commerce_order', $order);
        $line_items                 = $wrapper->commerce_line_items;
        $quantity                   = commerce_line_items_quantity($line_items, commerce_product_line_item_types());
        $total                      = commerce_line_items_total($line_items);
        $currency                   = commerce_currency_load($total['currency_code']);
        $quantity_cart = isset($quantity) ? $quantity : '';
        $total_cart       = isset($total) ? commerce_currency_format($total['amount'],$total['currency_code']) : '';

    endif;
//}

?>
<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php print render($title_prefix); ?>
    <?php if ($block->subject): ?>
        <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
    <?php endif;?>
    <?php print render($title_suffix); ?>

    <div class="content"<?php print $content_attributes; ?>>
        <div class="menu-shop-card"><div class="main_menu_link_wrapper mn-has-sub"> <a href="/cart" class="mn-has-sub"><i class="flaticon-shopping-carts6 button_open"><span><?php print (isset($quantity_cart) && $quantity_cart > 0 ) ? $quantity_cart : '0' ?></span></i></a></div>
            <ul class="mn-sub right">
                <li>
                    <aside class="widget-top-sellers shop-cart-menu">

                        <?php if (isset($quantity_cart) && $quantity_cart > 0 ) { ?>
                        <p> <?php print t('You have') ?>
                            <span class="tx-color-2"><?php print $quantity_cart ?><?php print t(' item(s)') ?></span> <?php print t('in your shopping cart') ?>
                        </p>
                        <?php } ?>
                        <?php print $content ?>
                        <?php if(isset($total_cart)): ?>
                            <hr class="mt-10 mb-10">
                            <div class="sub-total clearfix"><?php print t('Total:') ?> <span><?php print isset($total_cart) ? $total_cart : ''; ?></span></div>
                            <hr class="mt-10 mb-10">
                            <div class="row">
                                <div class="col-xs-6"><a href="<?php print base_path().'cart' ?>" class="cws-button full-width"><?php print t('View Cart') ?></a></div>
                                <div class="col-xs-6"><a href="<?php print base_path().'checkout' ?>" class="cws-button full-width"><?php print t('Checkout') ?></a></div>
                            </div>
                        <?php endif; ?>
                    </aside>
                </li>
            </ul>
        </div>
    </div>
</div>