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
		return $this->db->select('nas.id, nasname, shortname, secret')
					->join('tst', 'tst.ID_Org = Org.ID_Org')
					->join('routers', 'routers.ID_TST = tst.ID_TST')
					->join('nas', 'nas.id = routers.ID_Routers')
					->where('Org.ID_Org', $this->session->userdata('ID_Org'))->get('Org');
	}
	
	public function get_true_org($id)
	{
		return $this->db->join('tst', 'tst.ID_Org = Org.ID_Org')
					->join('routers', 'routers.ID_TST = tst.ID_TST')
					->join('nas', 'nas.id = routers.ID_Routers')
					->where('Org.ID_Org', $this->session->userdata('ID_Org'))
					->where('nas.id', $id)
					->count_all_results('Org');
	}
	
	public function delete($id)
	{
		return 	$this->db->delete('nas', ['id' => $id]);
	}
		
	public function add($Name)
	{
			
			$data = [
					'nasname' => $Name,
					'shortname' => $this->input->post('nasname'),
					'secret' => random_string('alnum', 7)
			];

			return ($this->db->insert('nas', $data)) ? $this->db->insert_id() : false ;
	}

}