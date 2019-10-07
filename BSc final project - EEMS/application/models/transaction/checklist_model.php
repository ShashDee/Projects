<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklist_model extends CI_Model
{
	function checklist_model()
	{
		parent:: __Construct();
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

	function fetch_predata()
	{
		$data = array();

		$this->db->select('EMP_ID as "id", EMP_Fullname as "name"');
		$this->db->where('EMP_status', 1);
		$emps = $this->db->get('EMPLOYEE')->result_array();

		$data['emp'][''] = "Select Team Member";

		foreach ($emps as $row) 
		{
			$data['emp'][$row['id']] = $row['name'];
		}

		return $data;
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

		$this->db->select('ENT_ID as "id", COUNT(*) as "act_count"');
		$this->db->group_by('ENT_ID');
		$act_counts = $this->db->get('EVENT_ACTIVITY')->result_array();

		$act_array = array();

		foreach ($act_counts as $row) 
		{
			$act_array[$row['id']] = $row['act_count'];
		}

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']     = ++$i;
			$ref['act_count'] = 0;

			if(array_key_exists($ref['id'], $act_array))
				$ref['act_count'] = $act_array[$ref['id']];

			$ref['action'] = ($ref['status'] == 0 ? "<a onclick = 'addChecklist(".$ref['id'].");' class = 'text-info' style = 'cursor:pointer'><strong>Add Checklist</strong></a>" : "<a onclick = 'viewChecklist(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>View Checklist</strong></a>"); 
			$ref['status'] = ($ref['status'] == 0 ? 'On Progress' : 'Completed');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function fetch_activities()
	{
		$r = array();

		if($_GET['id'] != "")
		{
			$this->db->select('EAY_ID as "act_id", , EAY_Activity as "activity", DATE(EAY_Deadline) as "deadline"');
			$this->db->where('ENT_ID', $_GET['id']);
			$r = $this->db->get('EVENT_ACTIVITY')->result_array();
		}

		return $r;
	}

	function fetch_checklists()
	{
		$r    = array();
		$data = array();

		if($_GET['id'] != "")
		{
			$this->db->select('ACL_ID as "id", ACL_EAY_ID as "act_id", EAY_Activity as "activity", DATE(EAY_Deadline) as "deadline", ACL_Checklist_item as "item", ACL_Incharge as "incharge", EMP_Fullname as "assigned_name", ACL_Status as "status", DATE(ACL_Deadline) as "ckl_deadline", ACL_Completed_on as "completed"');
			$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
			$this->db->join('EVENT', 'EVENT.ENT_ID=EVENT_ACTIVITY.ENT_ID');
			$this->db->join('EMPLOYEE', 'EMPLOYEE.EMP_ID=ACTIVITY_CHECKLIST.ACL_Incharge');
			$this->db->where('EVENT.ENT_ID', $_GET['id']);
			$r = $this->db->get('ACTIVITY_CHECKLIST')->result_array();
		}

		$data['aaData'] = $r;
		return $data;
	}

	function fetch_lp_checklists()
	{
		$r    = array();
		$data = array();

		if($_POST['id'] != "")
		{
			$this->db->select('ACL_ID as "id", ACL_EAY_ID as "act_id", EAY_Activity as "activity", DATE(EAY_Deadline) as "deadline", ACL_Checklist_item as "item", ACL_Incharge as "incharge", EMP_Fullname as "assigned_name", ACL_Status as "status", DATE(ACL_Deadline) as "ckl_deadline", ACL_Completed_on as "completed"');
			$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
			$this->db->join('EVENT', 'EVENT.ENT_ID=EVENT_ACTIVITY.ENT_ID');
			$this->db->join('EMPLOYEE', 'EMPLOYEE.EMP_ID=ACTIVITY_CHECKLIST.ACL_Incharge');
			$this->db->where('EVENT.ENT_ID', $_POST['id']);

			if($_POST['from'] != "")
				$this->db->where('DATE(ACL_Deadline) >=', $_POST['from']);
			if($_POST['to'] != "")
				$this->db->where('DATE(ACL_Deadline) <=', $_POST['to']);
			if($_POST['employee'] != "")
				$this->db->where('ACL_Incharge', $_POST['employee']);

			$this->db->order_by('act_id', 'ASC');
			$r = $this->db->get('ACTIVITY_CHECKLIST')->result_array();

			$i = 0;

			foreach ($r as $row => &$ref) 
			{
				$ref['index']  = ++$i;
				$ref['status'] = ($ref['status'] == 1 ? "Completed" : "On Progress");
			}
		}

		$data['aaData'] = $r;
		return $data;
	}

	function save_checklists()
	{
		$this->form_validation->set_rules('checklist_items', 'Activity Checklist(s)', 'callback_validate_checklist');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		$this->db->trans_strict(1);
		$this->db->trans_begin();

		$com_array = array();

		if(!empty( (array) json_decode($_POST['remove_checklist_items'])) )
		{
			$remove_checklist_items = (array) json_decode($_POST['remove_checklist_items']);
			$remove_ids             = array();

			foreach ($remove_checklist_items as $row)
			{
				$entry = (array) $row;

				if(!array_key_exists($entry['act_id'], $com_array))
				{
					$this->db->select('COUNT(*) as "tot_count"');
					$this->db->where('ACL_EAY_ID', $entry['act_id']);
					$r_tot = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

					$com_array[$entry['act_id']]['tot'] = (($r_tot['tot_count'] - 1) > 0 ? --$r_tot['tot_count'] : 0);

					if($com_array[$entry['act_id']]['tot'] == 0)
						$com_array[$entry['act_id']]['com'] = 0;
				}
				else
				{
					if(($com_array[$entry['act_id']]['tot'] - 1) > 0)
						--$com_array[$entry['act_id']]['tot'];
					else
					{
						$com_array[$entry['act_id']]['tot'] = 0;
						$com_array[$entry['act_id']]['com'] = 0;
					}
				}

				$remove_ids[] = $entry['acl_id'];
			}

			$this->db->where_in('ACL_ID', $remove_ids);
			$this->db->delete('ACTIVITY_CHECKLIST');
		}

		$checklist_items    = (array) json_decode($_POST['checklist_items']);
		$checklist_data     = array();
		$upd_checklist_data = array();
		$i                  = 0;
		$upd_i              = 0;
		$actvitiy_data      = array();
		$act_i              = 0;

		foreach ($checklist_items as $row) 
		{
			$entry = (array) $row;

			if(!array_key_exists($entry['act_id'], $com_array))
			{
				$this->db->select('COUNT(*) as "com_count"');
				$this->db->where('ACL_EAY_ID', $entry['act_id']);
				$this->db->where('ACL_Status', 1);
				$com = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

				$this->db->select('COUNT(*) as "tot_count"');
				$this->db->where('ACL_EAY_ID', $entry['act_id']);
				$tot = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

				$com_array[$entry['act_id']]['com'] = $com['com_count'];
				$com_array[$entry['act_id']]['tot'] = $tot['tot_count'];

				if($entry['new'] == 1)
				{
					++$com_array[$entry['act_id']]['tot'];

					if($entry['status'] == 1)
						++$com_array[$entry['act_id']]['com'];
				}
				else if($entry['new'] == 0 && $entry['old_status'] == 0 && $entry['status'] == 1)
					++$com_array[$entry['act_id']]['com'];
				else if($entry['new'] == 0 && $entry['old_status'] == 1 && $entry['status'] == 0)
					--$com_array[$entry['act_id']]['com'];
			}
			else
			{
				if(!array_key_exists('com', $com_array[$entry['act_id']]))
				{
					$this->db->select('COUNT(*) as "com_count"');
					$this->db->where('ACL_Status', 1);
					$this->db->where('ACL_EAY_ID', $entry['act_id']);
					$this->db->where_not_in('ACL_ID', $remove_ids);
					$r_count = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

					$com_array[$entry['act_id']]['com'] = $r_count['com_count'];
				}

				if($entry['new'] == 1)
				{
					++$com_array[$entry['act_id']]['tot'];

					if($entry['status'] == 1)
						++$com_array[$entry['act_id']]['com'];
				}
				else if($entry['new'] == 0 && $entry['old_status'] == 0 && $entry['status'] == 1)
					++$com_array[$entry['act_id']]['com'];
				else if($entry['new'] == 0 && $entry['old_status'] == 1 && $entry['status'] == 0)
					--$com_array[$entry['act_id']]['com'];
			}

			if($entry['new'] == 1)
			{
				$checklist_data[$i]['ACL_EAY_ID']         = $entry['act_id'];
				$checklist_data[$i]['ACL_Checklist_item'] = $entry['checklist_itm'];
				$checklist_data[$i]['ACL_Incharge']       = $entry['emp_id'];
				$checklist_data[$i]['ACL_Status']         = $entry['status'];
				$checklist_data[$i]['ACL_Deadline']       = $entry['deadline']; 
				$checklist_data[$i]['ACL_Completed_on']   = ($entry['status'] == 1 ? date('Y-m-d H:i:s') : '');
				$checklist_data[$i]['ACL_User']           = $this->session->userdata('username'); 
				$checklist_data[$i]['ACL_Timestamp']      = date('Y-m-d H:i:s');  

				$i++;
			}
			else if($entry['new'] == 0)
			{
				$upd_checklist_data[$upd_i]['ACL_ID']              = $entry['acl_id'];
				$upd_checklist_data[$upd_i]['ACL_EAY_ID']          = $entry['act_id'];
				$upd_checklist_data[$upd_i]['ACL_Checklist_item']  = $entry['checklist_itm'];
				$upd_checklist_data[$upd_i]['ACL_Incharge']        = $entry['emp_id'];
				$upd_checklist_data[$upd_i]['ACL_Status']          = $entry['status'];
				$upd_checklist_data[$upd_i]['ACL_Deadline']        = $entry['deadline']; 
				$upd_checklist_data[$upd_i]['ACL_Completed_on']    = ($entry['old_status'] == 0 && $entry['status'] == 1 ? date('Y-m-d H:i:s') : ($entry['old_status'] == 1 && $entry['status'] == 0 ? '' : $entry['org_com_date'])); 
				$upd_checklist_data[$upd_i]['ACL_UpdateUser']      = $this->session->userdata('username'); 
				$upd_checklist_data[$upd_i]['ACL_UpdateTimestamp'] = date('Y-m-d H:i:s');  

				$upd_i++;
			}
		}

		if(!empty($checklist_data))
			$this->db->insert_batch('ACTIVITY_CHECKLIST', $checklist_data);

		if(!empty($upd_checklist_data))
			$this->db->update_batch('ACTIVITY_CHECKLIST', $upd_checklist_data, 'ACL_ID');

		if(!empty($com_array))
		{
			foreach ($com_array as $key => $row) 
			{
				$act_array[$act_i]['EAY_ID'] = $key;

				if($row['tot'] > 0)
					$act_array[$act_i]['EAY_Complete_perc'] = ($row['com']/$row['tot']) * 100;
				else
					$act_array[$act_i]['EAY_Complete_perc'] = 0;

				$act_i++;	
			} 

			$this->db->update_batch('EVENT_ACTIVITY', $act_array, 'EAY_ID');
		}

		$event = "Creation";

		if($this->db->trans_status() == false)
		{
			$this->session->set_flashdata('e', 'Checklist '. $event . ' failed.');
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->session->set_flashdata('s', 'Checklist '. $event . ' successful.');
			$this->db->trans_commit();
			return true;
		}
	}

	function validate_checklist($str)
	{
		$checklist_items = array();

		$checklist_items = (array) json_decode($str);

		if(!(empty($checklist_items)))
		{
			return true;
		}
		else 
		{
			$this->form_validation->set_message('validate_checklist', 'The Activity Checklist(s) are not Defined.');
			return false;
		}
	}
}