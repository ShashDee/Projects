<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_type_model extends CI_Model
{
	function event_type_model()
	{
		parent:: __Construct();

		//loading sequence generation library
		$this->load->library('sequence');
	}

	function fetch_predata()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('EVT', 6);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function reload_sequence()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('EVT', 6);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function save_event_type()
	{
		$this->form_validation->set_rules('evt_code_input', 'Event Type Code', 'trim|required');
		$this->form_validation->set_rules('event_type_input', 'Event Type', 'trim|required');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e',validation_errors());
			return false;
		}

		if($_POST['update_id'] == 'false')
		{
			$data = array();

			$data['EVT_Code']       = $_POST['evt_code_input'];
			$data['EVT_Event_type'] = $_POST['event_type_input'];
			$data['EVT_Shortname']  = $_POST['event_short_input'];
			$data['EVT_Status']     = (isset($_POST['status_switch']) ? 1 : 0);
			$data['EVT_User']       = $this->session->userdata('username');
			$data['EVT_Timestamp']  = date('Y-m-d H:i:s');

			$this->db->insert('EVENT_TYPE', $data);

			$event = "Creation";
		}
		else
		{
			if($_POST['update_id'] != null)
			{
				$data = array();

				$data['EVT_Code']            = $_POST['evt_code_input'];
				$data['EVT_Event_type']      = $_POST['event_type_input'];
				$data['EVT_Shortname']       = $_POST['event_short_input'];
				$data['EVT_Status']          = (isset($_POST['status_switch']) ? 1 : 0);
				$data['EVT_UpdateUser']      = $this->session->userdata('username');
				$data['EVT_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('EVT_ID', $_POST['update_id']);
				$this->db->update('EVENT_TYPE', $data);
			}

			$event = "Update";
		}

		if($this->db->affected_rows() > 0)
		{
			$this->session->set_flashdata('s', 'Event Type - ' . $_POST['event_type_input'] . ' '. $event . ' successful.');
			return true;
		}
		else
		{
			$this->session->set_flashdata('e', 'Event Type - ' . $_POST['event_type_input'] . ' '. $event . ' failed.');
			return false;
		}
	}

	function fetch_event_types()
	{
		$r    = array();
		$data = array();

		$this->db->select('EVT_ID as "id", EVT_Event_type as "event_type", EVT_Shortname as "shortname", EVT_Status as "status", EVT_User as "user"');

		if($_POST['status'] != null)
			$this->db->where('EVT_Status', $_POST['status']);

		$r = $this->db->get('EVENT_TYPE')->result_array();

		$i = 0 ;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']  = ++$i;
			$ref['action'] = "<a class = 'text-info' style = 'cursor:pointer' onclick ='editEventType(".$ref['id'].")'><strong>Edit</strong></a> | ".($ref['status'] == 0 ? "<a onclick = 'quickToggleEVTStatus(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>Activate</strong></a>" : "<a onclick = 'quickToggleEVTStatus(".$ref['id'].");' class = 'text-danger' style = 'cursor:pointer'><strong>Deactivate</strong></a>");
			$ref['status'] = ($ref['status'] == 0 ? 'Inactive' : 'Active');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function fetch_event_type()
	{
		$r = array();

		if($_GET['id'] != null)
		{
			$this->db->select('EVT_ID as "id", EVT_Code as "code", EVT_Event_type as "event_type", EVT_Shortname as "shortname", EVT_Status as "status"');
			$this->db->where('EVT_ID', $_GET['id']);
			$r = $this->db->get('EVENT_TYPE')->result_array();
		}

		return $r;
	}

	function quick_toggle_evt_status()
	{
		$data = array();

		if($_POST['update_id'] != null && $_POST['update_id'] != '')
		{
			$this->db->select('EVT_Event_type as "evt_type", EVT_Status as "status"');
			$this->db->where('EVT_ID', $_POST['update_id']);
			$r = $this->db->get('EVENT_TYPE')->row_array();

			if(empty($r))
			{
				$this->db->set_flashdata('e', 'Invalid Event Type ID. Please Try Again.');
				return false;
			}

			$data['EVT_Status'] = ($r['status'] == 1 ? 0 : 1);

			$this->db->where('EVT_ID', $_POST['update_id']);
			$this->db->update('EVENT_TYPE', $data);

			if($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('s', 'Event Type - ' . $r['evt_type'] . ' status quick update successful.');
				return true;
			}
			else
			{
				$this->session->set_flashdata('e', 'Event Type - ' . $r['evt_type'] . ' status quick update failed.');
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}