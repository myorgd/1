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
class Loadlib {

	protected $JS = array();
	protected $CSS = array();

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->add_css(["bower_components/bootstrap/dist/css/bootstrap.min.css",
						"bower_components/metisMenu/dist/metisMenu.min.css",
						"dist/css/sb-admin-2.css",
						"bower_components/font-awesome/css/font-awesome.css"]);
		$this->add_js(["bower_components/jquery/dist/jquery.min.js",
					  "bower_components/bootstrap/dist/js/bootstrap.min.js",
					  "bower_components/metisMenu/dist/metisMenu.min.js",
					  "dist/js/sb-admin-2.js"]);
					  
	}
	
	public function add_js($url)
	{
		if (is_array($url)){
			foreach ($url as $value) {
				$this->JS[] = base_url().$value;	
			}
		} else {
			$this->JS[] = base_url().$url;	
		}
	}

	public function add_css($url)
	{
		if (is_array($url)){
			foreach ($url as $value) {
				$this->CSS[] = base_url().$value;	
			}
		} else {
			$this->CSS[] = base_url().$url;	
		}		
	}

	public function show_css()
	{
		$Out = '';

		foreach ($this->CSS as $value) {
			$Out .=  '<link href="'.$value.'" rel="stylesheet">';
		}
				
		echo $Out;
	}
	
	public function show_js()
	{
		$Out = '';

		foreach ($this->JS as $value) {
			$Out .=  '<script src="'.$value.'"></script>';
		}
				
		echo $Out;
	}
	
}
