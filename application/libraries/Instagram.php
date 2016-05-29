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
class Instagram {

    protected $param;

    protected $token;
    public $userId;
    public $userData;

	function __construct() {
		$this->CI=& get_instance();
		$this->CI->config->load('social_networks', true);
      	$this->param = (object) $this->CI->config->item('ig', 'social_networks');
	}

    /**
     * @url https://vk.com/dev/auth_sites
     */
    public function goToAuth()
    {
        redirect($this->param->URL_AUTHORIZE .
            '?client_id=' . $this->param->CLIENT_ID .
            '&redirect_uri=' . urlencode($this->param->REDIRECT_URI) .
            '&response_type=code', 'location', 301);
    }

    public function getToken($code) {
        /*
        $url = $this->param->URL_ACCESS_TOKEN .
            '?client_id=' . $this->param->CLIENT_ID .
            '&client_secret=' . $this->param->CLIENT_SECRET .
            '&grant_type=authorization_code' .
            '&redirect_uri=' . urlencode($this->param->REDIRECT_URI) .
            '&code=' . $code;

        if (!($res = @file_get_contents($url))) {
            return false;
        }
        */
        $data = [
            'code' => trim($code),
            'redirect_uri' => $this->param->REDIRECT_URI,
            'client_id' => $this->param->CLIENT_ID,
            'client_secret' => $this->param->CLIENT_SECRET,
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

        if (!($response = @file_get_contents($this->param->URL_ACCESS_TOKEN, false, stream_context_create($opts)))) {
            return false;
        }
        
        $res = json_decode($response);

        if (empty($res->access_token) || empty($res->user->id)) {
            return false;
        }

        $this->token = $res->access_token;
        $this->userId = $res->user->id;

        return true;
    }

    public function getUser() {

        if (!$this->userId) {
            return false;
        }

        $url = $this->param->URL_GET_PROFILES.
            $this->userId .
            '/?access_token=' . $this->token;

        if (!($res = @file_get_contents($url))) {
            return false;
        }

        $user = json_decode($res);
        
        if (!empty($user->error)) {
            //$this->printError($user->error);
            return false;
        }

        if (empty($user->data)) {
            return false;
        }

        $user = $user->data;
        if (empty($user->id) || empty($user->full_name)) {
            return false;
        }

        return $this->userData = $user;
    }
}