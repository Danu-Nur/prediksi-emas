<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_codeigniter extends CI_Model {

	public function getAll($_table)
    {
        return $this->db->get($_table);
    }

	public function getKolom($column,$_table)
    {
		$this->db->select($column);
		// $this->db->limit(2);
		
        return $this->db->get($_table);
    }

	public function getById($_table, $idm, $id){
        return $this->db->get_where($_table, [$idm => $id])->row_array();
    } 

    public function add($_table,$data)
    {
        $this->db->insert($_table, $data);
    }

    public function edit($_table, $idm, $data)
    {
        $this->db->where($idm, $data[$idm]);
        $this->db->update($_table, $data);
    }

	public function delete($_table, $idm, $id)
	{        
        return $this->db->delete($_table, [$idm => $id]);     
    }

}

/* End of file m_kriteria.php */
