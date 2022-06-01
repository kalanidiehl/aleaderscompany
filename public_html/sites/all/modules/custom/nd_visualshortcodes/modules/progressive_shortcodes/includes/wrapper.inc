<?php

function progressive_shortcodes_wrapper_shortcode_info(&$shortcodes)
{
    $shortcodes['wrapper'] = array(
        'title' => t('Wrapper'),
        'description' => t('Wrapper HTML'),
        'process callback' => 'progressive_shortcodes_shortcode_wrapper',
        'process settings callback' => 'progressive_shortcodes_shortcode_wrapper_settings',
        'tips callback' => 'progressive_shortcodes_shortcode_wrapper_tip',
        'icon' => 'fa fa-list-alt',
        //'description_callback' => 'progressive_shortcodes_shortcode_view_description',
    );
}

function progressive_shortcodes_shortcode_wrapper($attrs, $text) {
    $attrs['class'] = (isset($attrs['class']) ? $attrs['class'] : '');

    $text = '<'.$attrs['wrap_html'].' ' . _progressive_shortcodes_shortcode_attributes($attrs) .'>' . $text . '</'.$attrs['wrap_html'].'>';
    return $text;
}

function progressive_shortcodes_shortcode_wrapper_settings($attrs,$text){
    $form['wrap_html'] = array(
        '#type' => 'select',
        '#title' => t('Choose HTML'),
        '#options' => drupal_map_assoc(array('div','section')),
        '#default_value' => isset($attrs['wrap_html']) ? $attrs['wrap_html'] : 'div',
        '#attributes' => array('class' => array('form-control'))
    );

    return $form;
}

function progressive_shortcodes_shortcode_wrapper_tip($format, $long) {
    $output = array();
    $output[] = '<p><strong>Wrapper HTML :</strong><br/>[wrapper]Content[/wrapper]</br>';
    $output[] = 'Use this for wrapper content.</p>';
    return implode(' ', $output);
}