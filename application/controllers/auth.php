<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
		$this->load->model('users_model', 'users');
	}

	public function index()
	{

		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run())
		{
			if ($this->users->block()) {
				if ($this->users->auth_users()) {
					redirect('/panel');
				} else {
					$this->msg->add('Не верно введен логин или пароль.', 0);
				}
			} else {
				$this->msg->add('Попробуйте еще раз через 5 минут', 0);
			}
		}

		$data['Page'] = 'login';
		$data['title'] = 'Авторизация';
		$this->load->view('main', $data);
	}
}
