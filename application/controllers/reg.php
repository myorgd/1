<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg extends CI_Controller {

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
		$this->load->helper('captcha');
	}

	public function index()
	{

			$this->form_validation->set_rules('phone', 'номер телефона', 'required');
			$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[users.Login]');
			$this->form_validation->set_rules('rules', 'тип пользователя', 'required|in_list[' . $this->users->get_rules_id_str() . ']');
			$this->form_validation->set_rules('captcha', 'код', 'required|captcha');
			$this->form_validation->set_message('in_list', 'Поле {field} выбрано не правильно.');

			if ($this->form_validation->run()) {
				if ($this->users->block()) {
					if ($this->users->reg()) {
						//redirect('/panel');
					} else {
						$this->msg->add('Ошибка, попробуйте еще раз.', 0);
					}
				} else {
					$this->msg->add('Попробуйте еще раз через 5 минут', 0);
				}

			} else {
				$this->msg->add(validation_errors('<li>', '</li>'), 0);
			}

		$cap = create_captcha([
				'img_path'      => './captcha/',
				'img_url'       => base_url().'/captcha/',
				'font_path'     => './bower_components/bootstrap/fonts/9364.ttf',
				'img_width'     => 150,
				'img_height'    => 30,
				'expiration'    => 7200,
				'word_length'   => 5,
				'font_size'     => 15,
				'img_id'        => 'Imageid',
				'pool'          => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',

			// White background and border, black text and red grid
				'colors'        => [
						'background' => array(255, 255, 255),
						'border' => array(255, 255, 255),
						'text' => array(0, 0, 0),
						'grid' => array(255, 40, 40)
				]
		]);

		$this->db->insert('captcha',
				[
						'captcha_time'  => $cap['time'],
						'ip_address'    => $this->input->ip_address(),
						'word'          => $cap['word']
				]);

		$data['image'] = $cap['image'];
		$data['Page'] = 'reg';
		$data['title'] = 'Регистрация';
		$this->load->view('main', $data);
	}
}