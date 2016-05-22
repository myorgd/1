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
		$this->load->library('table');

		$this->table->set_template(['table_open'  => '<table class="table table-striped table-bordered table-hover">']);
        $this->table->set_heading('Название', 'Адрес', 'Контактный телефон', 'Редактировать');
		
		foreach ($this->tst->get_all()->result() as $row)
		{
				$this->table->add_row([$row->Name, $row->Address, $row->Phone, '<center><a href="'.base_url().'tst/delete/'.$row->ID_TST.'" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></a></center>']);
		}
		
		$data = [
			'Page' 	=> $this->parser->parse('tst/index', 
				[
					'table' => $this->table->generate()
				], TRUE),
			'title' => 'Список ТСТ'
		];
		
		$this->parser->parse('main', $data);
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
		
		$this->form_validation->set_rules('name', 'Название ТСТ', 'required');
		$this->form_validation->set_rules('address', 'Адрес', 'required');
		$this->form_validation->set_rules('phone', 'Контактный номер телефона', 'required');

		if ($this->form_validation->run())
		{
				$this->tst->add();	
				redirect('/tst');
		}
		
		$data = [
			'Page' 	=> $this->parser->parse('tst/add', [
					'form_Open' 	=> form_open('tst/add', 'role="form" id="myform"').'<fieldset>',
					'name' 			=> form_input_new('name', 'Название ТСТ', 'text', false, false, set_value('name')),
					'address' 		=> form_input_new('address', 'Адрес', 'text', false, false, set_value('address')),
					'phone' 		=> form_input_new('phone', 'Контактный номер телефона', 'text', false, false, set_value('phone')),
					'form_close' 	=> form_close(),
					'form_submit'	=> form_submit('myform', 'Добавить', 'class="btn btn-lg btn-success btn-block"')
			], TRUE),
			'title' => 'Добавить компанию'
		];
		
		$this->parser->parse('main', $data);
	}
}
