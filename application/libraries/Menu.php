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
class Menu {

	protected $CI;

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}

	public function show()
	{
		$uri_str = uri_string();
		$query = $this->CI->db->select('ID_PARENT, Name_Img, URL, Name_URL')
				->join('access_url', 'access_url.ID_URL = url.ID_URL')
				->where('ID_Rules', ($this->CI->session->userdata('Rules') == NULL) ? 2 : $this->CI->session->userdata('Rules'))
				->get('url');
		$data = array();
		$datatemp = array();
		foreach ($query->result() as $row) {
			$data[$row->ID_PARENT][] = ['Name' => $row->Name_URL, 'URL' => $row->URL, 'Name_Img' => $row->Name_Img, 'Name_URL' => $row->Name_URL];
			if (array_search($row->ID_PARENT, $datatemp) == false) {
				$datatemp[] = $row->ID_PARENT;
			}
		}

		$Out = '<div class="navbar-default sidebar" role="navigation"><div class="sidebar-nav navbar-collapse"><ul class="nav" id="side-menu">';
		
		if ($datatemp != null)
		{
			$query = $this->CI->db->select('ID_URL, Name_Img, URL, Name_URL')
					->where_in('ID_URL', $datatemp)
					->or_where('`ID_PARENT` IS NULL', null, false)
					->get('url');

			foreach ($query->result_array() as $row) {

				if (array_key_exists ($row['ID_URL'], $data)){
					$Out .= $this->_menu_line($row, $uri_str, true);

					foreach ($data[$row['ID_URL']] as $val){
						$Out .= $this->_menu_line($val, $uri_str);
					}

					$Out .= '</ul></li>';
				} else {
					$Out .= $this->_menu_line($row, $uri_str);
				}
			}
		}
		
		$Out .=  '</ul></div></div>';

		return $Out;
	}

	private function _menu_line($row, $activuri = false, $end = false)
	{

		$url = ($row['URL'] != NULL) ? base_url().$row['URL'] : '#' ;

		if ($activuri == $row['URL'] && $activuri != false){
			$Out = '<li><a href="'.$url.'" class="active"><i class="fa fa-'.$row['Name_Img'].' fa-fw"></i>'.$row['Name_URL'];
		} else {
			$Out = '<li><a href="'.$url.'"><i class="fa fa-'.$row['Name_Img'].' fa-fw"></i>'.$row['Name_URL'];
		}

		return (!$end) ? $Out.'</a></li>' : $Out.'<span class="fa arrow"></span></a><ul class="nav nav-second-level collapse">';
	}

}
