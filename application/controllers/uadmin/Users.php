<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Uadmin_Controller 
{
	private $services = null;
    private $name = null;
    private $parent_page = 'uadmin';
	private $current_page = 'uadmin/users/';
	private $_user_groups = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->library('services/Employee_services');
		$this->services = new Employee_services;
		$this->_user_groups = array(
			"employee" => 'Pegawai',
		);
		$this->load->model(array(
			'employee_model',
			'position_model',
			'organization_model',
			'religion_model',
		));
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

	public function index( $id_user = NULL )
	{
		 // 
		 $page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		 //pagination parameter
		 $pagination['base_url'] = base_url( $this->current_page ) .'/index';
		 $pagination['total_records'] = $this->ion_auth->record_count() ;
		 $pagination['limit_per_page'] = 10;
		 $pagination['start_record'] = $page*$pagination['limit_per_page'];
		 $pagination['uri_segment'] = 4;
		 //set pagination
		 if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->employee_model->employees( $pagination['limit_per_page'], $pagination['start_record']  )->result();
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		$link_add = 
		array(
			"name" => "Tambah",
			"type" => "link",
			"url" => site_url( $this->current_page."add/"),
			"button_color" => "primary",	
			"data" => NULL,
		);
		$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_add, TRUE ); ;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "User Management";
		$this->data["header"] = "User Management";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add()
    {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->form_validation->set_rules( $this->services->get_validation_config() );
        $this->form_validation->set_rules('phone', "No Telepon", 'trim|required');
        $this->form_validation->set_rules('email', "Email", 'trim|required|is_unique[users.email]');

        if ( $this->form_validation->run() === TRUE )
        {
          $group_id = $this->input->post('group_id');

        //   $email = $this->input->post('email') ;
        //   $phone = $this->input->post('phone') ;
        //   $identity = $phone ;
		//   $password = $phone ;
		$email = $this->input->post('email') ;
		$identity = $email;
		$password = substr( $email, 0, strpos( $identity, "@" ) ) ;


          $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
          );
		}
		
		$identity_mode = NULL;

        if ($this->form_validation->run() === TRUE && ( $user_id =  $this->ion_auth->register($identity, $password, $email,$additional_data, [$group_id], $identity_mode ) ) )
        {
			$employee_data = array(
				'employee_id_number'=> $this->input->post('employee_id_number'),
				'position_id' 		=> $this->input->post('position_id'),
				'organization_id' 	=> $this->input->post('organization_id'),
				'religion_id' 		=> $this->input->post('religion_id'),
				'user_id' 			=> $user_id
			);
			$this->employee_model->create( $employee_data );

            $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
            // redirect( s_ite_url( $this->current_page.$this->ion_auth->group( $group_id )->row()->name)  );
            redirect( site_url( $this->current_page  )  );
        }
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Tambah User ";
			$this->data["header"] = "Tambah User ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data();
            $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;

            $this->data[ "contents" ] =  $form_data;
            
            $this->render( "templates/contents/plain_content_form" );
        }
	}

	public function edit( $employee_id = NULL )
    {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->form_validation->set_rules( $this->ion_auth->get_validation_config() );
        $this->form_validation->set_rules('phone', "No Telepon", 'trim|required');
		if ( $this->input->post('password') )
        {
            $this->form_validation->set_rules( 'password',"Kata Sandi",'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]' );            
            $this->form_validation->set_rules( 'password_confirm',"konfirmasi Kata Sandi",'trim|required'); 

        }
        if ( $this->form_validation->run() === TRUE )
        {
			$user_id = $this->input->post('id');
			$employee_id = $this->input->post('employee_id');
			$group_id = $this->input->post('group_id');
      
            $data = array(
              'first_name' => $this->input->post('first_name'),
              'last_name' => $this->input->post('last_name'),
              'email' => $this->input->post('email'),
              'phone' => $this->input->post('phone'),
              'group_id' => $this->input->post('group_id'),
            );
			
            if ( $this->input->post('password') )
            {
              $data['password'] = $this->input->post('password');
			}
			if( !$this->ion_auth->in_group( ["admin", "uadmin"] , $user_id ) )
			{
				$identity_mode = NULL;
			}
			// check to see if we are updating the user
			if ( $this->ion_auth->update( $user_id, $data, $identity_mode) )
			{
				$employee_data = array(
					'employee_id_number'=> $this->input->post('employee_id_number'),
					'position_id' 		=> $this->input->post('position_id'),
					'organization_id' 	=> $this->input->post('organization_id'),
					'religion_id' 		=> $this->input->post('religion_id')
				);
				$data_param['id'] = $employee_id;

				if ( $this->employee_model->update( $employee_data, $data_param ) )
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->employee_model->messages() ) );
					redirect( site_url( $this->current_page  )  );
				}
				else 
				{
					$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->employee_model->errors() ) );
					redirect( site_url($this->current_page)."edit/".$employee_id  );		
				}
              // redirect them back to the uadmin page if uadmin, or to the base url if non uadmin
            }
            else
            {
              // redirect them back to the uadmin page if uadmin, or to the base url if non uadmin
              $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );
              redirect( site_url($this->current_page)."edit/".$employee_id  );
            }
        }
        else
        {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            if(  !empty( validation_errors() ) || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

            $alert = $this->session->flashdata('alert');
			$this->data["key"] = $this->input->get('key', FALSE);
			$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
			$this->data["current_page"] = $this->current_page;
			$this->data["block_header"] = "Edit User ";
			$this->data["header"] = "Edit User ";
			$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

            $form_data = $this->services->get_form_data( $employee_id );
			$form_password[ 'form_data' ] = array(
				"password" => array(
				  'type' => 'password',
				  'label' => "Password",
				),
				"password_confirm" => array(
				  'type' => 'password',
				  'label' => "Konfirmasi Password",
				),
			);
			$form_data[ 'form_data' ] = array_merge( $form_data[ 'form_data' ] , $form_password[ 'form_data' ] );
			$form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;
            $this->data[ "contents" ] =  $form_data;
            $this->render( "templates/contents/plain_content_form" );
        }
	}

	public function detail( $employee_id = NULL )
	{
		if( !($employee_id) ) redirect(site_url('uadmin'));  

		$form_data = $this->services->get_form_data_readonly(  $employee_id );
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;

		$this->data[ "contents" ] =  $form_data;
		
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Detail User ";
		$this->data["header"] = "Detail User ";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

		$this->render( "templates/contents/plain_content" );
	}
	public function delete(  )
	{
		if( !($_POST) ) redirect(site_url('uadmin'));  

		$group_id 	= $this->input->post('group_id');
		$id_user 	= $this->input->post('id');

		if( $this->ion_auth->delete_user( $id_user ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );
		}
		redirect( site_url( $this->current_page  )  );
	}
}
