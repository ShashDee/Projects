<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_rate_report_model extends CI_Model
{
	function event_rate_report_model()
	{
		parent:: __Construct();
	}

	// function fetch_predata()
	// {
	// 	$data = array();

	// 	$this->db->select('ENT_ID as "id", ENT_Code as "code", ENT_Complete as "status"');
	// 	$event = $this->db->get('EVENT')->result_array();

	// 	$data['ent_select'] = '<option value = "">Select Event</option>';

	// 	foreach($event as $row)
	// 	{
	// 		$data['ent_select'] .= '<option data-status = "'.$row['status'].'" value = "'.$row['id'].'">' . $row['code'] . '</option>';
	// 	}

	// 	return $data;
	// }

	function fetch_event_count()
	{
		$r    = array();
		$data = array();

		if($_POST['from'] != "" || $_POST['to'] != "")
		{
			$this->db->select('COUNT(*) as "count", EVT_Event_type as "type", EVT_ID as "id"');
			$this->db->join('EVENT_TYPE', 'EVENT_TYPE.EVT_ID=EVENT.ENT_EVT_ID');

			if($_POST['from'] != "")
				$this->db->where('DATE(ENT_Date) >=', $_POST['from']);
			if($_POST['to'] != "")
				$this->db->where('DATE(ENT_Date) <=', $_POST['to']);

			$this->db->group_by('EVT_ID');
			$r = $this->db->get('EVENT')->result_array();

			$i = 0;

			foreach ($r as $row => &$ref) 
			{
				$ref['index'] = ++$i;
			}
		}

		$data['aaData'] = $r;

		return $data;
	}

	function fetch_event_count_graph() //fetching data for event count bar graph
	{
		$r = array(); //initializing

		//fetching no. of events for each event type
		$this->db->select('COUNT(*) as "count", EVT_Event_type as "type"');
		$this->db->join('EVENT_TYPE', 'EVENT_TYPE.EVT_ID=EVENT.ENT_EVT_ID');

		if($_POST['from'] != "") //applyinh filters
			$this->db->where('DATE(ENT_Date) >=', $_POST['from']);
		if($_POST['to'] != "")
			$this->db->where('DATE(ENT_Date) <=', $_POST['to']);

		$this->db->group_by('EVT_ID'); //grouping by event type
		$r = $this->db->get('EVENT')->result_array();

		$data = array();

		if(!empty($r))
		{
			foreach ($r as $row) 
			{
				//setting up array in format for graph
				$data[] = array('label' => $row['type'] , 'value' => $row['count']);
			}

			return array('key' => 'Event Rate', 'values' => $data); //data array for graph
		}
		else
		{
			return null;
		}
	}

	function fetch_events()
	{
		$r = array();

		if(($_POST['from'] != "" || $_POST['to'] != "") && $_POST['data']['id'] != "")
		{
			$this->db->select('ENT_ID as "id", ENT_Code as "code", DATE(ENT_Date) as "date"');
			$this->db->where('ENT_EVT_ID', $_POST['data']['id']);

			if($_POST['from'] != "")
				$this->db->where('DATE(ENT_Date) >=', $_POST['from']);
			if($_POST['to'] != "")
				$this->db->where('DATE(ENT_Date) <=', $_POST['to']);

			$r = $this->db->get('EVENT')->result_array();
		}

		return $r;
	}

	function fetch_event()
	{
		$r = array();

		if($_POST['id'] != "")
		{
			$this->db->select('ENT_ID as "id", ENT_Code as "code", DATE(ENT_Date) as "date", ENT_Starttime as "start", ENT_Endtime as "end", ENT_Initial_budget as "ini_budget", ENT_Budget as "budget", ENT_Complete as "status", ENT_Requirement as "req", ENT_Remarks as "remarks", EVT_Event_type as "type", CUS_Name as "customer", VEN_Name as "venue", VNH_Hall_name as "hall"');
			$this->db->join('EVENT_TYPE', 'EVENT_TYPE.EVT_ID=EVENT.ENT_EVT_ID');
			$this->db->join('CUSTOMER', 'CUSTOMER.CUS_ID=EVENT.ENT_CUS_ID');
			$this->db->join('VENUE', 'VENUE.VEN_ID=EVENT.ENT_VEN_ID');
			$this->db->join('VENUE_HALLS', 'VENUE_HALLS.VEN_ID=VENUE.VEN_ID');
			$this->db->where('ENT_ID', $_POST['id']);
			$r['main'] = $this->db->get('EVENT')->row_array();

			$this->db->select('EAY_ID as "act_id", EAY_Activity as "activity", EAY_Description as "desc", DATE(EAY_Deadline) as "deadline", EAY_SUP_ID as "sup_id", SUP_Name as "sup_name", EAY_Role_IDs as "role_ids", EAY_Role_text as "roles", EAY_Budget as "act_budget", EAY_Complete_perc as "com_perc"');
			$this->db->join('SUPPLIER', 'SUPPLIER.SUP_ID=EVENT_ACTIVITY.EAY_SUP_ID');
			$this->db->where('ENT_ID', $_POST['id']);
			$r['activities'] = $this->db->get('EVENT_ACTIVITY')->result_array();
		}

		return $r;
	}
}