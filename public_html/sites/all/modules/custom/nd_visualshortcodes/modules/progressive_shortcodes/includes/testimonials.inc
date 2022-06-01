<?php

function progressive_shortcodes_testimonial_info(&$shortcodes){

    $shortcodes['testimonial'] = array(
        'title' => t('Testimonial'),
        'description' => t('Testimonial container'),
        'process callback' => 'progressive_shortcodes_shortcode_testimonial',
        'process settings callback' => 'progressive_shortcodes_shortcode_testimonial_settings',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'icon' => 'fa fa-commenting-o',
    );
}

function progressive_shortcodes_shortcode_testimonial($attrs,$text){
    $file = isset($attrs['image']) ? file_load($attrs['image']) : '';
    $variables = array(
        'container_class' => isset($attrs['container_class']) ? $attrs['container_class'] : '',
        'file_image' => !empty($file) ? $file : '',
        'image_class' => isset($attrs['image_class']) ? $attrs['image_class'] : '',
        'author_name' => isset($attrs['author_name']) ? $attrs['author_name'] : '',
        'class_author' => isset($attrs['class_author']) ? $attrs['class_author'] : '',
        'description' => isset($attrs['description']) ? $attrs['description'] : '',
        'text_link' => isset($attrs['text_link']) ? $attrs['text_link'] : '',
        'link'      => isset($attrs['link']) ? $attrs['link'] : '',
        'icon_link' => isset($attrs['icon_link']) ? $attrs['icon_link'] : '',
        'class_link' => isset($attrs['class_link']) ? $attrs['class_link'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );

    return theme('shortcode_testimonial',$variables);
}

function progressive_shortcodes_shortcode_testimonial_settings($attrs,$text){
    $form = array();
    $filename = (isset($attrs['image']) ? file_load($attrs['image'])->uri : '');
    $image = $filename ? theme('image_style', array('style_name' => 'media_thumbnail', 'path' => $filename)) : '';

    $form['container_class'] = array(
        '#type' => 'textfield',
        '#title' => 'Container Class',
        '#attributes' => array('class' => array('form-control')),
        '#default_value' => isset($attrs['container_class']) ? $attrs['container_class'] : '',
        '#prefix' => '<div class="row"><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );

    $form['image'] = array(
        '#type' => 'textfield',
        '#title' => t('Image'),
        '#default_value' => isset($attrs['image']) ? $attrs['image'] : '',
        '#attributes' => array('class' => array('image-media-upload hidden')),
        '#field_suffix' => '<div class = "preview-image">' . $image . '</div><a href = "#" class = "media-upload button">' . t('Upload Image') .'</a><a href = "#" class = "media-remove button">' . t('Remove Image') .'</a>',
        '#prefix' => '<div class = "row"><div class = "col-sm-8">',
    );
    $form['image_class'] = array(
        '#type' => 'textfield',
        '#title' => 'Class Image',
        '#default_value' => isset($attrs['image_class']) ? $attrs['image_class'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',
        '#suffix' => '</div></div>'
    );

    $form['author_name'] = array(
        '#type' => 'textfield',
        '#title' => 'Author name',
        '#default_value' => isset($attrs['author_name']) ? $attrs['author_name'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-6">',
    );
    $form['class_author'] = array(
        '#type' => 'textfield',
        '#title' => 'Class author',
        '#default_value' => isset($attrs['class_author']) ? $attrs['class_author'] : '',
        '#attributes'    => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );
    $form['description'] = array(
        '#type' => 'textarea',
        '#title' => 'Description',
        '#default_value' => isset($attrs['description']) ? $attrs['description'] : '',
        '#attributes' => array('class' => array('form-control'))
    );
    $form['text_link'] = array(
        '#type' => 'textfield',
        '#title' => 'Text Link',
        '#default_value' => isset($attrs['text_link']) ? $attrs['text_link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class ="col-sm-3">',
    );
    $form['link'] = array(
        '#type' => 'textfield',
        '#title' => 'Link',
        '#default_value' => isset($attrs['link']) ? $attrs['link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class ="col-sm-3">',
    );

    $form['icon_link'] = array(
        '#title' => t('Icon Link'),
        '#type'  => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['icon_link']) ? $attrs['icon_link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-3">'
    );

    $form['class_link'] = array(
        '#title' => 'Class Link',
        '#type'  => 'textfield',
        '#default_value' => isset($attrs['class_link']) ? $attrs['class_link'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-3">',
        '#suffix' => '</div></div>'
    );

    return $form;
}