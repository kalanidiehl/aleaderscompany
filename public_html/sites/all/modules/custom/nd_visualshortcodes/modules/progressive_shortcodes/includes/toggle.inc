<?php

function progressive_shortcodes_toggle_shortcode_info(&$shortcodes){
    $shortcodes['toggle'] = array(
        'title' => t('Toggle container'),
        'description' => t('Toggle Container.'),
        'process callback' => 'progressive_shortcodes_shortcode_toggle',
        'process settings callback' => 'progressive_shortcodes_shortcode_toggle_settings',
        'tips callback' => 'progressive_shortcodes_shortcode_toggle_tip',
        'child shortcode' => 'toggle_item',
        'icon' => 'fa fa-caret-square-o-dow'
    );

    $shortcodes['toggle_item'] = array(
        'title' => t('Toggle item'),
        'description' => t('Toggle item'),
        'process callback' => 'progressive_shortcodes_shorcode_toggle_item',
        'process settings callback' => 'progressive_shortcodes_shortcode_toggle_item_settings',
        'icon' => 'fa fa-outdent',
    );
}

function progressive_shortcodes_shortcode_toggle($attrs,$text){
    $variables = array(
        'class_toggle' => isset($attrs['class_toggle']) ? $attrs['class_toggle'] : '',
        'items' => isset($text) ? $text : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );
    return theme('shortcode_toggle',$variables);
}

function progressive_shortcodes_shortcode_toggle_settings($attr,$tex){
    $form['class_toggle'] = array(
        '#type' => 'textfield',
        '#title' => 'Class Toggle',
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attr['class_toggle']) ? $attr['class_toggle'] : '',
        '#prefix' => '<div class="row"><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    return $form;
}

function progressive_shortcodes_shorcode_toggle_item($attrs,$text){

    $variables = array(
        'title' => isset($attrs['title_toggle']) ? $attrs['title_toggle'] : '',
        'class' => isset($attrs['class_toggle']) ? $attrs['class_toggle'] : '',
        'icon'  => isset($attrs['icon'])  ? $attrs['icon'] : '',
        'icon_class' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        'text_element' => isset($text) ? $text : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );

    return theme('shortcode_toggle_item',$variables);

}

function progressive_shortcodes_shortcode_toggle_item_settings($attrs,$text){

    $form = array();

    $form['title_toggle'] = array(
        '#title' => 'Title Toggle',
        '#type' => 'textfield',
        '#default_value' => isset($attrs['title_toggle']) ? $attrs['title_toggle'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-6">'
    );

    $form['class_toggle'] = array(
        '#title' => 'Class title',
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['class_toggle']) ? $attrs['class_toggle'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-6">',
        '#suffix'     => '</div></div>'
    );

    $form['icon'] = array(
        '#title' => t('Icon'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['icon']) ? $attrs['icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '<div class="row"><div class="col-sm-6">',
    );

    $form['icon_class'] = array(
        '#title' => 'Class icon',
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-6">',
        '#suffix'     => '</div></div>'
    );


    return $form;
}