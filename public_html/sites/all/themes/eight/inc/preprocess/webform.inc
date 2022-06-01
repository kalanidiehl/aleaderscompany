<?php
function eight_preprocess_webform_email(&$variables){
    $element = $variables['element'];
    $variables['element']['#attributes']['class'][] = 'form-control';
}