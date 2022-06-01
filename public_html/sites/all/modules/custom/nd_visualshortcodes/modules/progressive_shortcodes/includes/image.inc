<?php

function progressive_shortcodes_image_shortcode_info(&$shortcodes)
{
    $shortcodes['image'] = array(
        'title' => t('Image'),
        'description' => t('Image with caption'),
        'process callback' => 'progressive_shortcodes_shortcode_image',
        'process settings callback' => 'progressive_shortcodes_shortcode_image_settings',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'tips callback' => 'progressive_shortcodes_shortcode_image_tip',
        'icon' => 'fa fa-file-image-o'
    );
}

function progressive_shortcodes_shortcode_image($attrs, $text) {

    $file = isset($attrs['fid']) && !empty($attrs['fid']) ? file_load($attrs['fid']) : $attrs['path'];
    $filename = isset($file->uri) ? file_create_url($file->uri) : $file;
    $variables = array(
        'attributes' => _progressive_shortcodes_shortcode_attributes($attrs),
        'path'  => $filename,
        'title' => $file->title,
        'alt'   => $file->alt,
        'width' => $file->width,
        'height' => $file->height,
        'fancy'  => (isset($attrs['fancey']) && $attrs['fancy'] == 1)  ? true : false,
        'class_image' => isset($attrs['class_image']) ? $attrs['class_image'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
        );

    return theme('shortcode_image',$variables);
}


function progressive_shortcodes_shortcode_image_settings($attrs, $text) {

    $filename = (isset($attrs['fid']) ? file_load($attrs['fid'])->uri : '');
    $image = $filename ? theme('image_style', array('style_name' => 'media_thumbnail', 'path' => $filename)) : '';
    $form['fid'] = array(
        '#type' => 'textfield',
        '#title' => t('Image'),
        '#default_value' => isset($attrs['fid']) ? $attrs['fid'] : '',
        '#attributes' => array('class' => array('image-media-upload hidden')),
        '#field_suffix' => '<div class = "preview-image">' . $image . '</div><a href = "#" class = "media-upload button">' . t('Upload Image') .'</a><a href = "#" class = "media-remove button">' . t('Remove Image') .'</a>',
        '#prefix' => '<div class = "row"><div class = "col-sm-4">',
    );
    $form['class_image'] = array(
        '#type' => 'textfield',
        '#title' => 'Class Image',
        '#default_value' => isset($attrs['class_image']) ? $attrs['class_image'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',

    );
    $form['fancy'] = array(
        '#type' => 'checkbox',
        '#title' => 'Fancy Box',
        '#default_value' => ($attrs['fancy'] == 1) ? 1 : 0,
        '#prefix' => '</div><div class="col-sm-4">',
        '#suffix' => '</div></div>'

    );

    return $form;
}