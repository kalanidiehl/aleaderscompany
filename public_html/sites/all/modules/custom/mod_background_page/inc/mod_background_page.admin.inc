<?php

/*
 *  Overview page admin list
 */

function mod_background_page_list()
{
    /**
     *  Create header
     */
    $header = array(t('Title'),t('Thumbnail'),array('data' => t('Operations'),'colspan'=> '3'));
    $rows = array();

    $bg_list = MDBackgroundPage::getall();
    if($bg_list !== FALSE)
    {
        foreach($bg_list as $bg)
        {
            $data  = json_decode(base64_decode($bg->data));

            $image = file_load($data->settings->fid);
           // krumo($image);
            $variables = array(
              'path' => $image->uri,
              'width' => 200,
              'height' => 100,
                'alt'  => $image->alt,
              'title'  => $image->title,
              'attributes' => NULL
            );
            $row = array(check_plain($bg->title));
            $row[] = theme_image($variables);
            $row[] = array("data" => l(t('Edit'),'admin/structure/background-page/'.$bg->id.'/edit'));
            $row[] = array("data" => l(t('Delete'),'admin/structure/background-page/'.$bg->id.'/delete'));
            $rows[] = $row;
        }
    }
    $per_page = 20;
    // Initialize the pager
    $current_page = pager_default_initialize(count($rows), $per_page);
    // Split your list into page sized chunks
    $chunks = array_chunk($rows, $per_page, TRUE);
    $output = theme("table",array("header" => $header,"rows" => isset($chunks[$current_page]) ? $chunks[$current_page] : array() ,"empty" => t('No Data')));
    // Show the pager
    $output .= theme('pager', array('quantity',count($rows)));

    return $output;

}

/*
 *  Call back configure default form
 */

function mod_background_page_configure_default_form($form,&$form_state)
{
    $fid = variable_get('mod_background_default_page','');

    $form['background_default'] = array(
        '#type' => 'media',
        '#description' => t('Upload background image to page'),
        '#tree' => TRUE,
        '#default_value' => isset($fid) ? $fid : '',
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit')
    );
    return $form;
}

function mod_background_page_configure_default_form_submit($form,&$form_state)
{
    $values = $form_state['values'];
    variable_set('mod_background_default_page',$values['background_default']);
    drupal_set_message(t('Set default background page successful'),'status');
    $form_state['redirect'] = 'admin/structure/background-page';
}

/*
 *  Callback to create configure form for Background Page
 */

function mod_background_page_configure_form($form,&$form_state,$id="")
{
    // Get Background
    if(isset($id))
    {
        $background = MDBackgroundPage::get($id);
    }
    if($background !== FALSE)
    {

        $form_state["update_bg"] = $background;
        $data = json_decode(base64_decode($background->data));
        $data = $data->settings;
        $form['id'] = array(
            '#type' => 'hidden',
            '#value' => $background->id
        );
    }
    $form['title'] = array(
        '#type' => 'textfield',
        '#title' => t('Name'),
        '#description' => t('Input the name to page'),
        '#required' => TRUE,
        '#default_value' => isset($background->title) ? $background->title : '',
    );
   $form['background'] = array(
       '#type' => 'media',
       '#description' => t('Upload background image to page'),
       '#tree' => TRUE,
       '#default_value' => isset($data->fid) ? $data->fid : '',
   );
   $form['pages'] = array(
       '#type' => 'textarea',
       '#title' => t('Pages'),
       '#description' => t('Specify pages by using their paths. Enter one path per line.'),
       '#required' => TRUE,
       '#default_value' => isset($data->pages) ? implode("\n",$data->pages) : '',

   );
    if($background === FALSE) {
        $form['create'] = array(
            '#type' => 'submit',
            '#value' => t('Create'),
        );
    }
    else{
        $form['edit'] = array(
            '#type' => 'submit',
            '#value' => t('Edit')
        );
        $form['delete'] = array(
            '#type' => 'submit',
            '#value' => t('Delete')
        );
    }
    return $form;
}

/*
 *  Call form configure form submit
 */

function mod_background_page_configure_form_submit($form,&$form_state)
{
    //Set page title
    drupal_set_title(t('Configure Background Page'));
    $values = $form_state['values'];
    $data =  base64_encode(json_encode(array('settings'=>array('pages'=>explode("\n",$values['pages']),'fid'=>$values['background']))));
    if(isset($form_state['update_bg']))
    {
        // Update Background record
        $background = new MDBackgroundPage;
        $background->id    = $values['id'];
        $background->title = $values['title'];
        $background->data  = $data;

        // Save to database
        $response = $background->save();
    }
    else {
        // Create new background page

        $background = new MDBackgroundPage;
        $background->title = $values['title'];
        $background->data = $data;

        // Save to database
        $response = $background->save();
    }
    //
   switch($form_state["values"]["op"]) {
       case t("Create"):
           if ($response) {
               drupal_set_message(t("The background '{$values["title"]}' created successful"), 'status');
               $form_state['redirect'] = "admin/structure/background-page";
           }
           else
           {
               drupal_set_message(t("The background '{$values["title"]}' has been created unsuccessful"), 'error');
           }
           break;
       case t("Edit"):
           if ($response)
           {
               drupal_set_message(t("The background '{$values["title"]}' update successful"), 'status');
           }
           else
           {
               drupal_set_message(t("The background '{$values["title"]}' has been update unsuccessful"), 'error');
           }
           $form_state['redirect'] = "admin/structure/background-page";

           break;
       case t("Delete"):
           $form_state["redirect"] = "admin/structure/background-page/{$values['id']}/delete";
           $_GET["destination"] = NULL;
           break;
   }

}

/*
 *  Call method delete record
 */

function mod_background_page_delete($id)
{

    $background = MDBackgroundPage::get($id);
    if($background == FALSE)
    {
        drupal_set_message(t("'.$id.'not found in database"),'error');
        drupal_goto("admin/structure/background-page");
        return false;
    }
    else
    {
        $response = MDBackgroundPage::delete($id);
        if($response) {
            drupal_set_messages(t('Delete @title unsuccessful',array('@title'=>$background->title)),'status');
            drupal_goto("admin/structure/background-page");
        }
    }

}