<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url()?>asset/adminlte/assets/"
  data-template="vertical-menu-template-free"
>
  <?php $this->load->view('template/header'); ?>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php $this->load->view('template/sidebar'); ?>
        <!-- / Menu -->
        <!-- Layout container -->
          <div class="layout-page">
          <!-- Navbar -->
          <?php $this->load->view('template/navbar'); ?>
          <!-- / Navbar -->          
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Content -->
              <?php $this->load->view($contents);?>
              <!-- Logout Delete Confirmation-->
              <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                        <div class="modal-body">Data yang dihapus tidak akan bisa dikembalikan.</div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                          <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- / Content -->
            <!-- Footer -->
      <?php $this->load->view('template/footer');?>
  </body>
</html>
