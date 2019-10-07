<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
	function supplier_model()
	{
		parent:: __Construct();

		//loading sequence generation library
		$this->load->library('sequence');
	}

	function fetch_predata()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('SUP', 6);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function fetch_lookup_predata()
	{
		$r = array();

		$this->db->select('SPT_ID as "id", SPT_Supplier_Type as "sup_type"');
		$types = $this->db->get('SUPPLIER_TYPE')->result_array();	

		$r['types'][''] = "Filter Supplier Type";

		foreach ($types as $row) 
		{
			$r['types'][$row['id']] = $row['sup_type'];
		}

		return $r;
	}

	function reload_sequence()
	{
		$data         = array();
		$sequence     = $this->sequence->generate_sequence('SUP', 6);
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function load_supplier_types()
	{
		$r    = array();
		$data = array();

		$this->db->select('SPT_ID as "id", SPT_Supplier_Type as "sup_type"');
		$r = $this->db->get('SUPPLIER_TYPE')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index'] = ++$i;
		}

		$data['aaData'] = $r;

		return $data;
	}

	function save_sup_type()
	{
		$this->form_validation->set_rules('sup_type_input', 'Supplier Type', 'trim|required');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		$data = array();

		$data['SPT_Supplier_Type'] = $_POST['sup_type_input'];
		$data['SPT_User']          = $this->session->userdata('username');
		$data['SPT_Timestamp']     = date('Y-m-d H:i:S');

		$this->db->insert('SUPPLIER_TYPE', $data);

		if($this->db->affected_rows() > 0)
		{
			$this->session->set_flashdata('s',  'Supplier Type - ' . $_POST['sup_type_input'] . ' Creation Successful.');
			return true;
		}
		else
		{
			$this->session->set_flashdata('e',  'Supplier Type - ' . $_POST['sup_type_input'] . ' Creation Failed.');
			return false;
		}
	}

	function save_supplier()
	{
		$this->form_validation->set_rules('supplier_code_input', 'Suppler Code', 'trim|required');
		$this->form_validation->set_rules('sup_name_input', 'Supplier Name', 'trim|required');
		$this->form_validation->set_rules('con_name_input', 'Contact Person Name', 'trim|required');
		$this->form_validation->set_rules('con_design_input', 'Conatct Person Designation', 'trim|required');
		$this->form_validation->set_rules('sup_email_input', 'Email Address', 'trim|required');
		$this->form_validation->set_rules('sup_type_select[]', 'Supplier Type(s)', 'required');
		$this->form_validation->set_rules('sup_min_rate_input', 'Minimum Rate', 'trim|required');
		$this->form_validation->set_rules('branch_entries', 'Supplier Branch Information', 'callback_validate_branches');

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

			$data['SUP_Code']            = $_POST['supplier_code_input'];
			$data['SUP_Name']            = $_POST['sup_name_input'];
			$data['SUP_Email']           = $_POST['sup_email_input'];
			$data['SUP_Skype']           = $_POST['sup_skype_input'];
			$data['SUP_Contact_person']  = $_POST['con_name_input'];
			$data['SUP_Con_designation'] = $_POST['con_design_input'];
			$data['SUP_Minimum_rate']    = $_POST['sup_min_rate_input'];
			$data['SUP_Status']          = (isset($_POST['status_switch']) ? 1 : 0);
			$data['SUP_User']            = $this->session->userdata('username');
			$data['SUP_Timestamp']       = date('Y-m-d H:i:s');

			$this->db->insert('SUPPLIER', $data);
			$sup_id = $this->db->insert_id();

			$sup_types = array();
			$s_i       = 0;

			foreach ($_POST['sup_type_select'] as $row) 
			{
				$sup_types[$s_i]['SUP_ID'] = $sup_id;
				$sup_types[$s_i]['SPT_ID'] = $row;

				$s_i++;
			}

			$this->db->insert_batch('SUPPLIER_SUPPLIER_TYPES', $sup_types);

			$branch_entries = (array) json_decode($_POST['branch_entries']);
			$branch_data    = array();
			$i              = 0;

			foreach ($branch_entries as $row) 
			{
				$entry = (array) $row;

				$branch_data[$i]['SUP_ID']        = $sup_id;
				$branch_data[$i]['SBP_Office_no'] = $entry['office'];
				$branch_data[$i]['SBP_Mobile_no'] = $entry['mobile'];
				$branch_data[$i]['SBP_Address']   = $entry['address'];

				$i++;
			}

			$this->db->insert_batch('SUPPLIER_BRANCH', $branch_data);

			$event = "Creation";
		}
		else
		{
			if($_POST['update_id'] != null)
			{
				$data = array();

				$data['SUP_Code']            = $_POST['supplier_code_input'];
				$data['SUP_Name']            = $_POST['sup_name_input'];
				$data['SUP_Email']           = $_POST['sup_email_input'];
				$data['SUP_Skype']           = $_POST['sup_skype_input'];
				$data['SUP_Contact_person']  = $_POST['con_name_input'];
				$data['SUP_Con_designation'] = $_POST['con_design_input'];
				$data['SUP_Minimum_rate']    = $_POST['sup_min_rate_input'];
				$data['SUP_Status']          = (isset($_POST['status_switch']) ? 1 : 0);
				$data['SUP_UpdateUser']      = $this->session->userdata('username');
				$data['SUP_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('SUP_ID', $_POST['update_id']);
				$this->db->update('SUPPLIER', $data);
				$sup_id = $_POST['update_id'];

				$this->db->where('SUP_ID', $_POST['update_id']);
				$this->db->delete('SUPPLIER_SUPPLIER_TYPES');

				$sup_types = array();
				$s_i       = 0;

				foreach ($_POST['sup_type_select'] as $row) 
				{
					$sup_types[$s_i]['SUP_ID'] = $sup_id;
					$sup_types[$s_i]['SPT_ID'] = $row;

					$s_i++;
				}

				$this->db->insert_batch('SUPPLIER_SUPPLIER_TYPES', $sup_types);

				if(!empty((array) json_decode($_POST['remove_branch_entries'])))
				{
					$remove_branch_entries = (array) json_decode($_POST['remove_branch_entries']);
					$remove_ids            = array();

					foreach ($remove_branch_entries as $row)
					{
						$entry = (array) $row;

						$remove_ids[] = $entry['branch_id'];
					}

					$this->db->where_in('SPB_ID', $remove_ids);
					$this->db->delete('SUPPLIER_BRANCH');
				}

				$branch_entries = (array) json_decode($_POST['branch_entries']);
				$branch_data    = array();
				$i              = 0;

				foreach ($branch_entries as $row) 
				{
					$entry = (array) $row;

					if($entry['new'] == 1)
					{
						$branch_data[$i]['SUP_ID']        = $sup_id;
						$branch_data[$i]['SBP_Office_no'] = $entry['office'];
						$branch_data[$i]['SBP_Mobile_no'] = $entry['mobile'];
						$branch_data[$i]['SBP_Address']   = $entry['address'];

						$i++;
					}
				}

				if(!empty($branch_data))
					$this->db->insert_batch('SUPPLIER_BRANCH', $branch_data);
			}

			$event = "Update";
		}

		if($this->db->trans_status() == false)
		{
			$this->session->set_flashdata('e', 'Supplier - ' . $_POST['sup_name_input'] . ' '. $event . ' failed.');
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->session->set_flashdata('s', 'Supplier - ' . $_POST['sup_name_input'] . ' '. $event . ' successful.');
			$this->db->trans_commit();
			return true;
		}

	}

	function validate_branches($str)
	{
		$branch_entries = array();

		$branch_entries = (array) json_decode($str);

		if(!(empty($branch_entries)))
		{
			return true;
		}
		else 
		{
			$this->form_validation->set_message('validate_branches', 'The Employee Skills Are Not Selected.');
			return false;
		}
	}

	function fetch_suppliers() //fetch all existing suppliers
	{
		//initialize empty array
		$r     = array();
		$data  = array();
		$types = array();

		//fetching supplier types of all suppliers
		$this->db->select('SUP_ID as "sup_id", SUPPLIER_SUPPLIER_TYPES.SPT_ID as "type_id", SPT_Supplier_Type as "sup_type"');
		$this->db->join('SUPPLIER_TYPE', 'SUPPLIER_TYPE.SPT_ID=SUPPLIER_SUPPLIER_TYPES.SPT_ID');
		$types = $this->db->get('SUPPLIER_SUPPLIER_TYPES')->result_array();

		$sup_types_array = array(); //array to hold supplier types with PK as array element key

		foreach ($types as $row) 
		{
			if(!(array_key_exists($row['sup_id'], $sup_types_array)))
			{
				$sup_types_array[$row['sup_id']] = "";
				$sup_types_array[$row['sup_id']] .= $row['sup_type'];
			}
			else
				$sup_types_array[$row['sup_id']] .= (", " . $row['sup_type']);
		}

		//fetching all suppliers
		$this->db->select('SUP_ID as "id", SUP_Name as "name", SUP_Minimum_rate as "min_rate", SUP_Email as "email", SUP_Skype as "skype", SUP_User as "user", SUP_Status as "status"');

		//applyinh filters if selected by user
		if($_POST['min_from'] != "")
			$this->db->where("SUP_Minimum_rate >=", $_POST['min_from']);
		if($_POST['min_to'] != "")
			$this->db->where("SUP_Minimum_rate <=", $_POST['min_to']);
		if($_POST['type'] != "")
			$this->db->where('`SUP_ID` in (select `SUP_ID` from `SUPPLIER_SUPPLIER_TYPES` where `SPT_ID` = '.$_POST['type'].')', NULL, FALSE);
		if($_POST['status'] != "")
			$this->db->where('SUP_Status', $_POST['status']);

		$r = $this->db->get('SUPPLIER')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']           = ++$i; //generating index
			$ref['name']            = $ref['name'];
			$ref['sup_type_string'] = "";

			if(array_key_exists($ref['id'], $sup_types_array)) //getting supplier types of supplier
				$ref['sup_type_string'] = $sup_types_array[$ref['id']];

			$ref['action'] = "<a class = 'text-info' style = 'cursor:pointer' onclick ='editSupplier(".$ref['id'].")'><strong>Edit</strong></a> | ".($ref['status'] == 0 ? "<a onclick = 'quickToggleSupStatus(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>Activate</strong></a>" : "<a onclick = 'quickToggleSupStatus(".$ref['id'].");' class = 'text-danger' style = 'cursor:pointer'><strong>Deactivate</strong></a>"); //defining available actions as 
			$ref['status'] = ($ref['status'] == 0 ? 'Inactive' : 'Active');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function quick_toggle_sup_status()
	{
		$data = array();

		if($_POST['update_id'] != null && $_POST['update_id'] != '')
		{
			$this->db->select('SUP_Name as "name", SUP_Status as "status"');
			$this->db->where('SUP_ID', $_POST['update_id']);
			$r = $this->db->get('SUPPLIER')->row_array();

			if(empty($r))
			{
				$this->db->set_flashdata('e', 'Invalid Supplier ID. Please Try Again.');
				return false;
			}

			if($r['status'] == 1)
			{
				$this->db->select('COUNT(*) as "events"');
				$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.ENT_ID=EVENT.ENT_ID');
				$this->db->where('EAY_SUP_ID', $_POST['update_id']);
				$this->db->where('ENT_Date >=', date('Y-m-d'));
				$check = $this->db->get('EVENT')->row_array();

				if($check['events'] > 0)
				{
					$this->session->set_flashdata('e','Supplier is assigned to activities of an upcoming event. Cannot Deactive.');
					return false;
				}
			}
			

			$data['SUP_Status'] = ($r['status'] == 1 ? 0 : 1);

			$this->db->where('SUP_ID', $_POST['update_id']);
			$this->db->update('SUPPLIER', $data);

			if($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('s', 'Supplier - ' . $r['name'] . ' status quick update successful.');
				return true;
			}
			else
			{
				$this->session->set_flashdata('e', 'Supplier - ' . $r['name'] . ' status quick update failed.');
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function fetch_supplier()
	{
		$r = array();

		$this->db->select('SUP_ID as "id", SUP_Code as "code", SUP_Name as "name", SUP_Email as "email", SUP_Skype as "skype", SUP_Contact_person as "contat_person", SUP_Con_designation as "con_desig", SUP_Minimum_rate as "min_rate", SUP_Status as "status"');
		$this->db->where('SUP_ID', $_GET['id']);
		$r['supplier'] = $this->db->get('SUPPLIER')->row_array();

		$sup_types = array();
		$types     = array();

		$this->db->select('SPT_ID');
		$this->db->where('SUP_ID', $r['supplier']['id']);
		$sup_types = $this->db->get('SUPPLIER_SUPPLIER_TYPES')->result_array();

		foreach ($sup_types as $row) 
		{
			$types[] = $row['SPT_ID'];
		}

		$r['supplier']['sup_type'] = $types;

		$this->db->select('SPB_ID as "branch_id", SBP_Office_no as "office", SBP_Mobile_no as "mobile", SBP_Address as "address"');
		$this->db->where('SUP_ID', $_GET['id']);
		$r['branch'] = $this->db->get('SUPPLIER_BRANCH')->result_array();

		return $r;
	}

	function check_tasks()
	{
		$r = array();

		if($_GET['update_id'] != "false")
		{
			$this->db->select('COUNT(*) as "events"');
			$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.ENT_ID=EVENT.ENT_ID');
			$this->db->where('EAY_SUP_ID', $_GET['update_id']);
			$this->db->where('ENT_Date >=', date('Y-m-d'));
			$r = $this->db->get('EVENT')->row_array();
		}

		return $r;
	}
}