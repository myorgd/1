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
class Msg {

	protected $Msg = array();
	protected $CI;

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}

	public function add($msg, $type)
	{
		if (!empty($msg)) {
			if (array_key_exists($type, $this->Msg)) {
				$this->Msg[$type] .= '</br>' . $msg;
			} else {
				$this->Msg[$type] = $msg;
			}
		}
	}

	public function show()
	{
		$Out = '';

		foreach ($this->Msg as $key => $value) {
			switch ($key) {
				case 0:
					$Out .= '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
					break;
				case 1:
					$Out .= '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
					break;
				case 2:
					$Out .= '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
					break;
				case 3:
					$Out .= '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$value.'</div>';
					break;
			}
		}

		return $Out;
	}

}
