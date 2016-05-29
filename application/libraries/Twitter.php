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
class Twitter {
    protected $param;
    private $token;
    public $userId;
    public $userData;

	function __construct($params=array()) {
		$this->CI=& get_instance();
		$this->CI->config->load('social_networks', true);
      	$this->param = (object) $this->CI->config->item('twitter', 'social_networks');
	}

    public function goToAuth() {
        $oauth_nonce = md5(uniqid(rand(), true));
        $oauth_timestamp = time();

        $oauth_base_text = "GET&" .
            urlencode($this->param->URL_REQUEST_TOKEN) . "&" .
            urlencode(
                "oauth_callback=" . urlencode($this->param->URL_CALLBACK) . "&" .
                "oauth_consumer_key=" . $this->param->CONSUMER_KEY . "&" .
                "oauth_nonce=" . $oauth_nonce . "&" .
                "oauth_signature_method=HMAC-SHA1&" .
                "oauth_timestamp=" . $oauth_timestamp . "&" .
                "oauth_version=1.0"
            );

        $key = $this->param->CONSUMER_SECRET . "&";
        $oauth_signature = $this->encode($oauth_base_text, $key);

        $url = $this->param->URL_REQUEST_TOKEN .
            '?oauth_callback=' . urlencode($this->param->URL_CALLBACK) .
            '&oauth_consumer_key=' . $this->param->CONSUMER_KEY .
            '&oauth_nonce=' . $oauth_nonce .
            '&oauth_signature=' . urlencode($oauth_signature) .
            '&oauth_signature_method=HMAC-SHA1' .
            '&oauth_timestamp=' . $oauth_timestamp .
            '&oauth_version=1.0';

        if (!($response = @file_get_contents($url))) {
            return false;
        }
        parse_str($response, $result);

        if (empty($result['oauth_token_secret'])) {
            return false;
        }

        $this->CI->session->set_userdata(['oauth_token_secret' => $result['oauth_token_secret']]);

        redirect($this->param->URL_AUTHORIZE . '?oauth_token=' . $result['oauth_token'], 'location', 301);
        return true;
    }

    private function encode($string, $key) {
        return base64_encode(hash_hmac("sha1", $string, $key, true));
    }

    public function getToken($oauth_token, $oauth_verifier) {
        $oauth_nonce = md5(uniqid(rand(), true));
        $oauth_timestamp = time();
        $oauth_token_secret = $this->CI->session->userdata('oauth_token_secret');

        $oauth_base_text = "GET&" .
            urlencode($this->param->URL_ACCESS_TOKEN) . "&" .
            urlencode(
                "oauth_consumer_key=" . $this->param->CONSUMER_KEY . "&" .
                "oauth_nonce=" . $oauth_nonce . "&" .
                "oauth_signature_method=HMAC-SHA1&" .
                "oauth_token=" . $oauth_token . "&" .
                "oauth_timestamp=" . $oauth_timestamp . "&" .
                "oauth_verifier=" . $oauth_verifier . "&" .
                "oauth_version=1.0"
            );

        $key = $this->param->CONSUMER_SECRET . "&" . $oauth_token_secret;
        $oauth_signature = $this->encode($oauth_base_text, $key);

        $url = $this->param->URL_ACCESS_TOKEN .
            '?oauth_consumer_key=' . $this->param->CONSUMER_KEY .
            '&oauth_nonce=' . $oauth_nonce .
            '&oauth_signature_method=HMAC-SHA1' .
            '&oauth_token=' . urlencode($oauth_token) .
            '&oauth_timestamp=' . $oauth_timestamp .
            '&oauth_verifier=' . urlencode($oauth_verifier) .
            '&oauth_signature=' . urlencode($oauth_signature) .
            '&oauth_version=1.0';

        if (!($response = @file_get_contents($url))) {
            return false;
        }

        parse_str($response, $result);

        if (empty($result['oauth_token']) || empty($result['user_id'])) {
            return false;
        }

        $this->token = $result['oauth_token'];
        $this->userId = $result['user_id'];

        return true;
    }

    public function getUser() {
        $data = array(
            'grant_type' => 'client_credentials',
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  =>"Content-type: application/x-www-form-urlencoded;charset=UTF-8\r\n" .
                    'Authorization: Basic ' . base64_encode($this->param->CONSUMER_KEY . ':' . $this->param->CONSUMER_SECRET) . "\r\n",
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($opts);

        if (!($response = @file_get_contents($this->param->URL_GET_TOKEN, false, $context))) {
            return false;
        }
        $result = json_decode($response, true);

        if (empty($result['access_token'])) {
            return false;
        }

        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'header'  =>"Content-type: application/x-www-form-urlencoded;charset=UTF-8\r\n" .
                    'Authorization: Bearer ' . $result['access_token'] . "\r\n",
            )
        );

        $url = $this->param->URL_USER_DATA . '?user_id=' . $this->userId;
        if (!($response = @file_get_contents($url, false, stream_context_create($opts)))) {
            return false;
        }

        $user = json_decode($response, true);
        if (empty($user)) {
            return false;
        }

        return $this->userData = $user;
    }
}