<?php

/**
 * @file
 * Defines all page callbacks.
 */

function opigno_video_app_sort_course_videos_form($form, $form_state, $node) {
  $form['table'] = array(
    '#tree' => TRUE,
  );

  $form['gid'] = array(
    '#type' => 'hidden',
    '#value' => $node->nid,
  );

  $i = 0;
  foreach (opigno_video_app_get_course_videos($node) as $video_nid) {
    //dpm($video_nid,"video_nid");
    $video = node_load($video_nid);
    $form['table']["quiz_{$video_nid}"]['nid'] = array(
      '#type' => 'hidden',
      '#value' => $video_nid,
    );
    $form['table']["quiz_{$video_nid}"]['title'] = array(
      '#markup' => check_plain($video->title),
    );
    $form['table']["quiz_{$video_nid}"]['weight'] = array(
      '#type' => 'weight',
      '#delta' => 50,
      '#default_value' => opigno_video_app_get_course_video_weight($node->nid, $video_nid),
      '#attributes' => array('class' => array('opigno-video-app-sort-course-videos-weight')),
    );
    $i++;
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t("Save order"),
  );

  return $form;
}

function opigno_video_app_sort_course_videos_form_submit($form, $form_state) {
  foreach ($form_state['values']['table'] as $values) {
    opigno_video_app_set_course_video_weight($form_state['values']['gid'], $values['nid'], $values['weight']);
  }
}
