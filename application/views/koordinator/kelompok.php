<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col mt-1 mb-3">
              <?= $this->session->flashdata('message'); ?>
            </div>
            <div class="col-auto ml-auto">
              <button class="btn btn-info mt-1 mb-3 tambahkelompok" data-toggle="modal" data-target="#kelompokEdit">Tambah Kelompok</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Kelompok</th>
                  <th>Jumlah Anggota</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kelompok as $k) : ?>
                  <tr>
                    <th><?= $k['name']; ?></th>
                    <th><?= $k['jumlah']; ?></th>
                    <th>

                    </th>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="kelompokEdit" tabindex="-1" role="dialog" aria-labelledby="kelompokEditLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kelompokEditLabel">Edit Kelengkapan Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addkelompok') ?>" method="post">
          <div class="form-group">
            <label for="kelompok">Nama Kelompok</label>
            <input class="form-control" id="kelompok" name="kelompok" type="text" required>
            <input class="form-control" id="id" name="id" type="text" hidden>
            <div class="invalid-feedback">
              Nama kelompok sudah dipakai.
            </div>
            <div class="valid-feedback">
              Nama kelompok tersedia
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" id="submit" class="btn btn-primary">Edit</button>
      </div>
      </form>
    </div>
  </div>
</div>