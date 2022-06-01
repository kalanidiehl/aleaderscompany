<?php

class MDBackgroundPage {
    public $id;
    public $title;
    public $data;


    /*
     *  Get field in database
     */
    public function getfield()
    {
        return array('title','data');
    }


    public static function __callStatic($name,$args)
    {
        return "No method $name ";
    }

    public function __call($name,$args)
    {
        return "No method $name ";
    }

    /*
    *  Get all record in database
    */
    public static function getall()
    {
        $result = db_select('mod_background_page','mbp')
            ->fields('mbp')
            ->execute();
        // Check result of query
        //if(count($result) == 0)
          if(!empty($result) == 0)
            return false;

        return $result;
    }

    /*
     *  Get record by id
     */
    public static function get($id)
    {
        $result = db_select("mod_background_page","mbp")
                  ->fields("mbp")
                  ->condition("id",$id)
                  ->execute()
                  ->fetchAll();
        if(count($result) !=1 )
            return FALSE;
        return array_shift($result);

    }

    /*
     *  Save field into database
     */
    public function save()
    {
        $fields = array();
        foreach($this->getfield() as $field)
        {
            $fields[$field] = $this->{$field};
        }
        if($this->id && $this->id > 0)
        {
            $response = db_update("mod_background_page")
                        ->fields($fields)
                        ->condition("id",$this->id)
                        ->execute();
        }
        else{
            $response = db_insert("mod_background_page")
                        ->fields($fields)
                        ->execute();
            if($response > 0)
            {
                $this->id = $response;
            }
        }

        return (boolean) $response;

    }

    /**
     *  Delete field database
     */
    public static function delete($id)
    {
        $result = db_delete('mod_background_page')
                 ->condition('id',$id)
                 ->execute();
        return (boolean) $result;
    }

    public static function check_url()
    {
        $list_url = array();
        $bg_list = MDBackgroundPage::getall();
        $path = strtolower(drupal_get_path_alias($_GET['q']));
        if($bg_list) {
            foreach ($bg_list as $background) {
                $data = json_decode(base64_decode($background->data));
                $list_url = $data->settings->pages;
                foreach ($list_url as $url) {
                    $pages = strtolower($url);
                    $page_match = drupal_match_path($path, $pages);
                    if ($path != $_GET['q']) {
                        $page_match = $page_match || drupal_match_path($_GET['q'], $pages);
                    }
                    if ($page_match) {
                        return $background;
                    }
                }

            }
        }


    }
}