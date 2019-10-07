<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda_model extends CI_Model
{
	function agenda_model()
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

	function fetch_agenda()
	{
		$r = array();

		if($_GET['id'] != "")
		{
			$this->db->select('EAD_ID as "id", EAD_Agenda_item as "agenda_item", EAD_Starttime as "start_time", EAD_Endtime as "end_time"');
			$this->db->where('EAD_ENT_ID', $_GET['id']);
			$r = $this->db->get('EVENT_AGENDA')->result_array();
		}

		return $r;
	}

	function save_agenda()
	{
		$this->form_validation->set_rules('ent_select', 'Event', 'trim|required');
		$this->form_validation->set_rules('agenda_items', 'Agenda Item(s)', 'callback_validate_items');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		$this->db->trans_strict(1);
		$this->db->trans_begin();

		if(!empty( (array) json_decode($_POST['remove_agenda_items'])) )
		{
			$remove_agenda_items = (array) json_decode($_POST['remove_agenda_items']);
			$remove_ids           = array();

			foreach ($remove_agenda_items as $row)
			{
				$entry = (array) $row;

				$remove_ids[] = $entry['ead_id'];
			}

			$this->db->where_in('EAD_ID', $remove_ids);
			$this->db->delete('EVENT_AGENDA');
		}

		$agenda_items    = (array) json_decode($_POST['agenda_items']);
		$agenda_data     = array();
		$i               = 0;

		foreach ($agenda_items as $row) 
		{
			$entry = (array) $row;

			if($entry['new'] == 1)
			{
				$agenda_data[$i]['EAD_ENT_ID']      = $_POST['ent_select'];
				$agenda_data[$i]['EAD_Agenda_item'] = $entry['agenda_item'];
				$agenda_data[$i]['EAD_Starttime']   = $entry['start']; 
				$agenda_data[$i]['EAD_Endtime']     = $entry['end'];
				$agenda_data[$i]['EAD_User']        = $this->session->userdata('username'); 
				$agenda_data[$i]['EAD_Timestamp']   = date('Y-m-d H:i:s');  

				$i++;
			}
		}

		if(!empty($agenda_data))
			$this->db->insert_batch('EVENT_AGENDA', $agenda_data);

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

	function validate_items($str)
	{
		$agenda_items = array();

		$agenda_items = (array) json_decode($str);

		if(!(empty($agenda_items)))
		{
			return true;
		}
		else 
		{
			$this->form_validation->set_message('validate_items', 'The Event Agenda is not Defined.');
			return false;
		}
	}
}