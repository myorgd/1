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

	   $this->loadlib->add_css("/bower_components/bootstrap-social/bootstrap-social.css");

	   $base_url = base_url().'wifi/';

       $data = [
			'form_Open' 	=> form_open('wifi/access', 'role="form" id="myform"').'<fieldset>',
			'email' 		=> form_input_new('phone', 'Номер телефона', 'text', false, false, '', 'autofocus'),
			//'password' 		=> form_input_new('password', 'Password', 'password', false, false),
			'remember' 		=> form_checkbox_new('remember', 'Согласие с правилами'),
			'form_close' 	=> form_close(),
			'form_submit'	=> form_submit('myform', 'Вход', 'class="btn btn-lg btn-success btn-block"'),
			'title' 		=> 'Авторизация',
			'SC'			=> [['name' => 'vk', 'link' => $base_url.'vk'],
								['name' => 'facebook', 'link' => $base_url.'facebook'],
								['name' => 'odnoklassniki', 'link' => $base_url.'odnoklassniki'],
								['name' => 'twitter', 'link' => $base_url.'twitter'],
								['name' => 'instagram', 'link' => $base_url.'instagram']]
		];

		$this->parser->parse('wifi/index', $data);
	}

	public function vk()
	{
		$this->load->library('vk');

		// Пример использования класса:
		if (!empty($this->input->get('error'))) {
			// Пришёл ответ с ошибкой. Например, юзер отменил авторизацию.
		} elseif (empty($this->input->get('code'))) {
			// Самый первый запрос
			$this->vk->goToAuth();
		} else {
			// Пришёл ответ без ошибок после запроса авторизации
			if (!$this->vk->getToken($this->input->get('code'))) {
				die('Error - no token by code');
			}
			/*
			* На данном этапе можно проверить зарегистрирован ли у вас ВК-юзер с id = OAuthVK::$userId
			* Если да, то можно просто авторизовать его и не запрашивать его данные.
			*/

			$user = $this->vk->getUser();
			print_r($user);
			/*
			* Вот и всё - мы узнали основные данные авторизованного юзера.
			* $user в этом примере состоит из трёх полей: uid, first_name, last_name.
			* Делайте с ними что угодно - регистрируйте, авторизуйте, ругайте...
			*/
		}
	}

	public function facebook ()
	{
		$this->load->library('fb');

		if (!empty($this->input->get('error'))) {
			// Пришёл ответ с ошибкой. Например, юзер отменил авторизацию.
			die($this->input->get('error'));
		} elseif (empty($this->input->get('code'))) {
			// Самый первый запрос
			$this->fb->goToAuth();
		} else {
			// Пришёл ответ без ошибок после запроса авторизации

			if (!$this->fb->checkState($this->input->get('state'))) {
				die("The state does not match. You may be a victim of CSRF.");
			}

			if (!$this->fb->getToken($this->input->get('code'))) {
				die('Error - no token by code');
			}

			$user = $this->fb->getUser();
			print_r($user);
			/*
			* Вот и всё - мы узнали основные данные авторизованного юзера.
			* $user в этом примере состоит из двух полей: id, name.
			* Делайте с ними что угодно - регистрируйте, авторизуйте, ругайте...
			*/
		}
	}
	
	public function instagram ()
	{
		$this->load->library('instagram');

		if (!empty($this->input->get('error'))) {
			// Пришёл ответ с ошибкой. Например, юзер отменил авторизацию.
			die($this->input->get('error'));
		} elseif (empty($this->input->get('code'))) {
			// Самый первый запрос
			$this->instagram->goToAuth();
		} else {
			// Пришёл ответ без ошибок после запроса авторизации

			if (!$this->instagram->getToken($this->input->get('code'))) {
				die('Error - no token by code');
			}

			$user = $this->instagram->getUser();
			print_r($user);
			/*
			* Вот и всё - мы узнали основные данные авторизованного юзера.
			* $user в этом примере состоит из двух полей: id, name.
			* Делайте с ними что угодно - регистрируйте, авторизуйте, ругайте...
			*/
		}
	}

	public function twitter ()
	{
			$this->load->library('twitter');
			// Пример использования класса:
			if (!empty($this->input->get('denied'))) {
			    // Пользователь отменил авторизацию.
			    die('denied');
			} elseif (empty($this->input->get('oauth_token')) || empty($this->input->get('oauth_verifier'))) {
			    // Самый первый запрос
			    $this->twitter->goToAuth();
			} else {
			    // Пришёл ответ без ошибок после запроса авторизации
			    $oauth_token = trim($this->input->get('oauth_token'));
			    $oauth_verifier = trim($this->input->get('oauth_verifier'));
			    if (!$this->twitter->getToken($oauth_token, $oauth_verifier)) {
			        die('Error - no token by code');
			    }
			    /*
			     * На данном этапе можно проверить зарегистрирован ли у вас Twitter-юзер с id = $this->twitter->$userId
			     * Если да, то можно просто авторизовать его и не запрашивать его данные.
			     */

			    $user = $this->twitter->getUser();
			    print_r($user);
			    /*
			     * Вот и всё - мы узнали основные данные авторизованного юзера.
			     * $user в этом примере состоит из многих полей: id, name, screen_name и т.д.
			     */
			}
	}

	public function odnoklassniki ()
	{
		$this->load->library('odnoklassniki');
				// Пример использования класса:
		if (!empty($this->input->get('error'))) {
		    // Пришёл ответ с ошибкой. Например, юзер отменил авторизацию.
		    die($this->input->get('error'));
		} elseif (empty($this->input->get('code'))) {
		    // Самый первый запрос
		    $this->odnoklassniki->goToAuth();
		} else {
		    // Пришёл ответ без ошибок после запроса авторизации
		    if (!$this->odnoklassniki->getToken($this->input->get('code'))) {
		        die('Error - no token by code');
		    }
		    /*
		     * На данном этапе можно проверить зарегистрирован ли у вас одноклассник с id = $this->odnoklassniki->$userId
		     * Если да, то можно просто авторизовать его и не запрашивать его данные.
		     */

		    $user = $this->odnoklassniki->getUser();
		    print_r($user);
		    /*
		     * Вот и всё - мы узнали основные данные авторизованного юзера.
		     */
		}
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