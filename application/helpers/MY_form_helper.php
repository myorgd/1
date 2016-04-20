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
	 * Text Input Field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	mixed
	 * @return	string
	 */
	function form_input_new($name = '', $isplaceholder = false,  $type = false, $iserr = false, $namelabel = false, $value = '', $extra = '')
	{
		$Out = '';

		$defaults = array(
				'class' => 'form-control',
				'type' => ($type != false) ? $type : 'text',
				'name' => $name,
				'placeholder' => ($isplaceholder != false) ? $isplaceholder : '',
				'id' => $name,
				'value' => $value
		);

		if ($namelabel != false){
				$Out = form_label($namelabel, $name, array('class' => 'control-label'));
		}

		$Out .= '<input '._parse_form_attributes('', $defaults)._attributes_to_string($extra)." />\n";

		if ($iserr != false) {
			if (set_value($name, false) != false) {
				return '<div class="form-group has-error">'.$Out.'</div>';
			}
		}

		return '<div class="form-group">'.$Out.'</div>';;
	}

function form_dropdown_new($data = '', $options = array(), $selected = array(), $namelabel = false, $extra = '')
{
	$defaults = ['class' => 'form-control'];

	if (is_array($data))
	{
		if (isset($data['selected']))
		{
			$selected = $data['selected'];
			unset($data['selected']); // select tags don't have a selected attribute
		}

		if (isset($data['options']))
		{
			$options = $data['options'];
			unset($data['options']); // select tags don't use an options attribute
		}
	}
	else
	{
		$defaults['name'] = $data;
	}

	is_array($selected) OR $selected = array($selected);
	is_array($options) OR $options = array($options);

	// If no selected state was submitted we will attempt to set it automatically
	if (empty($selected))
	{
		if (is_array($data))
		{
			if (isset($data['name'], $_POST[$data['name']]))
			{
				$selected = array($_POST[$data['name']]);
			}
		}
		elseif (isset($_POST[$data]))
		{
			$selected = array($_POST[$data]);
		}
	}

	$extra = _attributes_to_string($extra);

	$multiple = (count($selected) > 1 && stripos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

	$form = '<select '.rtrim(_parse_form_attributes($data, $defaults)).$extra.$multiple.">\n";

	if ($namelabel != false){
		$form .= form_label($namelabel, $data, ['class' => 'control-label']);
	}

	foreach ($options as $key => $val)
	{
		$key = (string) $key;

		if (is_array($val))
		{
			if (empty($val))
			{
				continue;
			}

			$form .= '<optgroup label="'.$key."\">\n";

			foreach ($val as $optgroup_key => $optgroup_val)
			{
				$sel = in_array($optgroup_key, $selected) ? ' selected="selected"' : '';
				$form .= '<option value="'.html_escape($optgroup_key).'"'.$sel.'>'
						.(string) $optgroup_val."</option>\n";
			}

			$form .= "</optgroup>\n";
		}
		else
		{
			$form .= '<option value="'.html_escape($key).'"'
					.(in_array($key, $selected) ? ' selected="selected"' : '').'>'
					.(string) $val."</option>\n";
		}
	}

	return '<div class="form-group">'.$form."</select>\n</div>";
}
