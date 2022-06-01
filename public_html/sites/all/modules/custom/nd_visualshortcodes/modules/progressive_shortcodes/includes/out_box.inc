<?php

function progressive_shortcodes_outbox_shortcode_info(&$shortcodes){
    $shortcodes['outbox'] = array(
        'title' => t('Out box content'),
        'description' => t('Out Box container content'),
        'process callback' => 'progressive_shortcodes_shortcode_outbox',
        'process settings callback' => 'progressive_shortcodes_shortcode_outbox_settings',
        'child shortcode' => 'html',
        'icon' => 'fa fa-square-o'
    );
}

function progressive_shortcodes_shortcode_outbox($attrs,$text){

    $variables = array(
        'class' => isset($attrs['class_outbox']) ? $attrs['class_outbox'] : '',
        'title' => isset($attrs['title']) ? $attrs['title'] : '',
        'class_title' => isset($attrs['class_title']) ? $attrs['class_title'] : '',
        'icon'   => isset($attrs['icon']) ? $attrs['icon'] : '',
        'icon_class' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        'text_link'  => isset($attrs['text_link']) ? $attrs['text_link'] : '',
        'link'       => isset($attrs['link']) ? $attrs['link'] : '',
        'class_link' => isset($attrs['class_link']) ? $attrs['class_link'] : '',
        'text_element' => $text,
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );

    return theme('shortcode_outbox',$variables);
}

function progressive_shortcodes_shortcode_outbox_settings($attrs,$text){

    $form = array();

    $form['class_outbox'] = array(
        '#type' => 'textfield',
        '#title' => 'Class outbox',
        '#default_value' => isset($attrs['class_outbox']) ? $attrs['class_outbox'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    $form['title'] = array(
        '#type'  => 'textfield',
        '#title' => 'Title',
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '<div class="row"><div class="col-sm-6">',
        //'#suffix'     => '</div></div>',
    );

    $form['class_title'] = array(
        '#type' => 'textfield',
        '#title' => 'Class title',
        '#default_value' => isset($attrs['class_title']) ? $attrs['class_title'] : '',
        '#attributes'    => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-6">',
        '#suffix'     => '</div></div>',
    );
    $form['icon'] = array(
        '#title' => t('Icon'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attr['icon']) ? $attr['icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '<div class="row"><div class="col-sm-6">',
    );

    $form['icon_class'] = array(
        '#title'    => t('Class icon'),
        '#type'     => 'textfield',
        '#default_value' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-6" >',
        '#suffix'     => '</div></div>'
    );

    $form['text_link'] = array(
        '#type'  => 'textfield',
        '#title' => 'Text Link',
        '#default_value' => isset($attrs['text_link']) ? $attrs['text_link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '<div class="row"><div class="col-sm-4">',
    );
    $form['link'] = array(
        '#type'  => 'textfield',
        '#title' => 'Link',
        '#default_value' => isset($attrs['link']) ? $attrs['link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-4">',
    );
    $form['class_link'] = array(
        '#type'  => 'textfield',
        '#title' => 'Class link',
        '#default_value' => isset($attrs['class_link']) ? $attrs['class_link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-4">',
        '#suffix'     => '</div></div>',
    );

    return $form;

}