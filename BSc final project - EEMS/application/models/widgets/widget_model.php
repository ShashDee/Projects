<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget_model extends CI_Model
{
	function __contruct()
	{
		parent::__contruct();
	}

	function fetch_event_count()
	{
		$r = array();

		$this->db->select('COUNT(*) as "event_count"');
		$this->db->where('DATEDIFF(ENT_DATE, CURDATE()) <=', 7, false);
		$this->db->where('DATEDIFF(ENT_DATE, CURDATE()) >=', 0, false);
		$this->db->where('CONCAT(ENT_DATE, " ", ENT_Endtime) >=', date('Y-m-d H:i'));
		$r = $this->db->get('EVENT')->row_array();

		return $r;
	}

	function fetch_event_list()
	{
		$r = array();

		$this->db->select('ENT_ID as "id", ENT_Code as "code", DATE(ENT_Date) as "date"');
		$this->db->where('DATEDIFF(ENT_DATE, CURDATE()) <=', 7, false);
		$this->db->where('DATEDIFF(ENT_DATE, CURDATE()) >=', 0, false);
		$this->db->where('CONCAT(ENT_DATE, " ", ENT_Endtime) >=', date('Y-m-d H:i'));
		$this->db->order_by('ENT_DATE', 'ASC');
		$r = $this->db->get('EVENT')->result_array();

		return $r;
	}

	function fetch_checklist()
	{
		$r = array();

		$this->db->select('ACL_ID as "id", EVENT.ENT_ID as "ent_id", ENT_Code as "ent_code", ACL_EAY_ID as "act_id", EAY_Activity as "activity", ACL_Checklist_item as "item", ACL_Incharge as "incharge", EMP_Fullname as "assigned_name", DATE(ACL_Deadline) as "ckl_deadline"');
		$this->db->join('EVENT_ACTIVITY', 'EVENT_ACTIVITY.EAY_ID=ACTIVITY_CHECKLIST.ACL_EAY_ID');
		$this->db->join('EVENT', 'EVENT.ENT_ID=EVENT_ACTIVITY.ENT_ID');
		$this->db->join('EMPLOYEE', 'EMPLOYEE.EMP_ID=ACTIVITY_CHECKLIST.ACL_Incharge');
		$this->db->where('DATEDIFF(ACL_Deadline, CURDATE()) <=', 7, false);
		$this->db->where('DATEDIFF(ACL_Deadline, CURDATE()) >=', 0, false);
		$this->db->where('ACL_Status', 0);

		if($this->session->userdata('user_group') == 'user')
			$this->db->where('ACL_Incharge', $this->session->userdata('emp_id'));

		$this->db->order_by('ACL_Deadline', 'ASC');
		$r = $this->db->get('ACTIVITY_CHECKLIST')->result_array();

		return $r;
	}

	function fetch_checklist_count()
	{
		$r = array();

		$this->db->select('COUNT(*) as checklist_count');
		$this->db->where('DATEDIFF(ACL_Deadline, CURDATE()) <=', 7, false);
		$this->db->where('DATEDIFF(ACL_Deadline, CURDATE()) >=', 0, false);
		$this->db->where('ACL_Status', 0);

		if($this->session->userdata('user_group') == 'user')
			$this->db->where('ACL_Incharge', $this->session->userdata('emp_id'));

		$r = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

		return $r;
	}

	function fetch_meeting_count()
	{
		$r = array();

		$this->db->select('COUNT(*) as meeting_count');
		$this->db->where('DATEDIFF(MET_Date, CURDATE()) <=', 7, false);
		$this->db->where('DATEDIFF(MET_Date, CURDATE()) >=', 0, false);
		$this->db->where('MET_Cancelled', 0);
		$r = $this->db->get('MEETING')->row_array();

		return $r;
	}

	function fetch_exp_checklist_count()
	{
		$r = array();

		$this->db->select('COUNT(*) as exp_checklist_count');
		$this->db->where('ACL_Deadline <', date('Y-m-d'));
		$this->db->where('ACL_Status', 0);

		if($this->session->userdata('user_group') == 'user')
			$this->db->where('ACL_Incharge', $this->session->userdata('emp_id'));

		$r = $this->db->get('ACTIVITY_CHECKLIST')->row_array();

		return $r;
	}
}