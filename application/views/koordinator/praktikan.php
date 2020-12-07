<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-10">
      <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3">
          <div class="row">
            <div class="col">
              <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
            </div>
            <div class="col-auto ml-auto">
              <button class="btn btn-danger btn-sm btn-icon-split" data-toggle="modal" data-target="#deletePraktikan">
                <span class="icon"><i class="fas fa-robot"></i></span>
                <span class="text">Hapus Seluruh Praktikan</span>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col mt-1 mb-3">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Lengkap</th>
                  <th>NRP</th>
                  <th>Kelompok</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($list as $l) : ?>
                  <tr>
                    <th><?= $l['name']; ?></th>
                    <th><?= $l['nrp']; ?></th>
                    <th><?= $l['kelompok']; ?></th>
                    <th>
                      <a href="<?= base_url('assets/img/frs/') . $l['frs']; ?>" class="badge badge-pill badge-info"><i class="fas fa-fw fa-file-contract"></i> FRS</a>
                      <a href="<?= base_url('assets/img/jadwal/') . $l['jadwal']; ?>" class="badge badge-pill badge-info"><i class="fas fa-fw fa-calendar-day"></i> Jadwal</a>
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

<div class="modal fade" id="deletePraktikan" tabindex="-1" role="dialog" aria-labelledby="deletePraktikanLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletePraktikanLabel">Hapus Seluruh Praktikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Yakin ingin menghapus seluruh data praktikan?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
        <a href="<?= base_url('koordinator/deletePraktikan') ?>" class="btn btn-danger">Ya</a>
      </div>
    </div>
  </div>
</div>