<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	function user_model()
	{
		parent:: __Construct();
	}

	function fetch_predata()
	{
		$data = array();

		$this->db->select('USR_ID as "user", EMP_ID as "id", EMP_Fullname as "name"');
		$this->db->join('USER', 'USER.USR_EMP_ID=EMPLOYEE.EMP_ID', 'LEFT');
		$this->db->where('EMP_status', 1);
		$emps = $this->db->get('EMPLOYEE')->result_array();

		$data['emp'][''] = "Select Employee";

		foreach ($emps as $row) 
		{
			if($row['user'] == "" || $row['user'] == null)
				$data['emp'][$row['id']] = $row['name'];
		}

		return $data;
	}

	function save_user()
	{
		$this->form_validation->set_rules('emp_select', 'Employee', 'trim|required');
		$this->form_validation->set_rules('user_nic_input', 'NIC', 'trim|required');
		$this->form_validation->set_rules('user_fname_input', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('user_mobile_input', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('user_add_input', 'Address', 'trim|required');
		$this->form_validation->set_rules('username_input', 'Username', 'trim|required');
		$this->form_validation->set_rules('u_group_select', 'User Group', 'trim|required');
		$this->form_validation->set_rules('pass_confirmation', 'Password', 'trim|required');
		$this->form_validation->set_rules('pass', 'Confirm Password', 'trim|required');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		if($_POST['pass_confirmation'] != $_POST['pass'])
		{
			$this->session->set_flashdata('e', 'Password and Confirm Password Does Not Match!. Please Try Again.');
			return false;
		}

		if($_POST['update_id'] == "false")
		{
			$data = array();

			$data['USR_EMP_ID']     = $_POST['emp_select'];
			$data['USR_NIC']        = $_POST['user_nic_input'];
			$data['USR_Fullname']   = $_POST['user_fname_input'];
			$data['USR_Address']    = $_POST['user_add_input'];
			$data['USR_Mobile_no']  = $_POST['user_mobile_input'];
			$data['USR_Contact_no'] = $_POST['user_home_input'];
			$data['USR_Email']      = $_POST['emp_email_input'];
			$data['USR_User_group'] = $_POST['u_group_select'];
			$data['USR_Username']   = $_POST['username_input'];
			$data['USR_Password']   = $_POST['pass_confirmation'];
			$data['USR_Status']     = (isset($_POST['status_switch']) ? 1 : 0);
			$data['USR_User']       = $this->session->userdata('username');
			$data['USR_Timestamp']  = date('Y-m-d H:i:s');

			$this->db->insert('USER', $data);
			$user_id = $this->db->insert_id();

			$event = "Creation";
		}
		else
		{
			if($_POST['update_id'] != null)
			{
				$data['USR_NIC']             = $_POST['user_nic_input'];
				$data['USR_Fullname']        = $_POST['user_fname_input'];
				$data['USR_Address']         = $_POST['user_add_input'];
				$data['USR_Mobile_no']       = $_POST['user_mobile_input'];
				$data['USR_Contact_no']      = $_POST['user_home_input'];
				$data['USR_Email']           = $_POST['emp_email_input'];
				$data['USR_User_group']      = $_POST['u_group_select'];
				$data['USR_Username']        = $_POST['username_input'];
				$data['USR_Password']        = $_POST['pass_confirmation'];
				$data['USR_Status']          = (isset($_POST['status_switch']) ? 1 : 0);
				$data['USR_UpdateUser']      = $this->session->userdata('username');
				$data['USR_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('USR_ID', $_POST['update_id']);
				$this->db->update('USER', $data);
			}

			$event = "Update";
		}

		if($this->db->affected_rows() > 0)
		{
			$this->session->set_flashdata('s', 'User - ' . $_POST['user_fname_input'] . ' '. $event . ' successful.');
			return true;
		}
		else
		{
			$this->session->set_flashdata('e', 'User - ' . $_POST['user_fname_input'] . ' '. $event . ' failed.');
			return false;
		}
	}

	function fetch_users()
	{
		$data = array();
		$r    = array();

		$this->db->select('USR_ID as "id", USR_NIC as "nic", USR_Fullname as "full_name", USR_User_group as "group", USR_User as "user", USR_Status as "status"');

		if($_POST['group'] != "")
			$this->db->where('USR_User_group', $_POST['group']);

		if($_POST['status'] != "")
			$this->db->where('USR_Status', $_POST['status']);

		$r = $this->db->get('USER')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']  = ++$i;
			
			$ref['action'] = "<a class = 'text-info' style = 'cursor:pointer' onclick ='editUser(".$ref['id'].")'><strong>Edit</strong></a> | ".($ref['status'] == 0 ? "<a onclick = 'quickToggleUserStatus(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>Activate</strong></a>" : "<a onclick = 'quickToggleUserStatus(".$ref['id'].");' class = 'text-danger' style = 'cursor:pointer'><strong>Deactivate</strong></a>");
			$ref['status'] = ($ref['status'] == 0 ? 'Inactive' : 'Active');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function quick_toggle_user_status()
	{
		$data = array();

		if($_POST['update_id'] != null && $_POST['update_id'] != '')
		{
			$this->db->select('USR_Fullname as "name", USR_Status as "status"');
			$this->db->where('USR_ID', $_POST['update_id']);
			$r = $this->db->get('USER')->row_array();

			if(empty($r))
			{
				$this->db->set_flashdata('e', 'Invalid User ID. Please Try Again.');
				return false;
			}

			$data['USR_Status'] = ($r['status'] == 1 ? 0 : 1);

			$this->db->where('USR_ID', $_POST['update_id']);
			$this->db->update('USER', $data);

			if($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('s', 'User - ' . $r['name'] . ' status quick update successful.');
				return true;
			}
			else
			{
				$this->session->set_flashdata('e', 'User - ' . $r['name'] . ' status quick update failed.');
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function fetch_user()
	{
		$r = array();

		if($_GET['id'] != '')
		{
			$this->db->select('USR_ID as "id", USR_NIC as "nic", USR_Fullname as "full_name", USR_Address as "address", USR_Contact_no as "home", USR_Mobile_no as "mobile", USR_Email as "email", USR_Username as "username", USR_Password as "pwd", USR_User_group as "group", USR_Status as "status", USR_EMP_ID as "emp_id", EMP_Fullname as "emp_name"');
			$this->db->join('EMPLOYEE', 'USER.USR_EMP_ID=EMPLOYEE.EMP_ID');
			$this->db->where('USR_ID', $_GET['id']);
			$r = $this->db->get('USER')->row_array();
		}

		return $r;
	}
}