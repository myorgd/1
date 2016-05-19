<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nas extends CI_Controller {

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
		$this->load->model('radnas_model', 'nas');
	}

	public function index()
	{
		$data['Page'] = 'nas/index';
		$data['title'] = 'Список устройств';
		$this->load->library('table');

		$this->table->set_template(['table_open'  => '<table class="table table-striped table-bordered table-hover">']);
        $this->table->set_heading('ИД', 'Имя роутера', 'Секретное слово', 'Удалить');
		
		foreach ($this->nas->get_all()->result() as $row)
		{
				$this->table->add_row([$row->nasname, $row->shortname, $row->secret, '<center><a href="'.base_url().'nas/delete/'.$row->id.'" class="btn btn-danger btn-circle"><i class="fa fa-times"></i></a></center>']);
		}
		
		$data['table'] = $this->table->generate();
		
		$this->load->view('main', $data);
	}
	
	public function delete($id)
	{
		if ($this->nas->get_true_org($id) > 0) {
			$this->nas->delete($id);
		} 
			redirect('/nas');
	}
	
	public function add()
	{
		$this->load->helper('string');
		$this->load->model('tst_model', 'tst');
		$this->load->model('routers_model', 'routers');
		
		$data['Page'] = 'nas/add';
		$data['title'] = 'Добавить оборудование';
		
		$this->form_validation->set_rules('tst', 'ТСТ', 'required');
		$this->form_validation->set_rules('nasname', 'имя оборудования', 'required');
		if ($this->form_validation->run())
		{		
			do {
				$nasname = random_string('alnum', 8);
			} while (!$this->form_validation->is_unique($nasname, "nas.nasname"));
			
			$ID = $this->nas->add($nasname);
			$this->routers->add($ID);
			
			redirect('/nas');
		}
		
		$this->load->view('main', $data);
	}
}
