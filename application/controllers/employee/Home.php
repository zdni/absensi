<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Employee_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'employee';
	private $current_page = 'employee/home';
	public function __construct(){
		parent::__construct();
		$this->load->model([
			'employee_activity_model',
			'employee_model',
		]);
	}
	public function index()
	{
		$employee_id = $this->employee_model->get_employee_by_user_id( $this->session->userdata('user_id') )->row()->employee_id;

		$total_minutes_work 	= $this->employee_activity_model->get_total_minutes_work( $employee_id )->row();
		$activity_validated 	= $this->employee_activity_model->get_total_employee_activity( $employee_id, 2 )->row();
		$activity_not_responded	= $this->employee_activity_model->get_total_employee_activity( $employee_id, 1 )->row();
		$activity_rejected 		= $this->employee_activity_model->get_total_employee_activity( $employee_id, 3 )->row();

		$this->data['total_minutes'] 			= $total_minutes_work->total_minutes ? $total_minutes_work->total_minutes : 0;
		$this->data['activity_validated'] 		= $activity_validated->total_employee_activity;
		$this->data['activity_not_responded']	= $activity_not_responded->total_employee_activity;
		$this->data['activity_rejected'] 		= $activity_rejected->total_employee_activity;
		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->render( "employee/home" );
	}
}
