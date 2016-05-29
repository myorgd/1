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
class Odnoklassniki {
            /*
	protected $APP_ID = 1247133440; //ID приложения
    protected $APP_PUBLIC = 'CBAQLGFLEBABABABA'; //Публичный ключ
    protected $APP_SECRET = 'F2DC27635A7161FD03025158'; //Защищенный ключ
    protected $URL_CALLBACK = 'http://localhost/wifi/wifi/odnoklassniki'; //URL, на который произойдет перенаправление после авторизации
    protected $URL_AUTHORIZE = 'http://www.odnoklassniki.ru/oauth/authorize';
    protected $URL_GET_TOKEN = 'http://api.odnoklassniki.ru/oauth/token.do';
    protected $URL_ACCESS_TOKEN = 'http://api.odnoklassniki.ru/fb.do';
              */
    protected $param;

    private $token;
    public $userId;
    public $userData;

	function __construct($params=array()) {
		$this->CI=& get_instance();
		$this->CI->config->load('social_networks', true);
      	$this->param = (object) $this->CI->config->item('ok', 'social_networks');
	}

    /**
     * @url http://apiok.ru/wiki/pages/viewpage.action?pageId=81822109
     */
    public function goToAuth()
    {
        redirect($this->param->URL_AUTHORIZE .
            '?client_id=' . $this->param->APP_ID .
            '&response_type=code' .
            '&redirect_uri=' . urlencode($this->param->URL_CALLBACK), 'location', 301);
    }

    public function getToken($code) {

        $data = [
            'code' => trim($code),
            'redirect_uri' => $this->param->URL_CALLBACK,
            'client_id' => $this->param->APP_ID,
            'client_secret' => $this->param->APP_SECRET,
            'grant_type' => 'authorization_code'
        ];

        $opts = ['http' =>
            [
                'method'  => 'POST',
                'header'  =>"Content-type: application/x-www-form-urlencoded\r\n".
                    "Accept: */*\r\n",
                'content' => http_build_query($data)
            ]
        ];

        if (!($response = @file_get_contents($this->param->URL_GET_TOKEN, false, stream_context_create($opts)))) {
            return false;
        }

        $result = json_decode($response);
        if (empty($result->access_token)) {
            return false;
        }

        $this->token = $result->access_token;

        return true;
    }

    /**
     * Если данных недостаточно, то посмотрите что можно ещё запросить по этой ссылке
     * @url http://apiok.ru/wiki/display/api/users.getCurrentUser+ru
     */
    public function getUser() {

        if (!$this->token) {
            return false;
        }

        $url = $this->param->URL_ACCESS_TOKEN .
            '?access_token=' . $this->token .
            '&method=users.getCurrentUser' .
            '&application_key=' . $this->param->APP_PUBLIC .
            '&sig=' . md5('application_key=' . $this->param->APP_PUBLIC . 'method=users.getCurrentUser' . md5($this->token . $this->param->APP_SECRET));

        if (!($response = @file_get_contents($url))) {
            return false;
        }

        $user = json_decode($response);

        if (empty($user)) {
            return false;
        }

        $this->userId = $user->uid;
        return $this->userData = $user;
    }
}