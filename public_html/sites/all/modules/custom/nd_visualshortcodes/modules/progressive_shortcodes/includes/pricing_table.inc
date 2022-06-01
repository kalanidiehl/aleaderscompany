<?php

function progressive_shortcodes_pricing_table_shortcode_info(&$shortcodes)
{
    $shortcodes['pricing_table'] = array(
        'title' => t('Pricing Table'),
        'description' => t('Responsive Pricing Table.'),
        'process callback' => 'progressive_shortcodes_shortcode_pricing_table',
        'process settings callback' => 'progressive_shortcodes_shortcode_pricing_table_settings',
        'child shortcode'=> 'pricing_table_row',
        'icon' => 'fa fa-usd',
        'description_field' => 'title',
    );
}

function progressive_shortcodes_shortcode_pricing_table($attrs, $text) {

    $output = '';
    $rows    = array();
    $icon_rows = array();
    $actives = array();
    $values = array();
    foreach($attrs as $name => $value) {
        if(strpos($name, 'row_value_') === 0) {
            $rows[] = $value;
        }
        if(strpos($name, 'row_active_') === 0) {
            $actives[] = $value;
        }
        if(strpos($name, 'row_icon_') === 0){
            $icon_rows[] = $value;
        }
    }
    foreach($rows as $id => $row){
        $values[] = array(
            'title_row' => $row,
            'active_row' => $actives[$id],
            'icon_row'   => $icon_rows[$id],
        );
    }

    $variables = array(
        'title' => isset($attrs['title']) ? $attrs['title'] : '',
        'color_table' => isset($attrs['color']) ? '#'.$attrs['color'] : '',
        'table_class' => isset($attrs['table_class']) ?  $attrs['table_class'] : '',
        'featured'    => isset($attrs['featured']) && ($attrs['featured'] == 1) ? true : false,
        'description' => isset($attrs['description']) ? $attrs['description'] : '',
        'currency_label' => isset($attrs['currency_label']) ? $attrs['currency_label'] : '',
        'price'       => isset($attrs['price']) ? $attrs['price'] : '',
        'date_price'  => isset($attrs['price_text']) ? $attrs['price_text'] : '',
        'price_icon'  => isset($attrs['price_icon']) ? $attrs['price_icon'] : '',
        'read_more_text'   => isset($attrs['read_more']) ? $attrs['read_more'] : '',
        'read_more_color'  => isset($attrs['read_more_color']) ? '#'.$attrs['read_more_color'] : '',
        'read_more_class'  => isset($attrs['read_more_class']) ? $attrs['read_more_class'] : '',
        'read_more_link'   => isset($attrs['read_more_link']) ? $attrs['read_more_link'] : '',
        'rows'             => isset($values) && is_array($values) ? $values : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
     );
    return theme('shortcode_table_price',$variables);

}

function progressive_shortcodes_shortcode_pricing_table_settings($attrs, $text,$form, &$form_state) {
    if(isset($form_state['values'])) {
        $attrs = $form_state['values'];
    }

    $attrs['count_items'] = 0;
    foreach($attrs as $name => $value) {
        if(strpos($name, 'row_value_') === 0) {
            $attrs['count_items']++;
        }
    }
    // Add new item
    if(isset($form_state['values'])) {
        if (isset($form_state['values']['op']) && $form_state['values']['op'] == t('Add new item')) {
            $attrs['count_items']++;
        }
    }
    $attrs['row_value_1'] = isset($attrs['row_value_1']) ? $attrs['row_value_1'] : '';
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-3">',
    );
    $form['color'] = array(
        '#type' => 'textfield',
        '#title' => 'Color Table',
        '#default_value' => isset($attrs['color']) ? $attrs['color'] : '',
        '#attributes'    => array('class' => array('form-control colorpicker-enable')),
        '#prefix'        => '</div><div class="col-sm-3">'
    );
    $form['table_class'] = array(
        '#type' => 'textfield',
        '#title' => 'Class Table',
        '#default_value' => isset($attrs['table_class']) ? $attrs['table_class'] : '',
        '#attributes'    => array('class' => array('form-control')),
        '#prefix'        => '</div><div class="col-sm-3">'
    );
    $form['featured'] = array(
        '#type' => 'checkbox',
        '#title' => t('Feature'),
        '#default_value' => isset($attrs['featured']) ? $attrs['featured'] : false,
        '#prefix' => '</div><div class = "col-sm-3">',
        '#suffix' => '</div></div>',
    );
    $form['description'] = array(
        '#type' => 'textarea',
        '#rows' => 3,
        '#title' => t('Short Description'),
        '#default_value' => isset($attrs['description']) ? $attrs['description'] : '',
        '#attributes' => array('class' => array('form-control'))
    );
    $ajax = array(
        'callback' => 'progressive_shortcodes_shortcode_table_ajax_callback',
        'wrapper' => 'nd_visualshortcodes_table_rows',
        'effect' => 'fade',
        'method' => 'replace',
    );
    $form['items'] = array(
        '#type' => 'container',
        '#attributes' => array('id' => array('nd_visualshortcodes_table_rows')),
        '#theme' => 'progressive_shortcodes_shortcode_pricing_settings',
        '#attrs' => $attrs
    );

    foreach($attrs as $name => $value) {
        if(strpos($name,'row_value_') === 0) {
            $i = str_replace('row_value_','', $name);
            $form['items'] += progressive_shortcodes_shortcode_table_row($attrs, $i);
        }
    }

    // Add new row
    if(isset($form_state['values'])) {
        if (isset($form_state['values']['op']) && $form_state['values']['op'] == t('Add new row')) {

            $form['items'] += progressive_shortcodes_shortcode_table_row($attrs, ++$i);
        }
    }
    $form['add_new'] = array(
        '#type' => 'submit',
        '#value' => t('Add new row'),
        '#submit' => array('_shortcodes_pricing_table_ajax_rebuild'),
        '#ajax' => $ajax
    );
    $form['currency_label'] = array(
        '#type' => 'textfield',
        '#title' => t('Currency'),
        '#default_value' => isset($attrs['currency_label']) ? $attrs['currency_label'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-4">'
    );
    $form['price'] = array(
        '#type' => 'textfield',
        '#title' => t('Price'),
        '#default_value' => isset($attrs['price']) ? $attrs['price'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class = "col-sm-4">',
    );
    $form['price_text'] = array(
        '#type' => 'textfield',
        '#title' => t('Date'),
        '#default_value' => isset($attrs['price_text']) ? $attrs['price_text'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class = "col-sm-4">',
        '#suffix' => '</div></div>',
    );
    $form['price_icon'] = array(
        '#type' => 'textfield',
        '#title' => t('Icon Price'),
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['price_icon']) ? $attrs['price_icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-12">',
        '#suffix' => '</div></div>',
    );

    $form['read_more'] = array(
        '#type' => 'textfield',
        '#title' => t('Read More text'),
        '#default_value' => isset($attrs['read_more']) ? $attrs['read_more'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-3">',
    );
    $form['read_more_color'] = array(
        '#type' => 'textfield',
        '#title' => 'Color Link',
        '#default_value' => isset($attrs['read_more_color']) ? $attrs['read_more_color'] : '',
        '#attributes'    => array('class' => array('form-control colorpicker-enable')),
        '#prefix' => '</div><div class = "col-sm-3">',
    );
    $form['read_more_class'] = array(
        '#type' => 'textfield',
        '#title' => 'Class Readmore',
        '#default_value' => isset($attrs['read_more_class']) ? $attrs['read_more_class'] : '',
        '#attributes'    => array('class' => array('form-control')),
        '#prefix' => '</div><div class = "col-sm-3">',
    );
    $form['read_more_link'] = array(
        '#type' => 'textfield',
        '#title' => t('Read More link'),
        '#default_value' => isset($attrs['read_more_link']) ? $attrs['read_more_link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class = "col-sm-3">',
        '#suffix' => '</div></div>',
    );
    return $form;
}

function progressive_shortcodes_shortcode_table_ajax_callback($form,&$form_state)
{
    return $form['shortcode']['settings']['items'];
}

function progressive_shortcodes_shortcode_table_row($attrs,$i){
    $form['row_value_'.$i] = array(
        '#type' => 'textfield',
        '#title' => 'Title row',
        '#default_value' => isset($attrs['row_value_'.$i]) ? $attrs['row_value_'.$i] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-4">',
    );
    $form['row_icon_'.$i]  = array(
        '#type' => 'textfield',
        '#title' => 'Icon Row',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['row_icon_'.$i]) ? $attrs['row_icon_'.$i] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',
    );
    $form['row_active_'.$i] = array(
        '#type' => 'checkbox',
        '#title' => t('Active'),
        '#default_value' => isset($attrs['row_active_'.$i]) ? $attrs['row_active_'.$i] : '',
        '#prefix' => '</div><div class="col-sm-4">',
        '#suffix' => '</div></div>'
    );
    return $form;
}
function _shortcodes_pricing_table_ajax_rebuild($form, &$form_state) {
    $form_state['rebuild'] = TRUE;
}

function theme_progressive_shortcodes_shortcode_pricing_settings($form){
    $output = '';
    $rows = array();
    $output .= render($form['form']['settings']);
    $header = array(t('Row'), t('Active'));

    foreach (element_children($form['form']) as $key) {
        if(strpos($key,'row_value_') === 0) {
            $i = str_replace('row_value_', '', $key);
            $row = array(
                render($form['form']['row_value_' . $i]),
                render($form['form']['row_icon_'. $i ]),
                render($form['form']['row_active_' . $i]),
            );
            $rows[] = $row;
        }
    }
    $output .= theme('table', array('rows' => $rows, 'header' => $header));
    return $output;
}