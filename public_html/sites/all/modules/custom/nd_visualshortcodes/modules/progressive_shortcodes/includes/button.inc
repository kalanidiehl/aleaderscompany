<?php

function progressive_shortcodes_button_shortcode_info(&$shortcodes)
{
    $shortcodes['butoon'] = array(
        'title' => t('Button'),
        'description' => t('Button Link'),
        'process callback' => 'progressive_shortcodes_shortcode_button',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'process settings callback' => 'progressive_shortcodes_shortcode_button_settings',
        'icon' => 'fa fa-bold'
    );
}

function progressive_shortcodes_shortcode_button($attrs, $text){

    $variables = array(
        'text_button'  => isset($attrs['text_button']) ? $attrs['text_button'] : '',
        'icon'         => isset($attrs['icon_button']) ? $attrs['icon_button'] : '',
        'link'         => isset($attrs['link_button']) ? $attrs['link_button'] : '',
        'class_button' => isset($attrs['class_button']) ? $attrs['class_button'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );
    return theme('shortcode_button',$variables);
}

function progressive_shortcodes_shortcode_button_settings($attrs, $text)
{
    $form['text_button'] = array(
        '#type' => 'textfield',
        '#title' => 'Text Button',
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['text_button']) ? $attrs['text_button'] : '',
        '#prefix' => '<div class="row"><div class="col-sm-6">',
    );

    $form['icon_button'] = array(
        '#type' => 'textfield',
        '#title' => 'Icon button',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['icon_button']) ? $attrs['icon_button'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    $form['link_button'] = array(
        '#type' =>'textfield',
        '#title' => 'Link Button',
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['link_button']) ? $attrs['link_button'] : '',
        '#prefix'   => '<div class="row"><div class="col-sm-6">',
    );

    $form['class_button'] = array(
        '#type' => 'textfield',
        '#title' => 'Class Button',
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['class_button']) ? $attrs['class_button'] : '',
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    return $form;
}