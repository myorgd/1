<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	public $ID_Users;
	public $Login;
	public $ID_Org;
	public $Pass;
	public $ID_Rules;
	public $Phone;

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	public function get_rules_id_public_str()
	{
		$query = $this->db->select('ID_Rules, Name')->where('Public_Reg', 1)->get('rules');
		$rules = '';
		foreach ($query->result() as $row) {
			$rules .= $row->ID_Rules . ',';
		}

		return rtrim($rules, ',');
	}

	public function get_rules_id_select()
	{
		$query = $this->db->select('ID_Rules, Name')->where('Public_Reg', 1)->get('rules');
		foreach ($query->result() as $row) {
			$data[$row->ID_Rules] = $row->Name;
		}

		return $data;
	}

	public function reg()
	{
		$this->load->helper('string');
		$pass = random_string('alnum', 8);
		$data = [
				'ID_Rules'  => $this->input->post('rules'),
				'Login'     => $this->input->post('email'),
				'Phone'     => $this->input->post('phone'),
				'Pass'  	=> password_hash($pass, PASSWORD_DEFAULT)
		];
		
		if ($this->db->insert('users', $data)) {
			echo $pass; 
/* Расскоментировать перед релизом
			$this->load->library('email');

			$this->email->from('your@example.com', 'Your Name');
			$this->email->to($this->input->post('email'));

			$this->email->subject('Добро пожаловать к нам.');
			$this->email->message('Ваш пароль для входа: ' . $pass . ', логин ваш E-Mail.');

			$this->email->send();
*/
			return true;

		}
		return false;

	}

	public function update_pass()
	{
		$this->load->helper('string');
		return $this->db->update('users', ['Pass' => password_hash(random_string('alnum', 8), PASSWORD_DEFAULT)], ['ID_Users' => $this->session->userdata('ID')]);
	}
	
	public function delete($id)
	{
		$this->db->delete('users', ['ID_Users' => $id]);
	}

	public function auth()
	{
		$query = $this->db->select('users.ID_Users, Login, users.ID_Rules, ID_Org, Pass, Add_Org')
						->join('org', 'org.ID_Users = users.ID_Users', 'left')
						->join('rules', 'rules.ID_Rules = users.ID_Rules', 'left')
						->get_where('users', ['Login' => $this->input->post('email')], 1);
		$row = $query->row();

		if (isset($row) && password_verify($this->input->post('password'), $row->Pass))
		{
			$newdata = [
					'ID'  			=> $row->ID_Users,
					'Login'     	=> $row->Login,
					'Rules'  		=> $row->ID_Rules,
					'ID_Org'   	 	=> $row->ID_Org,
					'Add_Org'    	=> $row->Add_Org,
					'logged_in' 	=> true
			];
			//удалить
			print_r($newdata);
			
			$this->session->set_userdata($newdata);
			return true;
		}
			return false;
	}

	public function block()
	{
		$expiration = time() - 300;
		$this->db->where('Datetime < ', $expiration)->delete('access_bad');

		if ($this->db->where('ip_address', $this->input->ip_address())->count_all_results('access_bad') < 5) {
			$data = [
					'Datetime' => time(),
					'Login' => $this->input->post('email'),
					'ip_address' => $this->input->ip_address()
			];

			$this->db->insert('access_bad', $data);
			return true;
		} else {
			return false;
		}
	}

	public function logouth()
	{
		$this->session->sess_destroy();
	}

}