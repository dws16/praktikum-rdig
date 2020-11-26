<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <!-- DataTales Example -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-7">
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
              <button class="btn btn-info mt-1 mb-3 tambahFilePraktikum" data-toggle="modal" data-target="#filePraktikumEdit">Tambah File</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Modul</th>
                  <th>Title</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($file as $f) : ?>
                  <?php if ($f['filename']) : ?>
                    <tr>
                      <td><?= $f['name']; ?></td>
                      <td><?= $f['title']; ?></td>
                      <td>
                        <a href="#" class="badge badge-pill badge-info editFilePraktikum" data-toggle="modal" data-id="<?= $f['id']; ?>" data-target="#filePraktikumEdit"><i class="fas fa-fw fa-edit"></i>Edit</a>
                        <a href="<?= base_url('koordinator/deletefilepraktikum/') . $f['id']; ?>" class="badge badge-pill badge-danger" onclick="return confirm('Yakin?');"><i class="fas fa-fw fa-trash-alt"></i>Delete</a>
                      </td>
                    </tr>
                  <?php endif; ?>
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

<div class="modal fade" id="filePraktikumEdit" tabindex="-1" role="dialog" aria-labelledby="filePraktikumEditLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filePraktikumEditLabel">Edit Kelengkapan Praktikum</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open_multipart(base_url('koordinator/editfilepraktikum')) ?>
        <div class="form-group">
          <label for="modul">Modul</label>
          <select class="form-control" id="modul" name="modul">
            <?php foreach ($file as $f) : ?>
              <?php if (!$f['filename']) : ?>
                <option value="<?= $f['praktikumID'] ?>"><?= $f['name']; ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="filepraktikum" name="filepraktikum">
          <label class="custom-file-label" for="filepraktikum">Pilih berkas</label>
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