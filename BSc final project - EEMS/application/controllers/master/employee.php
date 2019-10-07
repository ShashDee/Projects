<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('master/employee_model');
   	}

	function employee_view()
	{
		$this->load->view('master/employee_view');
	}

	function save_employee()
	{
		echo json_encode($this->employee_model->save_employee());
	}

	public function validate_skills($str)
	{
		return $this->employee_model->validate_skills($str);
	}

	function employee_lookup_view()
	{
		$data = $this->employee_model->fetch_lookup_predata();
		$this->load->view('master/employee_lookup_view', $data);
	}

	function fetch_employees()
	{
		echo json_encode($this->employee_model->fetch_employees());
	}

	function quick_toggle_emp_status()
	{
		echo json_encode($this->employee_model->quick_toggle_emp_status());
	}

	function fetch_employee()
	{
		echo json_encode($this->employee_model->fetch_employee());
	}

	function check_tasks()
	{
		echo json_encode($this->employee_model->check_tasks());
	}
}
