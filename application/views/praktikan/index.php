<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <div class="row justify-content-center mt-5">
    <div class="col-xl-3 col-md-6 mb-4">
      <?php foreach ($praktikum as $p) : ?>
        <!-- P1 Card -->
        <div class="card border-left-info shadow py-2 my-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-s font-weight-bold text-info text-uppercase mb-1"><?= $p['date'] ?></div>
                <div class="text-xs text-dark font-weight-bold mt-4">ASISTEN:</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-overflow: ellipsis;"><?= $p['asisten'] ?></div>
              </div>
              <div class="col-auto">
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $p['name'] ?></div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="col-xl-8 col-md-6 mb-4">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger">Kelompok <?= $kelompok['name'] ?></h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>NRP</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($anggota as $a) : ?>
                  <tr>
                    <td><?= $a['name'] ?></td>
                    <td><?= $a['nrp'] ?></td>
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