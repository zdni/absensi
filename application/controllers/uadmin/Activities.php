<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends Uadmin_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'uadmin';
	private $current_page = 'uadmin/activities/';
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Activity_services');
		$this->services = new Activity_services;
		$this->load->model(array(
			'activity_model',
			'activity_type_model',
		));

	}

	public function get_activity_type_list() {
		$activity_types = $this->activity_type_model->activity_types()->result();
		foreach ($activity_types as $key => $activity_type) {
		  $activity_type_list[$activity_type->id] = $activity_type->name; 
		}
		return $activity_type_list;
	  }

	public function index()
	{
		$activity_type_list = $this->get_activity_type_list();
		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->activity_model->activities()->result();
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		$add_menu = array(
			"name" => "Tambah Aktifitas",
			"modal_id" => "add_activity_",
			"button_color" => "primary",
			"url" => site_url($this->current_page . "add/"),
			"form_data" => array(
				"name" => array(
					'type' => 'text',
					'label' => "Nama Aktifitas",
					'value' => "",
				),
				"type_id" => array(
					'type' => 'select',
					'label' => "Jenis Aktifitas",
					'options' => $activity_type_list,
				),
				'data' => NULL
			),
		);

		$add_menu = $this->load->view('templates/actions/modal_form', $add_menu, true);
		
		$this->data["header_button"] =  $add_menu;
		
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Aktifitas";
		$this->data["header"] = "Daftar Aktifitas";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		$this->form_validation->set_rules( "name", "name", "trim|required" );
		$this->form_validation->set_rules( "type_id", "type_id", "required" );

        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['type_id'] = $this->input->post( 'type_id' );
			

			if( $this->activity_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->activity_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->activity_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->activity_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->activity_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page)  );
	}

	public function edit(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		$group_id = $this->input->post( 'group_id' );
		// echo var_dump( $data );return;
		$this->form_validation->set_rules( "name", "name", "trim|required" );
		$this->form_validation->set_rules( "type_id", "type_id", "required" );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['type_id'] = $this->input->post( 'type_id' );
			
			$data_param['id'] = $this->input->post( 'id' );

			if( $this->activity_model->update( $data, $data_param  ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->activity_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->activity_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->activity_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->activity_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page)  );
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
	  
		$data_param['id'] 	= $this->input->post('id');
		if( $this->activity_model->delete( $data_param ) ){
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->activity_model->messages() ) );
		}else{
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->activity_model->errors() ) );
		}
		redirect( site_url($this->current_page )  );
	  }
}
