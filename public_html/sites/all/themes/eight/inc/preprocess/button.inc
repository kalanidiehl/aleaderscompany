<?php

function eight_preprocess_button(&$variables){
    $variables['element']['#attributes']['class'][] = 'cws-button';
    if($variables['element']['#button_type'] == 'submit')
    {
        $variables['element']['#attributes']['class'][] = 'cws-button alt';
    }
}