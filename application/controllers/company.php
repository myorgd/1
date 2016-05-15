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
			if ($this->_true_add_org())
			{
				$ID = $this->org->add();
				
				if ($ID != false)
				{
					$this->session->set_userdata('ID_Org', $ID);
					$this->users->update_org($ID);
					redirect('/company');		
				} else {
					$this->msg->add('Ошибка попробуйте еще раз', 0);
				}
			} else {
				$this->msg->add('Вам запрещено это действие', 0);
			}
		}
		
		$data['Page'] = 'company/add';
		$data['title'] = 'Информация об компании';
		$this->load->view('main', $data);
	}
	
	private function _true_add_org()
	{
		if ($this->session->userdata('Add_Org'))
			if ($this->session->userdata('ID_Org') == null || $this->session->userdata('Add_More_Org'))
			{
				return true;
			}
		}
		return false;
	}
}
