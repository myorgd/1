<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routers_model extends CI_Model {

	public $ID_Routers;
	public $Name;
	public $ID_TST;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	public function add($id)
	{
			$data = [
					'ID_Routers' => $id,
					'ID_TST' => $this->input->post('tst')
			];

			return ($this->db->insert('routers', $data));
	}

}