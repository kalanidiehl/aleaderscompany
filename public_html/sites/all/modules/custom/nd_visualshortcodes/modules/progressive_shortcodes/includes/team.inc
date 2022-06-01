<?php

function progressive_shortcodes_team_shortcode_info(&$shortcodes)
{
    $shortcodes['team'] = array(
        'title' => t('Team'),
        'description' => t('Shortcode Team'),
        'process callback' => 'progressive_shortcodes_shortcode_team',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'process settings callback' => 'progressive_shortcodes_shortcode_team_settings',
        'icon' => 'fa fa-user',
        //'description_callback' => 'progressive_shortcodes_shortcode_view_description',
    );
}

function progressive_shortcodes_shortcode_team($attrs,$text){

    $attrs['class'] = 'de-team-list';

    $file = isset($attrs['team_img']) && !empty($attrs['team_img']) ? file_load($attrs['team_img']) : $attrs['path'];
    $filename = isset($file->uri) ? file_create_url($file->uri) : $file;
    $image = '<img src="' . $filename . '" class="img-responsive" alt="' . (isset($attrs['alt']) ? $attrs['alt'] : '') . '" title="' . (isset($attrs['title']) ? $attrs['title'] : '') . '">';
    $text = '<div '._progressive_shortcodes_shortcode_attributes($attrs).'>';
          $text.= isset($image) ? '<div class="team-pic">'.$image.'</div>' : '';
          $text.= '<div  class="team-desc col-md-12">';
                $text.= isset($attrs['team_name']) ? '<h3>'.$attrs['team_name'].'</h3>' : '';
                $text.= isset($attrs['team_job']) ? '<p class="lead">'.$attrs['team_job'].'</p>' : '';
                $text.= '<div class="small-border"></div>';
                $text.= isset($attrs['team_text']) ? '<p>'.$attrs['team_text'].'</p>' : '';
                $text.= '<div class="social">';
                    $text.= isset($attrs['social_fb']) ? '<a href="'.$attrs['social_fb'].'"><i class="fa fa-facebook fa-lg"></i></a>':'';
                    $text.= isset($attrs['social_tw']) ?'<a href="'.$attrs['social_tw'].'"><i class="fa fa-twitter fa-lg"></i></a>':'';
                    $text.= isset($attrs['social_gl']) ?'<a href="'.$attrs['social_gl'].'"><i class="fa fa-google-plus fa-lg"></i></a>':'';
                    $text.= isset($attrs['social_skype']) ?'<a href="'.$attrs['social_skype'].'"><i class="fa fa-linkedin fa-lg"></i></a>':'';
                $text.= '</div>';
          $text.= '</div>';
    $text .= '</div>';

    $variables = array(
        'file_image' => isset($file) ? $file : '',
        'team_name' => isset($attrs['team_name']) ? $attrs['team_name'] : '',
        'team_job'  => isset($attrs['team_job'])  ? $attrs['team_job']  : '',
        'team_text' => isset($attrs['team_text']) ? $attrs['team_text'] : '',
        'link_facebook' => isset($attrs['social_fb']) ? $attrs['social_fb'] : '',
        'link_twitter' => isset($attrs['social_tw']) ? $attrs['social_tw'] : '',
        'link_google' => isset($attrs['social_gl']) ? $attrs['social_gl'] : '',
        'name_skype'  => isset($attrs['social_skype']) ? $attrs['social_skype'] : '',
        'attributes_shortcode' => _progressive_shortcodes_shortcode_attributes($attrs),
    );
    return theme('shortcode_team',$variables);
}

function progressive_shortcodes_shortcode_team_settings($attrs, $text){
    $filename = (isset($attrs['team_img']) ? file_load($attrs['team_img'])->uri : '');
    $image = $filename ? theme('image_style', array('style_name' => 'media_thumbnail', 'path' => $filename)) : '';
    $form['team_img'] = array(
        '#type' => 'textfield',
        '#title' => t('Image'),
        '#default_value' => isset($attrs['team_img']) ? $attrs['team_img'] : '',
        '#attributes' => array('class' => array('image-media-upload hidden')),
        '#field_suffix' => '<div class = "preview-image">' . $image . '</div><a href = "#" class = "media-upload button">' . t('Upload Image') .'</a><a href = "#" class = "media-remove button">' . t('Remove Image') .'</a>',
        '#prefix' => '<div class="row"><div class="col-sm-4">'

    );
    $form['team_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Name'),
        '#default_value' => isset($attrs['team_name']) ? $attrs['team_name'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix'    => '</div><div class="col-sm-4">',


    );
    $form['team_job'] = array(
        '#type' => 'textfield',
        '#title' => t('Jobs'),
        '#default_value' =>  isset($attrs['team_job']) ? $attrs['team_job'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-4">',
        '#suffix' => '</div></div>'
    );
    $form['team_text'] = array(
        '#type' => 'textarea',
        '#title' => t('Text Team'),
        '#default_value' => isset($attrs['team_text']) ? $attrs['team_text'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-12" >',
        '#suffix' => '</div></div>'
    );
    $form['social_fb'] = array(
        '#type' => 'textfield',
        '#title' => 'Link facebook',
        '#default_value' => isset($attrs['social_fb']) ? $attrs['social_fb'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-3">'
    );
    $form['social_tw'] = array(
        '#type' => 'textfield',
        '#title' => 'Link twitter',
        '#default_value' => isset($attrs['social_tw']) ? $attrs['social_tw'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-3">'
    );
    $form['social_gl'] = array(
        '#type' => 'textfield',
        '#title' => 'Link for Bio',
        '#default_value' => isset($attrs['social_gl']) ? $attrs['social_gl'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-3">'
    );
    $form['social_skype'] = array(
        '#type' => 'textfield',
        '#title' => 'Linkedin',
        '#default_value' => isset($attrs['social_skype']) ? $attrs['social_skype'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class="col-sm-3">',
        '#suffix' => '</div></div>'
    );

    return $form;
}