<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venue_model extends CI_Model
{
	function venue_model()
	{
		parent:: __Construct();

		//loading sequence generation library
		$this->load->library('sequence');
	}

	function fetch_predata()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('VEN', 6);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function reload_sequence()
	{
		$data         = array();
		
		$sequence     = $this->sequence->generate_sequence('VEN', 6);
		
		$data['code'] = $sequence['sequence'];

		return $data;
	}

	function save_venue()
	{
		$this->form_validation->set_rules('venue_code_input', 'Venue Code', 'trim|required');
		$this->form_validation->set_rules('ven_name_input', 'Venue Name', 'trim|required');
		$this->form_validation->set_rules('con_no1_input', 'Contact Number', 'trim|required');
		$this->form_validation->set_rules('ven_add_input', 'Address', 'trim|required');
		$this->form_validation->set_rules('ven_email_input', 'Email Address', 'trim|required');
		$this->form_validation->set_rules('hall_entries', 'Email Address', 'callback_validate_entries');

		if(!$this->form_validation->run()) 
		{
			$this->session->set_flashdata('e', validation_errors());
			return false;
		}

		$this->db->trans_strict(1);
		$this->db->trans_begin();

		if($_POST['update_id'] == "false")
		{
			$data = array();
			
			$data['VEN_Code']           = $_POST['venue_code_input'];
			$data['VEN_Name']           = $_POST['ven_name_input'];
			$data['VEN_Address']        = $_POST['ven_add_input'];
			$data['VEN_Contact_no_one'] = $_POST['con_no1_input'];
			$data['VEN_Contact_no_two'] = $_POST['con_no2_input'];
			$data['VEN_Email']          = $_POST['ven_email_input'];
			$data['VEN_Status']         = (isset($_POST['status_switch']) ? 1 : 0);
			$data['VEN_User']           = $this->session->userdata('username');
			$data['VEN_Timestamp']      = date('Y-m-d H:i:s');

			$this->db->insert('VENUE', $data);
			$ven_id = $this->db->insert_id();

			$hall_entries = (array) json_decode($_POST['hall_entries']);
			$hall_info    = array();
			$i            = 0;

			foreach ($hall_entries as $row) 
			{
				$entry = (array) $row;

				$hall_info[$i]['VEN_ID']           = $ven_id;
				$hall_info[$i]['VNH_Hall_name']    = $entry['hall_name'];
				$hall_info[$i]['VNH_Type']         = $entry['hall_type'];
				$hall_info[$i]['VNH_Accomadation'] = $entry['accomadation'];
				$hall_info[$i]['VNH_Price']        = $entry['price'];

				$i++;
			}

			$this->db->insert_batch('VENUE_HALLS', $hall_info);

			$event = "Creation";
		}
		else 
		{
			if($_POST['update_id'] != null)
			{
				$data = array();
				
				$data['VEN_Code']            = $_POST['venue_code_input'];
				$data['VEN_Name']            = $_POST['ven_name_input'];
				$data['VEN_Address']         = $_POST['ven_add_input'];
				$data['VEN_Contact_no_one']  = $_POST['con_no1_input'];
				$data['VEN_Contact_no_two']  = $_POST['con_no2_input'];
				$data['VEN_Email']           = $_POST['ven_email_input'];
				$data['VEN_Status']          = (isset($_POST['status_switch']) ? 1 : 0);
				$data['VEN_UpdateUser']      = $this->session->userdata('username');
				$data['VEN_UpdateTimestamp'] = date('Y-m-d H:i:s');

				$this->db->where('VEN_ID', $_POST['update_id']);
				$this->db->update('VENUE', $data);
				$ven_id = $_POST['update_id'];

				if(!empty((array) json_decode($_POST['remove_hall_entries'])))
				{
					$remove_hall_entries = (array) json_decode($_POST['remove_hall_entries']);
					$remove_ids          = array();

					foreach ($remove_hall_entries as $row)
					{
						$entry = (array) $row;

						$remove_ids[] = $entry['hall_id'];
					}

					$this->db->where_in('VNH_ID', $remove_ids);
					$this->db->delete('VENUE_HALLS');
				}

				$hall_entries = (array) json_decode($_POST['hall_entries']);
				$hall_info    = array();
				$i            = 0;

				foreach ($hall_entries as $row) 
				{
					$entry = (array) $row;

					if($entry['new'] == 1)
					{
						$hall_info[$i]['VEN_ID']           = $ven_id;
						$hall_info[$i]['VNH_Hall_name']    = $entry['hall_name'];
						$hall_info[$i]['VNH_Type']         = $entry['hall_type'];
						$hall_info[$i]['VNH_Accomadation'] = $entry['accomadation'];
						$hall_info[$i]['VNH_Price']        = $entry['price'];

						$i++;
					}
				}

				if(!empty($hall_info))
					$this->db->insert_batch('VENUE_HALLS', $hall_info);
			}

			$event = "Update";
		}

		if($this->db->trans_status() == false)
		{
			$this->db->trans_rollback();
			$this->session->set_flashdata('e', 'Venue - ' . $_POST['ven_name_input'] . ' '. $event . ' failed.');
			return false;
		}
		else
		{
			$this->db->trans_commit();
			$this->session->set_flashdata('s', 'Venue - ' . $_POST['ven_name_input'] . ' '. $event . ' successful.');
			return true;
		}
	}

	function validate_entries($str)
	{
		$hall_entries = array();

		$hall_entries = (array) json_decode($str);

		if(!(empty($hall_entries)))
		{
			return true;
		}
		else 
		{
			$this->form_validation->set_message('validate_entries', 'The Venue Halls Are Empty.');
			return false;
		}
	}

	function fetch_venues()
	{
		$r    = array();
		$data = array();

		$this->db->select('VEN_ID as "id", VEN_Name as "name", VEN_Address as "address", VEN_Contact_no_one as "con_one", VEN_Contact_no_two as "con_two", VEN_Email as "email", VEN_User as "user", VEN_Status as "status"');

		if($_POST['status'] != "")
			$this->db->where('VEN_Status', $_POST['status']);

		$r = $this->db->get('VENUE')->result_array();

		$i = 0;

		foreach ($r as $row => &$ref) 
		{
			$ref['index']   = ++$i;
			$ref['contact'] = $ref['con_one'] . ($ref['con_two'] != null ? ', '.$ref['con_two'] : '');
			$ref['action']  = "<a class = 'text-info' style = 'cursor:pointer' onclick ='editVenue(".$ref['id'].")'><strong>Edit</strong></a> | ".($ref['status'] == 0 ? "<a onclick = 'quickToggleVenStatus(".$ref['id'].");' class = 'text-success' style = 'cursor:pointer'><strong>Activate</strong></a>" : "<a onclick = 'quickToggleVenStatus(".$ref['id'].");' class = 'text-danger' style = 'cursor:pointer'><strong>Deactivate</strong></a>");
			$ref['status']  = ($ref['status'] == 0 ? 'Inactive' : 'Active');
		}

		$data['aaData'] = $r;

		return $data;
	}

	function quick_toggle_ven_status()
	{
		$data = array();

		if($_POST['update_id'] != null && $_POST['update_id'] != '')
		{
			$this->db->select('VEN_Name as "name", VEN_Status as "status"');
			$this->db->where('VEN_ID', $_POST['update_id']);
			$r = $this->db->get('VENUE')->row_array();

			if(empty($r))
			{
				$this->db->set_flashdata('e', 'Invalid Venue ID. Please Try Again.');
				return false;
			}

			if($r['status'] == 1)
			{
				$this->db->select('COUNT(*) as "events"');
				$this->db->where('ENT_VEN_ID', $_POST['update_id']);
				$this->db->where('ENT_Date >=', date('Y-m-d'));
				$check = $this->db->get('EVENT')->row_array();

				if($check['events'] > 0)
				{
					$this->session->set_flashdata('e','Upcoming events available for venue. Cannot Deactive.');
					return false;
				}
			}

			$data['VEN_Status'] = ($r['status'] == 1 ? 0 : 1);

			$this->db->where('VEN_ID', $_POST['update_id']);
			$this->db->update('VENUE', $data);

			if($this->db->affected_rows() > 0)
			{
				$this->session->set_flashdata('s', 'Venue - ' . $r['name'] . ' status quick update successful.');
				return true;
			}
			else
			{
				$this->session->set_flashdata('e', 'Venue - ' . $r['name'] . ' status quick update failed.');
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function fetch_venue()
	{
		$r = array();

		if($_GET['id'] != "")
		{
			$this->db->select('VEN_ID as "id", VEN_Code as "code", VEN_Name as "name", VEN_Address as "address", VEN_Contact_no_one as "con_one", VEN_Contact_no_two as "con_two", VEN_Email as "email", VEN_Status as "status"');
			$this->db->where('VEN_ID', $_GET['id']);
			$r['venue'] = $this->db->get('VENUE')->row_array();

			$this->db->select('VNH_ID as "hall_id", VNH_Hall_name as "hall_name", VNH_Type as "type", VNH_Accomadation as "accomadation", VNH_Price as "price"');
			$this->db->where('VEN_ID', $_GET['id']);
			$r['halls'] = $this->db->get('VENUE_HALLS')->result_array();
		}

		return $r;
	}

	function check_events()
	{
		$r = array();

		if($_GET['update_id'] != "false")
		{
			$this->db->select('COUNT(*) as "events"');
			$this->db->where('ENT_VEN_ID', $_GET['update_id']);
			$this->db->where('ENT_Date >=', date('Y-m-d'));
			$r = $this->db->get('EVENT')->row_array();
		}

		return $r;
	}
}