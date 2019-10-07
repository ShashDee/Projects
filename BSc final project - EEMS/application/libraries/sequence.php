<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sequence
{

	var $CI = null;
	
	public function __construct()
	{
		$this->CI =& get_instance(); 
	}

	function generate_sequence($module = 'SEQ', $length = 0)
	{
		$r    = array();
		$rows = "";

		if($module == "EVT")
		{
			$rows = $this->CI->db->count_all('EVENT_TYPE');
		}
		else if($module == "SUP")
		{
			$rows = $this->CI->db->count_all('SUPPLIER');
		}
		else if($module == "CUS")
		{
			$rows = $this->CI->db->count_all('CUSTOMER');
		}
		else if($module == "VEN")
		{
			$rows = $this->CI->db->count_all('VENUE');
		}
		else if($module == "ENT")
		{
			$rows = $this->CI->db->count_all('EVENT');
		}

		$r['sequence'] = str_pad($module, $length, '0', STR_PAD_RIGHT) . (++$rows);

		return $r;
	}
}