<?php

function eight_preprocess_password(&$variables){
    $variables['element']['#attributes']['class'][] = 'form-control';
}