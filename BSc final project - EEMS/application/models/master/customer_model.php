<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
	function customer_model()
	{
		parent:: __Construct();

		//loading sequence generation library
		$this->load->library('sequence');
	}

	function fetch_predata()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('CUS', 8);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function reload_sequence()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('CUS', 8);

		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function save_customer()
	{
		$this->form_validation->set_rules('customer_code_input', 'Customer Code', 'trim|required');
		$this->form_validation->set_rules('cus_nic_input', 'Customer NIC', 'trim|required');
		$this->form_validation->set_rules('title_select', 'Customer Title', 'trim|required');
		$this->form_validation->set_rules('cus_name_input', 'Customer Name', 'trim|required');
		$this->form_validation->set_rules('radio_gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('cus_mobile_input', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('cus_add_input', 'Customer Address', 'trim|required');
		$this->form_validation->set_rules('cus_email_input', 'Email Address', 'trim|required');
		$this->form_validation->set_rules('reg_date_input', 'Registered Date', 'trim|required');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		if($_POST['update_id'] == 'false')
		{
			$data = array();

			$data['CUS_Code']          = $_POST['customer_code_input'];
			$data['CUS_NIC']           = $_POST['cus_nic_input'];
			$data['CUS_Title']         = $_POST['title_select'];
			$data['CUS_Name']          = $_POST['cus_name_input'];
			$data['CUS_Gender']        = $_POST['radio_gender'];
			$data['CUS_Address']       = $_POST['cus_add_input'];
			$data['CUS_Mobile_no']     = $_POST['cus_mobile_input'];
			$data['CUS_Contact_no']    = $_POST['cus_home_input'];
			$data['CUS_Email']         = $_POST['cus_email_input'];
			$data['CUS_Skype_address'] = $_POST['cus_skype_input'];
			$data['CUS_Register_date'] = $_POST['reg_date_input'];
			$data['CUS_Status']        = (isset($_POST['status_switch']) ? 1 : 0);
			$data['CUS_User']          = $this->session->userdata('username');
			$data['CUS_Timestamp']     = date('Y-m-d H:i:s');

			$this->db->insert('CUSTOMER', $data);

			$event = "Creation";
		}
		else
		{
			if($_POST['update_id'] != null)
			{
				$data = array();

				$data['CUS_Code']          = $_POST['customer_code_input'];
				$data['CUS_NIC']           = $_POST['cus_nic_input'];
				$data['CUS_Title']         = $_POST['title_select'];
				$data['CUS_Name']          = $_POST['cus_name_input'];
				$data['CUS_Gender']        = $_POST['radio_gender'];
				$data['CUS_Address']       = $_POST['cus_add_input'];
				$data['CUS_Mobile_no']     = $_POST['cus_mobile_input'];
				$data['CUS_Contact_no']    = $_POST['cus_home_input'];
				$data['CUS_Email']         = $_POST['cus_email_input'];
				$data['CUS_Skype_address'] = $_POST['cus_skype_input'];
				$data['CUS_Register_date'] = $_POST['reg_date_input'];
				$data['CUS_Status']        = (isset($_POST['status_switch']) ? 1 : 0);
				$data['CUS_User']          = $this->session->userdata('username');
				$data['CUS_Timestamp']     = date('Y-m-d H:i:s');

				$this->db->where('CUS_ID', $_POST['update_id']);
				$this->db->update('CUSTOMER', $data);
			}

			$event = "Update";
		}

		if($this->db->affected_rows() > 0)
		{
			$this->session->set_flashdata('s', 'Customer - ' . $_POST['cus_name_input'] . ' '. $event . ' successful.');
			return true;
		}
		else
		{
			$this->session->set_flashdata('e', 'Customer - ' . $_POST['cus_name_input'] . ' '. $event . ' failed.');
			return false;
		}
	}

	function fetch_customers()
	{
		$r    = array();
		$data = array();

		$this->db->select('CUS_ID as "id", CUS_NIC as "nic", CUS_Title as "title", CUS_Name as "name", CUS_Mobile_no as "mobile", DATE(CUS_Register_date) as "reg_date", CUS_Address as "address", CUS_Email as "email", CUS_Skype_address as "skype", CUS_Status as "status", CUS_User as "user"');

		if($_POST['from'] != "")
			$this->db->where('CUS_Register_date >=', $_POST['from'] . ' 00:00:00');
		if($_POST['to'] != "")
			$this->db->where('CUS_Register_date <=', $_POST['to'] . ' 23:59:59');
		if($_POST['status'] != "")
			$this->db->where('CUS_Status', $_POST['status']);

		$r = $this->db->get('CUSTOMER')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']  = ++$i;
			$ref['action'] = "<a class = 'text-info' style = 'cursor:pointer' onclick ='editCustomer(".$ref['id'].")'><strong>Edit</strong></a> | ".($ref['status'] == 0 ? "<a onclick = 'quickToggleCusStatus(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>Activate</strong></a>" : "<a onclick = 'quickToggleCusStatus(".$ref['id'].");' class = 'text-danger' style = 'cursor:pointer'><strong>Deactivate</strong></a>");
			$ref['status'] = ($ref['status'] == 0 ? 'Inactive' : 'Active');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function quick_toggle_cus_status()
	{
		$data = array();

		if($_POST['update_id'] != null && $_POST['update_id'] != '')
		{
			$this->db->select('CUS_Name as "name", CUS_Status as "status"');
			$this->db->where('CUS_ID', $_POST['update_id']);
			$r = $this->db->get('CUSTOMER')->row_array();

			if(empty($r))
			{
				$this->db->set_flashdata('e', 'Invalid Customer ID. Please Try Again.');
				return false;
			}

			if($r['status'] == 1)
			{
				$this->db->select('COUNT(*) as "events"');
				$this->db->where('ENT_CUS_ID', $_POST['update_id']);
				$this->db->where('ENT_Date >=', date('Y-m-d'));
				$check = $this->db->get('EVENT')->row_array();

				if($check['events'] > 0)
				{
					$this->session->set_flashdata('e','Customer has Upcoming Incomplete Events. Cannot Deactive.');
					return false;
				}
			}

			$data['CUS_Status'] = ($r['status'] == 1 ? 0 : 1);

			$this->db->where('CUS_ID', $_POST['update_id']);
			$this->db->update('CUSTOMER', $data);

			if($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('s', 'Customer - ' . $r['name'] . ' status quick update successful.');
				return true;
			}
			else
			{
				$this->session->set_flashdata('e', 'Customer - ' . $r['name'] . ' status quick update failed.');
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function fetch_customer()
	{
		$r = array();

		if($_GET['id'] != null && $_GET['id'] != "")
		{
			$this->db->select('CUS_ID as "id", CUS_Code as "code", CUS_NIC as "nic", CUS_Title as "title", CUS_Name as "name", CUS_Gender as "gender", CUS_Contact_no as "home", CUS_Mobile_no as "mobile", DATE(CUS_Register_date) as "reg_date", CUS_Address as "address", CUS_Email as "email", CUS_Skype_address as "skype", CUS_Status as "status", CUS_User as "user"');
			$this->db->where('CUS_ID', $_GET['id']);
			$r = $this->db->get('CUSTOMER')->row_array();	
		}

		return $r;
	}

	function check_events()
	{
		$r = array();

		if($_GET['update_id'] != "false")
		{
			$this->db->select('COUNT(*) as "events"');
			$this->db->where('ENT_CUS_ID', $_GET['update_id']);
			$this->db->where('ENT_Date >=', date('Y-m-d'));
			$r = $this->db->get('EVENT')->row_array();
		}

		return $r;
	}
}