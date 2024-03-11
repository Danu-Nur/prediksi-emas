<!-- Bootstrap Dark Table -->
<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible" role="alert">
    <?= $this->session->flashdata('success'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
	<?php endif; ?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title text-primary">TABEL <?= $judul ?></h5>
    <button type="button" class="btn btn-outline-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahdata"><i class='bx bx-plus-medical'></i> Tambah Data</button>
    <div class="table-responsive text-nowrap">
      <table class="table table-bordered table-dark" id="example1">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Password</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
      <?php $no=1; foreach ($tampil as $p): ?>
				<tr>
				<td> <?= $no++; ?> </td>
				<td> <?= $p->nama ?> </td>
				<td> <?= $p->username_user ?> </td>
				<td> <?= $p->password_user ?> </td>
				<td> <span class="badge <?= ($p->status == "USER") ? 'bg-label-info' : 'bg-label-success';?> me-1"><?= $p->status ?></span></td>
        <td>
          <div class="dropdown">
             <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
               <i class="bx bx-dots-vertical-rounded"></i>
             </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editdata<?= $p->id_user ?>">
                  <i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" onclick="deleteConfirm('<?php echo site_url('admin/Users/delete/'.$p->id_user) ?>')" href="#!">
                  <i class="bx bx-trash me-1"></i> Delete</a>
              </div>
            </div>
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
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
    <form action="<?= site_url('admin/Users') ?>" method="post" enctype="multipart/form-data" >
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid':'' ?>" placeholder="Nama" />
            <div class="invalid-feedback">
				      <?= form_error('nama') ?>
			      </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="username_user" class="form-label">Username</label>
            <input type="text" name="username_user" class="form-control <?= form_error('username_user') ? 'is-invalid':'' ?>" placeholder="username" />
            <div class="invalid-feedback">
				      <?= form_error('username_user') ?>
			      </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="password_user" class="form-label">Password</label>
            <input type="text" step="any" name="password_user" class="form-control <?= form_error('password_user') ? 'is-invalid':'' ?>" placeholder="password" />
            <div class="invalid-feedback">
				      <?= form_error('password_user') ?>
			      </div>
          </div>
        </div>
        <div class="row">
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select <?= form_error('status') ? 'is-invalid':'' ?>" name="status" aria-label="Default select example">
              <option selected>Pilih...</option>
              <option value="USER">USER</option>
              <option value="ADMIN">ADMIN</option>
            </select>
            <div class="invalid-feedback">
				      <?= form_error('status') ?>
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
<?php foreach ($tampil as $p): ?>
<div class="modal fade" id="editdata<?= $p->id_user ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1"><?= $sub2 ?></h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
    <form action="<?= site_url('admin/Users/edit') ?>" method="post" enctype="multipart/form-data" >
    <div class="modal-body">
        <input type="hidden" name="id_user" value="<?= $p->id_user?>" />
        <div class="row">
          <div class="col mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control <?= form_error('nama') ? 'is-invalid':'' ?>" placeholder="Nama" value="<?=$p->nama?>"/>
            <div class="invalid-feedback">
				      <?= form_error('nama') ?>
			      </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="username_user" class="form-label">Username</label>
            <input type="text" name="username_user" class="form-control <?= form_error('username_user') ? 'is-invalid':'' ?>" placeholder="username"  value="<?=$p->username_user?>"/>
            <div class="invalid-feedback">
				      <?= form_error('username_user') ?>
			      </div>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="password_user" class="form-label">Password</label>
            <input type="text" step="any" name="password_user" class="form-control <?= form_error('password_user') ? 'is-invalid':'' ?>" placeholder="password user"  value="<?=$p->password_user?>"/>
            <div class="invalid-feedback">
				      <?= form_error('password_user') ?>
			      </div>
          </div>
        </div>
        <div class="row">
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select <?= form_error('status') ? 'is-invalid':'' ?>" name="status" aria-label="Default select example">
              <option selected>Pilih...</option>
              <option value="USER" <?= $p->status == "USER" ? "selected" : "" ?>>USER</option>
              <option value="ADMIN" <?= $p->status == "ADMIN" ? "selected" : "" ?>>ADMIN</option>
            </select>
            <div class="invalid-feedback">
				      <?= form_error('status') ?>
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
