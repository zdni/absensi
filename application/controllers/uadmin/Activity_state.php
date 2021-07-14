<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_state extends Uadmin_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'uadmin';
	private $current_page = 'uadmin/activity_state/';
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Activity_state_services');
		$this->services = new Activity_state_services;
		$this->load->model(array(
			'activity_state_model',
		));
	}

	public function index()
	{
		$table = $this->services->get_table_config( $this->current_page );
		$table[ "rows" ] = $this->activity_state_model->activity_states()->result();
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		$add_menu = array(
			"name" => "Tambah Status Aktifitas",
			"modal_id" => "add_activity_state_",
			"button_color" => "primary",
			"url" => site_url($this->current_page . "add/"),
			"form_data" => array(
				"name" => array(
					'type' => 'text',
					'label' => "Nama Status Aktifitas",
					'value' => "",
				),
				"color" => array(
					'type' => 'text',
					'label' => "Warna (dalam format hexa tanpa #)",
					'value' => "",
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
		$this->data["block_header"] = "Status Aktifitas";
		$this->data["header"] = "Daftar Status Aktifitas";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function add(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		$this->form_validation->set_rules( "name", "name", "trim|required" );

        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['color'] = $this->input->post( 'color' );
			

			if( $this->activity_state_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->activity_state_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->activity_state_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->activity_state_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->activity_state_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page)  );
	}

	public function edit(  )
	{
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  

		$this->form_validation->set_rules( "name", "name", "trim|required" );
        if ($this->form_validation->run() === TRUE )
        {
			$data['name'] = $this->input->post( 'name' );
			$data['color'] = $this->input->post( 'color' );
			
			$data_param['id'] = $this->input->post( 'id' );

			if( $this->activity_state_model->update( $data, $data_param  ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->activity_state_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->activity_state_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->activity_state_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->activity_state_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page)  );
	}

	public function delete(  ) {
		if( !($_POST) ) redirect( site_url($this->current_page) );
	  
		$data_param['id'] 	= $this->input->post('id');
		if( $this->activity_state_model->delete( $data_param ) ){
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->activity_state_model->messages() ) );
		}else{
		  $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->activity_state_model->errors() ) );
		}
		redirect( site_url($this->current_page )  );
	  }
}
