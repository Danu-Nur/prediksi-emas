<!-- Bootstrap Dark Table -->
<div class="card">
	<div class="card-body">
		<h5 class="card-title text-primary">TABEL <?= $sub1 ?></h5>
		<div class="table-responsive text-nowrap">
			<table class="table table-bordered table-dark" id="example">
				<thead>
					<tr>
						<th>Tangal</th>
						<th>Harga Emas</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0">
					<td> <?= ($harga_emas_uji['tanggal'] != null) ? $harga_emas_uji['tanggal'] : "-"; ?> </td>
					<td> <?= ($harga_emas_uji['harga_emas'] != null) ? "Rp " . number_format($harga_emas_uji['harga_emas'], 2, ',', '.') : "-"; ?> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr class="my-5" />

<div class="card">
	<div class="card-body">
		<h5 class="card-title text-primary">TABEL <?= $sub2 ?></h5>
		<!-- <button type="button" class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata"><i class='bx bx-plus-medical'></i> Tambah Data</button> -->
		<div class="table-responsive text-nowrap">
			<table class="table table-bordered table-dark" id="example1">
				<thead>
					<tr>
						<th>No</th>
						<th>Harga Emas</th>
						<th>Current State</th>
						<th>Next State</th>
						<th>Forecast</th>
						<th>MAPE</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0">
					<?php $no = 1;
					foreach ($prediksi_fuzzy_time_series as $p) : ?>
						<tr>
							<td> <?= $no++; ?> </td>
							<td> <?= "Rp " . number_format($p['harga_emas'], 2, ',', '.') ?> </td>
							<td> <?= $p['current_state'] ?> </td>
							<td> <?= $p['next_state'] ?> </td>
							<td> <?= "Rp " . number_format($p['forecast'], 2, ',', '.') ?> </td>
							<td> <?= $p['mape'] ?> </td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<hr class="my-5" />

<div class="card">
	<div class="card-body">
		<h5 class="card-title text-primary">TABEL <?= $sub3 ?></h5>
		<div class="table-responsive text-nowrap">
			<table class="table table-bordered table-dark" id="example1">
				<thead>
					<tr>
						<th>Harga Minimum</th>
						<th>Harga Maximum</th>
						<th>Rentang Harga</th>
						<th>Jumlah Kelas</th>
						<th>Interval Kelas</th>
						<th>Interval Terbentuk</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0">
						<tr>
							<td> <?= "Rp " . number_format($prediksi_markov_chain[0]['min_harga'], 2, ',', '.') ?> </td>
							<td> <?= "Rp " . number_format($prediksi_markov_chain[0]['max_harga'], 2, ',', '.') ?> </td>
							<td> <?= "Rp " . number_format($prediksi_markov_chain[0]['rentang_harga'], 2, ',', '.') ?> </td>
							<td> <?= $prediksi_markov_chain[0]['jumlah_kelas'] ?> </td>
							<td> <?= $prediksi_markov_chain[0]['interval_kelas'] ?> </td>
							<td> <?= "Rp " . number_format($prediksi_markov_chain[0]['interval_terbentuk'], 2, ',', '.') ?> </td>
						</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
