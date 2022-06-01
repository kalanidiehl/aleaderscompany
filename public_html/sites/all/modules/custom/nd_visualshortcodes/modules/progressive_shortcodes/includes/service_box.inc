<?php

function progressive_shortcodes_service_box_shortcode_info(&$shortcodes)
{
    $shortcodes['service_box'] = array(
        'title' => t('Service Box'),
        'description' => t('Service box with text.'),
        'process callback' => 'progressive_shortcodes_shortcode_servicebox',
        'tips callback' => 'progressive_shortcodes_shortcode_servicebox_tip',
        'process settings callback' => 'progressive_shortcodes_shortcode_servicebox_settings',
        'icon' => 'fa fa-star',
        'description_field' => 'title',
    );
}

function progressive_shortcodes_shortcode_servicebox($attrs, $text) {
    $variables = array(
        'position' => isset($attrs['position']) ? $attrs['position'] : '',
        'tag_title' => isset($attrs['tag_title']) ? $attrs['tag_title'] : '',
        'title'    => isset($attrs['title']) ? $attrs['title'] : '',
        'title_class' => isset($attrs['title_class']) ? $attrs['title_class'] : '',
        'icon'     => isset($attrs['icon'])  ? $attrs['icon'] : '',
        'color_icon' => isset($attrs['color_icon']) ? '#'.$attrs['color_icon'] : '',
        'icon_class' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        'text_element' => $text,
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );

    return theme('shortcode_service_icon',$variables);
}


function progressive_shortcodes_shortcode_servicebox_settings($attrs, $text) {

    $form['position'] = array(
        '#type' => 'select',
        '#title' => 'Position Icon',
        '#options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'),
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['position']) ? $attrs['position'] : '',

    );
    $form['tag_title'] = array(
        '#type'   => 'select',
        '#title'  => 'Tag title',
        '#options' => array('h1' => 'H1','h2' => 'H2','h3' => 'H3','h4' => 'H4', 'h5' => 'H5','h6' => 'H6'),
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['tag_title']) ? $attrs['tag_title'] : 'h3',
        '#prefix' => '<div class="row"><div class="col-sm-2">',
    );
    $form['title'] = array(
        '#type'  => 'textfield',
        '#title' => t('Title'),
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#prefix' => '</div><div class="col-sm-5">',
    );
    $form['title_class'] = array(
        '#type'  => 'textfield',
        '#title' => t('Class title'),
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['title_class']) ? $attrs['title_class'] : '',
        '#prefix' => '</div><div class="col-sm-5">',
        '#suffix' => '</div></div>'
    );
    $form['icon']  = array(
        '#title' => t('Icon'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['icon']) ? $attrs['icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-4">',
    );
    $form['color_icon'] = array(
        '#title' => t('Color icon'),
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['color_icon']) ? $attrs['color_icon'] : '',
        '#attributes' => array('class' => array('colorpicker-enable form-control')),
        '#prefix' => '</div><div class="col-md-4">',

    );
    $form['icon_class'] = array(
        '#title' => 'Class Icon',
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',
        '#suffix' => '</div></div>'
    );
    return $form;
}