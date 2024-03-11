<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_codeigniter');
		$this->load->library('form_validation');

		if($this->session->userdata('status') != 'USER'){
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Anda Belum Login !!!
                </div>');
            redirect('Welcome');
        }   
    }

    public function index()
    { 
        $mdl = $this->m_codeigniter;
		$harga_dump = [];
		$tgl_dump = [];
		// $data_10 = $mdl->getAll('tb_dataset_emas')->limit(10)->result_array();
		$data_10 = $this->db->order_by('tanggal', 'desc')->limit(50)->get('tb_dataset_emas')->result_array();
		function compare_tanggal_asc($a, $b) {
			return strtotime($a['tanggal']) - strtotime($b['tanggal']);
		}
		
		// Melakukan pengurutan array menggunakan fungsi compare_tanggal_asc()
		usort($data_10, 'compare_tanggal_asc');

		foreach ($data_10 as $key) {
		// var_dump($key['harga_emas']);

			$harga_dump[] = (int) $key['harga_emas'];
			$tgl_dump[] = $key['tanggal'];
		}
		// var_dump($harga_dump);
		// die;
        $data = array(
            'judul' => 'Dashboard',
            'menu' => 'ds',
            'harga_emas' => json_encode($harga_dump),
            'tgl_emas' => json_encode($tgl_dump),
            // 'user' => count($mdl->getAll('tb_user')->result()),
            'contents' => 'admin/v_dashboard',
        );
        $this->load->view('template/index', $data);
        
    }

}

/* End of file Admin.php */
