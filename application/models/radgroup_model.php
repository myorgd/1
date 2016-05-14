<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Radgroup_model extends CI_Model {

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function get_id($Group_Name)
	{
		return $this->db->get_where('radgroupreply', ['groupname' => $Group_Name.'_'.$this->session->userdata('ID_Org')]);
	}
	
	public function get_all()
	{
		return $this->db->like('groupname', $this->session->userdata('ID_Org'))->group_by("groupname")->get('radgroupreply');
	}
	
	public function edit($Group_Name)
	{
			$this->db->trans_begin();
			$Group_Name .= $this->session->userdata('ID_Org');			
			$data = [
					'attribute' => "Auth-Type",
					'value' => "Local"
			];

			$this->db->where('groupname', $Group_Name)->update('radgroupcheck', $data);
			
			$data = [
				[
					'attribute' => "Session-Timeout",
					'value' => $this->input->post('session_timeout')
				],
				[
					'attribute' => "Idle-Timeout",
					'value' => $this->input->post('idle_timeout')
				],
				[
					'attribute' => "Acct-Interim-Interval",
					'value' => 120
				]
			];
			
			if ($this->input->post('Max_up') > 0)
			$data[] = [
					'attribute' => "WISPr-Bandwidth-Max-Up",
					'value' => $this->input->post('Max_up') * 1000
				];

			if ($this->input->post('Max_down') > 0)
			$data[] = [
					'attribute' => "WISPr-Bandwidth-Max-Down",
					'value' => $this->input->post('Max_down') * 1000
				];				
			
			$this->db->where('groupname', $Group_Name)->update('radgroupreply', $data);
				
			$this->db->trans_complete();
			
			return $this->db->trans_status();
	}
	
	public function add()
	{
			$this->db->trans_begin();
			$Group_Name = $this->input->post('Group_Name').'_'.$this->session->userdata('ID_Org');	
			$data = [
					'groupname' => $Group_Name,
					'attribute' => "Auth-Type",
					'value' => "Local"
			];

			$this->db->insert('radgroupcheck', $data);
			
			$data = [
				[
					'groupname' => $Group_Name,
					'attribute' => "Session-Timeout",
					'value' => $this->input->post('session_timeout')
				],
				[
					'groupname' => $Group_Name,
					'attribute' => "Idle-Timeout",
					'value' => $this->input->post('idle_timeout')
				],
				[
					'groupname' => $Group_Name,
					'attribute' => "Acct-Interim-Interval",
					'value' => 120
				]
			];
			
			if ($this->input->post('Max_up') > 0)
			$data[] = [
					'groupname' => $Group_Name,
					'attribute' => "WISPr-Bandwidth-Max-Up",
					'value' => $this->input->post('Max_up') * 1000
				];

			if ($this->input->post('Max_down') > 0)
			$data[] = [
					'groupname' => $Group_Name,
					'attribute' => "WISPr-Bandwidth-Max-Down",
					'value' => $this->input->post('Max_down') * 1000
				];				
			
			$this->db->insert('radgroupreply', $data);
				
			$this->db->trans_complete();
			
			return $this->db->trans_status();

	}

}