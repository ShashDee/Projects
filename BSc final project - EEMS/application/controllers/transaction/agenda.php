<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('transaction/agenda_model');
   	}

	function agenda_view()
	{
		$data = $this->agenda_model->fetch_predata();
		$this->load->view('transaction/agenda_view', $data);
	}

	function fetch_agenda()
	{
		echo json_encode($this->agenda_model->fetch_agenda());
	}

	function save_agenda()
	{
		echo json_encode($this->agenda_model->save_agenda());
	}

	public function validate_items($str)
	{
		return $this->agenda_model->validate_items($str);
	}
}
