<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_type extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('config/event_type_model');
   	}

	function event_type_view()
	{
		$data = $this->event_type_model->fetch_predata();
		$this->load->view('config/event_type_view', $data);
	}

	function save_event_type()
	{
		echo json_encode($this->event_type_model->save_event_type());
	}

	function reload_sequence()
	{
		echo json_encode($this->event_type_model->reload_sequence());
	}

	function event_type_lookup_view()
	{
		$this->load->view('config/event_type_lookup_view');
	}

	function fetch_event_types()
	{
		echo json_encode($this->event_type_model->fetch_event_types());
	}

	function fetch_event_type()
	{
		echo json_encode($this->event_type_model->fetch_event_type());
	}

	function quick_toggle_evt_status()
	{
		echo json_encode($this->event_type_model->quick_toggle_evt_status());
	}
}
