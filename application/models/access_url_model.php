<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access_url_model extends CI_Model {

	public $ID_URL;
	public $URL;
	public $ID_Rules;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();

			$login_True = $this->session->userdata('logged_in');
			
			$this->db->where('URL', $this->uri->segment(1, '') . "/" . $this->uri->segment(2, ''));
			$this->db->from('access_url');
			$this->db->join('url', 'url.ID_URL = access_url.ID_URL');
			
			if ($login_True) 
				$this->db->where('ID_Rules', $this->session->userdata('Rules'));	
			
			if (!$this->db->count_all_results()) {
				if ($login_True) { 
					redirect('/');
				} else {
					redirect('/');
				}
			}

	}

	public function add_rules_to_url($arrayrtou)
	{
		$this->db->insert('access_url', $arrayrtou);
	}

	public function delete_rules_to_url($id)
	{
		$this->db->delete('access_url', ['ID_Access_URL' => $id]);
	}

}