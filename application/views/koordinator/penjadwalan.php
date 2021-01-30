<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-12">
      <div class="card shadow mb-4 border-left-danger">
        <div class="d-block card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
        </div>
        <div class="card-body">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-link active" id="nav-sesi-tab" data-toggle="tab" href="#nav-sesi" role="tab" aria-controls="nav-sesi" aria-selected="true">Sesi Praktikum</a>
              <a class="nav-link" id="nav-jaga-tab" data-toggle="tab" href="#nav-jaga" role="tab" aria-controls="nav-jaga" aria-selected="false">Jaga Praktikum</a>
              <a class="nav-link" id="nav-praktikan-tab" data-toggle="tab" href="#nav-praktikan" role="tab" aria-controls="nav-praktikan" aria-selected="false">Praktikan</a>
            </div>
          </nav>
          <div class="tab-content mt-4" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-sesi" role="tabpanel" aria-labelledby="nav-sesi-tab">
              <div class="row">
                <div class="col mt-1 mb-3">
                  <?php if ($this->session->flashdata('messageSesi')) : ?>
                    <?= $this->session->flashdata('messageSesi') ?>
                    <script>
                      $(".nav-link").removeClass("active");
                      $(".tab-pane.fade").removeClass("active");
                      $(".tab-pane.fade").removeClass("show");
                      $("#nav-sesi").addClass("show");
                      $("#nav-sesi").addClass("active");
                      $("#nav-sesi-tab").addClass("active");
                    </script>
                  <?php endif; ?>
                </div>
                <div class="col-auto ml-auto">
                  <button class="btn btn-info btn-icon-split mt-1 mb-3 tambahSesi" data-toggle="modal" data-target="#sesiEdit">
                    <span class="icon"><i class="fas fa-clock"></i></span>
                    <span class="text">Tambah Jadwal</span>
                  </button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Praktikum</th>
                      <th>Jadwal</th>
                      <th>Keterangan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sesi as $s) : ?>
                      <tr>
                        <th><?= $s['name']; ?></th>
                        <th><?= $s['date']; ?></th>
                        <th><?= $s['ket']; ?></th>
                        <th class="text-center">
                          <a href="#" class="badge badge-pill badge-info editSesi" data-toggle="modal" data-id="<?= $s['dateID']; ?>" data-target="#sesiEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                          <a href="<?= base_url('koordinator/deletesesi/') . $s['dateID']; ?>" class="badge badge-pill badge-danger" onclick="return confirm('Yakin?');"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                        </th>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-jaga" role="tabpanel" aria-labelledby="nav-jaga-tab">
              <div class="row">
                <div class="col mt-1 mb-3">
                  <?php if ($this->session->flashdata('messageJaga')) : ?>
                    <?= $this->session->flashdata('messageJaga') ?>
                    <script>
                      $(".nav-link").removeClass("active");
                      $(".tab-pane.fade").removeClass("active");
                      $(".tab-pane.fade").removeClass("show");
                      $("#nav-jaga").addClass("show");
                      $("#nav-jaga").addClass("active");
                      $("#nav-jaga-tab").addClass("active");
                    </script>
                  <?php endif; ?>
                </div>

              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Praktikum</th>
                      <th>Jadwal</th>
                      <th>Keterangan</th>
                      <th>Jumlah Asisten</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sesi as $s) : ?>
                      <?php $i = 0; ?>
                      <tr>
                        <th><?= $s['name']; ?></th>
                        <th><?= $s['date']; ?></th>
                        <th><?= $s['ket']; ?></th>
                        <th>
                          <?php foreach ($listJaga as $j) :
                            if ($s['dateID'] == $j['dateID']) :
                              echo $j['jumlah'];
                              $i = 1;
                            endif;
                          endforeach; ?>
                          <?= ($i == 0) ? "0" : ""; ?>
                        </th>
                        <th class="text-center">
                          <a href="#" class="badge badge-pill badge-info editJaga" data-toggle="modal" data-ket="<?= $s['ket']; ?>" data-date="<?= $s['date']; ?>" data-modul="<?= $s['name']; ?>" data-id="<?= $s['dateID']; ?>" data-target="#jagaEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                        </th>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="nav-praktikan" role="tabpanel" aria-labelledby="nav-praktikan-tab">
              <div class="showed" id="kelompok">
                <div class="row">
                  <div class="col-3">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Show per</label>
                      </div>
                      <select class="custom-select showtable">
                        <option value="kelompok" selected>Kelompok</option>
                        <option value="praktikan">Praktikan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col mt-1 mb-3">
                    <?php if ($this->session->flashdata('messageKelompok')) : ?>
                      <?= $this->session->flashdata('messageKelompok') ?>
                      <script>
                        $(".nav-link").removeClass("active");
                        $(".tab-pane.fade").removeClass("active");
                        $(".tab-pane.fade").removeClass("show");
                        $("#nav-praktikan").addClass("show");
                        $("#nav-praktikan").addClass("active");
                        $("#nav-praktikan-tab").addClass("active");
                        $(".showtable").val('kelompok');
                      </script>
                    <?php endif; ?>
                  </div>
                  <div class="col-auto ml-auto">
                    <button class="btn btn-info btn-icon-split mt-1 mb-3 tambahJadwalKelompok" data-toggle="modal" data-target="#jadwalKelompokEdit">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span class="text">Tambah Jadwal</span>
                    </button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered dataTable table-striped" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Kelompok</th>
                        <th>Praktikum</th>
                        <th>Jadwal</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($jadwalKelompok as $s) : ?>
                        <tr>
                          <th><?= $s['kelompok']; ?></th>
                          <th><?= $s['name']; ?></th>
                          <th><?= $s['date']; ?></th>
                          <th class="text-center">
                            <a href="#" class="badge badge-pill badge-info editJadwalKelompok" data-toggle="modal" data-id="<?= $s['id']; ?>" data-target="#jadwalKelompokEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                            <a href="<?= base_url('koordinator/deletejadwalkelompok/') . $s['id']; ?>" onclick="return confirm('Yakin?');" class="badge badge-pill badge-danger"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                          </th>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="showed" id="praktikan" style="display: none;">
                <div class="row">
                  <div class="col-3">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Show per</label>
                      </div>
                      <select class="custom-select showtable">
                        <option value="kelompok" selected>Kelompok</option>
                        <option value="praktikan">Praktikan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col mt-1 mb-3">
                    <?php if ($this->session->flashdata('messagePraktikan')) : ?>
                      <?= $this->session->flashdata('messagePraktikan') ?>
                      <script>
                        $(".nav-link").removeClass("active");
                        $(".tab-pane.fade").removeClass("active");
                        $(".tab-pane.fade").removeClass("show");
                        $("#nav-praktikan").addClass("show");
                        $("#nav-praktikan").addClass("active");
                        $("#nav-praktikan-tab").addClass("active");
                        $(".showtable").val('praktikan');
                      </script>
                    <?php endif; ?>
                  </div>
                  <div class="col-auto ml-auto">
                    <button class="btn btn-info btn-icon-split mt-1 mb-3 tambahJadwalPraktikan" data-toggle="modal" data-target="#jadwalPraktikan">
                      <span class="icon"><i class="fas fa-clock"></i></span>
                      <span class="text">Tambah Jadwal</span>
                    </button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered dataTable table-striped" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>NRP</th>
                        <th>Kelompok</th>
                        <th>Praktikum</th>
                        <th>Jadwal</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($listPraktikan as $p) : ?>
                        <tr>
                          <th><?= $p['praktikan']; ?></th>
                          <th><?= $p['nrp']; ?></th>
                          <th><?= $p['kelompok']; ?></th>
                          <th><?= $p['modul']; ?></th>
                          <th><?= $p['ket']; ?></th>
                          <th class="text-center">
                            <a href="#" class="badge badge-pill badge-info editJadwalPraktikan" data-toggle="modal" data-id="<?= $p['id']; ?>" data-target="#jadwalPraktikan"><i class="fas fa-fw fa-edit"></i> Edit</a>
                            <a href="<?= base_url('koordinator/deletejadwalpraktikan/') . $p['id']; ?>" class="badge badge-pill badge-danger"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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
    </div>
  </div>
  <!-- DataTales Example -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Jadwal Praktikan -->
<div class="modal fade" id="jadwalPraktikan" tabindex="-1" role="dialog" aria-labelledby="jadwalPraktikanLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jadwalPraktikanLabel">Edit Jadwal Kelompok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addjadwalpraktikan') ?>" method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-4">
                <label for="kelompokID">Kelompok</label>
                <select class="form-control" name="kelompokPraktikanID" id="kelompokPraktikanID">
                  <?php foreach ($listKelompok as $k) : ?>
                    <option value="<?= $k['kelompokID'] ?>"><?= $k['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col">
                <label for="nrp">NRP - Nama</label>
                <select class="form-control" name="nrp" id="nrp">
                </select>
                <div class="invalid-feedback invalidNRP">
                </div>
              </div>
            </div>
            <div class="form-row mt-3">
              <div class="col">
                <label for="modulPraktikanID">Modul</label>
                <select class="form-control" name="modulPraktikanID" id="modulPraktikanID">
                  <?php foreach ($modul as $m) : ?>
                    <option value="<?= $m['praktikumID'] ?>"><?= $m['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback invalidModulPraktikan">
                </div>
              </div>
              <div class="col">
                <label for="dateID">Sesi</label>
                <select class="form-control" name="datePraktikanID" id="datePraktikanID">
                </select>
                <div class="invalid-feedback invalidDatePraktikan">
                </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="keterangan">Keterangan</label>
              <input type="text" class="form-control" name="keterangan" id="keterangan">
              <input type="text" class="form-control" name="jadwalID" id="jadwalID" hidden>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" id="submitPraktikan" class="btn btn-primary">Edit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Jadwal Kelompok -->
<div class="modal fade" id="jadwalKelompokEdit" tabindex="-1" role="dialog" aria-labelledby="jadwalKelompokEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jadwalKelompokEditLabel">Edit Jadwal Kelompok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addsesi') ?>" method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col">
                <label for="kelompokID">Kelompok</label>
                <select class="form-control" name="kelompokID" id="kelompokID">
                  <?php foreach ($listKelompok as $k) : ?>
                    <option value="<?= $k['kelompokID'] ?>"><?= $k['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="text" name="jadwalkelompokID" id="jadwalkelompokID" disabled hidden>
              </div>
            </div>
            <div class="form-row mt-3">
              <div class="col">
                <label for="IDpraktikum">Modul</label>
                <select class="form-control" name="IDpraktikum" id="IDpraktikum">
                  <?php foreach ($modul as $m) : ?>
                    <option value="<?= $m['praktikumID'] ?>"><?= $m['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback invalidModul">
                  <input type="text" id="IDModul" name="IDModul" hidden>
                </div>
              </div>
              <div class="col">
                <label for="dateID">Sesi</label>
                <select class="form-control" name="dateID" id="dateID">
                </select>
                <div class="invalid-feedback invalidDate">
                </div>
                <div class="valid-feedback validDate">
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" id="submitJadwal" class="btn btn-primary">Edit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Jadwal Jaga -->
<div class="modal fade" id="jagaEdit" tabindex="-1" role="dialog" aria-labelledby="jagaEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jagaEditLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addsesi') ?>" class="eventInsForm" method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col">
                <label for="modulID">Modul</label>
                <input class="form-control" type="text" name="modulID" id="modulID" disabled>
              </div>
              <div class="col">
                <label for="jadwalSesi">Tanggal</label>
                <input type="text" class="form-control" id="jadwalSesi" name="date" disabled>
                <input class="form-control" id="idSesi" name="idSesi" type="text" hidden>
              </div>
              <div class="col">
                <label for="ket">Keterangan</label>
                <input class="form-control" id="ketSesi" name="ketSesi" type="text" disabled>
              </div>
            </div>
          </div>
          <div class="form-row" style="margin-bottom:-4px;">
            <div class="col-8">
              <label for="anggota">Asisten</label>
            </div>
            <div class="col-1">
              <label for="pj">PJ</label>
            </div>
          </div>
          <div id="asisten">

          </div>

          <a href="#" class="btn btn-success btn-icon-split mt-4" id="addAsisten">
            <span class="icon"><i class="fas fa-user-plus"></i></span>
            <span class="text">Tambah Asisten</span>
          </a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" id="submitJaga" class="btn btn-primary">Edit</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Sesi -->
<div class="modal fade" id="sesiEdit" tabindex="-1" role="dialog" aria-labelledby="sesiEditLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sesiEditLabel">Edit Jadwal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addsesi') ?>" method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col">
                <label for="praktikumID">Modul</label>
                <select class="form-control" name="praktikumID" id="praktikumID">
                  <?php foreach ($modul as $m) : ?>
                    <option value="<?= $m['praktikumID'] ?>"><?= $m['name'] ?></option>
                  <?php endforeach; ?>
                </select>
                <input type="text" name="praktikumID" id="praktikumID2" disabled hidden>
              </div>
              <div class="col">
                <label for="date">Tanggal</label>
                <input type="datetime-local" class="form-control" id="date" name="date" required>
                <input class="form-control" id="id" name="id" type="text" hidden>
              </div>
            </div>
            <div class="form-group mt-4">
              <label for="ket">Keterangan</label>
              <input class="form-control" id="ket" name="ket" type="text" required>
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