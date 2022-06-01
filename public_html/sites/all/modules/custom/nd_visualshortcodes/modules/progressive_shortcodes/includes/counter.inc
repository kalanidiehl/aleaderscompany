<?php



function progressive_shortcodes_counter_shortcode_info(&$shortcodes)
{
    $shortcodes['counter'] = array(
        'title' => t('Counter'),
        'description' => t('Counter Number'),
        'process callback' => 'progressive_shortcodes_shortcode_counter',
        'process settings callback' => 'progressive_shortcodes_shortcode_counter_settings',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'icon' => 'fa fa-sort-numeric-asc'
    );
}

function progressive_shortcodes_shortcode_counter($attr,$text)
{
    //$attr['class']  = isset($attr['class']) ? ' ' . $attr['class'] : '';
    //$attr['class'] .= ' counter_number de_count counter-block border-none white-t';
    $variables = array(
        'position'       => isset($attr['text_position']) ? strtolower($attr['text_position']) : '',
        'class_counter'  => isset($attr['class_counter']) ? $attr['class_counter'] : '',
        'num_color_icon' => isset($attr['num_color_icon']) ? 'color:#'.$attr['num_color_icon'].'' : '',
        'num_prefix'     => isset($attr['num_prefix']) ? $attr['num_prefix'] : '',
        'num_suffix'     => isset($attr['num_suffix']) ? $attr['num_suffix'] : '',
        'num_icon_size'  => isset($attr['num_icon_size']) ? 'style=="font-size:'.$attr['num_icon_size'].'px"' :'',
        'num_icon'       => isset($attr['num_icon']) ? $attr['num_icon'] : '',
        'num_start'      => isset($attr['num_start']) ? $attr['num_start'] : '',
        'num_end'        => isset($attr['num_end']) ? $attr['num_end'] : '',
        'num_speed'      => isset($attr['num_speed']) ? $attr['num_speed'] : '',
        'text_below'     => isset($attr['text_below']) ? $attr['text_below']: '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attr),

    );
    return theme('shortcode_counter',$variables);
}



function progressive_shortcodes_shortcode_counter_settings($attr,$text)
{
    $form['text_position'] = array(
        '#title' => t('Postion'),
        '#type'  => 'select',
        '#options' => drupal_map_assoc(array('None','Left','Center','Right')),
        '#default_value' => isset($attr['text_position']) ? $attr['text_position'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-md-6">',
    );
    $form['class_counter'] = array(
        '#title' => t('Class counter'),
        '#type'  => 'textfield',
        '#default_value' => isset($attr['class_counter']) ? $attr['class_counter'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-md-6">',
        '#suffix' => '</div></div>'
    );
    $form['num_start'] = array(
        '#title' => t('Number Begin'),
        '#type'  => 'textfield',
        '#default_value' => isset($attr['num_start']) ? $attr['num_start'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-md-6">',
    );
    $form['num_end'] = array(
        '#title' => t('Number End'),
        '#type'  => 'textfield',
        '#default_value' => isset($attr['num_end']) ? $attr['num_end'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-md-6">',
        '#suffix' => '</div></div>'
    );
    $form['num_prefix'] = array(
        '#title' => t('Prefix'),
        '#type'  => 'textfield',
        '#description' => t('Input symbol or text for prefix'),
        '#default_value' => isset($attr['num_prefix']) ? $attr['num_prefix'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-md-6">',
    );
    $form['num_suffix'] = array(
        '#title' => t('Suffix'),
        '#type'  => 'textfield',
        '#description' => t('Input symbol or text for suffix'),
        '#default_value' => isset($attr['num_suffix']) ? $attr['num_suffix'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-md-6">',
        '#suffix' => '</div></div>'
    );
    $form['num_icon'] = array(
        '#title' => t('Icon'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attr['num_icon']) ? $attr['num_icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-md-4">'
    );
    $form['num_color_icon'] = array(
        '#title' => t('Color'),
        '#type'  => 'textfield',
        '#default_value' => isset($attr['num_color_icon']) ? $attr['num_color_icon'] : '',
        '#attributes' => array('class' => array('colorpicker-enable form-control')),
        '#prefix' => '</div><div class="col-md-4">',

    );
    $form['num_icon_size'] = array(
        '#title' => t('Size'),
        '#type'  => 'textfield',
        '#default_value' => isset($attr['num_icon_size']) ? $attr['num_icon_size'] : '',
        '#description' => t('Input number size,ex: "16px" you need input number "16"'),
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-md-4">',
        '#suffix' => '</div></div>'
    );

    $form['text_below'] = array(
        '#title'  => t('Input Text Below'),
        '#type'   => 'textfield',
        '#default_value' => isset($attr['text_below']) ? $attr['text_below'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-md-6">',
    );
    $form['num_speed'] = array(
        '#title' => t('Speed'),
        '#type'  => 'textfield',
        '#description' => 'Unit 1000 = 1s (seconds)',
        '#default_value' => isset($attr['num_speed']) ? $attr['num_speed'] : '',
        '#attributes'  => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-md-6"> ',
        '#suffix' => '</div></div>'
    );
    return $form;
}