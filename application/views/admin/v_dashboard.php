<div class="col-lg-12 mb-4 order-0">
	<div class="card">
		<div class="d-flex align-items-end row">
			<div class="col-sm-7">
				<div class="card-body">

					<p class="mb-4">
						PREDIKSI HARGA EMAS MENGGUNAKAN METODE FUZZY TIME SERIES MARKOV CHAIN
					</p>

					<!-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> -->
				</div>
			</div>
			<div class="col-sm-5 text-center text-sm-left">
				<div class="card-body pb-0 px-0 px-md-4">
					<img src="<?= base_url() ?>asset/adminlte/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($this->session->userdata('status') === 'ADMIN') : ?>

	<div class="col-lg-12 col-md-12 order-1">
		<div class="row">
			<!-- <div class="col-lg-6 col-md-12 col-6 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title d-flex align-items-start justify-content-between">
							<div class="avatar flex-shrink-0">
								<img src="<?= base_url() ?>asset/adminlte/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
							</div>
							<div class="dropdown">
								<button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="bx bx-dots-vertical-rounded"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
									<a class="dropdown-item" href="<?= base_url('admin/users'); ?>">View More</a>
								</div>
							</div>
						</div>
						<span class="fw-semibold d-block mb-1">User</span>
						<h3 class="card-title mb-2"><?= $user ?></h3>
					</div>
				</div>
			</div> -->
			<!-- <div class="col-lg-6 col-md-12 col-6 mb-4">
				<div class="card">
					<div class="card-body">
						<div class="card-title d-flex align-items-start justify-content-between">
							<div class="avatar flex-shrink-0">
								<img src="<?= base_url() ?>asset/adminlte/assets/img/icons/unicons/chart.png" alt="Credit Card" class="rounded" />
							</div>
							<div class="dropdown">
								<button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="bx bx-dots-vertical-rounded"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
									<a class="dropdown-item" href="<?= base_url('admin/wisata'); ?>">View More</a>
								</div>
							</div>
						</div>
						<span class="fw-semibold d-block mb-1">Wisata</span>
						<h3 class="card-title text-nowrap mb-1"><?= $wisata ?></h3>
					</div>
				</div>
			</div> -->

		</div>
	</div>



<?php else : ?>

	<div class="row">
		<!-- Basic Layout -->
		<!-- <div class="col-xxl">
			<div class="card mb-4">
				<div class="card-header d-flex align-items-center justify-content-between">
					<h5 class="card-title text-primary">FORM METODE SAW</h5>
				</div>
				<div class="card-body">
					<form action="<?= site_url('user/User/Metode') ?>" method="post" enctype="multipart/form-data">
						<div class="row mb-3">
							<label class="col-sm-2 col-form-label" for="harga_paket">Harga Paket</label>
							<div class="col-sm-10">
								<input type="text" name="harga_paket" class="form-control <?= form_error('harga_paket') ? 'is-invalid' : '' ?>" id="harga_paket" placeholder="Harga Paket" />
								<div class="invalid-feedback">
									<?= form_error('harga_paket') ?>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="id_usia" class="col-sm-2 col-form-label">Jenis Usia</label>
							<div class="col-sm-10">
								<select class="form-select <?= form_error('id_usia') ? 'is-invalid' : '' ?>" name="id_usia" aria-label="Default select example">
									<option value="0" selected>Pilih...</option>
									<?php foreach ($usia as $u) : ?>
										<option value="<?= $u->id_usia ?>"><?= $u->usia ?></option>
									<?php endforeach; ?>
								</select>
								<div class="invalid-feedback">
									<?= form_error('id_usia') ?>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="id_hobi" class="col-sm-2 col-form-label">Hobi</label>
							<div class="col-sm-10">
								<select class="form-select <?= form_error('id_hobi') ? 'is-invalid' : '' ?>" name="id_hobi" aria-label="Default select example">
									<option value="0" selected>Pilih...</option>
									<?php foreach ($hobi as $h) : ?>
										<option value="<?= $h->id_hobi ?>"><?= $h->hobi ?></option>
									<?php endforeach; ?>
								</select>
								<div class="invalid-feedback">
									<?= form_error('id_hobi') ?>
								</div>
							</div>
						</div>
						<div class="row mb-3">
							<label for="id_lokasi" class="col-sm-2 col-form-label">Lokasi</label>
							<div class="col-sm-10">
								<select class="form-select <?= form_error('id_lokasi') ? 'is-invalid' : '' ?>" name="id_lokasi" aria-label="Default select example">
									<option value="0" selected>Pilih...</option>
									<?php foreach ($lokasi as $l) : ?>
										<option value="<?= $l->id_lokasi ?>"><?= $l->lokasi ?></option>
									<?php endforeach; ?>
								</select>
								<div class="invalid-feedback">
									<?= form_error('id_lokasi') ?>
								</div>
							</div>
						</div>
						<div class="row justify-content-end">
							<div class="col-sm-10">
								<button type="submit" class="btn btn-primary">Send</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> -->


	<?php endif; ?>
	<div class="col-lg-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
		<div class="card">
			<div class="row row-bordered g-0">
				<div class="col-xs-12">
					<h5 class="card-header m-0 me-2 pb-3">Harga Emas</h5>
					<!-- <div id="totalRevenueChart" class="px-2"></div> -->
					<canvas id="myChart"></canvas>
				</div>

			</div>
		</div>
	</div>
	<!--/ Total Revenue -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
	<script>
		window.onload = function() {
			var harga_emas = <?= $harga_emas ?>;

			// Mendapatkan nilai minimum dan maksimum dari array
			var min_harga_emas = Math.min.apply(null, harga_emas);
			var max_harga_emas = Math.max.apply(null, harga_emas);
			// const xValues = [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];
			const xValues = <?= $tgl_emas ?>;
			const yValues = <?= $harga_emas ?>;
			// const yValues = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

			new Chart("myChart", {
				type: "line",
				data: {
					labels: xValues,
					datasets: [{
						fill: false,
						lineTension: 0,
						backgroundColor: "rgba(0,0,255,1.0)",
						borderColor: "rgba(0,0,255,0.1)",
						data: yValues
					}]
				},
				options: {
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							ticks: {
								min: min_harga_emas,
								max: max_harga_emas + 1000,
								callback: function(value, index, values) {
									return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								}
							}
						}],
					},
					tooltips: {
						callbacks: {
							label: function(tooltipItem, data) {
								var value = tooltipItem.yLabel;
								return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
							}
						}
					},
					hover: {
						mode: 'index',
						intersect: false,
						callbacks: {
							label: function(tooltipItem, data) {
								var value = tooltipItem.yLabel;
								return 'Rp' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
							}
						}
					}
				}
			});

		}
	</script>
