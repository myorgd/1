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
		
	public function edit()
	{			
			return $this->db->where('ID_Org', $this->session->userdata('ID_Org'))->update('org', ['Name' => $this->input->post('Org_Name')]);
	}
	
	public function add()
	{	
		$data = [
			'ID_Users' => $this->session->userdata('ID'),
			'Name' => $this->input->post('Org_Name')
		];
			return ($this->db->insert('org', $data)) ? $this->db->insert_id() : false ;
	}

}