<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dataset_emas extends CI_Controller
{

	private $_table = 'tb_dataset_emas';
	private $idm = 'id_emas';

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
				'field' => 'tanggal',
				'label' => 'tanggal',
				'rules' => 'required'
			],

			[
				'field' => 'harga_emas',
				'label' => 'Harga Emas',
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
			'judul' => 'Data Emas',
			'menu' => 'de',
			'sub' => 'Tambah Data',
			'sub2' => 'Edit Data',
			'data_emas' => $mdl->getAll($this->_table)->result(),
			'contents' => 'admin/v_data_emas',
		);
		$validation->set_rules($this->rules());
		if ($validation->run() == FALSE) {
			$this->load->view('template/index', $data);
		} else {
			$data = array(
				'tanggal' => $post['tanggal'],
				'harga_emas' => $post['harga_emas'],
			);
			$mdl->add($this->_table, $data);
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('admin/Dataset_emas');
		}
	}

	public function edit($id = NULL)
	{
		if (!isset($id)) {
			$id = $this->input->post($this->idm);
		}
		if (!isset($id)) redirect('admin/Dataset_emas');
		$mdl = $this->m_codeigniter;
		$validation = $this->form_validation;
		$post = $this->input->post();
		$validation->set_rules($this->rules());

		if ($validation->run()) {
			$data = array(
				$this->idm => $id,
				'tanggal' => $post['tanggal'],
				'harga_emas' => $post['harga_emas'],
			);
			$mdl->edit($this->_table, $this->idm, $data);
			$this->session->set_flashdata('success', 'Berhasil diupdate');
		}
		redirect('admin/Dataset_emas');
	}

	public function delete($id = NULL)
	{
		if (!isset($id)) show_404();
		if ($this->m_codeigniter->delete($this->_table, $this->idm, $id)) {
			$this->session->set_flashdata('success', 'Berhasil Dihapus');
			redirect('admin/Dataset_emas');
		}
	}
}

/* End of file Controllername.php */
