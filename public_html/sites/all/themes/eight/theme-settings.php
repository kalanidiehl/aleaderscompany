<?php

function eight_form_system_theme_settings_alter(&$form,&$form_state, $form_id = NULL) {
    // Get all themes.
    $themes = list_themes();
    // Get the current theme
    $active_theme = $GLOBALS['theme_key'];
    $form_state['build_info']['files'][] = str_replace("/$active_theme.info", '', $themes[$active_theme]->filename) . '/theme-settings.php';

    $form['eight_settings'] = array(
        '#type' => 'vertical_tabs',
        '#prefix' =>'<div class="oss_vertical_tab"><div class="oss_bg_header"><span class="label-setting">'.t('Theme settings').'</div>',
        '#suffix' =>'</div>',
        '#weight' => -10,
        '#attributes' => array(
            'class' => array('vertical_settings')
        )
    );
    $form['drupal_core_settings'] = array(
        '#type' => 'fieldset',
        '#title' => 'Drupal core',
        '#group' => 'eight_settings',
        '#weight' => 99,
        '#attributes' => array(
            'class' => array('drupal_core')
        )
    );
    // Logo Mobile
    $form['logo']['settings']['logo_mobile'] = array(
        '#type' => 'managed_file',
        '#title' => t('Upload Logo Mobile'),
        '#description' => t("If you don't have direct file access to the server, use this field to upload your logo mobile."),
        '#default_value' => variable_get('eight_logo_mobile', ''),
        '#upload_location' => 'public://logo_mobile/',
        '#upload_validators' => array(
            'file_validate_extensions' => array('gif png jpg jpeg'),
        )
    );
    /** Move Core theme settings,Logo,Favicon to fieldset */
    $form['drupal_core_settings']['theme_settings'] = $form['theme_settings'];
    $form['drupal_core_settings']['logo'] = $form['logo'];
    $form['drupal_core_settings']['favicon'] = $form['favicon'];

    // Style

    $form['switcher_style'] = array(

        '#type' => 'fieldset',

        '#title' => t('Switcher Style'),

        '#group' => 'eight_settings'

    );

    $form['switcher_style']['check_switch_style'] = array(
        '#type' => 'checkbox',
        '#title' => t('Check to show tool Switcher Style'),
        '#default_value' => theme_get_setting('check_switch_style'),
        '#prefix' => '<div class="default-checkboxs">',
        '#suffix' => '</div>'
    );

    $form['switcher_style']['eight_style_layout'] = array(
        '#type' => 'select',
        '#title' => 'Layout Style',
        '#options' => array('wide' => 'Wide','boxed' => 'Boxed'),
        '#default_value' => theme_get_setting('eight_style_layout'),
    );


        $form['switcher_style']['eight_color'] = array(
            '#type' => 'textfield',
            '#title' => 'Color',
            '#default_value' => theme_get_setting('eight_color'),
            '#attributes' => array('class' => array('colorpicker-enable')),
            '#prefix' => '<div class="row"><div class="col-sm-4">',
            '#suffix' => '</div>',
        );




    // Contact

    $form['contact'] = array(

        '#type' => 'fieldset',

        '#title' => t('Contact'),

        '#group' => 'eight_settings',

    );

    $form['contact']['map_contact'] = array(

        '#type' => 'fieldset',

        '#title' => t('Google Map'),

        '#collapsible' => False,

        '#collapsed' => TRUE

    );

    $form['contact']['map_contact']['info_map'] = array(

        '#markup'=> '<div id="infoPanel">

                    <b>Marker status:</b>

                    <div id="markerStatus"><i>Click and drag the marker.</i></div>

                    <b>Current position:</b>

                    <div id="info"></div>

                   

                  </div>'

    );

    $form['contact']['map_contact']['address_map'] = array(

        '#type' => 'textfield',

        '#title' => t('Address Map'),

        '#description' => t('Input automatic search address map'),

        '#default_value' => theme_get_setting('address_map'),

        '#attributes' => array(

            'id' =>'map_auto_contact',

        ),

    );



    $longitude = variable_get('eight_longitude_map','');

    $latitude =  variable_get('eight_latitude_map','');



    $form['contact']['map_contact']['bt_map'] = array(

        '#markup'=>'<input class="form-submit" type="button" value="Geocode" onclick="codeAddress()">'

    );

    $form['contact']['map_contact']['latitude_map'] = array(

        '#type' => 'hidden',

        '#default_value' => $latitude,

        '#attributes' => array(

            'id' => 'latitude_map',

        )

    );

    $form['contact']['map_contact']['longitude_map'] = array(

        '#type' => 'hidden',

        '#default_value' => $longitude,

        '#attributes' => array(

            'id' => 'longitude_map'

        )

    );

    $form['contact']['map_contact']['show_map'] = array(

        '#type' => 'markup',

        '#markup' => '<div id="address_map_contact"></div>',

    );



    $icon_marker = file_load(variable_get('eight_marker_map'));

    $form['contact']['map_contact']['marker_map'] = array(

        '#type' => 'managed_file',

        '#title' => t('Icon Maker'),

        '#description' => t('The uploaded image will be displayed marker map.'),

        '#default_value' => variable_get('eight_marker_map', ''),

        '#upload_location' => 'public://marker_map/',

        '#upload_validators' => array(

            'file_validate_extensions' => array('gif png jpg jpeg'),

            // Pass the maximum file size in bytes

            'file_validate_size' => array(10 * 1024 * 1024),

        )

    );

    $infowindow = theme_get_setting('map_infowindow');

    $form['contact']['map_contact']['map_infowindow'] = array(

        '#type' => 'text_format',

        '#title' => t('Info Window Map'),

        '#default_value' => isset($infowindow['value']) ? $infowindow['value'] : '',

        '#format' => isset($infowindow['format']) ? $infowindow['format'] : 'plain_text',

    );;

    if(isset($icon_marker)) {
        $icon_marker->uri = file_create_url($icon_marker->uri);
    }
    $infowindow['value'] = str_replace(array("\n", "\r"), '', $infowindow['value']);



    drupal_add_js('//maps.googleapis.com/maps/api/js?key=AIzaSyDmj-tJRlVsYZo7ef4nDIzY8U7t0Sefp_A&libraries=places', 'external');

    drupal_add_css(drupal_get_path('theme','eight').'/theme-settings/autoaddress-map.css');

    drupal_add_css(drupal_get_path('theme','eight').'/theme-settings/jquery.colorpicker.css');

    drupal_add_js(drupal_get_path('theme','eight').'/theme-settings/autoaddress-map.js',array('type'=>'file','cache'=>false,'scope'=>'footer'));

    drupal_add_js(array('eight'=>array('eight_longitude_map'=>$longitude,'eight_latitude_map'=>$latitude,'marker'=>$icon_marker,'infowindow'=>$infowindow)),'setting');

    drupal_add_css(base_path().drupal_get_path('theme','eight').'/theme-settings/theme-settings.css',array('preprocess'=>false));

    drupal_add_js(drupal_get_path('theme','eight').'/theme-settings/jquery.colorpicker.js',array('cache'=>false,'preprocess'=>false));

    drupal_add_js(drupal_get_path('theme','eight').'/theme-settings/theme-settings.js',array('cache'=>false,'preprocess'=>false));


    $contact_info = theme_get_setting('contact_info');

    $form['contact']['contact_info'] = array(

        '#type' => 'text_format',

        '#title' => t('Contact Info'),

        '#default_value' => $contact_info['value'],

        '#format' => $contact_info['format']

    );

    /** Unset  */
    unset($form['theme_settings']);
    unset($form['logo']);
    unset($form['favicon']);
    $form['#submit'][] = 'eight_form_system_theme_settings_submit';
}

function eight_form_system_theme_settings_submit(&$form,&$form_state)
{
    $values = $form_state['values'];
    if(isset($values['logo_mobile'])){
        _process_upload_img('eight_logo_mobile',$values['logo_mobile']);
    }
    if(isset($values['longitude_map']) && isset($values['latitude_map'])){

        variable_set('eight_longitude_map',$values['longitude_map']);

        variable_set('eight_latitude_map',$values['latitude_map']);

    }
    if(isset($values['marker_map'])){

        _process_upload_img('eight_marker_map',$values['marker_map']);

    }
}

function _process_upload_img($set_variable,$value){
    if ($value != 0) {
        $file = file_load((int)$value);
        if (!empty($file->fid)) {
            variable_set($set_variable, $file->fid);
            file_usage_add($file, 'eight', 'theme', $file->fid);
            $file->status = FILE_STATUS_PERMANENT;
            file_save($file);
        }
    } elseif ($value == 0) {
        $fid = (int)variable_get($set_variable);
        $file = file_load($fid);
        if (!empty($file)) {
            file_usage_delete($file, 'eight', 'theme', $fid);
            file_delete($file, TRUE);
            drupal_set_message(t('Old Image removed.'));
        }
    }
}