<!-- Bootstrap Dark Table -->
<?php if ($this->session->flashdata('success')) : ?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<?= $this->session->flashdata('success'); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php endif; ?>
<div class="card">
	<div class="card-body">
		<h5 class="card-title text-primary">TABEL <?= $judul ?></h5>
		<button type="button" class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata"><i class='bx bx-plus-medical'></i> Tambah Data</button>
		<div class="table-responsive.">
			<table class="table table-bordered table-dark text-center" id="example1">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal</th>
						<th>Harga Emas</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody class="table-border-bottom-0">
					<?php $no = 1;
					foreach ($data_emas as $p) : ?>
						<tr>
							<td> <?= $no++; ?> </td>
							<td> <?= $p->tanggal ?> </td>
							<td> <?= "Rp " . number_format($p->harga_emas,2,',','.') ?> </td>
							<td>
								<a class="btn active" data-bs-toggle="modal" data-bs-target="#editdata<?= $p->id_emas ?>">
									<i class="bx bx-edit-alt me-1"></i></a>
								<a class="btn active" onclick="deleteConfirm('<?php echo site_url('admin/Dataset_emas/delete/' . $p->id_emas) ?>')" href="#!">
									<i class="bx bx-trash me-1 text-white"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Tambah Data-->
<div class="modal fade" id="tambahdata" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1"><?= $sub ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= site_url('admin/Dataset_emas') ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col mb-3">
							<label for="tanggal" class="form-label">Tanggal*</label>
							<input type="date" name="tanggal" class="form-control <?= form_error('tanggal') ? 'is-invalid' : '' ?>" placeholder="tanggal" />
							<div class="invalid-feedback">
								<?= form_error('tanggal') ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col mb-3">
							<label for="harga_emas" class="form-label">Harga Emas</label>
							<input type="number" step="any" name="harga_emas" class="form-control <?= form_error('harga_emas') ? 'is-invalid' : '' ?>" placeholder="harga emas" />
							<div class="invalid-feedback">
								<?= form_error('harga_emas') ?>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
						Close
					</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Edit Data-->
<?php foreach ($data_emas as $p) : ?>
	<div class="modal fade" id="editdata<?= $p->id_emas ?>" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1"><?= $sub2 ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="<?= site_url('admin/Dataset_emas/edit') ?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<input type="hidden" name="id_emas" value="<?= $p->id_emas ?>" />
						<div class="row">
							<div class="col mb-3">
								<label for="tanggal" class="form-label">Label*</label>
								<input type="date" name="tanggal" class="form-control <?= form_error('tanggal') ? 'is-invalid' : '' ?>" placeholder="tanggal" value="<?= $p->tanggal ?>"/>
								<div class="invalid-feedback">
									<?= form_error('tanggal') ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="harga_emas" class="form-label">Harga Emas</label>
								<input type="number" step="any" name="harga_emas" class="form-control <?= form_error('harga_emas') ? 'is-invalid' : '' ?>" placeholder="harga_emas" value="<?= $p->harga_emas ?>"/>
								<div class="invalid-feedback">
									<?= form_error('harga_emas') ?>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
							Close
						</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach; ?>
