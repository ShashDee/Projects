<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('transaction/checklist_model');
   	}

   	function checklist_lookup_view()
   	{
   		$data = $this->checklist_model->fetch_lookup_predata();
   		$this->load->view('transaction/checklist_lookup_view', $data);
   	}

   	function fetch_events()
	{
		echo json_encode($this->checklist_model->fetch_events());
	}

	function checklist_view()
   	{
   		$data = $this->checklist_model->fetch_predata();
   		$this->load->view('transaction/checklist_view', $data);
   	}

   	function fetch_activities()
   	{
   		echo json_encode($this->checklist_model->fetch_activities());
   	}

   	function fetch_checklists()
   	{
   		echo json_encode($this->checklist_model->fetch_checklists());
   	}

   	function save_checklists()
   	{
   		echo json_encode($this->checklist_model->save_checklists());
   	}

   	public function validate_checklist($str)
	{
		return $this->checklist_model->validate_checklist($str);
	}

	function event_checklist_lookup_view()
	{
		$data = $this->checklist_model->fetch_predata();
		$this->load->view('transaction/event_checklist_lookup_view', $data);
	}

	function fetch_lp_checklists()
	{
		echo json_encode($this->checklist_model->fetch_lp_checklists());
	}
}
