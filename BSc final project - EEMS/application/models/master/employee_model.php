<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model
{
	function employee_model()
	{
		parent:: __Construct();
	}

	function fetch_lookup_predata()
	{
		$data = array();

		$this->db->distinct();
		$this->db->select('EMP_Designation as "designation"');
		$desig = $this->db->get('EMPLOYEE')->result_array();

		$data['designation'][''] = "Filter Designation";

		foreach ($desig as $row) 
		{
			$data['designation'][$row['designation']] = $row['designation'];
		}

		return $data;
	}

	function fetch_employees()
	{
		$r    = array();
		$data = array();

		$this->db->select('EMP_ID as "id", EMP_Code as "epf_no", EMP_Fullname as "full_name", EMP_Address as "address", DATE(EMP_Joined_date) as "joined_date", EMP_Designation as "desig", EMP_Email as "email", EMP_Mobile_no as "mobile", EMP_Skype_add as "skype", EMP_User as "user", EMP_Status as "status"');

		if($_POST['from'] != "")
			$this->db->where('EMP_Joined_date >=', $_POST['from'] . ' 00:00:00');
		if($_POST['to'] != "")
			$this->db->where('EMP_Joined_date <=', $_POST['to'] . ' 23:59:59');
		if($_POST['designation'] != "")
			$this->db->where('EMP_Designation', $_POST['designation']);
		if($_POST['status'] != "")
			$this->db->where('EMP_Status', $_POST['status']);

		$r = $this->db->get('EMPLOYEE')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']  = ++$i;
			$ref['action'] = "<a class = 'text-info' style = 'cursor:pointer' onclick ='editEmployee(".$ref['id'].")'><strong>Edit</strong></a> | ".($ref['status'] == 0 ? "<a onclick = 'quickToggleEmpStatus(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>Activate</strong></a>" : "<a onclick = 'quickToggleEmpStatus(".$ref['id'].");' class = 'text-danger' style = 'cursor:pointer'><strong>Deactivate</strong></a>");
			$ref['status'] = ($ref['status'] == 0 ? 'Inactive' : 'Active');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function save_employee()
	{
		$this->form_validation->set_rules('employee_no_input', 'Employee Number', 'trim|required');
		$this->form_validation->set_rules('emp_fname_input', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('emp_home_input', 'Home Number', 'trim|required');
		$this->form_validation->set_rules('emp_mobile_input', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('emp_nic_input', 'NIC', 'trim|required');
		$this->form_validation->set_rules('emp_add_input', 'Address', 'trim|required');
		$this->form_validation->set_rules('joined_date_input', 'Joined Date', 'trim|required');
		$this->form_validation->set_rules('emp_desig_input', 'Designation', 'trim|required');
		$this->form_validation->set_rules('radio_gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('skills', 'Employee Skills', 'callback_validate_skills');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e',validation_errors());
			return false;
		}

		$this->db->trans_strict(1);
		$this->db->trans_begin();

		if($_POST['update_id'] == 'false')
		{
			$data = array();

			$data['EMP_Code']        = $_POST['employee_no_input'];
			$data['EMP_NIC']         = $_POST['emp_nic_input'];
			$data['EMP_Fullname']    = $_POST['emp_fname_input'];
			$data['EMP_Initials']    = $_POST['emp_initials_input'];
			$data['EMP_Surname']     = $_POST['emp_surname_input'];
			$data['EMP_Home_no']     = $_POST['emp_home_input'];
			$data['EMP_Mobile_no']   = $_POST['emp_mobile_input'];
			$data['EMP_Address']     = $_POST['emp_add_input'];
			$data['EMP_Gender']      = $_POST['radio_gender'];
			$data['EMP_Email']       = $_POST['emp_email_input'];
			$data['EMP_Skype_add']   = $_POST['emp_skype_input'];
			$data['EMP_Designation'] = $_POST['emp_desig_input'];
			$data['EMP_Joined_date'] = $_POST['joined_date_input'];
			$data['EMP_Status']      = (isset($_POST['status_switch']) ? 1 : 0);
			$data['EMP_User']        = $this->session->userdata('username');
			$data['EMP_Timestamp']   = date('Y-m-d H:i:s');

			$this->db->insert('EMPLOYEE', $data);
			$emp_id = $this->db->insert_id();

			$skill_entries = (array) json_decode($_POST['skills']);
			$skill_info    = array();
			$i             = 0;

			foreach ($skill_entries as $row) 
			{
				$entry = (array) $row;

				$skill_info[$i]['EMP_ID']    = $emp_id;
				$skill_info[$i]['ESP_Skill'] = $entry['value'];

				$i++;
			}

			$this->db->insert_batch('EMPLOYEE_SKILLS', $skill_info);

			$event = "Creation";
		}
		else
		{
			if($_POST['update_id'] != null)
			{
				$data['EMP_Code']            = $_POST['employee_no_input'];
				$data['EMP_NIC']             = $_POST['emp_nic_input'];
				$data['EMP_Fullname']        = $_POST['emp_fname_input'];
				$data['EMP_Initials']        = $_POST['emp_initials_input'];
				$data['EMP_Surname']         = $_POST['emp_surname_input'];
				$data['EMP_Home_no']         = $_POST['emp_home_input'];
				$data['EMP_Mobile_no']       = $_POST['emp_mobile_input'];
				$data['EMP_Address']         = $_POST['emp_add_input'];
				$data['EMP_Gender']          = $_POST['radio_gender'];
				$data['EMP_Email']           = $_POST['emp_email_input'];
				$data['EMP_Skype_add']       = $_POST['emp_skype_input'];
				$data['EMP_Designation']     = $_POST['emp_desig_input'];
				$data['EMP_Joined_date']     = $_POST['joined_date_input'];
				$data['EMP_Status']          = (isset($_POST['status_switch']) ? 1 : 0);
				$data['EMP_UpdateUser']      = $this->session->userdata('username');
				$data['EMP_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('EMP_ID', $_POST['update_id']);
				$this->db->update('EMPLOYEE', $data);
				$emp_id = $_POST['update_id'];

				$this->db->where('EMP_ID', $_POST['update_id']);
				$this->db->delete('EMPLOYEE_SKILLS');

				$skill_entries = (array) json_decode($_POST['skills']);
				$skill_info    = array();
				$i             = 0;

				foreach ($skill_entries as $row) 
				{
					$entry = (array) $row;

					$skill_info[$i]['EMP_ID']    = $emp_id;
					$skill_info[$i]['ESP_Skill'] = $entry['value'];

					$i++;
				}

				$this->db->insert_batch('EMPLOYEE_SKILLS', $skill_info);
			}

			$event = "Update";
		}

		if($this->db->trans_status() == false)
		{
			$this->db->trans_rollback();
			$this->session->set_flashdata('e', 'Employee - ' . $_POST['emp_fname_input'] . ' '. $event . ' failed.');
			return false;
		}
		else
		{
			$this->db->trans_commit();
			$this->session->set_flashdata('s', 'Employee - ' . $_POST['emp_fname_input'] . ' '. $event . ' successful.');
			return true;
		}
	}

	function validate_skills($str)
	{
		$skill_entries = array();

		$skill_entries = (array) json_decode($str);

		if(!(empty($skill_entries)))
		{
			return true;
		}
		else 
		{
			$this->form_validation->set_message('validate_skills', 'The Employee Skills Are Not Selected.');
			return false;
		}
	}

	function quick_toggle_emp_status()
	{
		$data = array();

		if($_POST['update_id'] != null && $_POST['update_id'] != '')
		{
			$this->db->select('EMP_Fullname as "name", EMP_Status as "status"');
			$this->db->where('EMP_ID', $_POST['update_id']);
			$r = $this->db->get('EMPLOYEE')->row_array();

			if(empty($r))
			{
				$this->db->set_flashdata('e', 'Invalid Employee ID. Please Try Again.');
				return false;
			}

			if($r['status'] == 1)
			{
				$this->db->select('COUNT(*) as "events"');
				$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
				$this->db->join('EVENT', 'EVENT_ACTIVITY.ENT_ID=EVENT.ENT_ID');
				$this->db->where('ACL_Incharge', $_POST['update_id']);
				$this->db->where('ENT_Date >=', date('Y-m-d'));
				$check = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

				if($check['events'] > 0)
				{
					$this->session->set_flashdata('e','Employee is assigned to incomplete checklist items of an upcoming event. Cannot Deactive.');
					return false;
				}
			}

			$data['EMP_Status'] = ($r['status'] == 1 ? 0 : 1);

			$this->db->where('EMP_ID', $_POST['update_id']);
			$this->db->update('EMPLOYEE', $data);

			if($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('s', 'Employee - ' . $r['name'] . ' status quick update successful.');
				return true;
			}
			else
			{
				$this->session->set_flashdata('e', 'Employee - ' . $r['name'] . ' status quick update failed.');
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function fetch_employee()
	{
		$r = array();

		if($_GET['id'] != null)
		{
			$this->db->select('EMP_ID as "id", EMP_Code as "epf_no", EMP_NIC as "nic", EMP_Fullname as "full_name", EMP_Initials as "initials", EMP_Surname as "surname", EMP_Home_no as "home_no", EMP_Address as "address", DATE(EMP_Joined_date) as "joined_date", EMP_Designation as "desig", EMP_Email as "email", EMP_Mobile_no as "mobile", EMP_Gender as "gender", EMP_Skype_add as "skype", EMP_User as "user", EMP_Status as "status"');
			$this->db->where('EMP_ID', $_GET['id']);
			$r['employee'] = $this->db->get('EMPLOYEE')->row_array();

			$this->db->select('EPS_ID as "skill_id", ESP_Skill as "skill"');
			$this->db->where('EMP_ID', $_GET['id']);
			$r['skills'] = $this->db->get('EMPLOYEE_SKILLS')->result_array();
		}

		return $r;
	}

	function check_tasks()
	{
		$r = array();

		if($_GET['update_id'] != "false")
		{
			$this->db->select('COUNT(*) as "events"');
			$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
			$this->db->join('EVENT', 'EVENT_ACTIVITY.ENT_ID=EVENT.ENT_ID');
			$this->db->where('ACL_Incharge', $_GET['update_id']);
			$this->db->where('ENT_Date >=', date('Y-m-d'));
			$r = $this->db->get('ACTIVITY_CHECKLIST')->row_array();
		}

		return $r;
	}
}