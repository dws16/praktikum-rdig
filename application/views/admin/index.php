<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">User List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="row mx-1">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-1 mt-2">
                  <label for="show">Show</label>
                </div>
                <div class="col-md-2">
                  <select class="custom-select" name="show" id="show">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                  </select>
                </div>
                <div class="col-md-2 mt-2">Entries</div>
              </div>
            </div>
            <div class="col-md-5 ml-auto">
              <form action="<?= base_url('admin') ?>" method="post">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="keyword" placeholder="Search user...">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-fw fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
            <?= $this->session->flashdata('message'); ?>
          </div>
          <?php if (empty($list)) { ?>
            <div class="alert alert-danger" role="alert">
              Data not found!
            </div>
          <?php } else { ?>
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">NRP</th>
                  <th scope="col">Email</th>
                  <th scope="col">Role</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">NRP</th>
                  <th scope="col">Email</th>
                  <th scope="col">Role</th>
                  <th scope="col">Action</th>
                </tr>
              </tfoot>
              <tbody>
                <?php $i = 1;
                foreach ($list as $l) :
                  if ($l['role_id'] == 1) {
                    $l['role_id'] = 'Admin';
                  } else if ($l['role_id'] == 2) {
                    $l['role_id'] = 'Koor';
                  } else if ($l['role_id'] == 3) {
                    $l['role_id'] = 'Aslab';
                  } else {
                    $l['role_id'] = 'Praktikan';
                  } ?>
                  <tr>
                    <th scope="row"><?= $i; ?></th>
                    <td><?= $l['name']; ?></td>
                    <td><?= $l['nrp']; ?></td>
                    <td><?= $l['email']; ?></td>
                    <td><?= $l['role_id']; ?></td>
                    <td>
                      <a href="<?= base_url('admin/edit/') . $l['id']; ?>" class="badge badge-pill badge-primary tampilModalUbah" data-id="<?= $l['id']; ?>" data-toggle="modal" data-target="#UserEdit">
                        <i class=" fas fa-fw fa-edit"></i>
                        Edit
                      </a>
                      <a href="<?= base_url('admin/delete/') . $l['id']; ?>" onclick="return confirm('Yakin?');" class="badge badge-pill badge-danger">
                        <i class="fas fa-fw fa-trash-alt"></i>
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php $i++;
                endforeach; ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
</div>

<div class="modal fade" id="UserEdit" tabindex="-1" role="dialog" aria-labelledby="UserEditLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UserEditLabel">Edit User Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/edit') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="id">ID</label>
            <input class="form-control" type="text" name="id" id="id" readonly>
          </div>
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="nrp">NRP</label>
            <input type="text" class="form-control" id="nrp" name="nrp">
          </div>
          <div class="form-group">
            <label for="role_id">Role ID</label>
            <select class="form-control" name="role_id" id="role_id">
              <option value="1">Admin</option>
              <option value="2">Koor</option>
              <option value="3">Aslab</option>
              <option value="4">Praktikan</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>