<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_model extends CI_Model
{
	function event_model()
	{
		parent:: __Construct();

		//loading sequence generation library
		$this->load->library('sequence');
	}

	function fetch_predata()
	{
		$data = array();

		$this->db->select('CUS_ID as "id", CUS_Name as "name"');
		$this->db->where('CUS_Status', 1);
		$customers = $this->db->get('CUSTOMER')->result_array();

		$data['customer'][''] = "Select Customer";

		foreach ($customers as $row) 
		{
			$data['customer'][$row['id']] = $row['name'];
		}

		$this->db->select('VEN_ID as "id", VEN_Name as "name"');
		$this->db->where('VEN_status', 1);
		$venues = $this->db->get('VENUE')->result_array();

		$data['venue'][''] = "Select Venue";

		foreach ($venues as $row) 
		{
			$data['venue'][$row['id']] = $row['name'];
		}

		$this->db->select('EVT_ID as "id", EVT_Event_type as "name"');
		$this->db->where("EVT_Status", 1);
		$evt_types = $this->db->get('EVENT_TYPE')->result_array();

		$data['evt_types'][''] = "Select Event Type";

		foreach ($evt_types as $row) 
		{
			$data['evt_types'][$row['id']] = $row['name'];
		}		
		
		$sequence     = $this->sequence->generate_sequence('ENT', 10);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function reload_sequence()
	{
		$data         = array();
		$sequence     = $this->sequence->generate_sequence('ENT', 10);
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function fetch_lookup_predata()
	{
		$data = array();

		$this->db->select('CUS_ID as "id", CUS_Name as "name"');
		$this->db->where('CUS_Status', 1);
		$customers = $this->db->get('CUSTOMER')->result_array();

		$data['customer'][''] = "Filter Customer";

		foreach ($customers as $row) 
		{
			$data['customer'][$row['id']] = $row['name'];
		}

		$this->db->select('VEN_ID as "id", VEN_Name as "name"');
		$this->db->where('VEN_status', 1);
		$venues = $this->db->get('VENUE')->result_array();

		$data['venue'][''] = "Filter Venue";

		foreach ($venues as $row) 
		{
			$data['venue'][$row['id']] = $row['name'];
		}

		$this->db->select('EVT_ID as "id", EVT_Event_type as "name"');
		$this->db->where("EVT_Status", 1);
		$evt_types = $this->db->get('EVENT_TYPE')->result_array();

		$data['evt_types'][''] = "Filter Event Type";

		foreach ($evt_types as $row) 
		{
			$data['evt_types'][$row['id']] = $row['name'];
		}

		return $data;		
	}

	function fetch_halls()
	{
		$r = array();

		if($_GET['id'] != "")
		{
			$this->db->select('VNH_ID as "id", VNH_Hall_name as "name", VNH_Type as "type"');
			$this->db->where('VEN_ID', $_GET['id']);
			$r = $this->db->get('VENUE_HALLS')->result_array();
		}

		return $r;
	}

	function fetch_customers()
	{
		$r = array();

		$this->db->select('CUS_ID as "id", CUS_Name as "name"');
		$this->db->where('CUS_Status', 1);
		$r = $this->db->get('CUSTOMER')->result_array();
		
		return $r;
	}

	function fetch_suppliers()
	{
		$r     = array();
		$types = array();

		$this->db->select('SUP_ID as "sup_id", SUPPLIER_SUPPLIER_TYPES.SPT_ID as "type_id", SPT_Supplier_Type as "sup_type"');
		$this->db->join('SUPPLIER_TYPE', 'SUPPLIER_TYPE.SPT_ID=SUPPLIER_SUPPLIER_TYPES.SPT_ID');
		$types = $this->db->get('SUPPLIER_SUPPLIER_TYPES')->result_array();

		$sup_types_array = array();

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

		$this->db->select('SUP_ID as "id", SUP_Name as "name", SUP_Minimum_rate as "budget"');
		$this->db->where('SUP_Status', 1);
		$r = $this->db->get('SUPPLIER')->result_array();

		foreach ($r as $row => &$ref) 
		{
			$ref['sup_type_string'] = "";

			if(array_key_exists($ref['id'], $sup_types_array))
				$ref['sup_type_string'] = $sup_types_array[$ref['id']];
		}

		return $r;
	}


	function fetch_sup_types()
	{
		$r = array();

		if($_GET['id'] != "")
		{
			$this->db->select('SUP_ID as "sup_id", SUPPLIER_SUPPLIER_TYPES.SPT_ID as "id", SPT_Supplier_Type as "name"');
			$this->db->join('SUPPLIER_TYPE', 'SUPPLIER_TYPE.SPT_ID=SUPPLIER_SUPPLIER_TYPES.SPT_ID');
			$this->db->where('SUP_ID', $_GET['id']);
			$r = $this->db->get('SUPPLIER_SUPPLIER_TYPES')->result_array();
		}

		return $r;
	}

	function validate_activity()
	{
		$r = array();

		if($_POST['id'] != "")
		{
			$this->db->select('COUNT(*) as "count"');
			$this->db->where('ACL_EAY_ID', $_POST['id']);
			$r = $this->db->get('ACTIVITY_CHECKLIST')->row_array();
		}

		return $r;
	}

	function save_event() //save event
	{
		//back-end validation. provided by codeigniter framework
		$this->form_validation->set_rules('evt_code_input', 'Event Code', 'trim|required');
		$this->form_validation->set_rules('cus_select', 'Customer', 'trim|required');
		$this->form_validation->set_rules('evt_select', 'Event Type', 'trim|required');
		$this->form_validation->set_rules('evt_date_input', 'Event Date', 'trim|required');
		$this->form_validation->set_rules('start_time_input', 'Start Time', 'trim|required');
		$this->form_validation->set_rules('end_time_input', 'End Time', 'trim|required');
		$this->form_validation->set_rules('ven_select', 'Venue', 'trim|required');
		$this->form_validation->set_rules('hall_select', 'Hall', 'trim|required');
		$this->form_validation->set_rules('evt_budget_input', 'Event Budget', 'trim|required');
		$this->form_validation->set_rules('cus_req_input', 'Requirement', 'trim|required');
		

		if(isset($_POST['evt_complete_check'])) //validations only when event is completed
		{
			$this->form_validation->set_rules('ent_remarks_input', 'Event Remarks', 'trim|required');
			$this->form_validation->set_rules('act_budget_input', 'Actual Budget', 'trim|required');
			$this->form_validation->set_rules('total_fee_input', 'Total Fee', 'trim|required');
			$this->form_validation->set_rules('activity_list', 'Event Activities', 'callback_validate_activities');
		}
			

		if(!$this->form_validation->run()) //checking validation results. if validations failed
		{
			$this->session->set_flashdata('e', validation_errors()); //adding notfications to session to be displayed in the view
			return false;
		}

		//starting transaction since more than one insert happens
		$this->db->trans_strict(1);
		$this->db->trans_begin();

		if($_POST['update_id'] == "false") //during inital add
		{
			$data = array();

			//setting array to insert
			$data['ENT_Code']           = $_POST['evt_code_input'];
			$data['ENT_CUS_ID']         = $_POST['cus_select'];
			$data['ENT_EVT_ID']         = $_POST['evt_select'];
			$data['ENT_Date']           = $_POST['evt_date_input'];
			$data['ENT_Starttime']      = $_POST['start_time_input'];
			$data['ENT_Endtime']        = $_POST['end_time_input'];
			$data['ENT_VEN_ID']         = $_POST['ven_select'];
			$data['ENT_HALL_ID']        = $_POST['hall_select'];
			$data['ENT_Initial_budget'] = $_POST['evt_budget_input'];
			$data['ENT_Budget']         = $_POST['act_budget_input'];
			$data['ENT_Total_charge']   = $_POST['total_fee_input'];
			$data['ENT_Requirement']    = $_POST['cus_req_input'];
			$data['ENT_Remarks']        = $_POST['ent_remarks_input'];
			$data['ENT_Complete']       = (isset($_POST['evt_complete_check']) ? 1 : 0);
			$data['ENT_User']           = $this->session->userdata('username');
			$data['ENT_Timestamp']      = date('Y-m-d H:i:s');

			$this->db->insert('EVENT', $data); //insert statement
			$ent_id = $this->db->insert_id(); //getting ID of inserted record

			if(!empty( (array) json_decode($_POST['activity_list']) )) //if activties are available. 
			{
				$activity_list = (array) json_decode($_POST['activity_list']); //converting JSON string back to PHP variable
				$activity_data = array();
				$i             = 0;

				foreach ($activity_list as $row) //looping through the array of activities
				{
					$entry = (array) $row;

					$activity_data[$i]['ENT_ID']            = $ent_id;
					$activity_data[$i]['EAY_Activity']      = $entry['activity'];
					$activity_data[$i]['EAY_Description']   = $entry['desc'];
					$activity_data[$i]['EAY_Deadline']      = $entry['deadline'];
					$activity_data[$i]['EAY_SUP_ID']        = $entry['sup_id'];
					$activity_data[$i]['EAY_Role_IDs']      = $entry['role_ids'];
					$activity_data[$i]['EAY_Role_text']     = $entry['role'];
					$activity_data[$i]['EAY_Budget']        = $entry['budget']; 
					$activity_data[$i]['EAY_Complete_perc'] = $entry['com_perc'];

					$i++;
				}

				$this->db->insert_batch('EVENT_ACTIVITY', $activity_data); //batch insert of activites
			}

			$event = "Creation";
		}
		else //during update
		{
			if($_POST['update_id'] != null) //if update id is set
			{
				$data = array();

				$data['ENT_Code']            = $_POST['evt_code_input'];
				$data['ENT_CUS_ID']          = $_POST['cus_select'];
				$data['ENT_EVT_ID']          = $_POST['evt_select'];
				$data['ENT_Date']            = $_POST['evt_date_input'];
				$data['ENT_Starttime']       = $_POST['start_time_input'];
				$data['ENT_Endtime']         = $_POST['end_time_input'];
				$data['ENT_VEN_ID']          = $_POST['ven_select'];
				$data['ENT_HALL_ID']         = $_POST['hall_select'];
				$data['ENT_Initial_budget']  = $_POST['evt_budget_input'];
				$data['ENT_Budget']          = $_POST['act_budget_input'];
				$data['ENT_Total_charge']    = $_POST['total_fee_input'];
				$data['ENT_Requirement']     = $_POST['cus_req_input'];
				$data['ENT_Remarks']         = $_POST['ent_remarks_input'];
				$data['ENT_Complete']        = (isset($_POST['evt_complete_check']) ? 1 : 0);
				$data['ENT_UpdateUser']      = $this->session->userdata('username');
				$data['ENT_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('ENT_ID', $_POST['update_id']); //updateing
				$this->db->update('EVENT', $data);
				$ent_id = $_POST['update_id'];

				if(!empty((array) json_decode($_POST['remove_activity_list']))) //if activites to be removed are present
				{
					$remove_activity_list = (array) json_decode($_POST['remove_activity_list']);
					$remove_ids           = array();

					foreach ($remove_activity_list as $row)
					{
						$entry = (array) $row;

						$remove_ids[] = $entry['act_id'];
					}

					$this->db->where_in('EAY_ID', $remove_ids);
					$this->db->delete('EVENT_ACTIVITY'); //deleteing activites
				}

				if(!empty( (array) json_decode($_POST['activity_list']) )) //if activities are avaiable
				{
					$activity_list = (array) json_decode($_POST['activity_list']);
					$activity_data = array();
					$i             = 0;

					foreach ($activity_list as $row) 
					{
						$entry = (array) $row;

						if($entry['new'] == 1) //checking if new activites are available. Only these are inserted
						{
							$activity_data[$i]['ENT_ID']            = $ent_id;
							$activity_data[$i]['EAY_Activity']      = $entry['activity'];
							$activity_data[$i]['EAY_Description']   = $entry['desc'];
							$activity_data[$i]['EAY_Deadline']      = $entry['deadline'];
							$activity_data[$i]['EAY_SUP_ID']        = $entry['sup_id'];
							$activity_data[$i]['EAY_Role_IDs']      = $entry['role_ids'];
							$activity_data[$i]['EAY_Role_text']     = $entry['role'];
							$activity_data[$i]['EAY_Budget']        = $entry['budget']; 
							$activity_data[$i]['EAY_Complete_perc'] = $entry['com_perc'];

							$i++;
						}
					}

					if(!empty($activity_data)) //if data is available for insert
						$this->db->insert_batch('EVENT_ACTIVITY', $activity_data); //batch insert
				}
			}

			$event = "Update";
		}

		if($this->db->trans_status() == false) //checking transaction status. if error occured
		{
			//set notification to session
			$this->session->set_flashdata('e', 'Event - ' . $_POST['evt_code_input'] . ' '. $event . ' failed.');
			$this->db->trans_rollback(); //rollback changes
			return false;
		}
		else //if successful
		{
			$this->session->set_flashdata('s', 'Event - ' . $_POST['evt_code_input'] . ' '. $event . ' successful.');
			$this->db->trans_commit(); //commmit
			return true;
		}
	}

	function validate_event() //validating the event date selected
	{
		$r = array(); //empty array

		if($_GET['date'] != "" && $_GET['start'] != "" && $_GET['end'] != "") //checking if passed date start and end values are empty or not
		{
			//fetching event count
			$this->db->select('COUNT(*) as count');
			$this->db->where('DATE(ENT_Date)', $_GET['date']);
			$r['e'] = $this->db->get('EVENT')->row_array();

			//fetching meetings during selected date and time period
			$this->db->select('COUNT(*) as count');
			$this->db->where('DATE(MET_Date)', $_GET['date']);
			$this->db->where('MET_Starttime < ', $_GET['end']);
			$this->db->where('MET_Endtime > ', $_GET['start']);
			$this->db->where('MET_Cancelled', 0);
			$r['m'] = $this->db->get('MEETING')->row_array();

			return $r; //return data.
		}
		else //if date is not passed with a value
		{
			$this->session->set_flashdata('e', 'Event Date, Start Time & End Time is Required.'); //add to notification session which will be displayed in the view
			return false;
		}
	}

	function validate_activities($str)
	{
		$activity_list = array();

		$activity_list = (array) json_decode($str);

		if(!(empty($activity_list)))
		{
			return true;
		}
		else 
		{
			$this->form_validation->set_message('validate_activities', 'The Event Activites are not Defined.');
			return false;
		}
	}

	function fetch_events()
	{
		$r    = array();
		$data = array();

		$this->db->select('ENT_ID as "id", ENT_Code as "code", EVT_Event_type as "type", DATE(ENT_Date) as "date", CUS_Name as "customer", VEN_Name as "venue", ENT_Complete as "status"');
		$this->db->join('EVENT_TYPE', 'EVENT_TYPE.EVT_ID=EVENT.ENT_EVT_ID');
		$this->db->join('CUSTOMER', 'CUSTOMER.CUS_ID=EVENT.ENT_CUS_ID');
		$this->db->join('VENUE', 'VENUE.VEN_ID=EVENT.ENT_VEN_ID');

		if($_POST['from'] != null)
			$this->db->where('DATE(ENT_Date) >=', $_POST['from']);
		if($_POST['to'] != null)
			$this->db->where('DATE(ENT_Date) <=', $_POST['to']);
		if($_POST['customer'] != null)
			$this->db->where('ENT_CUS_ID ', $_POST['customer']);
		if($_POST['venue'] != null)
			$this->db->where('ENT_VEN_ID', $_POST['venue']);
		if($_POST['type'] != null)
			$this->db->where('ENT_EVT_ID', $_POST['type']);

		$r = $this->db->get('EVENT')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']  = ++$i;
			$ref['action'] = ($ref['status'] == 0 ? "<a onclick = 'editEvent(".$ref['id'].");' class = 'text-info' style = 'cursor:pointer'><strong>Edit</strong></a>" : "<a onclick = 'viewEvent(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>View</strong></a>");
			$ref['status'] = ($ref['status'] == 0 ? 'On Progress' : 'Completed');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function fetch_event()
	{
		$r = array();

		if($_GET['id'] != "")
		{
			$this->db->select('ENT_ID as "id", ENT_Code as "code", ENT_CUS_ID as "cus_id", ENT_EVT_ID as "type", DATE(ENT_Date) as "date", ENT_Starttime as "start", ENT_Endtime as "end", ENT_VEN_ID as "ven_id", ENT_HALL_ID as "hall_id", ENT_Initial_budget as "ini_budget", ENT_Budget as "budget", ENT_Total_charge as "fee", ENT_Complete as "status", ENT_Requirement as "req", ENT_Remarks as "remarks"');
			$this->db->where('ENT_ID', $_GET['id']);
			$r['event'] = $this->db->get('EVENT')->row_array();

			$this->db->select('EAY_ID as "act_id", EAY_Activity as "activity", EAY_Description as "desc", DATE(EAY_Deadline) as "deadline", EAY_SUP_ID as "sup_id", SUP_Name as "sup_name", EAY_Role_IDs as "role_ids", EAY_Role_text as "roles", EAY_Budget as "act_budget", EAY_Complete_perc as "com_perc"');
			$this->db->join('SUPPLIER', 'SUPPLIER.SUP_ID=EVENT_ACTIVITY.EAY_SUP_ID');
			$this->db->where('ENT_ID', $_GET['id']);
			$r['activities'] = $this->db->get('EVENT_ACTIVITY')->result_array();
		}

		return $r;
	}
}