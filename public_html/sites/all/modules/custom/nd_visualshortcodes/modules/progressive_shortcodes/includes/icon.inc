<?php

function progressive_shortcodes_icon_shortcode_info(&$shortcodes)
{
    $shortcodes['icon'] = array(
        'title' => t('Icon'),
        'description' => t('icon Font'),
        'process callback' => 'progressive_shortcodes_shortcode_icon',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'process settings callback' => 'progressive_shortcodes_shortcode_icon_settings',
        'icon' => 'fa fa-rocket'
    );
}
function progressive_shortcodes_shortcode_icon($attrs, $text) {

    $variables = array(
        'icon' => isset($attrs['icon']) ? $attrs['icon'] : '',
        'icon_color' => isset($attrs['icon_color']) ? '#'.$attrs['icon_color'] : '',
        'icon_class' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );

    return theme('shortcode_icon',$variables);

}

function progressive_shortcodes_shortcode_icon_settings($attrs, $text) {
    $form['icon'] = array(
        '#title' => t('Icon'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['icon']) ? $attrs['icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '<div class="row"><div class="col-md-4">',
    );
    $form['icon_color'] = array(
        '#title' => t('Color'),
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['icon_color']) ? $attrs['icon_color'] : '',
        '#attributes' => array('class' => array('colorpicker-enable form-control')),
        '#prefix'     => '</div><div class="col-sm-4">'
    );
    $form['icon_class'] = array(
        '#title' => t('Class Icon'),
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['icon_class']) ? $attrs['icon_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'     => '</div><div class="col-sm-4">',
        '#suffix'     => '</div></div>'
    );
    return $form;
}