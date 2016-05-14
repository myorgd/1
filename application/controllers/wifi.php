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
		$data['Page'] = 'wifi/auth';
		$data['title'] = 'Авторизация для доступа в интернет';

		$Data = $this->_gettoarray();
        if ($Data['mac'] != $this->session->userdata('mac'))
        {
        	if ($this->devices->get_id_mac($Data['mac']) == false)
        	{
				$this->session->set_userdata([
				'mac' => $this->devices->insert_device(['MAC' => $Data['mac'], 'ID_Routers' => $Data['nasid']], true),
				'nasid' => $Data['nasid']]);
        	}
        	 else
        	{
        	    $this->session->set_userdata(['mac' => $Data['mac'],
							        	      'uamip' => $Data['uamip'],
							        	      'uamport' => $Data['uamport'],
        	    							  'challenge' => $Data['challenge'],
        	    							  'nasid' => $Data['nasid']]);
        	}
        }

        $this->load->view('main', $data);
	}

	public function access()
	{
		$uamsecret = 'secret';
	    $hexchal = pack ("H32", $this->session->userdata('challenge'));
	    $newchal = $uamsecret ? pack("H*", md5($hexchal . $uamsecret)) : $hexchal;
	    $response = md5("\0" . $this->input->post('password') . $newchal);

	    $newpwd = pack("a32", $this->input->post('password'));
	    $pappassword = implode ('', unpack("H32", ($newpwd ^ $newchal)));

	    redirect('http://'.$this->session->userdata('uamip').':'.
	    		 $this->session->userdata('uamport').'/logon?username='.
	    		 $this->input->post('email').'&password='.$pappassword);
	}

	private function _gettoarray()
	{
		$arraydata = array();
		foreach (explode('&', $this->input->get('loginurl')) as $val)
		{
			$tempArr = explode('=', $val));
			$arraydate[$tempArr[0]] = $tempArr[1];
		}
		return $arraydate;	}
}