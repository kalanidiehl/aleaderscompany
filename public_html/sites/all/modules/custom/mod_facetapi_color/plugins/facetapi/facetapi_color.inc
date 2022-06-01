<?php
class FacetapiColorSwatchesWidget extends FacetapiWidgetLinks{

    public function init()
    {
        parent::init();
    }

    //TODO: this is a bit of a hack, prefered way of doing this?
    public function entity_info() {
        //TODO: how notify to Facet API if not supported for current field?
        $facet = facetapi_facet_load($this->settings->facet, $this->settings->searcher);
        //Provide api for this, alter?
        //TODO: entity reference etc
        //Utilize entity api?
        switch($facet['field type']) {
            case 'taxonomy_term':
                $field = field_info_field($facet['field api name']);
                $vocabulary = $field['settings']['allowed_values'][0]['vocabulary'];
                return array('taxonomy_term', $vocabulary);
            default:
                //TODO: handle this!
                return FALSE;
        }
    }

    public function color_fields() {
        list($entity_type, $bundle_name) = $this->entity_info();
        $instances = field_info_instances($entity_type, $bundle_name);
        $color_fields = array();
        foreach($instances as $key => $instance) {
             foreach($instance as $field_name => $instance_field)
             {
                 $field_info = field_info_field($field_name);

                 if($field_info['type'] === 'color_field_rgb') {
                     $color_fields[$field_name] = $instance_field;
                 }
             }

        }

        return $color_fields;
    }
    public function color_field_options() {
        $options = array();
        foreach($this->color_fields() as $field_name => $instance) {
            $options[$field_name] = t('!label (!field_name)', array('!field_name' => $field_name, '!label' => $instance['label']));
        }
        return $options;
    }
    /*
     *  Overrides FacetapiWidget::settingsForm().
     */
    function settingsForm(&$form,&$form_state){
        parent::settingsForm($form,$form_state);
        $form['widget']['widget_settings']['color_links'][$this->id]['color_field_name'] = array(
            '#type' => 'select',
            '#title' => t('Colors field'),
            '#default_value' => $this->settings->settings['color_field_name'],
            '#options' => $this->color_field_options(),
            '#description' => t('The Color field to use.'),
            '#states' => array(
                'visible' => array(
                    'select[name="widget"]' => array('value' => $this->id),
                ),
            ),
        );
        $form['widget']['widget_settings']['color_link'][$this->id]['color_width'] = array(
            '#type' => 'textfield',
            '#title' => t('Width'),
            '#default_value' => $this->settings->settings['color_width'],
            '#description' => t('The width for color'),
            '#states' => array(
                'visible' => array(
                    'select[name="widget"]' => array('value' => $this->id),
                ),
            ),
        );
        $form['widget']['widget_settings']['color_link'][$this->id]['color_height'] = array(
            '#type' => 'textfield',
            '#title' => t('Height'),
            '#default_value' => $this->settings->settings['color_height'],
            '#description' => t('The height for color'),
            '#states' => array(
                'visible' => array(
                    'select[name="widget"]' => array('value' => $this->id),
                ),
            ),
        );
    }

    /*
     *  Overrides FacetapiWidget::getDefaultSettings().
     */
    function getDefaultSettings()
    {
        return parent::getDefaultSettings()+ array(
            'color_field_name' => '',
            'color_width' => 50,
            'color_height' => 50
        );
    }

    function buildListItems($build)
    {

        $settings = $this->settings->settings;
        list($entity_type, $bundle_name) = $this->entity_info();
        // Initializes links attributes, adds rel="nofollow" if configured.
        $attributes = ($settings['nofollow']) ? array('rel' => 'nofollow') : array();
        $attributes += array('class' => $this->getItemClasses());

        // This is probably not very safe
        $entity_ids = array_keys($build);
        $entities = entity_load($entity_type, $entity_ids);

        // Builds rows.
        $items = array();
        foreach ($build as $value => $item) {
            $row = array('class' => array());

            // Allow adding classes via altering.
            if (isset($item['#class'])) {
                $attributes['class'] = array_merge($attributes['class'], $item['#class']);
            }
            $field_items = field_get_items($entity_type, $entities[$value], $settings['color_field_name']);
            $field_item = current($field_items);
            $item['#markup'] = theme('mod_color_swatches',array('color' => $field_item['rgb'],'width'=>$settings['color_width'],'height'=>$settings['color_height']));
            // Initializes variables passed to theme hook.
            unset($items['#count']);
            $variables = array(
                'text' => $item['#markup'],
                'path' => $item['#path'],
                'count' => $item['#count'],
                'options' => array(
                    'attributes' => $attributes,
                    'html' => true,
                    'query' => $item['#query'],
                ),
            );

            // Adds the facetapi-zero-results class to items that have no results.
            if (!$item['#count']) {
                $variables['options']['attributes']['class'][] = 'facetapi-zero-results';
            }

            // Add an ID to identify this link.
            $variables['options']['attributes']['id'] = drupal_html_id('facetapi-link');

            // If the item has no children, it is a leaf.
            if (empty($item['#item_children'])) {
                $row['class'][] = 'leaf';
            }
            else {
                // If the item is active or the "show_expanded" setting is selected,
                // show this item as expanded so we see its children.
                if ($item['#active'] || !empty($settings['show_expanded'])) {
                    $row['class'][] = 'expanded';
                    $row['children'] = $this->buildListItems($item['#item_children']);
                }
                else {
                    $row['class'][] = 'collapsed';
                }
            }

            // Gets theme hook, adds last minute classes.
            $class = ($item['#active']) ? 'facetapi-active' : 'facetapi-inactive';
            $variables['options']['attributes']['class'][] = $class;
            // Themes the link, adds row to items.
            $row['data'] = theme($item['#theme'], $variables);
            $items[] = $row;
        }

        return $items;
    }
}