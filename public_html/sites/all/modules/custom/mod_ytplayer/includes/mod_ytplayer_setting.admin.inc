<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mod_ytplayer_settings($form, &$form_state) {

    if(!get_ytplayer_by_id(arg(3))) drupal_goto('admin/structure/ytplayer');
        
    $ytplayer = get_ytplayer_by_id(arg(3));

    $settings = json_decode(base64_decode($ytplayer->settings));
    $form['id_ytplayer'] = array(
        '#type' => 'hidden',
        '#default_value' => arg(3)
    );
    $form['fullscreen_ytplayer'] = array(
        '#type' => 'checkbox',
        '#title' => t('Full screen'),
        '#description' => t('Block Full screen video'),
        '#default_value' =>!empty($ytplayer->settings) ? $settings->fullscreen_ytplayer : 0
        );
    $form['mute_ytplayer'] = array(
        '#type' => 'checkbox',
        '#title' => t('Mute'),
        '#description' => t('mute: true (boolean) mute the audio'),
        '#default_value' => !empty($ytplayer->settings) ? $settings->mute_ytplayer : 0
     );
    $form['showcontrols_ytplayer'] = array(
        '#type' => 'select',
        '#title' => t('showControls'),
        '#options' => array('false' => t('False'), 'true' => t('True')),
        '#default_value' => !empty($ytplayer->settings) ? $settings->showcontrols_ytplayer : '',
        '#description' => t('Show or hide the controls bar at the bottom of the page.')
    );
    $option_quality = array('default' => t('Default'), 'small' => t('Small'), 'medium' => t('Medium'), 'large' => t('Large'), 'hd720' => t('HD 720'), 'hd1080' => 'HD 1080', 'highres' => t('Highres'));
    $form['quality_ytplayer'] = array(
        '#type' => 'select',
        '#title' => t('Quatity'),
        //'#description' => t(''),
        '#options' => $option_quality,
        '#default_value' => !empty($ytplayer->settings) ? $settings->quality_ytplayer : '',
    );
    $form['autoplay_ytplayer'] = array(
        '#type' => 'select',
        '#title' => t('AutoPlay'),
        '#options' => array('false' => t('False'), 'true' => t('True')),
        '#default_value' => !empty($ytplayer->settings) ? $settings->autoplay_ytplayer : '',
        '#description' => t('true (boolean) or false play the video once ready.'),
    );
    $form['loop_ytplayer'] = array(
        '#type' => 'select',
        '#title' => t('Loop'),
        '#options' => array('false' => t('False'), 'true' => t('True')),
        '#default_value' => !empty($ytplayer->settings) ? $settings->loop_ytplayer : '',
        '#description' => t('true (boolean) or false loops the movie once ended.'),
    );
    $form['showytlogo_ytplayer'] = array(
        '#type' => 'select',
        '#title' => t('showYTLogo'),
        '#options' => array('false' => t('False'), 'true' => t('True')),
        '#default_value' => !empty($ytplayer->settings) ? $settings->showytlogo_ytplayer : '',
        '#description' => t('Show or hide the YT logo and the link to the original video URL.')
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit')
    );
    return $form;
}

function mod_ytplayer_settings_submit($form, &$form_state) {
    $values = $form_state['values'];

    foreach($form_state['values'] as $key => $value)
    {
        if(preg_match("/_ytplayer$/", $key) && !preg_match("/id_ytplayer/", $key))
        {
            $match_string[$key] = $value;
        }
    }

    $query = db_update("mod_ytplayer")
                ->fields(array(
                    'settings' => base64_encode(json_encode($match_string))
                ))
                ->condition('id',$values['id_ytplayer'])
                ->execute();
     drupal_set_message(t("Setting block ytPlayer has been updated"), 'status');            
    drupal_goto('admin/structure/ytplayer');
   
}
function preg_array_key_exists($pattern, $array) {
    $keys = array_keys($array);    
    return  preg_grep($pattern,$keys);
}

