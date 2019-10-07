<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		$this->load->model('master/user_model');
   	}

	function user_view()
	{
		$data = $this->user_model->fetch_predata();
		$this->load->view('master/user_view', $data);
	}

	function user_lookup_view()
	{
		$this->load->view('master/user_lookup_view');
	}

	function save_user()
	{
		echo json_encode($this->user_model->save_user());
	}

	function fetch_users()
	{
		echo json_encode($this->user_model->fetch_users());
	}

	function quick_toggle_user_status()
	{
		echo json_encode($this->user_model->quick_toggle_user_status());
	}

	function fetch_user()
	{
		echo json_encode($this->user_model->fetch_user());
	}
}
