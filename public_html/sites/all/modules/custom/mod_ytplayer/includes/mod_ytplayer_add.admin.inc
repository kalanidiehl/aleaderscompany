<?php

define('DEFAULT_SETTINGS_YTPLAYER','eyJmdWxsc2NyZWVuX3l0cGxheWVyIjowLCJtdXRlX3l0cGxheWVyIjoxLCJzaG93Y29udHJvbHNfeXRwbGF5ZXIiOiJ0cnVlIiwicXVhbGl0eV95dHBsYXllciI6ImRlZmF1bHQiLCJhdXRvcGxheV95dHBsYXllciI6ImZhbHNlIiwibG9vcF95dHBsYXllciI6ImZhbHNlIiwic2hvd3l0bG9nb195dHBsYXllciI6ImZhbHNlIn0=');
function mode_ytplayer_add($form, &$form_state, $ytPlayer_id = 0) {
    $ytPlayer_id = arg(3);
    if (is_numeric($ytPlayer_id)) {
        $ytPlayer = get_ytplayer_by_id($ytPlayer_id);

            if (isset($ytPlayer->data)) {
                $data = json_decode(base64_decode($ytPlayer->data));
                $body = $data->body;
            }

    }
    $form['id'] = array(
        '#type' => 'hidden',
        '#default_value' => isset($ytPlayer) ? $ytPlayer->id : ''
    );
    $form['name_ytplayer'] = array(
        '#title' => t('Name'),
        '#type' => 'textfield',
        '#required' => TRUE,
        '#default_value' => isset($ytPlayer->name) ? $ytPlayer->name : '',
        '#weight' => -2,
    );
    $form['body_ytplayer'] = array(
        '#type'     => 'text_format',
        '#title'    => t('Body'),
        '#description' => t('Add content display on Block Video'),
        '#default_value' => isset($body->value) ? $body->value : '',
        '#weight'   => -1,
        '#format' => isset($body->format) ? $body->format : 'filtered_html',
        );
    $form['image_ytplayer'] = array(
        '#tree' => TRUE,
        '#title' => t('Thumnail'),
        '#type' => 'media',
        '#description' => t('The uploaded image will be displayed background block ytplayer.'),
        '#default_value' => isset($data->thumnail) ? $data->thumnail : '',
        '#media_options' => array(
            'global' => array(
                'types' => array(
                    'image' => 'image',

                ),
                /*
                  'enabledPlugins' => array(
                  'upload' => 'upload',
                  'media_default--media_browser_1' => 'media_default--media_browser_1',
                  ),
                 */
                'schemes' => array(
                    'public' => 'public',
                ),
                'file_directory' => 'ytplayer/thumnail', // The directory upload file.
                'file_extensions' => 'png jpg gif',
                'max_filesize' => '3MB',
                'uri_scheme' => 'public',
            ),
        ),
        '#required' => TRUE,
    );
    $form['video_ytplayer'] = array(
        '#tree' => TRUE,
        '#title' => t('Media Video'),
        '#type' => 'media',
        '#description' => t('The uploaded Youtube Video will be displayed background block ytplayer.'),
        '#default_value' => isset($data->video) ? $data->video : '',
        '#media_options' => array(
            'global' => array(
                'types' => array(
                    'video' => 'video',

                ),

                  'enabledPlugins' => array(
                  'media_internet' => 'media_internet',
                  //'media_default--media_browser_1' => 'media_default--media_browser_1',
                  ),

                'schemes' => array(
                    'public' => 'public',
                ),
                'file_directory' => 'ytplayer', // The directory upload file.
                'file_extensions' => 'mov m4v mp4 mpeg avi ogg oga ogv wmv',
                'max_filesize' => '100MB',
                'uri_scheme' => 'public',
            ),
        ),
        '#required' => TRUE,
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );
    return $form;
}

function mode_ytplayer_add_submit($form, &$form_state) {
    $values = $form_state['values'];
    if (is_numeric($values['id']) && $values['id'] > 0) {

        $query = db_update("mod_ytplayer")
                ->fields(array(
                    'name' => $values['name_ytplayer'],
                    'data' => base64_encode(json_encode(array('video'=>$values['video_ytplayer'],'thumnail'=>$values['image_ytplayer'],'body'=>$values['body_ytplayer'])))
                ))
                ->condition('id', $values['id'])
                ->execute();
        drupal_set_message(t("Block ytPlayer @name has been updated", array('@name' => $form['name_ytplayer']['#value'])), 'status');
    } else {
        $query = db_insert('mod_ytplayer')
                ->fields(array(
                    'name' => $values['name_ytplayer'],
                    'settings' => DEFAULT_SETTINGS_YTPLAYER,
                    'data' => base64_encode(json_encode(array('video'=>$values['video_ytplayer'],'thumnail'=>$values['image_ytplayer'],'body'=>$values['body_ytplayer']))),
                ))
                ->execute();
        drupal_set_message(t('Add ytPlayer successfully'), 'status');
    }
    drupal_goto('admin/structure/ytplayer');
}

function mod_ytplayer_delete($id) {
    return drupal_get_form('mod_ytplayer_confirm_form');
}

function mod_ytplayer_confirm_form($form_state) {
    $form = array();
    $form['id'] = array(
        '#type' => 'hidden',
        '#default_value' => arg(3)
    );
    return confirm_form($form, t('Do you really want to detele this Block ytPlayer?'), 'admin/structure/ytplayer', NULL, 'Delete', 'Cancel');
}

function mod_ytplayer_confirm_form_submit($form, &$form_state) {
    $id = $form['id']['#value'];
    if(isset($id) && !empty($id))
    {
        $ytplayer = get_ytplayer_by_id($id);
        if(isset($ytplayer)) {
            $block_delta = 'block_yplayer_'.$ytplayer->id;
            swiper_delete_block($block_delta);
            db_delete('mod_ytplayer')
                ->condition('id', $id)
                ->execute();
            drupal_set_message(t('The Block ytPlayer has been deleted'));
            drupal_goto('admin/structure/ytplayer');
        }
    }
}

/**
 * Deletes a Drupal block created by the module.
 *
 * @param string $block_delta
 *   Block delta.
 */
function swiper_delete_block($block_delta) {
  db_delete('block')
  ->condition('delta', $block_delta)
  ->execute();
}
