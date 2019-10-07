<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_summary_report extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('reports/event_summary_report_model'); //loading model
   	}

	function event_summary_report_view() //load view
	{
		$data = $this->event_summary_report_model->fetch_predata(); //fetch initial data
		$this->load->view('reports/event_summary_report_view', $data); //loading view with initial data
	}

	function fetch_event_progress() //fetch event progress
	{
		echo json_encode($this->event_summary_report_model->fetch_event_progress());
	}

	function fetch_buget_info() //fetch budget variance
	{
		echo json_encode($this->event_summary_report_model->fetch_buget_info());
	}

	function fetch_basic_info() //fetch basic info
	{
		echo json_encode($this->event_summary_report_model->fetch_basic_info());
	}

	function fetch_progress_rate() //fetch progress rate graph
	{
		echo json_encode($this->event_summary_report_model->fetch_progress_rate());
	}

	function fetch_activity_budget() //fetch event budget breakdown information
	{
		echo json_encode($this->event_summary_report_model->fetch_activity_budget());
	}
}
