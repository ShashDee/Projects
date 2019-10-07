<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('transaction/event_model'); //loading model
   	}

	function event_view() //loading the view
	{
		$data = $this->event_model->fetch_predata(); //getting initial data necessary from model
		$this->load->view('transaction/event_view', $data); //lloading the view and passing the data 
	}

	function fetch_halls() //fetching all halls
	{
		echo json_encode($this->event_model->fetch_halls()); //fethcing data from model and passing back to view
	}

	function fetch_customers()
	{
		echo json_encode($this->event_model->fetch_customers());
	}

	function fetch_suppliers()
	{
		echo json_encode($this->event_model->fetch_suppliers());
	}

	function fetch_sup_types()
	{
		echo json_encode($this->event_model->fetch_sup_types());
	}

	function reload_sequence()
	{
		echo json_encode($this->event_model->reload_sequence());
	}

	function save_event()
	{
		echo json_encode($this->event_model->save_event());
	}

	public function validate_activities($str)
	{
		return $this->event_model->validate_activities($str);
	}

	function event_lookup_view()
	{
		$data = $this->event_model->fetch_lookup_predata();
		$this->load->view('transaction/event_lookup_view', $data);
	}

	function fetch_events()
	{
		echo json_encode($this->event_model->fetch_events());
	}

	function validate_event()
	{
		echo json_encode($this->event_model->validate_event());
	}

	function fetch_event()
	{
		echo json_encode($this->event_model->fetch_event());
	}

	function validate_activity()
	{
		echo json_encode($this->event_model->validate_activity());
	}
}
