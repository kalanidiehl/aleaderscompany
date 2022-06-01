<?php
function eight_preprocess_textfield(&$variables){
    $element = $variables['element'];
    if (isset($element['#id'])) {
      if (!preg_match('/^edit-quantity/', $element['#id']) && !preg_match('/^edit-edit-quantity/', $element['#id'])) {
        $variables['element']['#attributes']['class'][] = 'form-control';
      }
    }

}