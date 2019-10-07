<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_summary_report_model extends CI_Model
{
	function event_summary_report_model()
	{
		parent:: __Construct();
	}

	function fetch_predata()
	{
		$data = array();

		$this->db->select('ENT_ID as "id", ENT_Code as "code", ENT_Complete as "status"');
		$event = $this->db->get('EVENT')->result_array();

		$data['ent_select'] = '<option value = "">Select Event</option>';

		foreach($event as $row)
		{
			$data['ent_select'] .= '<option data-status = "'.$row['status'].'" value = "'.$row['id'].'">' . $row['code'] . '</option>';
		}

		return $data;
	}

	function fetch_event_progress() //fetching event progress percentage
	{
		//initializing
		$r        = array();
		$tot_ckl  = 0;
		$com_ckl  = 0;
		$progress = 0;

		if($_POST['ent_id'] != "") //if event ID is present
		{
			$this->db->select('COUNT(*) as "tot_ckl"'); //fetching total number of checklist items
			$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
			$this->db->where('ENT_ID', $_POST['ent_id']);
			$tot_ckl = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

			$this->db->select('COUNT(*) as "com_ckl"'); //fetching total number of completed checklist items
			$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
			$this->db->where('ENT_ID', $_POST['ent_id']);
			$this->db->where('ACL_Status', 1);
			$com_ckl = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

			if($tot_ckl['tot_ckl'] > 0)
				$progress = round(($com_ckl['com_ckl'] / $tot_ckl['tot_ckl']) * 100, 2); //percentage calculation 
		}

		$r['progress_perc'] = $progress;

		return $r;
	}

	function fetch_buget_info()
	{
		$r    = array();
		$data = array();

		if($_POST['ent_id'] != "")
		{
			$this->db->select('ENT_Code as "ent_code", ENT_Initial_budget as "ini_budget", ENT_Budget as "act_budget"');
			$this->db->where('ENT_ID', $_POST['ent_id']);
			$r = $this->db->get('EVENT')->result_array();

			foreach ($r as $row => &$ref) 
			{
				if($ref['act_budget'] != null && $ref['act_budget'] != "" && $ref['act_budget'] != 0)
				{
					$variance = $ref['ini_budget'] - $ref['act_budget'];

					if($variance > 0)
					{
						$ref['var_plus']  = $variance;
						$ref['var_minus'] = '';
					}
					else
					{
						$ref['var_minus'] = abs($variance);	
						$ref['var_plus']  = '';
					}

					$ref['ini_budget'] = "Rs. " . $ref['ini_budget'];
					$ref['act_budget'] = "Rs. " . $ref['act_budget'];
				}
				else
				{
					$ref['ini_budget'] = "Rs. " . $ref['ini_budget'];
					$ref['act_budget'] = "Data Pending";
					$ref['var_plus']   = ' - ';
					$ref['var_minus']  = ' - ';
				}
			}
		}

		$data['aaData'] = $r;

		return $data;
	}

	function fetch_basic_info()
	{
		$r = array();

		if($_POST['ent_id'] != "")
		{
			$this->db->select('ENT_ID as "id", ENT_Code as "code", EVT_Event_type as "type", DATE(ENT_Date) as "date", CUS_Name as "customer", VEN_Name as "venue", VNH_Hall_name as "hall", ENT_Complete as "status",ENT_Starttime as "st", ENT_Endtime as "et"');
			$this->db->join('EVENT_TYPE', 'EVENT_TYPE.EVT_ID=EVENT.ENT_EVT_ID');
			$this->db->join('CUSTOMER', 'CUSTOMER.CUS_ID=EVENT.ENT_CUS_ID');
			$this->db->join('VENUE', 'VENUE.VEN_ID=EVENT.ENT_VEN_ID');
			$this->db->join('VENUE_HALLS', 'VENUE_HALLS.VEN_ID=VENUE.VEN_ID');
			$this->db->where('ENT_ID', $_POST['ent_id']);
			$r = $this->db->get('EVENT')->row_array();

			$this->db->select('COUNT(*) as "count"');
			$this->db->where('ENT_ID', $_POST['ent_id']);
			$act_count = $this->db->get('EVENT_ACTIVITY')->row_array();

			$r['act_count'] = $act_count['count'];
			$r['status']    = ($r['status'] == 0 ? "<span class='label label-warning'>On Progress</span>" : "<span class='label label-success'>Complete</span>");
		}

		return $r;
	}

	function fetch_progress_rate() //fetch event progress rate
	{
		$r = array(); //empty array

		//fetch all dates where checklist items have been completed on
		$this->db->select('DATE(ACL_Completed_on) as "dates"');
		$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
		$this->db->where('ACL_Status', 1);
		$this->db->where('ENT_ID', $_POST['ent_id']);
		$this->db->group_by('DATE(ACL_Completed_on)');
		$this->db->order_by('DATE(ACL_Completed_on)', 'asc');
		$dates = $this->db->get('ACTIVITY_CHECKLIST')->result_array();

		//fetch total number of checklist items on each day of completion
		$this->db->select('COUNT(*) as "check_count", DATE(ACL_Completed_on) as "date"');
		$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
		$this->db->where('ACL_Status', 1);
		$this->db->where('ENT_ID', $_POST['ent_id']);
		$this->db->group_by('DATE(ACL_Completed_on)');
		$this->db->order_by('DATE(ACL_Completed_on)', 'asc');
		$counts = $this->db->get('ACTIVITY_CHECKLIST')->result_array();

		$count_array = array(); //empty array

		foreach ($counts as $row) //looping through array containing total no. of completed checklist items for each date where an checklist items was completed
		{
			//new array with date as key holding the total number of completed checklist items
			$count_array[$row['date']] = $row['check_count'];
		}

		$data  = array(); //empty array
		$count = 0; //counter

		if(!empty($dates))
		{
			$tot_count = 0; //total no.of completed checklist items

			foreach ($dates as $row) 
			{
				$tot_count += (float) $count_array[$row['dates']]; //adding to the total count of completed checklist items
				$data[]    = array('x'=> $count, 'y'=> $tot_count, 'series'=> 0, 'label' => date('Y-m-d', strtotime($row['dates'])), 'label1' => "Checklist item count:" . $count_array[$row['dates']]); //creating array with graph values

				$count++;	
			}

			return array('color' => "#0080FF", 'key' => 'Progress', 'seriesIndex'=>0, 'values' => $data); //return array with graph values and other data
		}
		else
		{
			return null; //return null if no data
		}
	}

	function fetch_activity_budget()
	{
		$r = array();
		
		$this->db->select('EAY_ID as "id", EAY_Activity as "act", EAY_Description as "desc", EAY_Budget as "budget"');
		$this->db->where('ENT_ID', $_POST['ent_id']);
		$r = $this->db->get('EVENT_ACTIVITY')->result_array();

		$data = array();

		if(!empty($r))
		{
			foreach ($r as $row) 
			{
				$data[] = array('label' => $row['act'] , 'value' => (float) $row['budget']);
			}

			return array('key' => 'Activity Budget Breakdown', 'values' => $data);
		}
		else
		{
			return null;
		}
	}
}