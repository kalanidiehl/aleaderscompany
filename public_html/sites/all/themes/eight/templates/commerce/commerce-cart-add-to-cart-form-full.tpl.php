<?php if(isset($form['attributes'])): ?>
<?php $fields = array_filter_key("/^field_(\w+)/",$form['attributes']); ?>
<?php foreach($fields as $name_field => $field){
    if($field['#type'] == 'select')
    {
        $form['attributes'][$name_field]['#prefix'] = '<div class="select-wrap">';
        $form['attributes'][$name_field]['#suffix'] = '</div>';
        $form['attributes'][$name_field]['#attributes']['class'][] = 'select';
    }
} ?>
<div class="product_attributes">
    <div class="select-type mb-10">
        <?php print render($form['attributes']); ?>
    </div>
</div>
<?php endif; ?>
<div class="add-cart-form">
    <?php if(isset($form['quantity'])): ?>
        <?php $form['quantity']['#attributes']['class'][] = 'qty' ?>
        <?php $form['quantity']['#theme_wrappers'] = array('form_element_none')?>
        <?php  print render($form['quantity']) ?>
    <?php endif ?>
    <button class="cws-button with-icon"><?php print $form['submit']['#value'] ?><i class="flaticon-shopping-carts6"></i></button>
</div>
<div class="js-hide"><?php print drupal_render_children($form) ?></div>

