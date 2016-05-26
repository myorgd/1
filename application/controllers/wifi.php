<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wifi extends CI_Controller {

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
		$this->load->model('devices_model', 'devices');
	}

	public function index()
	{
		$this->load->library('ulogin', [
			'type' 		=> 'panel',
			'fields'	=> ['first_name', 'last_name', 'email'],
			'providers'	=> ['vkontakte', 'odnoklassniki', 'mailru', 'facebook'],
			'hidden'	=> ['other'],
			'url' 		=> base_url().'wifi/sc'
		]);

		$Data = $this->input->get(['res','uamip','uamport','challenge','called','mac','ip','nasid','sessionid','userurl','md']);

        if ($Data != false && $Data['mac'] != $this->session->userdata('mac'))
        {
        	$id = $this->devices->get_id_mac($Data['mac']);

        	if ($id == false)
				$this->devices->insert_device(['MAC' => $Data['mac'], 'ID_Routers' => $Data['nasid']]);

       	    $this->session->set_userdata(['mac' 		=> $Data['mac'],
							        	  'uamip' 		=> $Data['uamip'],
							        	  'uamport' 	=> $Data['uamport'],
        	    						  'challenge' 	=> $Data['challenge'],
        	    						  'nasid' 		=> $Data['nasid'],
        	    						  'userurl' 	=> $Data['userurl']]);
       }

        $data = [
			'form_Open' 	=> form_open('wifi/access', 'role="form" id="myform"').'<fieldset>',
			'email' 		=> form_input_new('phone', 'Номер телефона', 'text', false, false, '', 'autofocus'),
			//'password' 		=> form_input_new('password', 'Password', 'password', false, false),
			'remember' 		=> form_checkbox_new('remember', 'Согласие с правилами'),
			'form_close' 	=> form_close(),
			'form_submit'	=> form_submit('myform', 'Вход', 'class="btn btn-lg btn-success btn-block"'),
			'title' 		=> 'Авторизация',
			'SC' 			=> $this->ulogin->get_html()
		];

		$this->parser->parse('wifi/index', $data);
	}

	public function sc()
	{
		$this->load->library('ulogin');
		$this->ulogin->right_now();
		print_r($this->ulogin->userdata());
	}

	public function access()
	{
		$uamsecret = 'secret';
	    $hexchal = pack ("H32", $this->session->userdata('challenge'));
	    $newchal = pack("H*", md5($hexchal . $uamsecret));
	    $response = md5("\0" . $this->input->post('password') . $newchal);

	    $newpwd = pack("a32", $this->input->post('password'));
	    $pappassword = implode ('', unpack("H32", ($newpwd ^ $newchal)));

            echo $pappassword;
	    redirect('http://'.$this->session->userdata('uamip').':'.
	    		 $this->session->userdata('uamport').'/logon?username='.
	    		 $this->input->post('email').'&password='.$pappassword.
	    		 '&userurl='.base_url().'wifi/news', 'refresh');
	}
}