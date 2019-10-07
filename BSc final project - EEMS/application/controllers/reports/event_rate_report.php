<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_rate_report extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('reports/event_rate_report_model');
   	}

	function event_rate_report_view()
	{
		$this->load->view('reports/event_rate_report_view');
	}

	function fetch_event_count()
	{
		echo json_encode($this->event_rate_report_model->fetch_event_count());
	}

	function fetch_event_count_graph()
	{
		echo json_encode($this->event_rate_report_model->fetch_event_count_graph());
	}

	function fetch_events()
	{
		echo json_encode($this->event_rate_report_model->fetch_events());
	}

	function fetch_event()
	{
		echo json_encode($this->event_rate_report_model->fetch_event());
	}
}
