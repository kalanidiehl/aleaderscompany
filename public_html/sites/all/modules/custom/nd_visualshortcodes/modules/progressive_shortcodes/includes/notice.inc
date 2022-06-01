<?php

function progressive_shortcodes_notice_shortcode_info(&$shortcodes)
{
    $shortcodes['notice'] = array(
        'title' => t('Notice'),
        'description' => t('Notice content'),
        'process callback' => 'progressive_shortcodes_shortcode_notice',
        'process settings callback' => 'progressive_shortcodes_shortcode_notice_settings',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'icon' => 'fa fa-bell-o'
    );
}

function progressive_shortcodes_shortcode_notice($attr,$text){
    $variabels = array(
        'type' => isset($attr['type']) ? $attr['type'] : '',
        'class_notice' => isset($attr['class_notice']) ? $attr['class_notice'] : '',
        'title' => isset($attr['title']) ? $attr['title'] : '',
        'class_title' => isset($attr['class_title']) ? $attr['class_title'] : '',
        'icon'      => isset($attr['icon'])  ? $attr['icon'] : '',
        'icon_class' => isset($attr['icon_class']) ? $attr['icon_class'] : '',
        'message'   => isset($attr['message'])  ? $attr['message'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attr),
    );

    return theme('shortcode_notice',$variabels);
}

function progressive_shortcodes_shortcode_notice_settings($attr,$text)
{
    $form = array();
    $form['type'] = array(
        '#type' => 'select',
        '#title' => 'Type Notice',
        '#options' => array('notice' => 'Notice','warning' => 'Warning','success' => 'Success','error' => 'Error','info' => 'Info','useful' => 'Useful'),
        '#default_value' => isset($attr['type']) ? $attr['type'] : 'warning',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row" ><div class="col-sm-6">',
    );
    $form['class_notice'] = array(
        '#type'  => 'textfield',
        '#title' => 'Class',
        '#default_value' => isset($attr['class_notice']) ? $attr['class_notice'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    $form['title'] = array(
        '#type'  => 'textfield',
        '#title' => 'Title',
        '#default_value' => isset($attr['title']) ? $attr['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'    => '<div class="row"><div class="col-sm-6">'
    );
    $form['class_title'] = array(
        '#type'  => 'textfield',
        '#title' => 'Class title',
        '#default_value' => isset($attr['class_title']) ? $attr['class_title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    $form['icon'] = array(
        '#type' => 'textfield',
        '#title' => 'Icon',
        '#default_value' => isset($attr['icon']) ? $attr['icon'] : '',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'   => '<div class="row"><div class="col-sm-6">',
    );

    $form['icon_class'] = array(
        '#type'  => 'textfield',
        '#title' => 'Class icon',
        '#default_value' => isset($attr['icon_class']) ? $attr['icon_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );
    $form['message'] = array(
        '#type'  => 'textarea',
        '#title' => 'Message',
        '#default_value' => isset($attr['message']) ? $attr['message'] : '',
        '#attributes' => array('class' => array('form-control')),
    );

    return $form;
}