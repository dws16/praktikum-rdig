<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->

  <div class="div row justify-content-center">
    <div class="div col-lg-8">
      <div class="card shadow mb-4 border-left-warning">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-warning"><?= $title; ?></h6>
        </div>
        <div class="card-body ">
          <?= form_open_multipart(base_url('profile/edit')); ?>
          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" name="email" id="email" value="<?= $user['email']; ?>" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="name" id="name" value="<?= $user['name']; ?>">
              <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">NRP</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nrp" id="nrp" value="<?= $user['nrp']; ?>">
              <?= form_error('nrp', '<small class="text-danger">', '</small>'); ?>
            </div>
          </div>
          <div class="form-group row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-warning">Edit</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->