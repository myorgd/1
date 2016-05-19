<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tst extends CI_Controller {

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
		//$this->load->model('access_url_model');
		$this->load->model('tst_model', 'tst');
	}

	public function index()
	{
		$data['Page'] = 'tst/index';
		$data['title'] = 'Список ТСТ';
		$this->load->library('table');

		$this->table->set_template(['table_open'  => '<table class="table table-striped table-bordered table-hover">']);
        $this->table->set_heading('Название', 'Адрес', 'Контактный телефон', 'Редактировать');
		
		foreach ($this->tst->get_all()->result() as $row)
		{
				$this->table->add_row([$row->Name, $row->Address, $row->Phone, '<center><a href="'.base_url().'tst/delete/'.$row->ID_TST.'" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></a></center>']);
		}
		
		$data['table'] = $this->table->generate();
		
		$this->load->view('main', $data);
	}
	
	public function delete($id)
	{
		if ($this->tst->get_true_org($id) > 0) {
			$this->tst->delete($id);
		} 
			redirect('/tst');
	}
	
	public function add()
	{
		$this->load->helper('string');

		$data['Page'] = 'tst/add';
			
		$this->form_validation->set_rules('orgname', 'название организации', 'required');

		if ($this->form_validation->run())
		{

				$ID = $this->org->add();
				
				if ($ID != false)
				{
					$this->session->set_userdata('ID_Org', $ID);
					redirect('/tst');		
				} else {
					$this->msg->add('Ошибка попробуйте еще раз', 0);
				}
		}
			
		
		$data['title'] = 'Добавить компанию';
		$this->load->view('main', $data);
	}
}
