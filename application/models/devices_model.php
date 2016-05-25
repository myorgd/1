<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices_model extends CI_Model {

	public $ID_Devices;
	public $MAC;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	public function get_last_ten_entries()
	{
		$query = $this->db->get('entries', 10);
		return $query->result();
	}

	public function insert_device($Data)
	{
		return ($this->db->insert('devices', $Data)) ? $this->db->insert_id() : false ;
	}

	public function get_id_mac($mac = '')
	{
		$query = $this->db->select('ID_Devices')->get_where('devices', array('MAC' => $mac));
		$row = $query->row();

		if (isset($row))
		{			return $row->ID_Devices;
		}
		return false;
	}

}