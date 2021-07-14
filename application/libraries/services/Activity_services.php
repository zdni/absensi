<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity_services
{
  function __construct(){
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }
  
  public function get_activity_type_list() {
    $this->load->model([
      'activity_type_model'
    ]);

    $activity_types = $this->activity_type_model->activity_types()->result();
    foreach ($activity_types as $key => $activity_type) {
      $activity_type_list[$activity_type->id] = $activity_type->name; 
    }
    return $activity_type_list;
  }

  public function get_table_config( $_page, $start_number = 1 )
  {
    $activity_type_list = $this->get_activity_type_list();
    $table["header"] = array(
        'name' => 'Nama Aktifitas',
        'type_name' => 'Jenis Aktifitas',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_",
                "url" => site_url( $_page."edit/"),
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
                        'type' => 'hidden',
                        'label' => "id",
                    ),
                    "name" => array(
                        'type' => 'text',
                        'label' => "Nama Aktifitas",
                    ),
                    "type_id" => array(
                      'type' => 'select',
                      'label' => "Jenis Aktifitas",
                      'options' => $activity_type_list,
                  ),
                ),
                "title" => "Aktifitas",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_",
                "url" => site_url( $_page."delete/"),
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
                ),
                "title" => "Aktifitas",
                "data_name" => "name",
              ),
    );
    return $table;
  }
  public function validation_config( ){
    $config = array(
        array(
          'field' => 'name',
          'label' => 'name',
          'rules' =>  'trim|required',
        ),
        array(
          'field' => 'type_id',
          'label' => 'type_id',
          'rules' =>  'required',
        ),
    );
    
    return $config;
  }
}
?>
