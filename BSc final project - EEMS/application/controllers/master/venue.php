<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venue extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('master/venue_model');
   	}

	function venue_view()
	{
		$data = $this->venue_model->fetch_predata();
		$this->load->view('master/venue_view', $data);
	}

	function reload_sequence()
	{
		echo json_encode($this->venue_model->reload_sequence());
	}

	function save_venue()
	{
		echo json_encode($this->venue_model->save_venue());
	}

	public function validate_entries($str)
	{
		return $this->venue_model->validate_entries($str);
	}

	function venue_lookup_view()
	{
		$this->load->view('master/venue_lookup_view');
	}

	function fetch_venues()
	{
		echo json_encode($this->venue_model->fetch_venues());
	}

	function quick_toggle_ven_status()
	{
		echo json_encode($this->venue_model->quick_toggle_ven_status());
	}

	function fetch_venue()
	{
		echo json_encode($this->venue_model->fetch_venue());
	}

	function check_events()
	{
		echo json_encode($this->venue_model->check_events());
	}
}
