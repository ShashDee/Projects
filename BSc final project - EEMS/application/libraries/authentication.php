<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Authentication
{

	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}

	public function check_login($username, $password)
	{
		$r = array();

		if($username != null)
		{
			if($password != null)
			{
				$this->CI->db->select('USR_ID as "id", USR_Fullname as "full_name", USR_User_group as "user_group", USR_Username as "user_name", USR_Password as "pwd", USR_EMP_ID as "emp_id"');
				$this->CI->db->where('USR_Username', $username);
				$this->CI->db->where('USR_Status', 1);
				$r = $this->CI->db->get('USER')->row_array();
				
				if(empty($r))
				{
					$this->CI->session->set_flashdata('e', 'Incorrect Username or User Disabled. Please Try Again.');
					return false;
				}

				if($r['pwd'] != $password)
				{
					$this->CI->session->set_flashdata('e', 'Incorrect Password. Please Try Again.');
					return false;
				}

				$this->create_session($r);
				return true;
			}
			else
			{
				$this->CI->session->set_flashdata('e', 'Invalid Password. Please Enter Again.');
				return false;
			}
		}
		else
		{
			$this->CI->session->set_flashdata('e','Invalid Username. Please Enter Again.');
			return false;
		}
	}

	private function create_session($r)
	{
		$user = array('username'   => $r['user_name'],
				      'full_name'  => $r['full_name'],
				      'user_group' => $r['user_group'],
				      'status'     => TRUE,
				      'user_id'    => $r['id'],
				      'emp_id'     => $r['emp_id']);

		$this->CI->session->set_userdata($user);
		return true;
	}

	public function redirect_login()
	{
		return $this->CI->session->userdata('status');
	}

	public function destroy_session()
	{
		$this->CI->session->sess_destroy();
		return true;
	}
}