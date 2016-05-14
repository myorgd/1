<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Raduser_model extends CI_Model {

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function add_mac($MAC,  $Group_Name)
	{
			
			$this->db->trans_begin();
	
			$data = [
					'username' => $MAC,
					'attribute' => "User-Password",
					'value' => "password"
			];

			$this->db->insert('radcheck', $data);
			
			$data = [
					'username' => $MAC,
					'groupname' => $Group_Name
			];

			$this->db->insert('radusergroup', $data);			
				
			$this->db->trans_complete();
			
			return $this->db->trans_status();

	}
		
	public function add($User_Name, $Pass, $Group_Name)
	{
			/*
			$this->load->helper('string');
			
			do {
				$User_Name = random_string('alnum', 5).'_'.$this->session->userdata('ID_Org');
			} while ($this->form_validation->is_unique($User_Name, "radcheck.username"));
			
			$Pass = random_string('alnum', 5);
			*/
			
			$this->db->trans_begin();
	
			$data = [
					'username' => $User_Name,
					'attribute' => "User-Password",
					'value' => $Pass
			];

			$this->db->insert('radcheck', $data);
			
			$data = [
					'username' => $User_Name,
					'groupname' => $Group_Name
			];

			$this->db->insert('radusergroup', $data);			
				
			$this->db->trans_complete();
			
			return $this->db->trans_status();

	}

}