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
 		//if ($this->uri->segment(1, '') != 'auth' && $this->uri->segment(1, '') != 'reg') {

			if ($this->session->userdata('logged_in')) {
				$this->db->where('ID_Rules', $this->session->userdata('Rules'));
			} else {
				$this->db->where('ID_Rules', 0);
			}

			$this->db->where('URL', $this->uri->segment(1, '') . "/" . $this->uri->segment(2, ''));
			$this->db->from('access_url');
			$this->db->join('url', 'url.ID_URL = access_url.ID_URL');

			if (!$this->db->count_all_results()) {
				redirect('/');
			}
		//}

	}

	public function add_rules_to_url($id_url, $id_rules)
	{
		$this->db->insert('access_url', array('ID_URL' => $id_url, 'ID_Rules' => $id_rules));
	}

	public function delete_rules_to_url($id)
	{
		$this->db->delete('access_url', array('ID_Access_URL' => $id));
	}

}