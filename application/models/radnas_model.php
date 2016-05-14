<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Radnas_model extends CI_Model {

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function get_id($NAS_Name)
	{
		return $this->db->get_where('nas', ['nasname' => $NAS_Name.'_'.$this->session->userdata('ID_Org')]);
	}
	
	public function get_all()
	{
		return $this->db->like('nasname', $this->session->userdata('ID_Org'))->get('nas');
	}
	
	public function edit($NAS_Name)
	{
			$NAS_Name .= $this->session->userdata('ID_Org');			
			$data = [
					'Attribute' => "Auth-Type",
					'Value' => "Local"
			];

			$this->db->where('GroupName', $Name_Group)->update('radgroupcheck', $data);
	}
	
	public function add()
	{
		$this->load->helper('string');
			
			$data = [
					'nasname' => $this->input->post('NAS_Name').'_'.$this->session->userdata('ID_Org'),
					'shortname' => $this->input->post('NAS_Name'),
					'secret' => random_string('alnum', 7)
			];

			$this->db->insert('nas', $data);
	}

}