<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends Employee_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'employee';
	private $current_page = 'employee/log/';
	public function __construct(){
		parent::__construct();
		$this->load->model([
			'employee_activity_model',
			'employee_model'
		]);
	}
	public function index()
	{
		$employee_id = $this->employee_model->get_employee_by_user_id( $this->session->userdata('user_id') )->row()->employee_id;
		// $employee_id = 2;

		$activity_date = [];

		// $start_date = date( 'Y-m-d' );
		// $end_date = date( 'Y-m-d' );

		if( $_GET ){
			if( $_GET['start_date'] && $_GET['end_date'] ){
				$start_date = date( 'Y-m-d', strtotime( $_GET['start_date'] ) );
				$end_date = date( 'Y-m-d', strtotime( $_GET['end_date'] ) );
			
				$employee_activities = $this->employee_activity_model->employee_activity_by_date($employee_id, $start_date, $end_date)->result();
				foreach ($employee_activities as $key => $employee_activity) {
					$describe = "";
					if( $employee_activity->state_id == 1 ) {
						$describe = ' Belum di validasi';
					}
					if( $employee_activity->state_id == 2 ) {
						$describe = ' telah Tervalidasi oleh ' . $employee_activity->checked_employee_id;
					}
					if( $employee_activity->state_id == 3 ) {
						$describe = ' telah ditolak oleh ' . $employee_activity->checked_employee_id;
					}
					$activity_date[ $employee_activity->date ][] = [
						'color' => $employee_activity->color,
						'end_time' => $employee_activity->end_time,
						'describe' => 'Aktivitas ' . $employee_activity->activity_name . $describe
					]; 
					// $activity_date[ $employee_activity->date ][][ 'end_time' ] = $employee_activity->end_time;
					// $activity_date[ $employee_activity->date ][][ 'describe'] = 'Aktivitas ' . $employee_activity->activity_name . $describe;
				}	
			}
			// var_dump( $activity_date );
			// die;
		}


		$add_menu = array(
			"name" => "Filter Aktifitas",
			"modal_id" => "filter_activity_",
			"button_color" => "primary",
			"url" => site_url($this->current_page . "index"),
			"form_data" => array(
				"start_date" => array(
					'type' => 'date',
					'label' => "Tanggal Mulai",
				),
				"end_date" => array(
					'type' => 'date',
					'label' => "Tanggal Akhir",
				),
				'data' => NULL
			),
		);

		$add_menu = $this->load->view('templates/actions/modal_form_get', $add_menu, true);
		
		$this->data["header_button"] =  $add_menu;

		$this->data['activity_date'] = $activity_date;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Log Informasi";
		$this->data["header"] = "Log Informasi";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "employee/log" );
	}
}
