<?php

defined('BASEPATH') or exit('No direct script access allowed');

class m_metode extends CI_Model
{
	public function getAllWhere($tbl, $id)
	{
		$this->db->where('id_user', $id);
		return $this->db->get($tbl)->result();
	}


	public function getWhere($tbl, $data)
	{
		$this->db->where('id_data', $data['id_data']);
		$this->db->where('id_user', $data['id_user']);
		return $this->db->get($tbl);
	}


	public function add($_table, $data)
	{
		$this->db->insert($_table, $data);
		return $this->db->insert_id();
	}
}

/* End of file M_metode.php */
