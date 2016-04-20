<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url_model extends CI_Model {

	public $ID_URL;
	public $URL;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
	public function edit_url($url, $id)
	{
		$this->db->update('url', array('URL' => $url), array('ID_URL' => $id));
	}

	public function add_url($url)
	{
		$this->db->insert('url', array('URL' => $url));
	}

	public function delete_rules_to_url($id)
	{
		$this->db->delete('url', array('ID_URL' => $id));
	}

}