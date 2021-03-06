<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-danger"><?= $title ?></h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Modul</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($modul as $m) : ?>
                  <tr>
                    <td><?= $m['name'] ?></td>
                    <td><a href="<?= base_url('assets/file/praktikum/') . $m['filename']; ?>" class="badge badge-pill badge-danger"><i class="fas fa-fw fa-arrow-down"></i>Download</a></td>
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