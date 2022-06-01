<?php

/**
 * @file
 * App configuration.
 */

/**
 * Implements hook_apps_app_info().
 */
function opigno_commerce_app_apps_app_info() {
  return array(
    'configure form' => 'opigno_commerce_app_apps_app_configure_form',
  );
}

/**
 * Configuration form.
 */
function opigno_commerce_app_apps_app_configure_form($form, &$form_state) {
  $form['sell_types'] = array(
    '#type' => 'fieldset',
    '#title' => t("Sellable items"),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#tree' => TRUE,
  );

  foreach (node_type_get_types() as $type => $type_info) {
    if (og_is_group_type('node', $type)) {
      $form['sell_types'][$type] = array(
        '#type' => 'checkbox',
        '#title' => t("Enable selling %type", array('%type' => $type_info->name)),
        '#default_value' => variable_get("opigno_commerce_app_type_{$type}_enabled", FALSE),
      );
    }
  }

  $form['payment_methods'] = array(
    '#type' => 'fieldset',
    '#title' => t("Payment methods"),
    '#description' => t("The following payment methods are available for your site."),
    '#tree' => TRUE,
  );

  $payment_methods = commerce_payment_methods();  

  if (!empty($payment_methods)) {
    $show_submit = TRUE;
    foreach ($payment_methods as $key => $info) {
      // Get the rules config.
      $rules_id = 'commerce_payment_' . $payment_methods[$key]['method_id'];
      $rules_config = rules_config_load($rules_id);
      $rules_element = rules_element_load(3, $rules_id); // It seems all payment methods always have the payment component with an ID of 3. But make sure it's always the case.

      $form['payment_methods'][$key] = array(
        '#type' => 'fieldset',
        '#title' => $info['title'] . ' (' . ($rules_config->active ? t("active") : t("disabled")) . ')',
        '#description' => $info['description'],
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
      );

      $form['payment_methods'][$key]['#rules_config'] = $rules_config;
      $form['payment_methods'][$key]['#rules_element'] = $rules_element;

      $form['payment_methods'][$key]['enable'] = array(
        '#type' => 'checkbox',
        '#title' => t("Enable this payment method"),
        '#default_value' => $rules_config->active,
      );

      // Fetch the rule configuration form.
      $rules_element->form($form['payment_methods'][$key], $form_state, array('button' => FALSE));

      // Hide the order select field and make the payment settings "hidable".
      $form['payment_methods'][$key]['parameter']['commerce_order']['#attributes']['class'][] = 'element-hidden';
      $form['payment_methods'][$key]['parameter']['payment_method']['#states']['visible'] = array(
        '#edit-payment-methods-' . str_replace('_', '-', $key) . '-enable' => array('checked' => TRUE),
      );
    }
  }
  else {
    $form['payment_methods']['#description'] = '<em>' . t("You currently have no payment methods enabled. You can go to <a href='!url'>this site</a> to find a payment method that suits your needs. Then you can download and install it and come back here to configure it.", array('!url' => 'http://www.drupalcommerce.org/extensions/module/payment')) . '</em>';
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t("Save"),
  );

  return $form;
}

/**
 * Validation callback for opigno_commerce_app_apps_app_configure_form().
 */
function opigno_commerce_app_apps_app_configure_form_validate($form, &$form_state) {
  foreach ($form_state['values']['payment_methods'] as $key => $payment_method_values) {
    $rules_form_state = opigno_commerce_app_map_form_state_values($form_state, $key);
    $form['payment_methods'][$key]['#rules_element']->form_validate($form, $rules_form_state);
  }
}

/**
 * Submit callback for opigno_commerce_app_apps_app_configure_form().
 */
function opigno_commerce_app_apps_app_configure_form_submit($form, $form_state) {
  foreach ($form_state['values']['payment_methods'] as $key => $payment_method_values) {
    // Save settings.
    $rules_form_state = opigno_commerce_app_map_form_state_values($form_state, $key);
    $form['payment_methods'][$key]['#rules_element']->form_submit($form, $rules_form_state);
    
    // Enable / disable payment method.
    $form['payment_methods'][$key]['#rules_config']->active = !!$form_state['values']['payment_methods'][$key]['enable'];
    $form['payment_methods'][$key]['#rules_config']->save();
    if ($form_state['values']['payment_methods'][$key]['enable']) {
      drupal_set_message(t("Enabled the %name payment method.", array('%name' => $form['payment_methods'][$key]['#title'])));
    }
    else {
      drupal_set_message(t("Disabled the %name payment method.", array('%name' => $form['payment_methods'][$key]['#title'])));
    }
  }

  foreach ($form_state['values']['sell_types'] as $type => $value) {
    variable_set("opigno_commerce_app_type_{$type}_enabled", !!$value);
    if ($value) {
      opigno_commerce_app_enable_type($type);
    }
  }
}


function opigno_commerce_app_map_form_state_values($form_state, $key) {
  $rules_form_state = $form_state;
  $rules_form_state['values'] = $form_state['values']['payment_methods'][$key];
  return $rules_form_state;
}
