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
              <button class="btn btn-info btn-sm btn-icon-split addModul" data-toggle="modal" data-target="#modulEdit">
                <span class="icon"><i class="fas fa-book-open"></i></span>
                <span class="text">Tambah Modul</span>
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
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Title</th>
                  <th>Modul</th>
                  <th>Desc</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($list as $f) : ?>
                  <tr>
                    <td><?= $f['name']; ?></td>
                    <td><?= $f['title']; ?></td>
                    <td class="text-center"><a href="<?= base_url('assets/file/praktikum/') . $f['filename']; ?>" class="badge badge-pill badge-info"><i class="fas fa-download"></i> Unduh</a></td>
                    <td><?= $f['description']; ?></td>
                    <td class="text-center"><?= $f['status'] == 1 ? "Aktif" : "Nonaktif"; ?></td>
                    <td class="text-center"><a href="#" class="badge badge-pill badge-info editModul" data-id="<?= $f['praktikumID'] ?>" data-toggle="modal" data-target="#modulEdit"><i class="fas fa-edit"></i> Edit</a>
                      <a href="<?= base_url('koordinator/deletemodul/') . $f['praktikumID']; ?>" onclick="return confirm('Yakin?');" class="badge badge-pill badge-danger"><i class="fas fa-trash"></i> Delete</a>
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

<div class="modal fade" id="modulEdit" tabindex="-1" role="dialog" aria-labelledby="modulEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modulEditLabel">Edit Kelengkapan Praktikum</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open_multipart(base_url('koordinator/addmodul')) ?>
        <div class="form-group">
          <div class="form-row mt-2 ">
            <div class="col-2">
              <label for="modul">Kode</label>
              <input class="form-control" id="modul" name="modul" type="text" required>
              <input class="form-control" id="id" name="id" type="text" hidden>
            </div>
            <div class="col">
              <label for="title">Judul</label>
              <input class="form-control" id="title" name="title" type="text" required>
            </div>
          </div>
          <div class="form-group mt-2">
            <label for="desc">Deskripsi</label>
            <input type="text" class="form-control" id="desc" name="desc">
          </div>
        </div>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="filepraktikum" name="filepraktikum" required>
          <label class="custom-file-label" for="filepraktikum">Berkas modul</label>
        </div>
        <div class="form-row mt-4 ml-1">
          <label for="status">Status</label>
        </div>
        <div class="form-row ml-1">
          <div class="col-auto">
            <input type="checkbox" name="status" id="status">
            <label class="ml-2" for="status" id="targetcheck">On</label>
          </div>
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