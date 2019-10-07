<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_controller extends CI_Controller 
{

	function __construct()
   	{
        parent::__construct();
		// $this->load->model('fts/dashboard_model');
   	}

	function index()
	{
		$this->load->view('test_page_header');
	}
}
