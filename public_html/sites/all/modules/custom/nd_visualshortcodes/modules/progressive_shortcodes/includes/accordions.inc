<?php



function progressive_shortcodes_preprocess_accordions_shortcode(&$variables)
{
  global $accordion_id, $accordion_filter;
  $variables['accordion_filter'] = $accordion_filter;
  $variables['accordion_id']     = $accordion_id;
  $accordion_id++;
  $accordion_filter = array();
}

function progressive_shortcodes_accordions_shortcode_info(&$shortcodes)
{
    $shortcodes['accordions'] = array(
        'title' => t('Accordion container'),
        'description' => t('Animated Accordions wrapper.'),
        'process callback' => 'progressive_shortcodes_shortcode_accordions',
        'process settings callback' => 'progressive_shortcodes_shortcode_accordions_settings',
        'tips callback' => 'progressive_shortcodes_shortcode_accordions_tip',
        'child shortcode' => 'accordion',
        'icon' => 'fa fa-bars'
    );
    $shortcodes['accordion'] = array(
        'title' => t('Accordion item'),
        'description' => t('Accordion item.'),
        'process callback' => 'progressive_shortcodes_shortcode_accordion',
        'process settings callback' => 'progressive_shortcodes_shortcode_accordion_settings',
        'icon' => 'fa fa-minus',
        'description_field' => 'title',
    );
}

function progressive_shortcodes_shortcode_accordions($attrs, $text) {

    $variables = array(
        'accordion_style' => isset($attrs['accordion_style']) ? $attrs['accordion_style'] : '',
        'text_element'  => isset($text) ? $text : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );

    return theme('shortcode_accordions',$variables);
}

function progressive_shortcodes_shortcode_accordions_settings($attrs, $text) {
  
    $form['accordion_style'] = array(
        '#type' => 'select',
        '#options' => array('style-1' => 'Style 1','style-2' => 'Style 2','style-3' => 'Style 3', 'style-4' => 'Style 4'),
        '#default_value' => $attrs['accordion_style'],
        '#attributes' => array('class' => array('form-control'))
    );
    return $form;
}

function progressive_shortcodes_shortcode_accordion($attrs, $text) {


    //$attrs['class'] .= isset($attrs['active']) && $attrs['active'] ? ' active' : '';
    $variables = array(
        'active_expand' => ($attrs['active'] == 1) ? true : false,
        'title_accordion' => isset($attrs['title']) ? $attrs['title'] : '',
        'icon_expand'  => isset($attrs['icon_expand']) ? $attrs['icon_expand'] : '',
        'text_element' => $text,
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );
    return theme('shortcode_accordion_item',$variables);
}

function progressive_shortcodes_shortcode_accordion_settings($attrs, $text) {
    $form['active'] = array(
        '#title' => t('Active'),
        '#type' => 'checkbox',
        '#default_value' => isset($attrs['active']) ? $attrs['active'] : '',
    );
    $form['title'] = array(
        '#type' => 'textfield' ,
        '#title' => t('Title'),
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-md-6">'
    );
    $form['icon_expand'] = array(
        '#title' => t('Icon'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attr['num_icon']) ? $attr['num_icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-md-6">',
        '#suffix' => '</div>'
    );

    return $form;
}


function progressive_shortcodes_shortcode_accordions_tip($format, $long) {
    $output = array();
    $output[] = '<p><strong>Accordion:</strong><br/>[accordions]<br/>&nbsp;&nbsp;[accordion title = "Accordion Panel #1" active]Text[/accordion]<br/>[/accordions]';
    return implode(' ', $output);
}

