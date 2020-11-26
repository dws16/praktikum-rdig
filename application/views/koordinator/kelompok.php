<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-10">
      <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col mt-1 mb-3">
              <?= $this->session->flashdata('message'); ?>
            </div>
            <div class="col-auto ml-auto">
              <button class="btn btn-info btn-icon-split mt-1 mb-3 tambahkelompok" data-toggle="modal" data-target="#kelompokEdit">
                <span class="icon"><i class="fas fa-user-friends"></i></span>
                <span class="text">Tambah Kelompok</span>
              </button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Kelompok</th>
                  <th>Jumlah Anggota</th>
                  <th>Semester - Tahun</th>
                  <th>Active</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kelompok as $k) : ?>
                  <tr>
                    <th><?= $k['name']; ?></th>
                    <th><?= $k['jumlah']; ?></th>
                    <th><?= ($k['term'] == 1) ? "Genap" : "Gasal"; ?> - <?= $k['year']; ?></th>
                    <th><?= ($k['status'] == 1) ? "Aktif" : "Nonaktif"; ?></th>
                    <th class="text-center">
                      <a href="#" class="badge badge-pill badge-info editkelompok" data-toggle="modal" data-id="<?= $k['kelompokID']; ?>" data-target="#kelompokEdit"><i class="fas fa-fw fa-info"></i> Detail</a>
                      <a href="<?= base_url('koordinator/deletekelompok/') . $k['kelompokID']; ?>" class="badge badge-pill badge-danger"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kelompokEditLabel">Edit Kelompok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addkelompok') ?>" method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col">
                <label for="kelompok">Nama Kelompok</label>
                <input class="form-control" id="kelompok" name="kelompok" type="text" required>
                <div class="invalid-feedback">
                  Nama kelompok sudah dipakai.
                </div>
                <div class="valid-feedback">
                  Nama kelompok tersedia
                </div>
                <input class="form-control" id="id" name="id" type="text" hidden>
              </div>
              <div class="col-2">
                <label for="year">Tahun</label>
                <input type="number" class="form-control" id="year" name="year" required>
              </div>
              <div class="col-2">
                <label for="term">Semester</label>
                <select class="form-control" name="term" id="term">
                  <option value="0">Gasal</option>
                  <option value="1">Genap</option>
                </select>
              </div>
              <div class="col-2">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                  <option value="0">Nonaktif</option>
                  <option value="1">Aktif</option>
                </select>
              </div>
            </div>
          </div>
          <div style="margin-bottom:-4px;">
            <label for="kelompok">Anggota Kelompok</label>
          </div>
          <div id="anggota">

          </div>

          <a href="#" class="btn btn-success btn-icon-split mt-4" id="addAnggota">
            <span class="icon"><i class="fas fa-user-plus"></i></span>
            <span class="text">Tambah Anggota</span>
          </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" id="submit" class="btn btn-primary">Edit</button>
      </div>
      </form>
    </div>
  </div>
</div>