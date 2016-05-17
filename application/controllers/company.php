<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->model('access_url_model');
		$this->load->model('org_model', 'org');
		$this->load->model('users_model', 'users');
	}

	public function index()
	{

		$data['Page'] = 'company/index';
		$data['title'] = 'Информация об компании';
		$this->load->view('main', $data);
	}
	
	public function add()
	{
		$this->form_validation->set_rules('orgname', 'название организации', 'required');

		if ($this->form_validation->run())
		{
			if ($this->session->userdata('Add_Org') && $this->session->userdata('ID_Org') == null)
			{
				$ID = $this->org->add();
				
				if ($ID != false)
				{
					$this->session->set_userdata('ID_Org', $ID);
					redirect('/company');		
				} else {
					$this->msg->add('Ошибка попробуйте еще раз', 0);
				}
			} else {
				$this->msg->add('Вам запрещено это действие', 0);
			}
		}
		
		$data['Page'] = 'company/add';
		$data['title'] = 'Добавить компанию';
		$this->load->view('main', $data);
	}
	
	public function edit()
	{
		if ($this->session->userdata('ID_Org') != null)
		{
			$data['Page'] = 'company/edit';
			
			$this->form_validation->set_rules('orgname', 'название организации', 'required');

			if ($this->form_validation->run())
			{
				$this->org->edit();
			} else {
				$query = $this->db->select('Name')->get_where('org', ['ID_Users' => $this->session->userdata('ID')]);
				$row = $query->row();
				$data['Name'] = $row->Name;
			}
			
		} else {
			$data['Page'] = 'source';
			$this->msg->add('Вам запрещено это действие', 0);
		}
		
		$data['title'] = 'Редактирование информация о компании';
		$this->load->view('main', $data);
	}
}
