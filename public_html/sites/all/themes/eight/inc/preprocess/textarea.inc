<?php

function eight_preprocess_textarea(&$variables){
    $variables['element']['#attributes']['class'][] = 'form-control';
}