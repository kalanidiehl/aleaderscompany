<?php

function eight_process_comment(&$variables) {
  if (isset($variables['elements']['links']['comment']['#links']['comment-reply'])) {
    $variables['elements']['links']['comment']['#links']['comment-reply']['title'] = ucfirst($variables['content']['links']['comment']['#links']['comment-reply']['title']) . '<i class="flaticon-return13"></i>';
    $variables['elements']['links']['comment']['#links']['comment-reply']['attributes']['class'][] = 'button-reply';
  }
}