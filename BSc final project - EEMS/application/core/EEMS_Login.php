<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EEMS_Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if($this->authentication->redirect_login())
			redirect(site_url() . 'dashboard');

		$this->load->view('login_view');
	}

	function submit_login()
	{
		if($this->authentication->redirect_login())
			redirect(site_url() . 'dashboard');

		if($this->authentication->check_login($_POST['username'], $_POST['password']))
			redirect(site_url() . 'dashboard');
		else
			redirect(site_url() . 'login');
	}
}