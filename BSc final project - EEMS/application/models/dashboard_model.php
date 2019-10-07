<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
	function dashboard_model()
	{
		parent:: __Construct();
	}

	function fetch_notifications()
	{
		$n = array();
		if(!empty($this->session->flashdata('s')))
			$n[] =array('t'=>'success','m'=>$this->session->flashdata('s'), 'd' => date('U'));

		if(!empty($this->session->flashdata('e')))
			$n[] =array('t'=>'error','m'=>$this->session->flashdata('e'), 'd' => date('U'));

		if(!empty($this->session->flashdata('w')))
			$n[] =array('t'=>'warning','m'=>$this->session->flashdata('w'), 'd' => date('U'));

		if(!empty($this->session->flashdata('i')))
			$n[] =array('t'=>'info','m'=>$this->session->flashdata('i'), 'd' => date('U'));

		return $n;
	}

	function check_session()
	{
		if($this->session->userdata('username'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}