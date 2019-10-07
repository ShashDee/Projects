<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Widget extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('widgets/widget_model');
	}

	function load_widgets()
	{
		$this->load->view('widgets/welcome_widget');

		$this->widget_foundation();
	}

	function widget_foundation()
	{
		$this->load->view('widgets/widget_foundation');
	}

	function load_left_column()
	{
		$this->load->view('widgets/event_list_widget');		
	}

	function load_right_column()
	{
		$this->load->view('widgets/checklist_widget');
	}

	function load_top_column()
	{
		$this->load->view('widgets/event_no_widget');
		$this->load->view('widgets/checklist_no_widget');
		$this->load->view('widgets/exp_checklist_no_widget');

		if($this->session->userdata('user_group') == "admin")
			$this->load->view('widgets/meeting_no_widget');
	}

	function fetch_event_count()
	{
		echo json_encode($this->widget_model->fetch_event_count());
	}

	function fetch_event_list()
	{
		echo json_encode($this->widget_model->fetch_event_list());
	}

	function fetch_checklist()
	{
		echo json_encode($this->widget_model->fetch_checklist());
	}

	function fetch_checklist_count()
	{
		echo json_encode($this->widget_model->fetch_checklist_count());
	}

	function fetch_meeting_count()
	{
		echo json_encode($this->widget_model->fetch_meeting_count());
	}

	function fetch_exp_checklist_count()
	{
		echo json_encode($this->widget_model->fetch_exp_checklist_count());
	}
}