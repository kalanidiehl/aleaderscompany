<?php
$_SESSION['location_message'] = "Your Location: ";
if (!isset($_COOKIE["LLI_REGION"])) {
  if (!isset($_SESSION['region'])) {

    if (isset($_SESSION['ip_geoloc']['location']['country_code'])) {
      $result = views_get_view_result('sales_regions', 'block_2');
      $_SESSION['region'] = $result[0]->node_title;
      setcookie("LLI_REGION", $_SESSION['region'], time() + 86400, "/");
      // $_SESSION['location_message'] .= "New Detection -> ". $_SESSION['ip_geoloc']['location']['formatted_address'];
      //$_SESSION['location_message'] .= "<br> Region set to: " . $_SESSION['region'];

    }
    else {
      if (isset($_GET['region'])) {
        $_SESSION['region'] = $_GET['region'];
        setcookie("LLI_REGION", $_SESSION['region'], time() + 86400, "/");
        //$_SESSION['location_message'] .= "Chosen Region -> " . $_SESSION['region'];
      }
    }


  }
  else {
    setcookie("LLI_REGION", $_SESSION['region'], time() + 86400, "/");
    //$_SESSION['location_message'] .= "Already Detected -> ". $_SESSION['ip_geoloc']['location']['formatted_address'];
    //$_SESSION['location_message'] .= "<br>Already Detected Region -> " . $_SESSION['region'];
  }

}
else {
  $_SESSION['region'] = $_COOKIE['LLI_REGION'];
  if (isset($_SESSION['ip_geoloc']['location']['formatted_address'])) {
    $_SESSION['location_message'] .= "Already Detected -> " . $_SESSION['ip_geoloc']['location']['formatted_address'];
  }
  //$_SESSION['location_message'] .= "<br>Already Detected Region -> " . $_SESSION['region'];
}


require_once 'inc/preprocess/button.inc';
require_once 'inc/preprocess/password.inc';
require_once 'inc/preprocess/textarea.inc';
require_once 'inc/preprocess/textfield.inc';
require_once 'inc/preprocess/webform.inc';
require_once 'inc/preprocess/field.inc';
require_once 'inc/preprocess/shortcodes.inc';
require_once 'inc/process/comment.inc';
require_once 'inc/theme/form-element.theme.inc';


function eight_preprocess_page(&$variables) {

  //remember to remove this code later
  //drupal_set_message(t($_SESSION['location_message']),'status',False);

  $checkbox_style = theme_get_setting('check_switch_style');
  $layout_style = theme_get_setting('eight_style_layout');
  $color_page = theme_get_setting('eight_color');

  drupal_add_js([
    'theme_eight' => [
      'checkbox_style' => $checkbox_style,
      'layout_style' => $layout_style,
      'color_page' => $color_page,
    ],
  ], 'setting');

  drupal_add_css(drupal_get_path('module', 'nd_visualshortcodes') . '/css/drupal.css');
  drupal_add_js(drupal_get_path('module', 'nd_visualshortcodes') . '/js/shortcodes_frontend.js', ['group' => JS_THEME]);
  $logo_mobile = file_load(variable_get('eight_logo_mobile'));
  $variables['logo_mobile'] = isset($logo_mobile) ? $logo_mobile : '';
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-xs-12 col-sm-6 col-md-6"';
  }
  elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-xs-12 col-sm-6 col-md-9"';
  }
  else {
    $variables['content_column_class'] = ' class="col-md-12"';
  }

  //----only show this part if user is logged in----
  if ($variables['logged_in']) {
    // Create the OG context tabs if user role is admin or exec
    if (($variables['is_admin']) || (user_has_role('executive'))) {
      if (module_exists('og_context')) {
        $group = og_context('node');
        if (!empty($group['gid'])) {
          $tabs = [];

          foreach ([
                     "node/{$group['gid']}" => [
                       'title' => "",
                       'class' => 'eight-og-context-view-tab eight-og-context-home-tab',
                     ],
                     "node/{$group['gid']}/edit" => [
                       'class' => 'eight-og-context-view-tab eight-og-context-settings-tab',
                       'query' => ['destination' => current_path()],
                     ],
                     "node/{$group['gid']}/group" => [
                       'class' => 'eight-og-context-view-tab eight-og-context-users-tab',
                     ],
                     "node/{$group['gid']}/tools" => [
                       'class' => 'eight-og-context-view-tab eight-og-context-tools-tab',
                     ],
                     // Ajout du menu trier les cours - Cédric - 10.09.2014
                     "node/{$group['gid']}/sort_courses" => [
                       'class' => 'eight-og-context-view-tab eight-og-context-sort-tab',
                     ],
                     // Ajout du menu statistics
                     "node/{$group['gid']}/opigno-statistics" => [
                       'class' => 'eight-og-context-view-tab eight-og-context-opigno_group_statistics-tab',
                     ],
                   ] as $path => $override) {
            $link = menu_get_item($path);
            if (!empty($link) && $link['access']) {
              if (!empty($override['title'])) {
                $link['title'] = $override['title'];
              }
              if (!empty($override['class'])) {
                $link['options']['attributes']['class'][] = $link['localized_options']['attributes']['class'][] = $override['class'];
              }
              if (!empty($override['query'])) {
                if (!isset($link['options']['query'])) {
                  $link['options']['query'] = [];
                }
                if (!isset($link['localized_options']['query'])) {
                  $link['localized_options']['query'] = [];
                }
                $link['localized_options']['query'] += $override['query'];
                $link['options']['query'] += $override['query'];
              }
              $link['options']['attributes']['title'] = $link['localized_options']['attributes']['title'] = $link['title'];//Ajout Axel
              $link['title'] = ''; //Ajout Axel
              $tabs[] = [
                '#theme' => 'menu_local_task',
                '#link' => $link,
                '#active' => TRUE,
              ];
            }
          }
          // Modificaton 10.09.14 - Cédric Carrard
          //
          // Ajout des tools avec des icons dans le menu en haut à droite
          //
          //
          if ((isset($variables['node'])) && (og_is_group('node', $variables['node']))) {

            $groups = $variables['node'];

            foreach (opigno_get_node_tools($groups) as $tool) {

              $link = menu_get_item($tool['path']);

              if (!empty($link) && $link['access']) {
                if (!empty($tool['name'])) {
                  $link['title'] = '';//$tool['name']; Ajout Axel
                }
                if (!empty($tool['machine_name'])) {
                  $link['options']['attributes']['class'][] = $link['localized_options']['attributes']['class'][] = 'eight-og-context-view-tab eight-og-context-' . $tool['machine_name'] . '-tab';
                }
                if (!empty($tool['query'])) {
                  if (!isset($link['options']['query'])) {
                    $link['options']['query'] = [];
                  }
                  if (!isset($link['localized_options']['query'])) {
                    $link['localized_options']['query'] = [];
                  }
                  $link['localized_options']['query'] += $tool['query'];
                  $link['options']['query'] += $tool['query'];
                }
                $link['options']['attributes']['title'] = $link['localized_options']['attributes']['title'] = $tool['name'];//Ajout Axel
                $tabs[] = [
                  '#theme' => 'menu_local_task',
                  '#link' => $link,
                  '#active' => TRUE,
                ];
              }
            }
          }
          else {
            $group = og_context('node');

            if (current_path() !== "node/{$group['gid']}") {

              $node = node_load($group['gid']);
              foreach (opigno_get_node_tools($node) as $tool) {
                $link = menu_get_item($tool['path']);
                if (!empty($link) && opigno_tool_access($tool)) {
                  if (!empty($tool['name'])) {
                    $link['title'] = '';//$tool['name']; Ajout Axel
                  }
                  if (!empty($tool['machine_name'])) {
                    $link['options']['attributes']['class'][] = $link['localized_options']['attributes']['class'][] = 'eight-og-context-view-tab eight-og-context-' . $tool['machine_name'] . '-tab';
                  }
                  if (!empty($tool['query'])) {
                    if (!isset($link['options']['query'])) {
                      $link['options']['query'] = [];
                    }
                    if (!isset($link['localized_options']['query'])) {
                      $link['localized_options']['query'] = [];
                    }
                    $link['localized_options']['query'] += $tool['query'];
                    $link['options']['query'] += $tool['query'];
                  }
                  $link['options']['attributes']['title'] = $link['localized_options']['attributes']['title'] = $tool['name'];//Ajout Axel
                  $tabs[] = [
                    '#theme' => 'menu_local_task',
                    '#link' => $link,
                    '#active' => TRUE,
                  ];
                }
              }
            }

          }
          if (!empty($tabs)) {
            if (isset($variables['node']) && !eight_display_tabs($variables['node'])) {
              unset($variables['tabs']['#primary']);
            }
            $variables['og_context_navigation'] = render($tabs);
          }
          if (isset($variables['node']) && $variables['node']->nid == $group['gid']) {
            // $variables['hide_tabs'] = TRUE;
            $variables['is_og_node'] = TRUE;
          }
        }
      }
    }
    // Remove primary tabs on course and lesson nodes
    $current_path = explode('/', drupal_get_path_alias());

    if ((end($current_path) == "group") || (isset($variables['node']) && (($variables['node']->type == 'course') || ($variables['node']->type == 'class') || ($variables['node']->type == 'quiz')))) {
      unset($variables['tabs']['#primary']);
    }

    if (isset($variables['group_state'])) {
      $variables['group_state'] = eight_render_group_state($variables['group_state']);
    }
  }
  //----END OF only show this part if user is logged in and an admin----

}


function eight_preprocess_node(&$variables) {
  //$variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];

  if ($variables['node']->type == 'course') {
    $variables['theme_hook_suggestions'][] = 'node__products__' . $variables['view_mode'];
  }
  $variables['classes_array'][] = 'view-' . $variables['view_mode'];
  $variables['link_node'] = base_path() . drupal_get_path_alias('node/' . $variables['node']->nid);
  /*---------START HERE added by Sascha from Opigno*/
  if (og_is_member('node', $variables['node']->nid) && $variables['view_mode'] == "full") {
    $variables['theme_hook_suggestions'][] = 'node__coursemember';

    $variables['base_path'] = base_path();
    if (defined('OPIGNO_COURSE_BUNDLE') && !empty($variables['node']->type) && in_array($variables['node']->type, [
        OPIGNO_COURSE_BUNDLE,
        'class',
      ]) && ($variables['view_mode']) != 'teaser') {
      $variables['content']['fields'] = [
        '#weight' => -100,
        '#prefix' => '<div class="node-course-other-fields node-course-more-info">',
        '#suffix' => '</div>',
      ];

      $variables['fields'][0]['opigno_course_image']['#label_display'] = 'hidden';

      if (isset($variables['content']['opigno_course_image'])) {
        $variables['content']['fields'][0]['opigno_course_image'] = $variables['content']['opigno_course_image'];
      }
      elseif (isset($variables['content']['opigno_class_image'])) {
        $variables['content']['fields'][0]['opigno_course_image'] = $variables['content']['opigno_class_image'];
      }

      if (!empty($variables['content']['body'])) {
        $variables['content']['fields'][1]['body'] = $variables['content']['body'];
      }

      $variables['content']['fields'][0]['opigno_course_image']['#label_display'] = 'hidden';
      $variables['content']['fields'][0]['opigno_course_image'][0]['#image_style'] = 'course_intro_image';

      $variables['content']['fields'][1]['body']['#prefix'] = '<div class="body-field"><div class="label">' . t('Description') . '</div><div class="content">';
      $variables['content']['fields'][1]['body']['#suffix'] = '</div></div>';

      if (
        !empty($variables['content']['group_group'][0]['#options']['attributes']['class'][0])
        && $variables['content']['group_group'][0]['#options']['attributes']['class'][0] == 'group unsubscribe'
      ) {
        unset($variables['content']['group_group'][0]);
      }

      if (isset($variables['content']['product:commerce_price'])) {
        $variables['content']['group_group'][0]['#options']['attributes']['class'][0] = 'group buy';
        $variables['content']['group_group'][0]['#title'] = t('Add to cart');
      }
      $variables['content']['group_group']['#label_display'] = 'hidden';

      foreach ($variables['content'] as $key => $item) {
        if ($key != 'fields' && $key != 'group_group') {
          unset($variables['content'][$key]);
        }
      }

      $roles = og_get_user_roles('node', $variables['node']->nid);
      foreach ($roles as $role) {
        $variables['classes_array'][] = str_replace(' ', '-', $role);
      }

      if (user_access('administer nodes')) {
        $variables['classes_array'][] = 'is-admin';
      }
    }

    if (module_exists('quiz') && $variables['node']->type == 'quiz') {
      global $user;
      $variables['passed_quiz'] = _eight_check_user_passed_quiz($variables['node'], $user);
    }
  }
  //----------END OF ADDED BY SASCHA------------*/
  // Flippy node

  $block_flippy = '';
  if (module_exists('flippy')) {
    // Render block flippy by Content Type

    $block_flippy = module_invoke('flippy', 'block_view', 'flippy_pager-node_type-' . $variables['type']);
    if ($block_flippy) {
      $variables['flippy'] = render($block_flippy['content']);
    }
  }
  $fields = array_filter_key("/^field_(\w+)/", $variables['content']);
}


function eight_preprocess_block(&$variables) {

  $block = $variables['block'];
  $variables['block']->subject = isset($variables['block']->subject) ? html_entity_decode($variables['block']->subject) : $variables['block']->title;
  switch ($block->region) {
    case 'sidebar_first':
    case 'sidebar_second':
      $variables['title_attributes_array']['class'][] = 'widget-title';
      break;
    case 'footer_first':
    case 'footer_second':
    case 'footer_third':
    case 'footer_four':
    case 'footer_five':
      $variables['block']->subject = $variables['block']->subject . '<span class="divider"></span>';
      $variables['classes_array'][] = 'widget-footer';
      break;
  }

  //list($field,$field_name) = explode(':','field_products:field_size_product');
  if ($block->module == 'facetapi') {

  }

}

function eight_form_commerce_cart_add_to_cart_form_alter(&$form, &$form_state, $view_mode = NULL) {
  if (!isset($form_state['#nid'])) {
    $form_state['#nid'] = get_display_node_by_product_id($form['product_id']['#value'], 'field_products');
  }
  if (isset($form_state['#nid'])) {
    $form['#nid'] = get_display_node_by_product_id($form['product_id']['#value'], 'field_products');
  }
  $param = drupal_get_query_parameters();
  //  unset($form['#theme'][array_search('commerce_cart_add_to_cart_form', $form['#theme'])]);
  if (isset($param['mode']) && !empty($param['mode'])) {
    $form['#theme'][] = 'commerce_cart_add_to_cart_form_' . $param['mode'];
  }
  else {
    if (isset($form_state['context']) && isset($form_state['context']['view_mode'])) {
      $form['#theme'][] = 'commerce_cart_add_to_cart_form_' . $form_state['context']['view_mode'];
    }
  }
}


function eight_theme() {
  $items['commerce_cart_add_to_cart_form_node_full'] = [
    'render element' => 'form',
    'template' => 'commerce-cart-add-to-cart-form-full',
    'path' => drupal_get_path('theme', 'eight') . '/templates/commerce',
  ];
  $items['commerce_cart_add_to_cart_form_node_teaser'] = [
    'render element' => 'form',
    'template' => 'commerce-cart-add-to-cart-form-teaser',
    'path' => drupal_get_path('theme', 'eight') . '/templates/commerce',
  ];
  $items['textfield_qty'] = [
    'render element' => 'element',
  ];

  $items['form_element_none'] = [
    'render element' => 'element',
  ];

  $items['item_list_facetapi_size'] = [
    'template' => 'item-list-facetapi-size',
    'variables' => isset($items['item_list']) ? $items['item_list']['variables'] : NULL,
    'path' => drupal_get_path('theme', 'eight') . '/templates/facetapi',
  ];
  $items['item_list_facetapi_color'] = [
    'template' => 'item-list-facetapi-color',
    'variables' => isset($items['item_list']) ? $items['item_list']['variables'] : NULL,
    'path' => drupal_get_path('theme', 'eight') . '/templates/facetapi',
  ];
  $items['facetapi_link_inactive_size'] = [
    'template' => 'facetapi-link-inactive-size',
    'variables' => isset($items['facetapi_link_inactive']) ? $items['facetapi_link_inactive']['variables'] : NULL,
    'path' => drupal_get_path('theme', 'eight') . '/templates/facetapi',
  ];
  $items['facetapi_link_inactive_color'] = [
    'template' => 'facetapi-link-inactive-color',
    'variables' => isset($items['facetapi_link_inactive']) ? $items['facetapi_link_inactive']['variables'] : NULL,
    'path' => drupal_get_path('theme', 'eight') . '/templates/facetapi',
  ];
  $items['facetapi_link_active_color'] = [
    'template' => 'facetapi-link-active-color',
    'variables' => isset($items['facetapi_link_active']) ? $items['facetapi_link_active']['variables'] : NULL,
    'path' => drupal_get_path('theme', 'eight') . '/templates/facetapi',
  ];
  $items['facetapi_link_active_size'] = [
    'template' => 'facetapi-link-active-size',
    'variables' => isset($items['facetapi_link_active']) ? $items['facetapi_link_active']['variables'] : NULL,
    'path' => drupal_get_path('theme', 'eight') . '/templates/facetapi',
  ];

  $items['contact_page'] = [
    'render element' => 'form',
    'template' => 'contact-page',
    'path' => drupal_get_path('theme', 'eight') . '/templates/contact',
  ];

  $items['mod_background'] = [
    'variables' => isset($items['mod_background']) ? $items['mod_background']['variables'] : NULL,
    'template' => 'block-mod-background',
    'path' => drupal_get_path('theme', 'eight') . '/templates/mod_background_page',
  ];
  $items['views_exposed_form__product_display'] = [
    'render element' => 'form',
    'template' => 'views-exposed-form--product-display',
    'path' => drupal_get_path('theme', 'eight') . '/templates/views/views-exposed',
  ];
  $items['search_api_ranges_block_slider_view_form'] = [
    'render element' => 'form',
    'template' => 'search-api-ranges-slider-form',
    'path' => drupal_get_path('theme', 'eight') . '/templates/search-api-ranges',
  ];
  $items['contact_one_page'] = [
    'render element' => 'form',
    'template' => 'contact-one-page',
    'path' => drupal_get_path('theme', 'eight') . '/templates/contact',
  ];
  $items['contact_landing_page'] = [
    'render element' => 'form',
    'template' => 'contact-landing-page',
    'path' => drupal_get_path('theme', 'eight') . '/templates/contact',
  ];
  return $items;
}

function eight_form_search_block_form_alter(&$form, &$form_state, $form_id) {

  $form['search_block_form']['#attributes']['class'][] = 'search-field';
  $form['search_block_form']['#attributes']['placeholder'] = t('Search . . .');
  $form['search_block_form']['#theme_wrappers'] = ['form_element_none'];

}

function theme_textfield_qty($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, [
    'id',
    'name',
    'value',
    'size',
    'maxlength',
  ]);
  _form_set_class($element, ['form-text']);

  $extra = '';
  if ($element['#autocomplete_path'] && !empty($element['#autocomplete_input'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = [];
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#autocomplete_input']['#id'];
    $attributes['value'] = $element['#autocomplete_input']['#url_value'];
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';

  return $output . $extra;
}


function eight_form_comment_form_alter(&$form, &$form_state) {

  $form['actions']['submit']['#attributes']['class'][] = 'cws-button';
  $form['actions']['preview']['#attributes']['class'][] = 'cws-button';
}


function eight_preprocess_contact_page(&$variables) {


  _handler_contact_site_form($variables);

}


function eight_preprocess_contact_one_page(&$variables) {


  $variables['name']['#attributes']['class'][] = 'form-control';
  _handler_contact_site_form($variables);
}

function eight_preprocess_contact_landing_page(&$variables) {
  _handler_contact_site_form($variables);
}

function _handler_contact_site_form(&$variables) {

  $variables['form']['name']['#prefix'] = '<div class="row"><div class="col-md-6">';
  $variables['form']['mail']['#prefix'] = '</div><div class="col-md-6">';
  $variables['form']['mail']['#suffix'] = '</div></div>';
  $variables['form']['actions']['submit']['#attributes']['class'] = ['cws-button border-radius pull-right'];
  $variables['form']['message']['#resizable'] = FALSE;

  // $contact_info = theme_get_setting('contact_info');

  $variables['contact_info'] = theme_get_setting('contact_info');

  $infowindow = theme_get_setting('map_infowindow');

  $icon_marker = file_load(variable_get('eight_marker_map'));

  $longitude = variable_get('eight_longitude_map', '');

  $latitude = variable_get('eight_latitude_map', '');

  $icon_marker->uri = file_create_url($icon_marker->uri);

  $infowindow['value'] = str_replace(["\n", "\r"], '', $infowindow['value']);

  drupal_add_css(drupal_get_path('theme', 'eight') . '/theme-settings/autoaddress-map.css');
  drupal_add_js('//maps.googleapis.com/maps/api/js?key=AIzaSyDmj-tJRlVsYZo7ef4nDIzY8U7t0Sefp_A&libraries=places', 'external');
  drupal_add_js(drupal_get_path('theme', 'eight') . '/theme-settings/autoaddress-map.js', [
    'type' => 'file',
    'cache' => FALSE,
    'weight' => 50,
  ]);
  drupal_add_js([
    'eight' => [
      'eight_longitude_map' => $longitude,
      'eight_latitude_map' => $latitude,
      'marker' => $icon_marker,
      'infowindow' => $infowindow,
    ],
  ], 'setting');
}

function eight_block_view_alter(&$data, $block) {

  if ($block->module == 'menu' && $block->region == 'navigation') {
    $data['content']['#theme_wrappers'] = ['menu_tree__main_menu'];
  }

}

function eight_form_contact_site_form_alter(&$form, &$form_state) {
  $page_manager = page_manager_get_current_page();

  if (isset($page_manager) && isset($page_manager['handler'])) {


    switch ($page_manager['handler']->subtask) {
      case 'standart_slider':
        unset($form['#theme'][array_search('contact_site_form', $form['#theme'])]);
        $form['#theme'][] = 'contact_one_page';
        break;
      case 'page_video_fullscreen':
        unset($form['#theme'][array_search('contact_site_form', $form['#theme'])]);
        $form['#theme'][] = 'contact_landing_page';
        break;
    }

  }
  if (arg(0) == 'contact') {
    $form['#theme'][] = 'contact_page';
  }


}


function eight_menu_tree__main_menu(&$variables) {
  $page_manager = page_manager_get_current_page();

  if (isset($page_manager) && isset($page_manager['handler'])) {

    $menu_bar = '';
    switch ($page_manager['handler']->subtask) {
      case 'page_video_fullscreen':
        return ' <div class="inner-nav desktop-nav switch-menu"><ul class="clearlist">' . $variables['tree'] . '</ul><a href="#" class="menu-bar"><span class="ham"></span></a></div>';
        break;
      default:
        return ' <div class="inner-nav desktop-nav"><ul class="clearlist">' . $variables['tree'] . '</ul></div>';
        break;
    }
  }
  else {
    return ' <div class="inner-nav desktop-nav"><ul class="clearlist">' . $variables['tree'] . '</ul></div>';
  }

}

function eight_menu_link__main_menu(&$variables) {
  $element = &$variables['element'];
  $sub_menu = '';
  if (isset($element['#below']) && count($element['#below']) > 0) {
    $variables['element']['#below']['#theme_wrappers'] = ['menu_tree__sub_menu'];
    $element['#localized_options']['attributes']['class'][] = 'mn-has-sub';
    $element['#localized_options']['html'] = TRUE;
    $element['#title'] .= ' <i class="fa fa-angle-down button_open"></i>';

    $sub_menu = drupal_render($element['#below']);

  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  $active_item = '';
  if (strpos($output, "active") > 0) {
    $active_item = "active ";
  }

  if ($element['#original_link']['depth'] == "1") {
    $subclass = "";
    if (isset($element['#localized_options']['attributes']['class'])) {
      $subclass = implode(" ",$element['#localized_options']['attributes']['class']);
    }
    $output = "<div class='main_menu_link_wrapper " . $active_item . $subclass  . "'>" . $output . "</div>";
  }

  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>";
}

function eight_menu_tree__sub_menu(&$variables) {
  return '<ul class="mn-sub">' . $variables['tree'] . '</ul>';
}

/** Alter Webform ID "Send Mail" */

function eight_form_webform_client_form_7_alter(&$form, &$form_state) {

  $form['#prefix'] = '<div class="contact-form alt clear-fix">';
  $form['#suffix'] = '</div>';
  $form['actions']['submit']['#attributes']['class'] = ['cws-button full-width'];

}

function eight_form_lang_dropdown_form_alter(&$form, &$form_state) {
  $form['lang_dropdown_select']['#attributes']['class'][] = 'lang-change';
}

/** Alter Views Exposed Form Blog Page 4 */
function eight_form_views_exposed_form_alter(&$form, &$form_state) {

  if ($form['#id'] == 'views-exposed-form-blog-page-4') {

    $form['title']['#attributes']['class'][] = 'search-field';
    $form['title']['#attributes']['placeholder'] = t('Search...');
    $form['button_sumit'] = [
      '#markup' => '<button type="submit" class="search-submit"><i class="flaticon-magnifying-glass34"></i></button>',
    ];
    $form['submit']['#attributes']['class'][] = 'js-hide';

  }
  if (preg_match('/^views-exposed-form-product*/', $form['#id'])) {

    $form['sort_by']['#attributes']['class'][] = 'orderby';
    $form['sort_order']['#attributes']['class'][] = 'orderby small';
  }

  if ($form['#id'] == 'views-exposed-form-glossary-view-search-block') {
    $form['combine']['#attributes'] = array('placeholder' => array(t('Search...')));
  }
}

function eight_form_views_form_commerce_cart_form_default_alter(&$form, &$form_state) {

  $form['actions']['submit']['#attributes']['class'] = ['cws-button'];
  $form['actions']['checkout']['#attributes']['class'] = ['cws-button'];
}

function eight_form_search_api_ranges_block_slider_view_form_alter(&$form, &$form_state) {
  $form['submit']['#value'] = t('Filter');
}

function eight_commerce_price_savings_formatter_inline(&$variables) {
  $output = '<div class="price">';
  $prices = $variables['prices'];
  if (isset($prices['price'])) {
    $output .= $prices['price']['#markup'];
  }
  if (isset($prices['list'])) {
    $output .= '<span class="old-price">' . $prices['list']['#markup'] . '</span>';
  }
  if (isset($prices['savings'])) {
    $output .= '<span class="discount">' . $prices['savings']['#markup'] . '</span>';
  }
  $output .= '</div>';
  return $output;
}

function eight_preprocess_username(&$variables) {
  if (empty($variables['attributes_array']['xml:lang'])) {
    unset($variables['attributes_array']['xml:lang']);
  }
}

/**
 * Returns HTML for the active facet item's count.
 * theme_facetapi_count()
 *
 * @param $variables
 *
 * @return string
 */

function eight_facetapi_count($variables) {
  return '<span class="counter-facet">(' . (int) $variables['count'] . ')</span>';
}

/**
 * Return HTML for deactivate widget
 *
 * @param $variables
 * theme_facetapi_deactive_widget();
 *
 * @return string
 */

function eight_facetapi_deactivate_widget(&$variables) {
  return '<span class=deactive">(-)</span>';
}

/**
 * theme_facetapi_link_active()
 *
 * @param $variables
 *
 * @return string
 */
/*
function eight_facetapi_link_active(&$variables)
{
    // Sanitizes the link text if necessary.
    $sanitize = empty($variables['options']['html']);
    $link_text = ($sanitize) ? check_plain($variables['text']) : $variables['text'];

    // Theme function variables fro accessible markup.
    // @see http://drupal.org/node/1316580
    $accessible_vars = array(
        'text' => $variables['text'],
        'active' => TRUE,
    );

    // Builds link, passes through t() which gives us the ability to change the
    // position of the widget on a per-language basis.
    $replacements = array(
        '!facetapi_deactivate_widget' => theme('facetapi_deactivate_widget', $variables),
        '!facetapi_accessible_markup' => theme('facetapi_accessible_markup', $accessible_vars),
        '!facetapi_text_active' => '<span class="text-active">'.$link_text.'</span>',
    );
    $variables['text'] = t('!facetapi_deactivate_widget !facetapi_accessible_markup !facetapi_text_active', $replacements);
    $variables['options']['html'] = TRUE;
    $variables['options']['attributes']['class'][] = 'active';
    return theme_link($variables);
}


function eight_preprocess_item_list(&$variables){


    if(isset($variables['attributes']['id']) && strpos($variables['attributes']['id'],'field-size') !== false ){

        $variables['theme_hook_suggestions'][] = 'item_list_facetapi_size';

    }
    if(isset($variables['attributes']['id']) && strpos($variables['attributes']['id'],'field-color') !== false ){

        $variables['theme_hook_suggestions'][] = 'item_list_facetapi_color';
    }
}

*/

function eight_preprocess_facetapi_link_inactive(&$variables) {


  $arr_query = explode(':', urldecode($variables['options']['query']['f'][0]));
  if (preg_grep('/^field_size/', $arr_query)) {

    //$variables['link'] = theme_link($variables);

    $variables['options']['attributes']['class'][] = 'size';
    // $variables['theme_hook_suggestions'][] = 'facetapi_link_inactive_size';
  }
  if (preg_grep('/^field_color/', $arr_query)) {
    //$variables['link'] = theme_link($variables);
    //$variables['theme_hook_suggestions'][] = 'facetapi_link_inactive_color';
  }
  if (preg_grep('/^field_tags/', $arr_query)) {

    unset($variables['count']);
    //        $variables['options']['attributes']['class'][] = 'tag';
  }

}

/*
function eight_preprocess_facetapi_link_active(&$variables){

    $arr_query = explode(':',urldecode($variables['options']['query']['f'][0]));
    if(preg_grep('/^field_size/',$arr_query)){

        $variables['link'] = theme_link($variables);
        $variables['theme_hook_suggestions'][] = 'facetapi_link_active_size';
    }
    if(preg_grep('/^field_color/',$arr_query)){
        $variables['theme_hook_suggestions'][] = 'facetapi_link_active_color';
    }
    if(preg_grep('/^field_tags/',$arr_query)){

    }

}
*/
function array_filter_key($matches, array $array) {
  $matchedKeys = preg_grep($matches, array_keys($array));
  return array_intersect_key($array, array_flip($matchedKeys));
}

function eight_form_commerce_checkout_form_checkout_alter(&$form, &$form_state) {

  $form['#attributes']['class'][] = 'form';
  $customer_address = $form['customer_profile_billing']['commerce_customer_address']['und'];

  $form['customer_profile_billing']['commerce_customer_address']['#prefix'] = '<div class="row"><div class="col-md-12">';
  $form['customer_profile_billing']['commerce_customer_address']['#suffix'] = '</div></div>';
  $form['customer_profile_billing']['commerce_customer_address']['und'][0]['country']['#attributes']['class'][] = 'form-control';
  $form['customer_profile_billing']['commerce_customer_address']['und'][0]['name_block']['name_line']['#attributes']['class'][] = 'form-submit';
  $form['buttons']['continue']['#prefix'] = '<div class="clearfix">';
  $form['buttons']['continue']['#attributes']['class'] = ['btn-submit-form form-submit pull-left'];
  $form['buttons']['cancel']['#attributes']['class'] = ['btn-submit-form form-submit pull-right'];
  $form['buttons']['cancel']['#prefix'] = '&nbsp;';
  $form['buttons']['cancel']['#suffix'] = '</div>';
}

function eight_form_commerce_checkout_form_review_alter(&$form, &$form_state) {
  $form['#attributes']['class'][] = 'form';

  $form['commerce_payment']['payment_method']['#prefix'] = '<div class="row"><div class="col-xs-12">';
  $form['commerce_payment']['payment_method']['#suffix'] = '</div>';

  $form['commerce_payment']['payment_details']['credit_card']['number']['#prefix'] = '<div class="col-xs-12">';
  $form['commerce_payment']['payment_details']['credit_card']['number']['#suffix'] = '</div>';
  $form['commerce_payment']['payment_details']['credit_card']['number']['#attributes']['class'][] = 'input-text';

  $form['commerce_payment']['payment_details']['credit_card']['exp_month']['#prefix'] = '<div class="col-xs-12">';
  $form['commerce_payment']['payment_details']['credit_card']['exp_month']['#attributes']['class'][] = 'input-text auto';

  $form['commerce_payment']['payment_details']['credit_card']['exp_year']['#suffix'] = '</div></div>';
  $form['commerce_payment']['payment_details']['credit_card']['exp_year']['#attributes']['class'][] = 'input-text auto';

  $form['buttons']['continue']['#attributes']['class'][] = 'btn btn-submit-form pull-left';
  $form['buttons']['back']['#prefix'] = '&nbsp;';
  $form['buttons']['back']['#attributes']['class'][] = 'btn pull-right';
}

function eight_preprocess_commerce_line_item_summary(&$variables) {

}

/**
 * Themes the optional checkout review page data.
 */
function eight_commerce_checkout_review($variables) {
  $form = $variables['form'];

  // Turn the review data array into table rows.
  $rows = [];

  foreach ($form['#data'] as $pane_id => $data) {
    // First add a row for the title.
    $rows[] = [
      'data' => [
        ['data' => $data['title'], 'colspan' => 2],
      ],
      'class' => ['pane-title', 'odd'],
    ];

    // Next, add the data for this particular section.
    if (is_array($data['data'])) {
      // If it's an array, treat each key / value pair as a 2 column row.
      foreach ($data['data'] as $key => $value) {
        $rows[] = [
          'data' => [
            ['data' => $key . ':', 'class' => ['pane-data-key']],
            ['data' => $value, 'class' => ['pane-data-value']],
          ],
          'class' => ['pane-data', 'even'],
        ];
      }
    }
    else {
      // Otherwise treat it as a block of text in its own row.
      $rows[] = [
        'data' => [
          [
            'data' => $data['data'],
            'colspan' => 2,
            'class' => ['pane-data-full'],
          ],
        ],
        'class' => ['pane-data', 'even'],
      ];
    }
  }

  return '<div class="table-responsive">' . theme('table', [
      'rows' => $rows,
      'attributes' => ['class' => ['table checkout-review']],
    ]) . '</div>';
}

function get_display_node_by_product_id($product_id, $field_product = NULL) {

  if (!empty($field_product)) {
    $fields = field_info_fields();
    $query = new EntityFieldQuery;
    $result = $query->entityCondition('entity_type', 'node', '=');
    foreach ($fields as $name_field => $field) {
      if (isset($field['columns']['product_id']) && $field['type'] == 'commerce_product_reference' && preg_match('/field/', $field['field_name'])) {
        //$result->fieldCondition($field['field_name'],'product_id',$product_id ,'=');
        $result = $query->fieldCondition($field_product, 'product_id', $product_id, '=');
      }
    }
    $result = $query->range(0, 1)->execute();

    if (empty($result['node'])) {
      return FALSE;
    }
    return reset($result['node'])->nid;
  }
}

//addition changes and updates from platon template.php
function eight_theme_registry_alter(&$registry) {
  $path = drupal_get_path('theme', 'eight');
  $registry['opigno_tool']['template'] = "$path/templates/LMS/opigno--tool";
  $registry['opigno_tools']['template'] = "$path/templates/LMS/opigno--tools";
  $registry['opigno_tool']['theme path'] = $registry['opigno_tools']['theme path'] = $path;
}

/**
 * Checks if the tabs should be rendered
 */
function eight_display_tabs($node) {
  $types = [];
  if (module_exists("quiz")) {
    $types = array_keys(_quiz_question_get_implementations());
  }
  $types[] = "notification";
  $types[] = "calendar_event";
  if (in_array($node->type, $types)) {
    return TRUE;
  }
  return FALSE;
}

function eight_render_group_state($variables) {
  $empty = TRUE;
  $html = '<div id="opigno-group-progress">';

  if ($context = og_context()) {
    $context_node = node_load($context['gid']);
    $certif = $context_node->certificate['node_settings']['manual']['manual'];
    $progress = opigno_quiz_app_get_course_class_progression($context['gid']);
    $score = opigno_quiz_app_get_course_class_score_average($context['gid']);
  }

  if (opigno_quiz_app_course_class_passed($context_node->nid)) {
    $class = 'ok';
  }
  else {
    $class = 'nok';
  }

  $html .= '<div class="opigno-group-status"><div class="text">';

  /*if (isset($context_node) && opigno_quiz_app_course_class_passed($context_node->nid)) {
    $html .= '<div class="label">' . t('SUCCESSFUL') . '</div>';
  }
  else {
    $html .= '<div class="label">' . t('IN PROGRESS') . '</div>';
  }*/

  if (isset($score)) {
    $html .= '<div>' . t('Average score:') . ' ' . $score . '%</div>';
  }
  if (isset($progress)) {
    /*
     * <div class="content-bottom">
    <div class="progression">

      <?php if ($view->render_field('course_class_progress', $view->row_index) == "100") { ?>
          <span class="background" style="width: 100%; background: green"></span>
          <span class="text">Completed</span>
      <?php } else { ?>
          <span class="background"
                style="width:<?php print $view->render_field('course_class_progress', $view->row_index) ?>%;"></span>
          <span class="text">
      <?php print t('progress:') ?> <?php print $view->render_field('course_class_progress', $view->row_index) ?>
              %
    </span>
      <?php } ?>

    </div>
     *
     */
    if ($progress==100){
      $progressbar = "<span class=\"background\" style=\"width: 100%; background: green\"></span>
          <span class=\"text\">Completed</span>";
    }
    else
    {
      $progressbar = "<span class=\"background\" style=\"width:" . $progress . "%\"></span><span class=\"text\">Progress: ". $progress . "%</span>";
    }
    $html .= '<div class="progression">' . $progressbar . '</div>';
  }

  $html .= '</div></div>';

  if (isset($certif) && $certif != -1) {
    if (opigno_quiz_app_course_class_passed($context_node->nid)) {
      $html .= '<div class="opigno-group-certificate">
                    <div class="pictogram">
                      <a href="' . url('node/' . $context_node->nid . '/certificate') . '" class="item">x</a>
                    </div>
                    <div class="text">
                      <div class="label">' . t('YOUR CERTIFICATE') . '</div>
                    </div>
                  </div>';
    }
    else {
      $html .= '<div class="opigno-group-certificate">
                    <div class="pictogram inactive">
                      <span href="#" class="item">x</span>
                    </div>
                    <div class="text">
                      <div class="label">' . t('YOUR CERTIFICATE') . '</div>
                    </div>
                  </div>';
    }
  }

  uasort($variables['course'], 'drupal_sort_weight');
  foreach ($variables['course'] as $index => $tool) {
    $html .= '<div class="opigno-group-progress-course">';
    $course = node_load($index);
    $html .= l(check_plain($course->title), 'node/' . $course->nid);
    if (isset($tool['quiz'])) {
      $empty = FALSE;
      $html .= '<div class="opigno-group-progress-course-quiz">';
      $html .= $tool['quiz'];
      $html .= '</div>';
    }
    if (isset($tool['in-house-training'])) {
      $empty = FALSE;
      $html .= '<div class="opigno-group-progress-course-in-house-training">';
      $html .= $tool['in-house-training'];
      $html .= '</div>';
    }
    if (isset($tool['webex'])) {
      $empty = FALSE;
      $html .= '<div class="opigno-group-progress-course-webex">';
      $html .= $tool['webex'];
      $html .= '</div>';
    }
    if (isset($tool['live-meetings'])) {
      $empty = FALSE;
      $html .= '<div class="opigno-group-progress-course-live-meetings">';
      $html .= $tool['live-meetings'];
      $html .= '</div>';
    }
    $html .= '</div>';
  }
  $html .= '</div>';

  return $html;
}

function eight_form_alter(&$form, &$form_state, $form_id) {
  if (isset($form['#groups']['group_course_settings'])) {
    $form['#groups']['group_course_settings']->format_type = 'html-element';
    $form['#groups']['group_course_settings']->format_settings['instance_settings']['element'] = 'div';
    $form['#groups']['group_course_settings']->format_settings['instance_settings']['show_label'] = 0;
    $form['#groups']['group_course_settings']->format_settings['instance_settings']['label_element'] = 'div';
    $form['#groups']['group_course_settings']->format_settings['instance_settings']['classes'] = 'group-course-settings';
  }
}

function eight_form_quiz_question_answering_form_alter(&$form, $form_state) {
  $form['navigation']['#prefix'] = '<div class="quiz-question-navigation-wrapper">';
  $form['navigation']['#suffix'] = '</div>';
}

function _eight_check_user_passed_quiz($node, $user) {
  $res = db_query('
      SELECT qnp.nid, qnp.pass_rate, qnrs.score
      FROM {quiz_node_properties} qnp
      INNER JOIN {quiz_node_results} qnrs ON qnrs.vid = qnp.vid
      WHERE qnrs.uid = :uid AND qnrs.nid = :nid AND qnrs.is_evaluated = 1
      ORDER BY qnrs.result_id DESC',
    [':uid' => $user->uid, ':nid' => $node->nid]
  );
  // Check if one of the results is "passed".
  while ($line = $res->fetchAssoc()) {
    if ($line['score'] >= $line['pass_rate']) {
      return TRUE;
    }
  }
  return FALSE;
}


