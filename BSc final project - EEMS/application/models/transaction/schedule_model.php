<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model
{
	function schedule_model()
	{
		parent:: __Construct();
	}

	function fetch_predata()
	{
		$data = array();

		$this->db->select('ENT_ID as "id", ENT_Code as "code"');
		$this->db->where('ENT_Complete', 0);
		$event = $this->db->get('EVENT')->result_array();

		$data['ent'][''] = 'Select Event';

		foreach($event as $row)
		{
			$data['ent'][$row['id']] = $row['code'];
		}

		return $data;
	}

	function fetch_events()
	{
		$data     = array();
		$events   = array();
		$meetings = array();
		$i        = 0;

		$start_date = $_POST['start'];
		$start      = date("Y-m-d", $start_date);
		$end_date   = $_POST['end'];
		$end        = date("Y-m-d", $end_date);

		$this->db->select('ENT_ID as "id", ENT_Code as "code", EVT_Event_type as "type", DATE(ENT_Date) as "date", ENT_Starttime as "start_time", ENT_Endtime as "end_time", CUS_Name as "customer", VEN_Name as "venue", ENT_Complete as "status"');
		$this->db->join('EVENT_TYPE', 'EVENT_TYPE.EVT_ID=EVENT.ENT_EVT_ID');
		$this->db->join('CUSTOMER', 'CUSTOMER.CUS_ID=EVENT.ENT_CUS_ID');
		$this->db->join('VENUE', 'VENUE.VEN_ID=EVENT.ENT_VEN_ID');
		$this->db->where('DATE(ENT_Date) >=', $start);
		$this->db->where('DATE(ENT_Date) <=', $end);
		$events = $this->db->get('EVENT')->result_array();

		foreach ($events as $row) 
		{
			$data[$i]['id']         = $row['id'];
			$data[$i]['type']       = "E";
			$data[$i]['title']      = $row['code'];
			$data[$i]['ent_type']   = $row['type'];
			$data[$i]['customer']   = $row['customer'];
			$data[$i]['venue']      = $row['venue'];
			$data[$i]['status']     = ($row['status'] == 1 ? "Complete" : "On Progress");
			$data[$i]['start']      = $row['date']."T".$row['start_time'];
			$data[$i]['end']        = $row['date']."T".$row['end_time'];
			$data[$i]['start_time'] = $row['start_time'];
			$data[$i]['end_time']   = $row['end_time'];

			$i++;
		}

		$this->db->select('MET_ID as "id", MET_Title as "title", MET_ENT_ID as "ent_id", MET_Date as "date", MET_Starttime as "start_time", MET_Endtime as "end_time", MET_Desc as "description", MET_Cancelled as "cancelled"');
		$this->db->where('DATE(MET_Date) >=', $start);
		$this->db->where('DATE(MET_Date) <=', $end);
		$meetings = $this->db->get('MEETING')->result_array();

		foreach ($meetings as $row) 
		{
			$data[$i]['id']         = "M-".$row['id'];
			$data[$i]['type']       = "M";
			$data[$i]['title']      = $row['title'];
			$data[$i]['start']      = $row['date']."T".$row['start_time'];
			$data[$i]['end']        = $row['date']."T".$row['end_time'];
			$data[$i]['date']       = $row['date'];
			$data[$i]['start_time'] = $row['start_time'];
			$data[$i]['end_time']   = $row['end_time'];
			$data[$i]['desc']       = $row['description'];
			$data[$i]['ent_id']     = $row['ent_id'];
			$data[$i]['cancelled']  = $row['cancelled'];
			$data[$i]['color']      = ($row['cancelled'] == 0 ? '#5CB85C' : '#D9534F');

			$i++;
		}

		return $data;
	}

	function save_meeting()
	{
		$this->form_validation->set_rules('title_input', 'Title', 'trim|required');
		$this->form_validation->set_rules('start_time_input', 'Start Time', 'trim|required');
		$this->form_validation->set_rules('end_time_input', 'End Time', 'trim|required');
		$this->form_validation->set_rules('desc_input', 'Description', 'trim|required');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		if($_POST['update_id'] == 'false')
		{
			$this->db->select('COUNT(*) as "count"');
			$this->db->where('DATE(ENT_DATE)', date('Y-m-d', $_POST['date']));
			$this->db->where('ENT_Starttime < ', $_POST['end_time_input']);
			$this->db->where('ENT_Endtime > ', $_POST['start_time_input']);
			$evt_count = $this->db->get('EVENT')->row_array();

			$this->db->select('COUNT(*) as "count"');
			$this->db->where('DATE(MET_Date)', date('Y-m-d', $_POST['date']));
			$this->db->where('MET_Starttime < ', $_POST['end_time_input']);
			$this->db->where('MET_Endtime > ', $_POST['start_time_input']);
			$this->db->where('MET_Cancelled', 0);
			$met_count = $this->db->get('MEETING')->row_array();
		}
		else
		{
			$this->db->select('COUNT(*) as "count"');
			$this->db->where('DATE(ENT_DATE)', $_POST['date']);
			$this->db->where('ENT_Starttime < ', $_POST['end_time_input']);
			$this->db->where('ENT_Endtime > ', $_POST['start_time_input']);
			$evt_count = $this->db->get('EVENT')->row_array();

			$this->db->select('COUNT(*) as "count"');
			$this->db->where('DATE(MET_Date)', $_POST['date']);
			$this->db->where('MET_Starttime < ', $_POST['end_time_input']);
			$this->db->where('MET_Endtime > ', $_POST['start_time_input']);
			$this->db->where('MET_Cancelled', 0);
			$this->db->where('MET_ID !=', $_POST['update_id']);
			$met_count = $this->db->get('MEETING')->row_array();
		}

		if($evt_count['count'] > 0 || $met_count['count'] > 0)
		{
			$this->session->set_flashdata('e', 'Time Slot Unavailable.');
			return false;
		}

		if($_POST['update_id'] == "false")
		{
			$data = array();

			$data['MET_Title']     = $_POST['title_input'];
			$data['MET_ENT_ID']    = $_POST['ent_select'];
			$data['MET_Starttime'] = $_POST['start_time_input'];
			$data['MET_Endtime']   = $_POST['end_time_input'];
			$data['MET_Desc']      = $_POST['desc_input'];
			$data['MET_Cancelled'] = (isset($_POST['met_cancel_check']) ? 1 : 0);
			$data['MET_Date']      = date('Y-m-d', $_POST['date']);
			$data['MET_User']      = $this->session->userdata('username');
			$data['MET_Timestamp'] = date('Y-m-d H:i:s');

			$this->db->insert('MEETING', $data);
			$met_id = $this->db->insert_id();

			$event = "Creation";
		}
		else
		{
			if($_POST['update_id'] != null)
			{
				$data = array();

				$data['MET_Title']           = $_POST['title_input'];
				$data['MET_ENT_ID']          = $_POST['ent_select'];
				$data['MET_Starttime']       = $_POST['start_time_input'];
				$data['MET_Endtime']         = $_POST['end_time_input'];
				$data['MET_Desc']            = $_POST['desc_input'];
				$data['MET_Cancelled']       = (isset($_POST['met_cancel_check']) ? 1 : 0);
				$data['MET_Date']            = $_POST['date'];
				$data['MET_UpdateUser']      = $this->session->userdata('username');
				$data['MET_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('MET_ID', $_POST['update_id']);
				$this->db->update('MEETING', $data);
				$met_id = $_POST['update_id'];
			}
			else
			{
				$this->session->set_flashdata('e', 'Invalid Meeting Selected.');
				return false;
			}

			$event = "Update";
		}

		if($this->db->affected_rows() > 0)
		{
			$events               = array();
			$events['id']         = "M-".$met_id;
			$events['title']      = $_POST['title_input'];
			$events['type']       = "M";
			$events['start']      = $data['MET_Date']."T".$data['MET_Starttime'];
			$events['end']        = $data['MET_Date']."T".$data['MET_Endtime'];
			$events['date']       = $data['MET_Date'];
			$events['start_time'] = $data['MET_Starttime'];
			$events['end_time']   = $data['MET_Endtime'];
			$events['desc']       = $data['MET_Desc'];
			$events['ent_id']     = $_POST['ent_select'];
			$events['cancelled']  = $data['MET_Cancelled'];
			$events['color']      = ($events['cancelled'] == 0 ? '#5CB85C' : '#D9534F');

			$this->session->set_flashdata('s', 'Meeting - ' . $_POST['title_input']. ' ' . $event . ' successful.');
			return $events;
		}
		else
		{
			$this->session->set_flashdata('e', 'Meeting - ' . $_POST['title_input']. ' ' . $event . ' failed.');
			return false;
		}
	}
}