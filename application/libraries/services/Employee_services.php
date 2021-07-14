<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_services
{
  protected $id;
  protected $group_id;
  protected $group_name;
  protected $employee_id;
	protected $identity;
	protected $first_name;
	protected $last_name;
	protected $phone;
	protected $address;
	protected $email;
	protected $employee_id_number;
	protected $position_name;
	protected $organization_name;
	protected $religion_name;
  protected $position_id;
	protected $organization_id;
	protected $religion_id;

  function __construct(){
    $this->id		              ='';
    $this->group_id		        ='';
    $this->group_name		      ='';
    $this->employee_id        ='';
    $this->identity		        ='';
    $this->first_name	        ="";
    $this->last_name	        ="";
    $this->phone		          ="";
    $this->address		        ="";
    $this->email		          ="";
    $this->employee_id_number ="";
    $this->position_name		  ="";
    $this->organization_name	="";
    $this->religion_name		  ="";
    $this->position_id  		  ="";
    $this->organization_id  	="";
    $this->religion_id  		  ="";

    $this->load->model([
      'position_model',
      'organization_model',
      'religion_model',
      'employee_model'
    ]);

  }

  public function __get($var)
  {
    return get_instance()->$var;
  }

  public function get_position_list() {
    $positions = $this->position_model->positions()->result();
    foreach ($positions as $key => $position) {
      $position_list[$position->id] = $position->name; 
    }
    return $position_list;
  }

  public function get_organization_list() {
    $organizations = $this->organization_model->organizations()->result();
    foreach ($organizations as $key => $organization) {
      $organization_list[$organization->id] = $organization->name; 
    }
    return $organization_list;
  }

  public function get_religion_list() {
    $religions = $this->religion_model->religions()->result();
    foreach ($religions as $key => $religion) {
      $religion_list[$religion->id] = $religion->name; 
    }
    return $religion_list;
  }

  public function get_group_list() {
    return [
      3 => 'employee'
    ];
  }

  public function get_photo_upload_config( $name = "_" )
  {
    $filename = "USER_".$name."_".time();
    $upload_path = 'uploads/users_photo/';

    $config['upload_path'] = './'.$upload_path;
    $config['image_path'] = base_url().$upload_path;
    $config['allowed_types'] = "gif|jpg|png|jpeg";
    $config['overwrite']="true";
    $config['max_size']="2048";
    $config['file_name'] = ''.$filename;

    return $config;
  }

  public function get_form_data( $user_id = -1 )
	{
    $position_list = $this->get_position_list();
    $organization_list = $this->get_organization_list();
    $religion_list = $this->get_religion_list();
    $group_list = $this->get_group_list();

		if( $user_id != -1 )
		{
			$user 				= $this->employee_model->employee( $user_id )->row();
			$this->identity		= $user->username;
			$this->first_name	= $user->first_name;
			$this->last_name	= $user->last_name;
			$this->phone		= $user->phone;
			$this->id			= $user->user_id;
			$this->group_id			= $user->group_id;
			$this->group_name			= $user->group_name;
			$this->employee_id			= $user->employee_id;
			$this->email		= $user->email;
			$this->address		= $user->address;
			$this->employee_id_number		= $user->employee_id_number;
      $this->position_id		= $user->position_id;
      $this->organization_id		= $user->organization_id;
      $this->religion_id		= $user->religion_id;
		}
		// echo var_dump($user);

		$groups = $this->ion_auth_model->groups(  )->result();

		$group_options ="";
		foreach($groups as $n => $item)
		{	
			
			$group_options .= form_radio("group_id", $item->id ,set_checkbox('group_id', $item->id), ' id="basic_checkbox_'.$n.'"');
			$group_options .= '<label for="basic_checkbox_'.$n.'"> '. $item->name .'</label><br>';
		}
		$data['groups'] = $group_options;
		$group_select = array();
		foreach( $groups as $group )
		{
			if( $group->id == 1 ) continue;
			$group_select[ $group->id ] = $group->name;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			  ),
        "employee_id" => array(
          'type' => 'hidden',
          'label' => "employee_id",
          'value' => $this->form_validation->set_value('employee_id', $this->employee_id),
          ),
			"first_name" => array(
			  'type' => 'text',
			  'label' => "Nama Depan",
			  'value' => $this->form_validation->set_value('first_name', $this->first_name),
			),
			"last_name" => array(
			  'type' => 'text',
			  'label' => "Nama Belakang",
			  'value' => $this->form_validation->set_value('last_name', $this->last_name),
			  
			),
			"address" => array(
				'type' => 'text',
				'label' => "Alamat",
				'value' => $this->form_validation->set_value('address', $this->address),			  
			),
			"email" => array(
			  'type' => 'text',
			  'label' => "Email",
			  'value' => $this->form_validation->set_value('email', $this->email),			  
			),
			"phone" => array(
			  'type' => 'number',
			  'label' => "Nomor Telepon",
			  'value' => $this->form_validation->set_value('phone', $this->phone),			  
			),
      "employee_id_number" => array(
			  'type' => 'number',
			  'label' => "NIP",
			  'value' => $this->form_validation->set_value('employee_id_number', $this->employee_id_number),			  
			),
      "position_id" => array(
			  'type' => 'select',
			  'label' => "Jabatan",
        'options' => $position_list,
        'selected' => $this->position_id
			),
      "organization_id" => array(
			  'type' => 'select',
			  'label' => "OPD",
        'options' => $organization_list,
        'selected' => $this->organization_id
			),
      "religion_id" => array(
			  'type' => 'select',
			  'label' => "Agama",
        'options' => $religion_list,
        'selected' => $this->religion_id
			),
      "group_id" => array(
			  'type' => 'select',
			  'label' => "Group",
        'options' => $group_list,
        'selected' => $this->group_id
			),
    );
		return $_data;
	}    
  
  public function get_table_config( $_page, $start_number = 1 )
  {
	// sesuaikan nama tabel header yang akan d tampilkan dengan nama atribut dari tabel yang ada dalam database
    $table["header"] = array(
			'username' => 'username',
			'user_fullname' => 'Nama Lengkap',
			'phone' => 'No Telepon',
			'address' => 'Alamat',
			'email' => 'Email',
		  );
		  $table["number"] = $start_number ;
		  $table[ "action" ] = array(
			array(
			  "name" => "Detail",
			  "type" => "link",
			  "url" => site_url($_page."detail/"),
			  "button_color" => "primary",
			  "param" => "employee_id",
			),
			array(
			  "name" => "Edit",
			  "type" => "link",
			  "url" => site_url($_page."edit/"),
			  "button_color" => "primary",
			  "param" => "employee_id",
			),
			array(
			  "name" => 'X',
			  "type" => "modal_delete",
			  "modal_id" => "delete_category_",
			  "url" => site_url( $_page."delete/"),
			  "button_color" => "danger",
			  "param" => "id",
			  "form_data" => array(
				"id" => array(
				  'type' => 'hidden',
				  'label' => "id",
				),
				"group_id" => array(
				  'type' => 'hidden',
				  'label' => "group_id",
				),
			  ),
			  "title" => "User",
			  "data_name" => "user_fullname",
			),
		);
    return $table;
  }

  /**
	 * get_form_data
	 *
	 * @return array
	 * @author madukubah
	 **/
	public function get_form_data_readonly( $user_id = -1 )
	{
		if( $user_id != -1 )
		{
			$user 				= $this->employee_model->employee( $user_id )->row();
			$this->identity		        =$user->username;
			$this->first_name	        =$user->first_name;
			$this->last_name	        =$user->last_name;
			$this->phone		          =$user->phone;
			$this->employee_id			  = $user->employee_id;
			$this->id			            =$user->user_id;
			$this->email		          =$user->email;
			$this->address		        =$user->address;
      $this->employee_id_number =$user->employee_id_number;
      $this->position_name		  =$user->position_name;
      $this->organization_name	=$user->organization_name;
      $this->religion_name		  =$user->religion_name;
      $this->group_name   		  =$user->group_name;

		}

		$groups =$this->ion_auth_model->groups(  )->result();
		$group_select = array();
		foreach( $groups as $group )
		{
			// if( $group->id == 1 ) continue;
			$group_select[ $group->id ] = $group->name;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			  ),
        "employee_id" => array(
          'type' => 'hidden',
          'label' => "employee_id",
          'value' => $this->form_validation->set_value('employee_id', $this->employee_id),
          ),
			"first_name" => array(
			  'type' => 'text',
			  'label' => "Nama Depan",
			  'value' => $this->form_validation->set_value('first_name', $this->first_name),
			),
			"last_name" => array(
			  'type' => 'text',
			  'label' => "Nama Belakang",
			  'value' => $this->form_validation->set_value('last_name', $this->last_name),
			),
			"email" => array(
			  'type' => 'text',
			  'label' => "Email",
			  'value' => $this->form_validation->set_value('email', $this->email),			  
			),
			"address" => array(
				'type' => 'text',
				'label' => "Alamat",
				'value' => $this->form_validation->set_value('address', $this->address),			  
			  ),
			"phone" => array(
			  'type' => 'number',
			  'label' => "Nomor Telepon",
			  'value' => $this->form_validation->set_value('phone', $this->phone),			  
			),
      "employee_id_number" => array(
			  'type' => 'number',
			  'label' => "NIP",
			  'value' => $this->form_validation->set_value('employee_id_number', $this->employee_id_number),			  
			),
      "position_name" => array(
			  'type' => 'text',
			  'label' => "Jabatan",
			  'value' => $this->form_validation->set_value('position_name', $this->position_name),			  
			),
      "organization_name" => array(
			  'type' => 'text',
			  'label' => "OPD",
			  'value' => $this->form_validation->set_value('organization_name', $this->organization_name),			  
			),
      "religion_name" => array(
			  'type' => 'text',
			  'label' => "Agama",
			  'value' => $this->form_validation->set_value('religion_name', $this->religion_name),			  
			),
      "group_name" => array(
			  'type' => 'text',
			  'label' => "Group",
			  'value' => $this->form_validation->set_value('group_name', $this->group_name),			  
			),
		  );
		return $_data;
	}

  public function get_validation_config()
	{
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');

		$config = array(
			array(
				'field' => 'first_name',
				 'label' => 'Nama Depan',
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'last_name',
				 'label' => 'Nama Belakang',
				 'rules' =>  'trim|required',
			),
			array(
				'field' => 'phone',
				 'label' =>('No Telepon'),
				 'rules' =>  'trim|required',
			),
			 array(
				'field' => 'group_id',
				 'label' => "User Group",
				 'rules' =>  'trim|required',
			 ),
		);
		
		return $config;
	}
}
?>
