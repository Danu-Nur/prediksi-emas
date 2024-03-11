<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	private $_table = 'tb_user';
    private $idm = 'id_user';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_codeigniter');
		$this->load->library('form_validation');

		if($this->session->userdata('status') != 'ADMIN'){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                  Anda Belum Login !!!
                </div>');
            redirect('Welcome');
        }   
    }

	public function rules(){ 
        return [
			['field' => 'nama',
			'label' => 'Nama',
			'rules' => 'required'],

			['field' => 'username_user',
			'label' => 'Username',
			'rules' => 'required'],

			['field' => 'password_user',
			'label' => 'Password',
			'rules' => 'required'],

			['field' => 'status',
			'label' => 'Status',
			'rules' => 'required']
        ];
    }

    public function index()
    {
		$mdl = $this->m_codeigniter;
		$validation = $this->form_validation;
		$post = $this->input->post();
		$data = array(
			'judul' => 'USERS',
			'menu' => 'dr',
			'sub' => 'Tambah Data',
			'sub2' => 'Edit Data',
			'tampil' => $mdl->getAll($this->_table)->result(),
			'contents' => 'admin/v_user'
		);
		
		$validation->set_rules($this->rules());
		if ($validation->run() == FALSE){
			$this->load->view('template/index',$data);
		} else {
			$data = array(
				'nama' => $post['nama'],
				'username_user' => $post['username_user'],
				'password_user' => $post['password_user'],
				'status' => $post['status'],
			);
			$mdl->add($this->_table, $data);
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('admin/Users');
		}
	}

	public function edit($id = NULL)
	{
		if(!isset($id))
    	{
    		$id = $this->input->post($this->idm);
    	}
		if(!isset($id)) redirect('admin/Users');
		$mdl = $this->m_codeigniter;
		$validation = $this->form_validation;
		$post = $this->input->post();
		$validation->set_rules($this->rules()); 

        if ($validation->run()){
			$data = array(
			$this->idm => $id,
			'nama' => $post['nama'],
			'username_user' => $post['username_user'],
			'password_user' => $post['password_user'],
			'status' => $post['status'],
		);
		$mdl->edit($this->_table, $this->idm, $data);
		$this->session->set_flashdata('success', 'Berhasil diupdate'); 
		}
		redirect('admin/Users');
	}

	public function delete($id = NULL)
	{
		if (!isset($id)) show_404();                  
    	if ($this->m_codeigniter->delete($this->_table, $this->idm, $id)) 
    		{             
				$this->session->set_flashdata('success', 'Berhasil Dihapus'); 
    			redirect('admin/Users');         
    		}     
    } 

}

/* End of file Kriteria.php */
