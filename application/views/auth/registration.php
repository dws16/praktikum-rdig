<body class="bg-gradient" style="background-color:#961B1B">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-lg-10">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-4 d-none d-lg-block bg-register-image"></div>
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                  </div>
                  <?= $this->session->flashdata('message'); ?>
                  <?= form_open_multipart(base_url('auth/registration')); ?>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name" value="<?= set_value('name'); ?>">
                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="nrp" name="nrp" placeholder="NRP" value="<?= set_value('nrp'); ?>">
                    <?= form_error('nrp', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                    </div>
                    <div class="col-sm-6">
                      <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                    </div>
                    <?= form_error('password1', '<small class="text-danger pl-4">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                    <div class="custom-file">
                      <input type="file" name="frs" class="custom-file-input" id="frs">
                      <label class="custom-file-label" for="frs">FRS/Transkrip (PDF/JPG/PNG)</label>
                      <?= form_error('frs', '<small class="text-danger">', '</small>'); ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-file">
                      <input type="file" name="jadwal" class="custom-file-input" id="jadwal">
                      <label class="custom-file-label" for="jadwal">Jadwal Kuliah (PDF/JPG/PNG)</label>
                      <?= form_error('jadwal', '<small class="text-danger">', '</small>'); ?>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Register Account
                  </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url('auth/login'); ?>">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>