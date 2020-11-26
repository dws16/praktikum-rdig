<body class="bg-gradient" style="background-color:#961B1B">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-lg-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-4 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <img src="<?= base_url('assets/img/') . "b401_logo.png" ?>" style="width:30%" alt="">
                    <h1 class="h4 mt-4 text-gray-900 mb-4">Portal Praktikum Rangkaian Digital</h1>
                  </div>
                  <?= $this->session->flashdata('message'); ?>
                  <form class="user" method="post" action="<?= base_url('auth/login'); ?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="nrp" name="nrp" value="<?= set_value('nrp'); ?>" placeholder="Enter NRP...">
                      <?= form_error('nrp', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                      <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <button type="submit" class="btn btn-user auth btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small text-auth" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small text-auth" href="<?= base_url('auth'); ?>/registration">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>






  <!--  -->