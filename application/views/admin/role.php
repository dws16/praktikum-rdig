<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg">
      <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

      <?= $this->session->flashdata('message'); ?>
      <a href="" class="btn btn-primary mb-3 tombolTambahRole" data-toggle="modal" data-target="#NewRoleModal">Add New Role</a>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Role</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php foreach ($role as $r) : ?>
                  <tr>

                    <th scope="row"><?= $i; ?></th>
                    <td><?= $r['role'] ?></td>
                    <td>
                      <a href="<?= base_url('admin/roleaccess/' . $r['id']); ?>" class="badge badge-pill badge-info"><i class="fas fa-fw fa-door-open"></i>Access</a>
                      <a href="<?= base_url('admin/editrole/' . $r['id']); ?>" data-toggle="modal" data-target="#NewRoleModal" data-id="<?= $r['id']; ?>" class="badge badge-pill badge-primary TampilEditRole"><i class="fas fa-fw fa-edit"></i>Edit</a>
                      <a href="<?= base_url('admin/deleterole/' . $r['id']); ?>" class="badge badge-pill badge-danger" onclick="return confirm('Yakin?');"><i class="fas fa-fw fa-trash-alt"></i>Delete</a>
                    </td>
                  </tr>
                  <?php $i++; ?>
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


<!-- Modal -->
<div class="modal fade" id="NewRoleModal" tabindex="-1" role="dialog" aria-labelledby="NewRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="NewRoleModalLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('admin/editrole') ?>" method="post">
          <div class="form-group">
            <input type="hidden" id="id" name="id">
            <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>