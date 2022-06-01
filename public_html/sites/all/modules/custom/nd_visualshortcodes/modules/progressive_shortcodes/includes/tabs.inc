<?php

function progressive_shortcodes_tabs_shortcode_info(&$shortcodes)
{
    $shortcodes['tabs'] = array(
        'title' => t('Tabs container'),
        'description' => t('jQuery Tabs.'),
        'process callback' => 'progressive_shortcodes_shortcode_tabs',
        'process settings callback' => 'progressive_shortcodes_shortcode_tabs_settings',
        'tips callback' => 'progressive_shortcodes_shortcode_tabs_tip',
        'icon' => 'fa fa-folder-open',
        'child shortcode' => 'tab',
        'description_field' => 'type',
    );
    $shortcodes['tab'] = array(
        'title' => t('Tab'),
        'description' => t('Tab content.'),
        'process callback' => 'progressive_shortcodes_shortcode_tab',
        'process settings callback' => 'progressive_shortcodes_shortcode_tab_settings',
        'icon' => 'fa fa-folder',
        'description_field' => 'title',
    );
}

function progressive_shortcodes_shortcode_tabs($attrs, $text) {
    global $tab_content;
    $attrs['class'] = 'tabs ' . (isset($attrs['class']) ? $attrs['class'] : '') . (isset($attrs['type']) ? $attrs['type'] : '');
    $text = '<div ' . _progressive_shortcodes_shortcode_attributes($attrs)  . '>
    <ul class = "nav nav-tabs">' .
        $text .
        '</ul>
    <div class = "tab-content">' .
        $tab_content .
        '</div>
    <div class="clearfix"></div>
    </div>';
    $tab_content = '';
    return $text;
}

function progressive_shortcodes_shortcode_tabs_tip($format, $long) {
    $output = array();
    $output[] = '<p><strong>Tabs:</strong><br/>[tabs]<br/>[tab title = "title" icon = "fa fa-user"]Text[/tab]<br>[/tabs]</br>';
    $output[] = 'Available variables: <strong>title</strong> - tabs of the title, <strong>icon</strong> - font class of the icon.</p>';
    return implode(' ', $output);
}

function progressive_shortcodes_shortcode_tabs_settings($attrs, $text) {
    $types = array('' => t('Horizontal'), 'tabs-left' => t('Vertical Left'), 'tabs-right' => t('Vertical Right'));
    $form['type'] = array(
        '#type' => 'select',
        '#title' => t('Type'),
        '#options' => $types,
        '#default_value' => isset($attrs['type']) ? $attrs['type'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-4">',
        '#suffix' => '</div></div>'
    );
    return $form;
}
function progressive_shortcodes_shortcode_tab($attrs, $text) {
    global $tab_counter;
    global $tab_content;
    $tab_counter++;
    $attrs['class'] = isset($attrs['class']) ? $attrs['class'] : '';
    $attrs['class'] .= $tab_content == '' ? ' active' : '';
    $class = shortcode_add_class($attrs['class']);
    $icon = isset($attrs['icon']) ? '<i class = "' . $attrs['icon'] .'"></i>' : '';
    $output = '<li ' . _progressive_shortcodes_shortcode_attributes($attrs)  . '><a href = "#tab-' . $tab_counter . '" data-toggle = "tab">' . $icon . (isset($attrs['title']) ? $attrs['title'] : '') . '</a></li>';

    if($tab_content == '') {
        $class .= ' in';
    }
    $tab_content .= '<div class="tab-pane fade ' . $class .  '" id="tab-' . $tab_counter . '">' . $text . '</div>';

    return $output;
}

function progressive_shortcodes_shortcode_tab_settings($attrs, $text) {
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('Title'),
        '#default_value' => isset($attrs['title']) ? $attrs['title'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '<div class = "row"><div class = "col-sm-9">',
    );
    $form['icon'] = array(
        '#title' => t('Icon'),
        '#type' => 'textfield',
        '#autocomplete_path' => 'admin/ajax/nd_visualshortcodes/icons_autocomplete/all',
        '#default_value' => isset($attrs['icon']) ? $attrs['icon'] : '',
        '#attributes' => array('class' => array('form-control')),
        '#prefix' => '</div><div class = "col-sm-3">',
        '#suffix' => '</div></div>'
    );
    return $form;
}