<?php

/**
 * @file
 * Wysiwyg API integration.
 */

/**
 * Implements hook_INCLUDE_plugin().
 */
function opigno_video_app_opigno_video_plugin() {
  drupal_add_library('system', 'ui.dialog');
  drupal_add_js(drupal_get_path('module', 'opigno_video_app') . '/js/opigno_video_wysiwyg.js');
  $plugins['opigno_video'] = array(
    'title' => t('Opigno Video'),
    'vendor url' => 'http://drupal.org/project/opigno_video_app',
    'icon file' => 'opigno_video.gif',
    'icon title' => t('Opigno Video'),
    'js file' => 'opigno_video.js',
    'css file' => 'opigno_video.css',
    'settings' => array(
      'global' => array(
        'url' => base_path() . 'video/browser?render=video-popup',
        'selectedId' => NULL,
        'dimensions' => NULL
      )
    ),
    'weight' => 1,
  );
  return $plugins;
}
