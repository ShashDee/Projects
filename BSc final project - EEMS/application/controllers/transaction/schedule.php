<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('transaction/schedule_model');
   	}

	function schedule_view()
	{
		$data = $this->schedule_model->fetch_predata();
		$this->load->view('transaction/schedule_view', $data);
	}

	function fetch_events()
	{
		echo json_encode($this->schedule_model->fetch_events());
	}

	function save_meeting()
	{
		echo json_encode($this->schedule_model->save_meeting());
	}
}
