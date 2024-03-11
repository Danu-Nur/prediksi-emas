<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Label extends CI_Controller
{

	private $_table = 'tb_label';
	private $idm = 'id_label';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_codeigniter');
		$this->load->library('form_validation');

		// if($this->session->userdata('status') != 'ADMIN'){
		//     $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
		//         Anda Belum Login !!!
		//         </div>');
		//     redirect('Welcome');
		// }  
	}

	public function rules()
	{
		return [
			[
				'field' => 'label',
				'label' => 'Label',
				'rules' => 'required'
			],

			[
				'field' => 'harga_min',
				'label' => 'Harga Min',
				'rules' => 'required'
			],

			[
				'field' => 'harga_max',
				'label' => 'Harga Max',
				'rules' => 'required'
			]
		];
	}

	public function index()
	{
		$mdl = $this->m_codeigniter;
		$validation = $this->form_validation;
		$post = $this->input->post();
		$data = array(
			'judul' => 'Data Label',
			'menu' => 'dl',
			'sub' => 'Tambah Data',
			'sub2' => 'Edit Data',
			'data_label' => $mdl->getAll($this->_table)->result(),
			'contents' => 'admin/v_label',
		);
		$validation->set_rules($this->rules());
		if ($validation->run() == FALSE) {
			$this->load->view('template/index', $data);
		} else {
			$data = array(
				'label' => $post['label'],
				'harga_min' => $post['harga_min'],
				'harga_max' => $post['harga_max'],
			);
			$mdl->add($this->_table, $data);
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('admin/Label');
		}
	}

	public function edit($id = NULL)
	{
		if (!isset($id)) {
			$id = $this->input->post($this->idm);
		}
		if (!isset($id)) redirect('admin/Label');
		$mdl = $this->m_codeigniter;
		$validation = $this->form_validation;
		$post = $this->input->post();
		$validation->set_rules($this->rules());

		if ($validation->run()) {
			$data = array(
				$this->idm => $id,
				'label' => $post['label'],
				'harga_min' => $post['harga_min'],
				'harga_max' => $post['harga_max'],
			);
			$mdl->edit($this->_table, $this->idm, $data);
			$this->session->set_flashdata('success', 'Berhasil diupdate');
		}
		redirect('admin/Label');
	}

	public function delete($id = NULL)
	{
		if (!isset($id)) show_404();
		if ($this->m_codeigniter->delete($this->_table, $this->idm, $id)) {
			$this->session->set_flashdata('success', 'Berhasil Dihapus');
			redirect('admin/Label');
		}
	}
}

/* End of file Controllername.php */
