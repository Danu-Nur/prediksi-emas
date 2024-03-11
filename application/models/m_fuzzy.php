<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode extends CI_Controller
{
	private $_table = 'tb_data_uji';
	private $idm = 'id_uji';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_codeigniter');
		$this->load->model('m_metode');
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
		$mdlmtd = $this->m_metode;
		$validation = $this->form_validation;
		$post = $this->input->post();
		$data = array(
			'judul' => 'HITUNG METODE',
			'menu' => 'de',
			'sub' => 'Tambah Data',
			'data_emas' => $mdl->getAll($this->_table)->result(),
			'contents' => 'admin/v_data_uji_metode',
		);
		$validation->set_rules($this->rules());
		if ($validation->run() == FALSE) {
			$this->load->view('template/index', $data);
		} else {
			$id_user = $this->session->userdata('id_user');
			$data = array(
				'tanggal' => $post['tanggal'],
				'harga_emas' => $post['harga_emas'],
				'id_user' => $id_user,
			);
			$id = $mdlmtd->add($this->_table, $data);
			$this->fuzzy_markov($id, $id_user);
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('admin/Metode');
		}
	}

	public function fuzzy_markov($id, $id_user)
	{

		$mdl = $this->m_codeigniter;
		$mdlmtd = $this->m_metode;

		$data_uji = $mdl->getById($this->_table, $this->idm, $id);
		$dataset = $mdl->getKolom('tanggal, harga_emas', 'tb_dataset_emas')->result_array();
		// var_dump('$dataset : ', $dataset);
		// $dataset_x_datauji[] = $dataset;
		// $dataset_x_datauji[] = array("tanggal" => $data_uji['tanggal'], "harga_emas" => $data_uji['harga_emas']);

		$transisi = $this->hitung_transisi($dataset);
		var_dump('$transisi : ', $transisi);

		// Hitung prediksi menggunakan Fuzzy Time Series
		$prediksi_fuzzy_time_series = $this->fuzzy_time_series_forecast($transisi);
		var_dump('$prediksi_fuzzy_time_series : ', $prediksi_fuzzy_time_series);
		
		// Hitung prediksi menggunakan Markov Chain
		$prediksi_markov_chain = $this->markov_chain_prediction($prediksi_fuzzy_time_series);
		var_dump('$prediksi_markov_chain : ', $prediksi_markov_chain);
		die();

		$data = array(
			'data_historis' => $dataset,
			'harga_emas_uji' => $data_uji,
			'prediksi_fuzzy_time_series' => $prediksi_fuzzy_time_series,
			'prediksi_markov_chain' => $prediksi_markov_chain
		);

		// Load view untuk menampilkan hasil prediksi
		$this->load->view('hasil_prediksi', $data);
	}

	public function hitung_transisi($data)
	{
		$transisi = array();

		foreach ($data as $key => $value) {
			if ($key > 0) {
				$sebelumnya = $this->tentukan_himpunan($data[$key - 1]['harga_emas']);
				$sekarang = $this->tentukan_himpunan($value['harga_emas']);

				// Check if the key exists in the $transisi array
				$key_transisi = $sebelumnya . '_' . $sekarang;
				if (isset($transisi[$key_transisi])) {
					$transisi[$key_transisi]++;
				} else {
					$transisi[$key_transisi] = 1;
				}
			}
		}


		return $transisi;
	}

	public function fuzzy_time_series_forecast($transisi)
	{
		$total_transisi = array();
		foreach ($transisi as $key => $value) {
			$state = explode('_', $key);
			$current_state = $state[0];

			// Check if the index exists, if not, initialize it to 0
			if (!isset($total_transisi[$current_state])) {
				$total_transisi[$current_state] = 0;
			}

			$total_transisi[$state[0]] += $value;
		}

		$probabilitas_transisi = array();
		foreach ($transisi as $key => $value) {
			$state = explode('_', $key);
			$probabilitas_transisi[$key] = $value / $total_transisi[$state[0]];
		}

		$prediksi = array();
		foreach ($probabilitas_transisi as $key => $value) {
			$state = explode('_', $key);
			$current_state = $state[0];
			$next_state = $state[1];

			if (!isset($prediksi[$current_state])) {
				$prediksi[$current_state] = array();
			}

			if (!isset($prediksi[$current_state][$next_state])) {
				$prediksi[$current_state][$next_state] = 0;
			}

			$prediksi[$current_state][$next_state] += $value;
		}

		return $prediksi;
	}

	public function markov_chain_prediction($probabilitas_transisi)
	{
		$prediksi_markov = array();
		foreach ($probabilitas_transisi as $current_state => $next_states) {
			var_dump('$current_state');
			var_dump($current_state);
			var_dump('$next_states');
			var_dump($next_states);
			// $prediksi_markov[$current_state] = $this->nilai_tengah($next_states);
		}

		return $prediksi_markov;
	}

	private function nilai_tengah($distribusi)
	{
		// Filter out non-numeric values and calculate total probabilitas
		$total_probabilitas = 0;
		foreach ($distribusi as $probabilitas) {
			if (is_numeric($probabilitas)) {
				$total_probabilitas += floatval($probabilitas);
			}
		}
		// var_dump($state);

		// Calculate the nilai tengah
		$nilai_tengah = 0;
		foreach ($distribusi as $state => $probabilitas) {
			if (is_numeric($probabilitas)) {
				$nilai_tengah += $state * $probabilitas;
			}
		}

		// Avoid division by zero if total_probabilitas is zero
		if ($total_probabilitas == 0) {
			return 0;
		}

		return $nilai_tengah / $total_probabilitas;
	}

	// private function nilai_tengah($distribusi)
	// {
	// 	$total_probabilitas = array_sum(floatval($distribusi));
	// 	$nilai_tengah = 0;
	// 	foreach ($distribusi as $state => $probabilitas) {
	// 		$nilai_tengah += $state * $probabilitas;
	// 	}
	// 	return $nilai_tengah / $total_probabilitas;
	// }

	private function tentukan_himpunan($nilai)
	{
		if ($nilai >= 924000 && $nilai <= 935900) {
			return 'A1';
		} elseif ($nilai > 935900 && $nilai <= 947800) {
			return 'A2';
		} elseif ($nilai > 947800 && $nilai <= 959700) {
			return 'A3';
		} elseif ($nilai > 959700 && $nilai <= 971600) {
			return 'A4';
		} elseif ($nilai > 971600 && $nilai <= 983500) {
			return 'A5';
		} elseif ($nilai > 983500 && $nilai <= 995400) {
			return 'A6';
		} elseif ($nilai > 995400 && $nilai <= 1007300) {
			return 'A7';
		} elseif ($nilai > 1007300 && $nilai <= 1019200) {
			return 'A8';
		} elseif ($nilai > 1019200 && $nilai <= 1031100) {
			return 'A9';
		} elseif ($nilai > 1031100 && $nilai <= 1043000) {
			return 'A10';
		}
	}

	// public function metode_hitung($id, $id_user)
	// {
	// 	$mdl = $this->m_codeigniter;
	// 	$mdlmtd = $this->m_metode;

	// 	// Mengambil data harga emas dan data fuzzifikasi
	// 	$harga_emas = $mdl->getAll($this->_table)->result_array();
	// 	$fuzifikasi = $mdl->getAll('tb_label')->result_array();

	// 	$input = []; // Variabel untuk menyimpan data input

	// 	// Melakukan iterasi untuk setiap data harga emas
	// 	foreach ($harga_emas as $key) {
	// 		$harga = $key['harga_emas'];

	// 		// Mencari himpunan fuzzy berdasarkan harga
	// 		$dump_fuzifikasi = array_filter($fuzifikasi, function ($fuzzy) use ($harga) {
	// 			return $harga >= $fuzzy['harga_min'] && $harga <= $fuzzy['harga_max'];
	// 		});

	// 		// Mengambil label dari himpunan fuzzy yang memenuhi kriteria
	// 		$labels = array_column($dump_fuzifikasi, 'label');

	// 		// Jika terdapat beberapa himpunan fuzzy yang memenuhi kriteria, Anda dapat memilih salah satu
	// 		if (!empty($labels)) {
	// 			$dump_fuzifikasi = reset($labels); // Mengambil label pertama dari himpunan fuzzy yang memenuhi kriteria
	// 		} else {
	// 			$dump_fuzifikasi = null; // Jika tidak ada himpunan fuzzy yang memenuhi kriteria
	// 		}

	// 		// Menyimpan data input ke dalam array
	// 		$input[] = [
	// 			'id_data' => $id,
	// 			'id_user' => $id_user,
	// 			'harga_emas' => $harga,
	// 			'fuzifikasi' => $dump_fuzifikasi
	// 		];
	// 	}

	// 	// Mengembalikan data input
	// 	return $input;
	// }

	// public function detail_metode($input)
	// {
	// 	$min_harga_emas = min(array_column($input, 'harga_emas'));
	// 	$max_harga_emas = max(array_column($input, 'harga_emas'));
	// 	foreach ($input as $value) {
	// 		$value;
	// 	}
	// }
}

/* End of file Metode.php */
