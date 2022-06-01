<?php

function progressive_shortcodes_tabs_step_shortcode_info(&$shortcodes)
{
    $shortcodes['tabs_step'] = array(
        'title' => t('Tabs Step'),
        'description' => t('Tabs Step'),
        'process callback' => 'progressive_shortcodes_tabs_step',
        'process settings callback' => 'progressive_shortcodes_tabs_step_settings',
        'process backend callback' => 'nd_visualshortcodes_backend_nochilds',
        'icon' => 'fa fa-circle'
    );
}

function progressive_shortcodes_tabs_step_theme($theme){
    
    $theme['progressive_shortcodes_shortcode_tabs_step_settings'] = array(
        'render element' => 'form'
    );
    return $theme;
}

function progressive_shortcodes_tabs_step($attrs,$text)
{
    $output  = '';
    $rows    = array();
    $actives = array();
    $tab_text = array();
    foreach($attrs as $name => $value) {
        if(strpos($name, 'tab_title_') === 0) {
            $rows[] = $value;
        }
        if(strpos($name, 'tab_active_') === 0) {
            $actives[] = $value;
        }
        if(strpos($name, 'tab_text_') === 0) {
            $tab_text[] = $value;
        }
    }
    foreach($rows as $id => $row){
        $values[] = array(
            'title' => $row,
            'active' => $actives[$id],
            'tab_text'  => $tab_text[$id],
        );
    }

    $output.='<div class="de_tab tab_steps">';
        $output.='<ul class="de_nav">';


        foreach($values as $key => $el){
            $class_active = '';
            if($values[$key]['active'] == 1){
                $class_active = 'active';
            }

            $output .= '<li class="'.$class_active.' wow fadeIn" data-wow-delay="0s"><span>'.$el['title'].'</span><div class="v-border"></div>
                                    </li>';
        }
        $output.= '</ul>';
        $output.='<div class="de_tab_content">';
            foreach($values as $key => $el){
                $output.='<div id="'.drupal_html_id('tab').'">'.$el['tab_text'].'</div>';
            }
        $output.='</div>';

    $output.='</div>';

    return $output;
}

function progressive_shortcodes_tabs_step_settings($attrs,$text,$form, &$form_state)
{
    if(isset($form_state['values'])) {
        $attrs = $form_state['values'];
    }

    // Set count item
    $attrs['count_items'] = 0;
    foreach($attrs as $name => $value) {
        if(strpos($name, 'tab_title_') === 0) {
            $attrs['count_items']++;
        }
    }
    // Add new item
    if(isset($form_state['values'])) {
        if (isset($form_state['values']['op']) && $form_state['values']['op'] == t('Add new tab')) {
            $attrs['count_items']++;
        }
    }
    // Set default item is first
    $attrs['tab_title_1'] = isset($attrs['tab_title_1']) ? $attrs['tab_title_1'] : '';
    $ajax = array(
        'callback' => 'progressive_shortcodes_shortcode_tabs_step_ajax_callback',
        'wrapper' => 'nd_visualshortcodes_tabs_step',
        'effect' => 'fade',
        'method' => 'replace',
    );
    $form['tab_items'] = array(
        '#type' => 'container',
        '#attributes' => array('id' => array('nd_visualshortcodes_tabs_step')),
        '#theme' => 'progressive_shortcodes_shortcode_tabs_step_settings',
        '#attrs' => $attrs
    );

    // Process show line tab
    foreach($attrs as $name => $value) {
        if(strpos($name, 'tab_title_') === 0) {
            $i = str_replace('tab_title_', '', $name);
            $form['tab_items'] += progressive_shortcodes_shortcode_tab_step_item($attrs, $i);
        }
    }
    // Add new row
    if(isset($form_state['values'])) {

        if (isset($form_state['values']['op']) && $form_state['values']['op'] == t('Add new tab')) {

            $form['tab_items'] += progressive_shortcodes_shortcode_tab_step_item($attrs, ++$i);
        }

    }
    $form['add_new'] = array(
        '#type' => 'submit',
        '#value' => t('Add new tab'),
        '#submit' => array('progressive_shortcodes_tab_step_ajax_rebuild'),
        '#ajax' => $ajax
    );
    return $form;
}

function progressive_shortcodes_shortcode_tab_step_item($attr,$i){

    $form['tab_title_'.$i] = array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#default_value' => isset($attr['tab_title_'.$i]) ? $attr['tab_title_'.$i] :'',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-6">',


    );
    $form['tab_active_'.$i] = array(
        '#type' => 'checkbox',
        '#title' => t('Active'),
        '#default_value' => isset($attr['tab_active_'.$i]) ? $attr['tab_active_'.$i] :'',
        '#prefix' => '</div><div class="col-sm-6">',
        '#suffix' => '</div></div>'
    );


    $form['tab_text_'.$i] = array(
        '#type' => 'textarea',
        '#title' => t('Text'),
        '#default_value' => isset($attr['tab_text_'.$i]) ? $attr['tab_text_'.$i] :'',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class="row"><div class="col-sm-12">',
        '#suffix' => '</div></div>'
    );
    return $form;
}

function progressive_shortcodes_tab_step_ajax_rebuild($form,&$form_state){

    $form_state['rebuild'] = TRUE;
}

function progressive_shortcodes_shortcode_tabs_step_ajax_callback($form,&$form_state){
    return $form['shortcode']['settings']['tab_items'];
}


function theme_progressive_shortcodes_shortcode_tabs_step_settings($form){
    $header  = array(t('Tab Item'));
    $output  = '';
    $rows = array();
    // $header = array(t('Values'));
    foreach (element_children($form['form']) as $key) {
        if(strpos($key, 'tab_title_') === 0) {
            $i = str_replace('tab_title_', '', $key);
            $element = &$form['form'][$key];
            $row = array(render($element));
            $rows[] = $row;
        }
    }
    $output .= theme('table', array('rows' => $rows, 'header' => $header));

    return $output;
}