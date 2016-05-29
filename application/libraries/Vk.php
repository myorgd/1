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
class Vk {

    protected $APP_ID = 5483556; //ID приложения
    protected $APP_SECRET = '48PE7iHaBE190lhbBd3Y'; //Защищенный ключ
    protected $URL_CALLBACK = 'http://localhost/wifi/wifi/vk'; //URL сайта до этого скрипта-обработчика 
    protected $URL_ACCESS_TOKEN = 'https://oauth.vk.com/access_token';
    protected $URL_AUTHORIZE = 'https://oauth.vk.com/authorize';
    protected $URL_GET_PROFILES = 'https://api.vk.com/method/users.get';

    protected $token;
    public $userId;
    public $userData;

	function __construct($params=array()) {
		$this->CI=& get_instance();
	}
	
    private static function printError($error) {
        echo '#' . $error->error_code . ' - ' . $error->error_msg;
    }

    /**
     * @url https://vk.com/dev/auth_sites
     */
    public function goToAuth()
    {
        redirect($this->URL_AUTHORIZE .
            '?client_id=' . $this->APP_ID .
            '&scope=offline' .
            '&redirect_uri=' . urlencode($this->URL_CALLBACK) .
            '&response_type=code', 'location', 301);
    }

    public function getToken($code) {
        $url = $this->URL_ACCESS_TOKEN .
            '?client_id=' . $this->APP_ID .
            '&client_secret=' . $this->APP_SECRET .
            '&code=' . $code .
            '&redirect_uri=' . urlencode($this->URL_CALLBACK);

        if (!($res = @file_get_contents($url))) {
            return false;
        }

        $res = json_decode($res);
        if (empty($res->access_token) || empty($res->user_id)) {
            return false;
        }

        $this->token = $res->access_token;
        $this->userId = $res->user_id;

        return true;
    }

    /**
     * Если данных недостаточно, то посмотрите что можно ещё запросить по этой ссылке
     * @url https://vk.com/pages.php?o=-1&p=getProfiles
     */
    public function getUser() {

        if (!$this->userId) {
            return false;
        }

        $url = $this->URL_GET_PROFILES.
            '?user_ids=' . $this->userId .
			'&fields=sex,bdate,city,photo_100,nickname,email
			&access_token=' . $this->token;

        if (!($res = @file_get_contents($url))) {
            return false;
        }

        $user = json_decode($res);

        if (!empty($user->error)) {
            //$this->printError($user->error);
            return false;
        }

        if (empty($user->response[0])) {
            return false;
        }

        $user = $user->response[0];
        if (empty($user->uid) || empty($user->first_name) || empty($user->last_name)) {
            return false;
        }

        return $this->userData = $user;
    }
}