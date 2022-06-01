<?php

function progressive_shortcodes_progress_shortcode_info(&$shortcodes)
{
    $shortcodes['progress_skill'] = array(
        'title' => t('Progress Skill'),
        'description' => t('Progress Skill with title and percents.'),
        'process callback' => 'progressive_shortcodes_shortcode_progress',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'process settings callback' => 'progressive_shortcodes_shortcode_progress_settings',
        'icon' => 'fa fa-tasks',
        'tips callback' => 'progressive_shortcodes_shortcode_progress_tip',
        'description_field' => 'title',
    );
}


function progressive_shortcodes_shortcode_progress($attrs, $text) {
    
    $variables = array(
        'title' => isset($attrs['title']) ? $attrs['title'] : '',
        'color_skill' => isset($attrs['color_skill']) ? $attrs['color_skill'] : '',
        'percent'     => isset($attrs['percent']) ? $attrs['percent'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );
    return theme('shortcode_process_skill',$variables);
}

function progressive_shortcodes_shortcode_progress_settings($attrs, $text) {
    $attrs['title'] = isset($attrs['title']) && $attrs['title'] ? $attrs['title'] : '';
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-4">',
        '#states' => array(
            'invisible' => array(
                '.progess-type-select' => array('value' => 'circle'),
            ),
        ),
    );
    $form['color_skill'] = array(
        '#type' => 'textfield',
        '#title' => t('Color'),
        '#default_value' => isset($attrs['color_skill']) ? $attrs['color_skill'] : '',
        '#attributes' => array('class' => array('colorpicker-enable form-control')),
        '#prefix' => '</div><div class = "col-sm-4">',
    );
    $form['percent'] = array(
        '#type' => 'textfield',
        '#title' => t('Percent'),
        '#default_value' => isset($attrs['percent']) ? $attrs['percent'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class = "col-sm-4">',
        '#suffix' => '</div></div>',
    );
    return $form;
}

function progressive_shortcodes_shortcode_progress_tip($format, $long) {
    $output = array();
    $output[] = '<p><strong>Progress skill:</strong><br/>[progress_skill percent = "90" color = "blue"]Design[/progress_skill]</br>';
    return implode(' ', $output);
}