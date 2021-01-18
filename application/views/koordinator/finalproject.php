<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-7">
      <div class="card shadow mb-4 border-left-danger">
        <div class="card-header py-3">
          <div class="row">
            <div class="col" style="margin: auto;">
              <h6 class="m-0 align-middle font-weight-bold text-danger"><?= $title ?></h6>
            </div>
            <div class="col-auto ml-auto">
              <button class="btn btn-info btn-sm btn-icon-split tambahFP" data-toggle="modal" data-target="#addFP">
                <span class="icon"><i class="fas fa-project-diagram"></i></span>
                <span class="text">Tambah Final Project</span>
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
            <table class="table table-bordered dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nama Rangkaian</th>
                  <th>Tipe</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($finalproject as $fp) : ?>
                  <tr>
                    <td><?= $fp['name']; ?></td>
                    <td><?= $fp['type']; ?></td>
                    <td><?= ($fp['status'] == 1 ? "Aktif" : "Nonaktif"); ?></td>
                    <td>
                      <a href="#" class="badge badge-pill badge-info editFP" data-toggle="modal" data-id="<?= $fp['id']; ?>" data-target="#addFP"><i class="fas fa-fw fa-edit"></i>Edit</a>
                      <a href="<?= base_url('koordinator/deletefp/') . $fp['id']; ?>" class="badge badge-pill badge-danger" onclick="return confirm('Yakin?');"><i class="fas fa-fw fa-trash-alt"></i>Delete</a>
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

<div class="modal fade" id="addFP" tabindex="-1" role="dialog" aria-labelledby="addFPLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFPLabel">Tambah Final Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('koordinator/addfp') ?>" method="post">
          <div class="form-row">
            <div class="form-group col-8">
              <label for="rangkaian">Nama Rangkaian</label>
              <input class="form-control" id="rangkaian" name="rangkaian" type="text">
              <input class="form-control" id="id" name="id" type="text" hidden>
            </div>
            <div class="form-group col-2">
              <label for="type">Tipe</label>
              <input class="form-control" id="type" name="type" type="text">
              <small class="form-text text-muted">A/B/C/D</small>
            </div>
            <div class="form-group col-2">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="input">Input</label>
              <select class="form-control" id="input" name="input">
                <option value="-">-</option>
                <option value="Active High">Active High</option>
                <option value="Active Low">Active Low</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="output">Output</label>
              <select class="form-control" id="output" name="output">
                <option value="-">-</option>
                <option value="Active High">Active High</option>
                <option value="Active Low">Active Low</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label for="selector">Selector</label>
              <select class="form-control" id="selector" name="selector">
                <option value="-">-</option>
                <option value="Active High">Active High</option>
                <option value="Active Low">Active Low</option>
              </select>
            </div>
            <div class="form-group col-6">
              <label for="enable">Enable</label>
              <select class="form-control" id="enable" name="enable">
                <option value="-">-</option>
                <option value="Active High">Active High</option>
                <option value="Active Low">Active Low</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="gate">Gate</label>
            <input class="form-control" type="text" name="gate" id="gate">
            <small class="form-text text-muted">Basic Gate/Module</small>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
      </form>
    </div>
  </div>
</div>