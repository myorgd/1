<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Driver Library Class
 *
 * This class enables you to create "Driver" libraries that add runtime ability
 * to extend the capabilities of a class via additional driver objects
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link
 */
class Fb {

    protected $APP_ID = 1801137726772847; //ID приложения
    protected $APP_SECRET = 'd2cd5c15fa1f97b785096c34fdcfada3'; //Защищенный ключ
    protected $URL_CALLBACK = 'http://localhost/wifi/wifi/facebook'; //URL сайта до этого скрипта-обработчика 
    protected $URL_ACCESS_TOKEN = 'https://graph.facebook.com/oauth/access_token';
    protected $URL_OATH = 'https://www.facebook.com/dialog/oauth';
    protected $URL_GET_ME = 'https://graph.facebook.com/me';

    protected $token;
    public $userId;
    public $userData;

	function __construct($params=array()) {
		$this->CI=& get_instance();
	}
	
    /**
     * @url https://vk.com/dev/auth_sites
     */
     
    public function goToAuth()
    {
        $hash = md5(uniqid(rand(), TRUE));
        $this->CI->session->set_userdata(['state' => $hash]);
        
        redirect($this->URL_OATH .
            '?client_id=' . sprintf('%.0f', $this->APP_ID) .
            '&redirect_uri=' . urlencode($this->URL_CALLBACK) .
            "&state=" . $hash, 'location', 301);
    }

    public function getToken($code) {

        $url = $this->URL_ACCESS_TOKEN .
            '?client_id=' . sprintf('%.0f', $this->APP_ID) .
            '&redirect_uri=' . urlencode($this->URL_CALLBACK) .
            '&client_secret=' . $this->APP_SECRET .
            '&code=' . $code;

        if (!($response = @file_get_contents($url))) {
            return false;
        }

        parse_str($response, $result);

        if (empty($result['access_token'])) {
            return false;
        }

        $this->token = $result['access_token'];
        return true;
    }


    public function getUser() {

        if (!$this->token) {
            return false;
        }

        $url = $this->URL_GET_ME . '?fields=age_range,id,name,birthday,email,gender,cover,link&access_token=' . $this->token;

        if (!($user = @file_get_contents($url))) {
            return false;
        }

        $user = json_decode($user);
        if (empty($user)) {
            return false;
        }

        $this->userId = $user->id;
        return $this->userData = $user;
    }

    public function checkState($state) {
        $state_session = $this->CI->session->userdata('state');
        return (isset($state_session) && ($state_session === $state));
    }
}