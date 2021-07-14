<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activities extends Employee_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'employee';
	private $current_page = 'employee/activities/';
	
	public function __construct(){
		parent::__construct();
		$this->load->model([
			'activity_state_model',
			'activity_model',
			'activity_type_model',
			'employee_activity_model',
			'employee_model'
		]);

	}
	public function index()
	{
		$activities_states = $this->activity_state_model->activity_states()->result();
		$activities_types = $this->activity_type_model->activity_types()->result();
		// var_dump(  );
		// die;

		$this->data['activities_states'] = $activities_states;
		$this->data['activities_types'] = $activities_types;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Aktivitas";
		$this->data["header"] = "Input Aktivitas";
		$this->data["url"] = $this->current_page . 'add';
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "employee/activity" );
	}

	public function add() {
		if( !($_POST) ) redirect(site_url(  $this->current_page ));  
		
		$this->form_validation->set_rules( "result", "result", "required" );
		$this->form_validation->set_rules( "description", "description", "required" );
		$this->form_validation->set_rules( "start_time", "start_time", "required" );
		$this->form_validation->set_rules( "end_time", "end_time", "required" );

        if ($this->form_validation->run() === TRUE )
        {
			$data['employee_id'] = $this->employee_model->get_employee_by_user_id( $this->session->userdata('user_id') )->row()->employee_id;
			$data['activity_id'] = $this->input->post( 'activity_id' );
			$data['state_id'] = $this->input->post( 'type_id' );
			$data['result'] = $this->input->post( 'result' );
			$data['date'] = date( 'Y-m-d' );
			$data['start_time'] = date( "Y-m-d H:i:m", strtotime( $_POST['date'] . $_POST['start_time'] ) );
			$data['end_time'] = date( "Y-m-d H:i:m", strtotime( $_POST['date'] . $_POST['end_time'] ) );
			$data['description'] = $this->input->post( 'description' );

			// minutes
			$data['minutes'] = ( date_create( $data['start_time'] )->diff( date_create( $data['end_time'] ) ) )->i;

			if( $this->employee_activity_model->create( $data ) ){
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->employee_activity_model->messages() ) );
			}else{
				$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->employee_activity_model->errors() ) );
			}
		}
        else
        {
          $this->data['message'] = (validation_errors() ? validation_errors() : ($this->m_account->errors() ? $this->employee_activity_model->errors() : $this->session->flashdata('message')));
          if(  validation_errors() || $this->employee_activity_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		}
		
		redirect( site_url($this->current_page)  );
	}

	public function get_activity_list(  ) {
		$type_id = $this->input->post('type_id', TRUE);
		$activities = $this->activity_model->get_activity_by_type( $type_id )->result();
		// var_dump( $activities );
		echo json_encode( $activities );
	}
}
