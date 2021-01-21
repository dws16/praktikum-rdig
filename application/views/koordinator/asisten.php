<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-12">
      <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col mt-1 mb-3">
              <?= $this->session->flashdata('message'); ?>
            </div>
          </div>
          <div class="row">
            <div class="col-2">
              <div class="list-group" id="list-tab" role="tablist">
                <?php $true = true; ?>
                <?php foreach ($modul as $m) : ?>
                  <a class="list-group-item list-group-item-action <?= ($true) ? "active" : ""; ?>" id="list-<?= $m['praktikumID']; ?>-list" data-toggle="list" href="#list-<?= $m['praktikumID']; ?>" role="tab" aria-controls="<?= $m['praktikumID'] ?>"><?= $m['name']; ?></a>
                  <?php $true = false; ?>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col">
              <div class="tab-content" id="nav-tabContent">
                <?php $true = true; ?>
                <?php foreach ($modul as $m) : ?>
                  <?php if ($m['IDType'] == 3) : ?>
                    <div class="tab-pane fade <?= ($true) ? "show active" : ""; ?>" id="list-<?= $m['praktikumID']; ?>" role="tabpanel" aria-labelledby="list-<?= $m['praktikumID']; ?>-list">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="dataTableFP" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Nama Kelompok</th>
                              <th>Nama Asisten</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($kelompok as $k) : ?>
                              <?php $i = 0; ?>
                              <?php foreach ($kelompok_asisten as $ka) : ?>
                                <?php if ($ka['IDPraktikum'] == $m['praktikumID'] && $ka['IDKelompok'] == $k['kelompokID']) : ?>
                                  <?php $i += 1; ?>
                                  <tr>
                                    <th class="text-center align-middle"><?= $k['name']; ?></th>
                                    <th><?= $ka['asisten']; ?></th>
                                    <th class="text-center align-middle">
                                      <a href="#" class=" badge badge-pill badge-info editAsistenFP" data-toggle="modal" data-modul="<?= $m['praktikumID']; ?>" data-kelompok="<?= $k['kelompokID']; ?>" data-target="#asistenEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                                    </th>
                                  </tr>
                                <?php endif; ?>
                              <?php endforeach; ?>
                              <?php if ($i == 0) : ?>
                                <?php for ($z = 0; $z < 3; $z++) { ?>
                                  <tr>
                                    <th class="text-center align-middle"><?= $k['name']; ?></th>
                                    <th>Belum ada asisten</th>
                                    <th class="text-center align-middle">
                                      <a href="#" class="badge badge-pill badge-info editAsistenFP" data-toggle="modal" data-modul="<?= $m['praktikumID']; ?>" data-kelompok="<?= $k['kelompokID']; ?>" data-target="#asistenEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                                    </th>
                                  </tr>
                                <?php } ?>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <?php else : ?>
                    <div class="tab-pane fade <?= ($true) ? "show active" : ""; ?>" id="list-<?= $m['praktikumID']; ?>" role="tabpanel" aria-labelledby="list-<?= $m['praktikumID']; ?>-list">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Nama Kelompok</th>
                              <th>Nama Asisten</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($kelompok as $k) : ?>
                              <tr>
                                <th><?= $k['name']; ?></th>
                                <?php $i = 0; ?>
                                <?php foreach ($kelompok_asisten as $ka) : ?>
                                  <?php if ($ka['IDPraktikum'] == $m['praktikumID'] && $ka['IDKelompok'] == $k['kelompokID']) : ?>
                                    <?php $i = 1; ?>
                                    <th><?= $ka['asisten']; ?></th>
                                    <th class="text-center">
                                      <a href="#" class="badge badge-pill badge-info editAsisten" data-toggle="modal" data-modul="<?= $m['praktikumID']; ?>" data-kelompok="<?= $k['kelompokID']; ?>" data-target="#asistenEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                                    </th>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if ($i == 0) : ?>
                                  <th>Belum ada asisten</th>
                                  <th class="text-center">
                                    <a href="#" class="badge badge-pill badge-info editAsisten" data-toggle="modal" data-modul="<?= $m['praktikumID']; ?>" data-kelompok="<?= $k['kelompokID']; ?>" data-target="#asistenEdit"><i class="fas fa-fw fa-edit"></i> Edit</a>
                                  </th>
                                <?php endif; ?>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php $true = false; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="asistenEdit" tabindex="-1" role="dialog" aria-labelledby="asistenEditLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asistenEditLabel">Tentukan Asisten</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/editasisten') ?>" method="post">
          <div class="form-group">
            <label for="kelompok">Kelompok</label>
            <div class="form-row mt-2 ">
              <input class="form-control" id="id" name="id" type="text" hidden>
              <div class="col-3">
                <input class="form-control" id="modul" name="modul" type="text" readonly>
              </div>
              <div class="col">
                <input class="form-control jumlah" id="kelompok" name="kelompok" type="text" readonly>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="nrp_asisten">Asisten</label>
            <div id="praktikum">

            </div>
            <div id="finalproject">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Edit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>