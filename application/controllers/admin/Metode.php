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
			'menu' => 'mtd',
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
			// redirect('admin/Metode');
		}
	}

	public function detailFuzzy($id, $id_user)
	{
		// Retrieve data from session
		// $data = $this->session->userdata('prediction_data');
		$mdl = $this->m_codeigniter;
		$mdlmtd = $this->m_metode;
		$datacek = array(
			'id_data' => $id,
			'id_user' => $id_user,
		);

		$data_uji = $mdl->getById($this->_table, $this->idm, $id);
		$prediksi_fuzzy_time_series = $mdlmtd->getWhere('tb_fuzzy_transisi', $datacek)->result_array();
		$prediksi_markov_chain = $mdlmtd->getWhere('tb_markov_chain', $datacek)->result_array();
		$data = array(
			'menu' => 'mtd',
			'sub1' => 'DATA UJI',
			'harga_emas_uji' => $data_uji,
			'sub2' => 'PREDIKSI FUZZY TIME SERIES',
			'prediksi_fuzzy_time_series' => $prediksi_fuzzy_time_series,
			'sub3' => 'PREDIKSI MARKOV CHAIN',
			'prediksi_markov_chain' => $prediksi_markov_chain,
			'contents' => 'admin/v_hasil_prediksi',
		);

		// Load the view
		$this->load->view('template/index', $data);
	}

	public function fuzzy_markov($id, $id_user)
	{

		$mdl = $this->m_codeigniter;
		$mdlmtd = $this->m_metode;
		$datacek = array(
			'id_data' => $id,
			'id_user' => $id_user,
		);

		$cekData = $mdlmtd->getWhere('tb_fuzzy_transisi', $datacek)->result_array();
		$data_uji = $mdl->getById($this->_table, $this->idm, $id);

		if (count($cekData) === 0) {
			$dataset = $mdl->getKolom('tanggal, harga_emas', 'tb_dataset_emas')->result_array();
			$dataset_x_datauji[] = $dataset;
			$data_uji_row = array(
				'tanggal' => $data_uji['tanggal'],
				'harga_emas' => $data_uji['harga_emas']
			);
			$dataset_x_datauji[0][] = $data_uji_row;

			// trnasisi fuzzy time serries
			$transisi = $this->hitung_transisi($id, $id_user, $dataset_x_datauji[0]);

			$prediksi_fuzzy_time_series = $this->fuzzy_time_series_forecast($transisi);
			// Hitung prediksi menggunakan Markov Chain
			// $prediksi_markov_chain = $this->markov_chain_prediction($id, $id_user, $prediksi_fuzzy_time_series);
			$this->markov_chain_prediction($id, $id_user, $prediksi_fuzzy_time_series);
			// var_dump('$prediksi_markov_chain : ', $prediksi_markov_chain);
		}



		// Store the data in session
		// $this->session->set_userdata('prediction_data', $data);

		// Redirect to another controller method to load the view
		// redirect('admin/Metode/detailFuzzy');
		// Redirect to another controller method to load the view
		redirect(site_url('admin/Metode/detailFuzzy/' . $id . '/' . $id_user));


		// Load view untuk menampilkan hasil prediksi
		// $this->load->view('template/index', $data);
	}

	public function hitung_transisi($id, $id_user, $data)
	{
		$mdl = $this->m_codeigniter;
		$fuzifikasi = $mdl->getAll('tb_label')->result_array();

		$transisi = array();

		foreach ($data as $key => $value) {
			if ($key > 0) {
				// var_dump('$data[$key - 1] : ' , $data[$key - 1]['harga_emas']);
				$sebelumnya = $this->tentukan_himpunan($fuzifikasi, $data[$key - 1]['harga_emas']);
				$sekarang = $this->tentukan_himpunan($fuzifikasi, $value['harga_emas']);
				$next_label = $this->tentukan_next_label($fuzifikasi, $sebelumnya);

				// Menyimpan data input ke dalam array
				$transisi[] = [
					'id_data' => $id,
					'id_user' => $id_user,
					'harga_emas' => $value['harga_emas'],
					'current_state' => $sebelumnya,
					'next_state' => $sekarang,
					'next_label' => $next_label,
				];
			}
		}

		return $transisi;
	}

	private function tentukan_next_label($fuzifikasi, $label)
	{
		// Mencari himpunan fuzzy berdasarkan harga
		$dump_fuzifikasi = array_filter($fuzifikasi, function ($fuzzy) use ($label) {
			return $fuzzy['label'] == $label;
		});

		// Mengambil label dari himpunan fuzzy yang memenuhi kriteria
		$label_next = array_column($dump_fuzifikasi, 'label_next');

		// Jika terdapat beberapa himpunan fuzzy yang memenuhi kriteria, Anda dapat memilih salah satu
		if (!empty($label_next)) {
			// Mengambil label pertama dari himpunan fuzzy yang memenuhi kriteria
			$dump_fuzifikasi = reset($label_next);
		} else {
			$dump_fuzifikasi = null; // Jika tidak ada himpunan fuzzy yang memenuhi kriteria
		}
		return $dump_fuzifikasi;
	}

	private function tentukan_himpunan($fuzifikasi, $harga)
	{
		// Mencari himpunan fuzzy berdasarkan harga
		$dump_fuzifikasi = array_filter($fuzifikasi, function ($fuzzy) use ($harga) {
			return $harga >= $fuzzy['harga_min'] && $harga <= $fuzzy['harga_max'];
		});

		// Mengambil label dari himpunan fuzzy yang memenuhi kriteria
		$labels = array_column($dump_fuzifikasi, 'label');

		// Jika terdapat beberapa himpunan fuzzy yang memenuhi kriteria, Anda dapat memilih salah satu
		if (!empty($labels)) {
			// Mengambil label pertama dari himpunan fuzzy yang memenuhi kriteria
			$dump_fuzifikasi = reset($labels);
		} else {
			$dump_fuzifikasi = null; // Jika tidak ada himpunan fuzzy yang memenuhi kriteria
		}
		return $dump_fuzifikasi;
	}

	public function fuzzy_time_series_forecast($transisi)
	{
		// Initialize an array to store min and max values for each label
		$min_max_values = array();

		// Iterate through the transisi data
		foreach ($transisi as $data) {
			$current_state = $data['current_state'];
			$harga_emas = $data['harga_emas'];

			// Check if the current_state exists in min_max_values array
			if (!isset($min_max_values[$current_state])) {
				// If not, initialize min and max values for the current_state
				$min_max_values[$current_state] = array(
					'label' => $current_state,
					'min' => $harga_emas,
					'mid' => $harga_emas,
					'max' => $harga_emas,
				);
			} else {
				// If it exists, update min and max values if necessary
				$min_max_values[$current_state]['label'] = $current_state;
				$min_max_values[$current_state]['min'] = min($min_max_values[$current_state]['min'], $harga_emas);
				$min_max_values[$current_state]['mid'] = (min($min_max_values[$current_state]['min'], $harga_emas) + max($min_max_values[$current_state]['max'], $harga_emas)) / 2;
				$min_max_values[$current_state]['max'] = max($min_max_values[$current_state]['max'], $harga_emas);
			}
		}

		foreach ($transisi as &$value) { // Use reference to update $transisi array elements
			// Get the next labels from the JSON string in 'next_state' field
			$next_label_data = json_decode($value['next_label'], true);
			// var_dump($next_label_data);

			// Initialize variables to store the sum and count for calculating the average
			$sum_mid_values = 0;
			$count_labels = count($next_label_data);

			foreach ($next_label_data as $label) {
				// Filter $min_max_values array to get the values corresponding to the label
				$option = array_filter($min_max_values, function ($mmv) use ($label) {
					return $mmv['label'] == $label;
				});

				// If matching label found, extract mid value and add it to the sum
				if (!empty($option)) {
					$mid_value = reset($option)['mid'];
					$sum_mid_values += $mid_value;
				}
			}

			// Calculate the average mid value for the labels
			$average_mid = $count_labels > 0 ? $sum_mid_values / $count_labels : 0;

			// Assign the average mid value to the 'average' key in $value array
			$value['forecast'] = $average_mid;
			$mape = (($value['harga_emas'] - $average_mid) / $value['harga_emas']) * 100;
			$value['mape'] = abs($mape);
		}
		if (!empty($transisi)) {
			$this->db->insert_batch('tb_fuzzy_transisi', $transisi);
		}

		return $transisi;
	}

	public function markov_chain_prediction($id, $id_user, $probabilitas_transisi)
	{
		$mdl = $this->m_codeigniter;
		$min_harga_emas = min(array_column($probabilitas_transisi, 'harga_emas'));
		$max_harga_emas = max(array_column($probabilitas_transisi, 'harga_emas'));
		$rentang_harga = $max_harga_emas - $min_harga_emas;
		$jumlah_kelas = 1 + (3.3 * log(482));
		$interval_kelas = $rentang_harga / $jumlah_kelas;
		$interval_terbentuk = $min_harga_emas;

		$prediksi_markov = array(
			'id_data' => $id,
			'id_user' => $id_user,
			'min_harga' => $min_harga_emas,
			'max_harga' => $max_harga_emas,
			'rentang_harga' => $rentang_harga,
			'jumlah_kelas' => $jumlah_kelas,
			'interval_kelas' => $interval_kelas,
			'interval_terbentuk' => $interval_terbentuk,
		);

		$mdl->add('tb_markov_chain', $prediksi_markov);

		return $prediksi_markov;
	}
}

/* End of file Metode.php */
