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
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Modul</th>
                  <th>Active</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($list as $f) : ?>
                  <tr>
                    <td><?= $f['code']; ?></td>
                    <td><?= $f['name']; ?></td>
                    <td class="text-center">
                      <input class="check" type="checkbox" <?= ($f['is_active'] == 1) ? 'checked="checked"' : ""; ?> data-modul="<?= $f['code'] ?>">
                    </td>
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