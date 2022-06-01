<div class="table-responsive">
    <table <?php if ($classes) { print 'class="table shop_table cart '. $classes . '" '; } ?><?php print $attributes; ?>>
        <?php if (!empty($title) || !empty($caption)) : ?>
            <caption><?php print $caption . $title; ?></caption>
        <?php endif; ?>
        <?php if (!empty($header)) : ?>
            <thead>
            <tr>
                <?php foreach ($header as $field => $label): ?>
                    <?php if($field != 'field_image_product'): ?>
                    <?php //if($field == 'field_image_product'){$header_classes[$field].= ' text-center' ;} ?>
                        <th <?php if ($header_classes[$field]) { print 'class="'. $header_classes[$field] . '" '; } if($field == 'line_item_title'){ print 'colspan="2"';} ?>  >
                            <?php print $label; ?>
                        </th>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            </thead>
        <?php endif; ?>
        <tbody>
        <?php $i = 0; ?>

        <?php foreach ($rows as $row_count => $row): ?>
        <tr <?php if ($row_classes[$row_count]) { print 'class="cart_item ' . implode(' ', $row_classes[$row_count]) .'"';  } ?>>
            <?php foreach ($row as $field => $content): ?>

                <?php if($field == 'field_image_product'){$field_classes[$field][$row_count].= ' product-thumbnail';}  ?>
                <?php if($field == 'line_item_title') {$field_classes[$field][$row_count].= ' product-name';} ?>
                <?php if($field == 'commerce_unit_price'){ $field_classes[$field][$row_count] = ' product-price'; }?>
                <?php if($field == 'edit_quantity' ){ $field_classes[$field][$row_count].= ' product-quantity' ;} ?>
                <?php if($field == 'commerce_total' ){ $field_classes[$field][$row_count] = ' product-subtotal' ;} ?>
                <?php  if($field == 'edit_delete') { $field_classes[$field][$row_count].= ' product-remove'; } ?>
                <?php if($field_classes[$field][$row_count] == '') ?>
                <td <?php if ($field_classes[$field][$row_count]) { print 'class="'. $field_classes[$field][$row_count] . '" '; } ?><?php print drupal_attributes($field_attributes[$field][$row_count]); ?>>
                    <?php print $content; ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>