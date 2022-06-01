<?php

/**
 * @file
 * Default implementation of a line item summary template.
 *
 * Available variables:
 * - $quantity_raw: The number of items in the cart.
 * - $quantity_label: The quantity appropriate label to use for the number of
 *   items in the shopping cart; "item" or "items" by default.
 * - $quantity: A single string containing the number and label.
 * - $total_raw: The raw numeric value of the total value of items in the cart.
 * - $total_label: A text label for the total value; "Total:" by default.
 * - $total: The currency formatted total value of items in the cart.
 * - $links: A rendered links array with cart and checkout links.
 *
 * Helper variables:
 * - $view: The View the line item summary is attached to.
 *
 * @see template_preprocess()
 * @see template_process()
 */

?>
<?php if($total): ?>
<div class="row mt-60">
    <div class="col-md-6 col-md-offset-6">

        <div class="table-responsive">
            <table class="table total-table">
                <tbody>

                <tr class="order-total">
                    <th><?php print t('Order Total') ?></th>
                    <td><span class="amount"><?php print $total; ?></span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
<?php print $links; ?>
