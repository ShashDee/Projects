<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('master/customer_model');
   	}

	function customer_view()
	{
		$data = $this->customer_model->fetch_predata();
		$this->load->view('master/customer_view', $data);
	}

	function reload_sequence()
	{
		echo json_encode($this->customer_model->reload_sequence());
	}

	function save_customer()
	{
		echo json_encode($this->customer_model->save_customer());
	}

	function fetch_customers()
	{
		echo json_encode($this->customer_model->fetch_customers());
	}

	function customer_lookup_view()
	{
		$this->load->view('master/customer_lookup_view');
	}

	function quick_toggle_cus_status()
	{
		echo json_encode($this->customer_model->quick_toggle_cus_status());
	}

	function fetch_customer()
	{
		echo json_encode($this->customer_model->fetch_customer());
	}

	function event_customer_view()
	{
		$data = $this->customer_model->fetch_predata();
		$this->load->view('master/event_customer_view', $data);
	}

	function check_events()
	{
		echo json_encode($this->customer_model->check_events());
	}
}
