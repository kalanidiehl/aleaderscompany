<?php

function progressive_shortcodes_title_shortcode_info(&$shortcodes)
{
    $shortcodes['title'] = array(
        'title' => t('Title'),
        'description' => t('Title with optional underline.'),
        'process callback' => 'progressive_shortcodes_shortcode_title',
        'tips callback' => 'progressive_shortcodes_shortcode_title_tip',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'process settings callback' => 'progressive_shortcodes_shortcode_title_settings',
        'icon' => 'fa fa-text-width',
        'description_field' => 'title',
    );
}

function progressive_shortcodes_shortcode_title($attrs, $text) {
    $attrs['class'] = isset($attrs['class']) ? ' ' . $attrs['class'] : '';
   // $attrs['class'] .= isset($attrs['underline']) && $attrs['underline'] && (!isset($attrs['type']) || $attrs['type'] != 'page') ? ' title-box' : '';
    $attrs['class'] .= isset($attrs['title_align']) && $attrs['title_align']? ' ' . $attrs['title_align'] : '';
    $align = 'left';
    if(isset($attrs['title_align'])) {
        switch ($attrs['title_align']) {
            case 'text-center':
                $align = 'center';
                break;
            case 'text-right':
                $align = 'right';
                break;
        }
    }
    $variables = array(
        'title' => isset($attrs['title']) ? $attrs['title'] : '',
        'title_class' => isset($attrs['title_class']) ? $attrs['title_class'] : '',
        'align' => $align,
        'bold_title' => isset($attrs['bold_title']) ? $attrs['bold_title'] : '',
        'tag'   => $attrs['tag'],
        'subtitle' => isset($attrs['subtitle']) ? $attrs['subtitle'] : '',
        'check_underline' => ($attrs['underline'] == 1) ? true : false,
        'position_underline' => $attrs['position_underline'],
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs)
    );

    return theme('shortcode_title',$variables);
}

function progressive_shortcodes_shortcode_title_settings($attrs, $text) {
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-4">'
    );
    $form['bold_title'] = array(
        '#type' => 'textfield',
        '#title' => t('Bold Title'),
        '#default_value' => isset($attrs['bold_title']) ? $attrs['bold_title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',

    );
    $form['title_class'] = array(
        '#type' => 'textfield',
        '#title' => t('Class title'),
        '#default_value' => isset($attrs['title_class']) ? $attrs['title_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',
        '#suffix' => '</div></div>'
    );
    $types = array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',);
    $form['tag'] = array(
        '#type' => 'select',
        '#title' => t('Tag'),
        '#options' => $types,
        '#default_value' => isset($attrs['tag']) ? $attrs['tag'] : 'h2',
        '#attributes' => array('class' => array('form-control','select_type'))
    );
    $form['subtitle'] = array(
        '#type' => 'textfield',
        '#title' => t('Sub title'),
        '#default_value' => isset($attrs['subtitle']) ? $attrs['subtitle'] : $attrs['subtitle'],
        '#attributes' => array('class' => array('form-control'))
    );
    $form['underline'] = array(
        '#type' => 'checkbox',
        '#title' => t('Underline'),
        '#default_value' => isset($attrs['underline']) ? $attrs['underline'] : 1,
        '#attributes' => array('class'=>array('underline_title'))
    );
    $form['position_underline'] = array(
        '#type' => 'select',
        '#title' => t('Position underline'),
        '#options' => array('after'=> t('After'),'before' => t('Before')),
        '#default_value' => isset($attrs['position_underline']) ? $attrs['position_underline'] : '',
        '#states' => array(
            'visible' => array(
                '.underline_title' => array('checked' => TRUE),
            )
        )
    );
    $aligns = array('' => t('Left'), 'text-center' => t('Center'), 'text-right' => t('Right'));
    $form['title_align'] = array(
        '#type' => 'select',
        '#title' => t('Align'),
        '#options' => $aligns,
        '#default_value' => isset($attrs['title_align']) ? $attrs['title_align'] : '',
        '#attributes' => array('class' => array('form-control'))
    );
    return $form;
}