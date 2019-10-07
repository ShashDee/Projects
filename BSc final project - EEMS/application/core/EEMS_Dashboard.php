<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EEMS_Dashboard extends CI_Controller
{

   	function __construct()
   	{
        parent::__construct();
		$this->load->model('dashboard_model');
   	}

	function index()
	{
		$status = $this->dashboard_model->check_session();

		if($status)
		{
			$this->load->view('main_header');
			$this->load->view('main_footer');
		}
		else
		{
			redirect(site_url() . 'login');
		}
		
	}

	function fetch_notifications()
	{
		echo json_encode($this->dashboard_model->fetch_notifications());
	}

	function logout()
	{
		$this->authentication->destroy_session();
		redirect(site_url() . 'login');
		return true;
	}
}
