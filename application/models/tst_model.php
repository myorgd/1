<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tst_model extends CI_Model {

	public $ID_TST;
	public $Name;
	public $ID_Org;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	public function get_all()
	{
		return $this->db->select('tst.Name, Phone, Address, ID_TST')
					->join('Org', 'Org.ID_Org = tst.ID_Org')
					->where('Org.ID_Org', $this->session->userdata('ID_Org'))->get('tst');
	}
	
	public function get_true_org($id)
	{
		return $this->db->join('Org', 'Org.ID_Org = tst.ID_Org')
					->where('Org.ID_Org', $this->session->userdata('ID_Org'))
					->where('ID_TST', $id)
					->count_all_results('tst');
	}
	
	public function get_tst_id_select()
	{
		$query = $this->db->select('ID_TST, tst.Name')
					->join('tst', 'tst.ID_Org = org.ID_Org')
					->where('org.ID_Org', $this->session->userdata('ID_Org'))
					->get('org');
		if ($query->num_rows() > 0)		
		{
			foreach ($query->result() as $row) {
				$data[$row->ID_TST] = $row->Name;
			}

			return $data;
		} else {
			return '';
		}
	}
	
	public function delete($id)
	{
		return 	$this->db->delete('tst', ['ID_TST' => $id]);
	}
	
	public function add()
	{	
		$data = [
			'ID_Org' 	=> $this->session->userdata('ID_Org'),
			'Name' 		=> $this->input->post('name'),
			'Address'	=> $this->input->post('address'),
			'Phone' 	=> $this->input->post('phone')
		];
			return $this->db->insert('tst', $data);
	}
}