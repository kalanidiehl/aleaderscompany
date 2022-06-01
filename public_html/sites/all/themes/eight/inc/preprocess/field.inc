<?php

function eight_preprocess_field(&$variables){
    if($variables['element']['#entity_type'] == 'node') {
        $variables['theme_hook_suggestions'][] = 'field__' . $variables['element']['#field_name'] . '_' . $variables['element']['#bundle'];
        $variables['theme_hook_suggestions'][] = 'field__' . $variables['element']['#field_name'] . '_' . $variables['element']['#bundle'] . '_' . $variables['element']['#view_mode'];
    }
  if (!empty($variables['element']['#field_name'])) {
    switch ($variables['element']['#field_name']) {
      case 'course_quota':
        if ($variables['items'][0]['#markup'] == '-1') {
          $variables['items'][0]['#markup'] = t("No limit");
        }
        break;

      case 'group_access':
        // Please forgive me :,-(
        $variables['items'][0]['#markup'] = t($variables['items'][0]['#markup']);
        break;
    }
  }

  if (!empty($variables['element']['#field_type'])) {
    if ($variables['element']['#field_type'] == 'list_boolean') {
      if (isset($variables['items'][0]['#markup']) && ($variables['items'][0]['#markup'] == '0')) {
        $variables['items'][0]['#markup'] = t("No");
      }
      elseif (isset($variables['items'][0]['#markup']) && ($variables['items'][0]['#markup'] == '1')) {
        $variables['items'][0]['#markup'] = t("Yes");
      }
    }
  }
}

