<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Org_model extends CI_Model {

	public $ID_Org;
	public $Name;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
		
	public function edit($Org_Name)
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
			return ($this->db->insert('org', ['Name' => $this->input->post('Org_Name')])) ? $this->db->insert_id() : false ;
	}

}