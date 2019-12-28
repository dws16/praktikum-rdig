<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = "Portal Praktikum Rangkaian Digital B401 ITS";
    $this->load->view('templates/auth_header', $data);
    $this->load->view('auth/index', $data);
    $this->load->view('templates/auth_footer', $data);
  }

  public function login()
  {
    if ($this->session->userdata('nrp')) {
      if ($this->session->userdata('role_id') == 1) {
        redirect(base_url('admin'));
      } else if ($$this->session->userdata('role_id') == 2) {
        redirect(base_url('koor'));
      } else if ($$this->session->userdata('role_id') == 3) {
        redirect(base_url('aslab'));
      } else if ($$this->session->userdata('role_id') == 4) {
        redirect(base_url('praktikan'));
      }
    }

    #Rules form
    $this->form_validation->set_rules('nrp', 'NRP', 'trim|exact_length[14]|numeric|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    #Cek jika isi form masih salah / kosong
    if ($this->form_validation->run() == false) {
      $data['title'] = "Portal Praktikum Rangkaian Digital B401 ITS";
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/index', $data);
      $this->load->view('templates/auth_footer', $data);
      #Jika sudah benar, panggil fungsi login di bawah
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    #mengambil data yg diinput oleh user
    $nrp = $this->input->post('nrp');
    $password = $this->input->post('password');

    #query data select * from user where 'nrp'='$nrp'
    $user = $this->db->get_where('user', ['nrp' => $nrp])->row_array();

    #jika data user ditemukan
    if ($user) {

      #jika user sudah diaktivasi
      if ($user['is_active'] == 1) {

        #mengecek password
        if (password_verify($password, $user['password'])) {
          $data = [
            'nrp' => $user['nrp'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'id' => $user['id']
          ];

          #memasukkan data di atas ke session
          $this->session->set_userdata($data);
          if ($user['role_id'] == 1) {
            redirect(base_url('admin'));
          } else if ($user['role_id'] == 2) {
            redirect(base_url('koor'));
          } else if ($user['role_id'] == 3) {
            redirect(base_url('aslab'));
          } else if ($user['role_id'] == 4) {
            redirect(base_url('praktikan'));
          }

          #jika password salah
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong password!
                    </div>');
          redirect(base_url());
        }

        #jika user belum diaktivasi
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                This account has not been activated!
                </div>');
        redirect(base_url());
      }

      #jika data user tidak ditemukan
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            NRP is not registered!
            </div>');
      redirect(base_url());
    }
  }

  public function registration()
  {
    if ($this->session->userdata('nrp')) {
      if ($this->session->userdata('role_id') == 1) {
        redirect(base_url('admin'));
      } else if ($$this->session->userdata('role_id') == 2) {
        redirect(base_url('koor'));
      } else if ($$this->session->userdata('role_id') == 3) {
        redirect(base_url('aslab'));
      } else if ($$this->session->userdata('role_id') == 4) {
        redirect(base_url('praktikan'));
      }
    }

    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('nrp', 'NRP', 'required|exact_length[14]|numeric|trim|is_unique[user.nrp]', [
      'is_unique' => 'This NRP has already registered!'
    ]);
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
      'is_unique' => 'This email has already registered!'
    ]);
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
      'matches' => 'Password does not match!',
      'min_length' => 'Password must be at least 8 characters!'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'User Registration';
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/registration');
      $this->load->view('templates/auth_footer');
    } else {
      $frs = $_FILES['frs']['name'];
      if ($frs) {
        $config['upload_path'] = './assets/img/frs';
        $config['allowed_types'] = 'pdf|jpg|png|JPG';
        $config['max_size']     = '2048';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('frs')) {
          $new_frs = $this->upload->data('file_name');
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
          redirect(base_url('auth/registration'));
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Upload FRS/Transkrip anda!
          </div>');
        redirect(base_url('auth/registration'));
      }

      $jadwal = $_FILES['jadwal']['name'];
      if ($jadwal) {
        $config2['upload_path'] = './assets/img/jadwal';
        $config2['allowed_types'] = 'pdf|jpg|png|JPG';
        $config2['max_size']     = '2048';

        $this->load->library('upload', $config2);

        if ($this->upload->do_upload('jadwal')) {
          $new_jadwal = $this->upload->data('file_name');
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
          redirect(base_url('auth/registration'));
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Upload Jadwal Kuliah anda!
          </div>');
        redirect(base_url('auth/registration'));
      }

      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'nrp' => htmlspecialchars($this->input->post('nrp', true)),
        'email' => htmlspecialchars($this->input->post('email', true)),
        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        'role_id' => 4,
        'is_active' => 0,
        'frs' => $new_frs,
        'jadwal' => $new_jadwal,
        'date_created' => time()
      ];

      // token
      $token = base64_encode(random_bytes(32));
      $user_token = [
        'email' => $this->input->post('email', true),
        'token' => $token,
        'date_created' => time()
      ];

      $this->db->insert('user', $data);
      $this->db->insert('user_token', $user_token);

      $this->_sendEmail($token, 'verify', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! Your account has been created. Please check your email to activate!
            </div>');
      redirect(base_url('auth/login'));
    }
  }

  private function _sendEmail($token, $type, $data)
  {
    $config = [
      'protocol' => 'smtp',
      'smtp_host' => 'smtp.hostinger.co.id',
      'smtp_user' => 'praktikum@b401telematics.com',
      'smtp_pass' => 'informatikadigital',
      'smtp_port' => 587,
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n"
    ];

    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->from('praktikum@b401telematics.com', 'B401 ITS');
    $this->email->to($this->input->post('email', true));

    if ($type == 'verify') {
      $this->email->subject('Account Verification');
      $this->email->message('<table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
      <tr>
          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
          <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
  
                  <!-- START CENTERED WHITE CONTAINER -->
                  <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Sebelum kamu dapat menggunakan akun mu pada web b401telematics.com, </span>
                  <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
  
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                          <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                  <tr>
  
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-left: 30px;">
                                          <div style="text-align: center; border-bottom: 4px solid gray; padding-bottom: 5px; margin-bottom: 10px;">
                                              <img src="http://b401telematics.com/wp-content/uploads/2017/08/logo-262x300-1.png" style="width: 180px;" alt="logob401">
                                          </div>
                                          <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Halo, ' . $data['name'] . '
                                              <p></p>
                                          </p>
                                          <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Sebelum kamu dapat menggunakan akunmu pada web praktikum.b401telematics.com, konfirmasi emailmu terlebih dahulu untuk mendaftarkan dirimu di Praktikum Rangkaian Digital. </p>
                                          <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                              <tbody>
                                                  <tr>
                                                      <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                                              <tbody>
                                                                  <tr>
                                                                      <div class="profil" style="background-color: #f2f2f2; border-left: 4px solid black; padding: 10px; width: 300px; margin: 4px 0 10px 0;">
                                                                          <var id="name">' . $data['name'] . '</var>
                                                                          <br>
                                                                          <var id="nrp">' . $data['nrp'] . '</var>
                                                                      </div>
                                                                  </tr>
                                                                  <tr>
                                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db; ">Konfirmasi</a>                                                                        </td>
                                                                  </tr>
                                                              </tbody>
                                                          </table>
                                                      </td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                          <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 0;">Best regards,</p>
                                          <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 0;">B401 Multimedia Computing Laboratory</p>
                                          <div style="text-align: center; border-bottom: 4px solid gray; padding-bottom: 5px; margin-bottom: 10px;">
                                          </div>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
  
                      <!-- END MAIN CONTENT AREA -->
                  </table>
  
                  <!-- START FOOTER -->
                  <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                          <tr>
                              <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                  <span class="" style="color: #999999; font-size: 12px; text-align: center;">This Email Sent by B401 Multimedia Computing Laboratory Assistant
                                  <br>Computer Engineering Department, Faculty of Electrical Technology, B Building 4th Floor, ITS Campus Sukolilo, Surabaya 60111</span>
                                  <br> Something\'s wrong? <a href="https://line.me/R/ti/p/%40zfn9202g" style="text-decoration: underline; color: #999999; font-size: 12px; text-align: center;">contact us</a>.
                              </td>
                          </tr>
  
                      </table>
                  </div>
                  <!-- END FOOTER -->
  
                  <!-- END CENTERED WHITE CONTAINER -->
              </div>
          </td>
          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
  </table>');
    } else if ($type == 'forgot') {
      $this->email->subject('Reset Password');
      $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
    }

    if ($this->email->send()) {
      return true;
    } else {
      echo $this->email->print_debugger();
      die;
    }
  }

  public function verify()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
      if ($user_token) {
        $this->db->set('is_active', 1);
        $this->db->where('email', $email);
        $this->db->update('user');

        $this->db->delete('user_token', ['email' => $email]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Account has been activated! Please login.
                </div>');
        redirect(base_url('auth'));
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Account activation failed! Token invalid.
                </div>');
        redirect(base_url('auth'));
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Account activation failed! Wrong email.
            </div>');
      redirect(base_url('auth'));
    }
  }

  // public function logout()
  // {
  //   $this->session->unset_userdata('email');
  //   $this->session->unset_userdata('nrp');
  //   $this->session->unset_userdata('id');
  //   $this->session->unset_userdata('role_id');

  //   $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  //           You have been logged out!
  //           </div>');
  //   redirect(base_url('auth'));
  // }

  // public function denied()
  // {
  //   $data['title'] = 'Access Denied';
  //   $this->load->view('templates/header', $data);
  //   $this->load->view('auth/denied');
  // }

  // public function forgotPassword()
  // {
  //   $data['title'] = 'Forgot Password';

  //   $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

  //   if ($this->form_validation->run() == false) {
  //     $this->load->view('templates/auth_header', $data);
  //     $this->load->view('auth/forgot-password');
  //     $this->load->view('templates/auth_footer', $data);
  //   } else {
  //     $email = $this->input->post('email', true);
  //     $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
  //     if ($user) {
  //       $token = base64_encode(random_bytes(32));
  //       $user_token = [
  //         'email' => $email,
  //         'token' => $token,
  //         'date_created' => time()
  //       ];

  //       $this->db->insert('user_token', $user_token);
  //       $this->_sendEmail($token, 'forgot');
  //       $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  //               Please check your email to reset your password!
  //               </div>');
  //       redirect(base_url('auth/forgotpassword'));
  //     } else {
  //       $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
  //               Email is not registered or activated!
  //               </div>');
  //       redirect(base_url('auth/forgotpassword'));
  //     }
  //   }
  // }

  // public function resetPassword()
  // {
  //   $email = $this->input->get('email');
  //   $token = $this->input->get('token');

  //   $user = $this->db->get_where('user', ['email' => $email])->row_array();
  //   if ($user) {
  //     $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
  //     if ($user_token) {
  //       $this->session->set_userdata('reset_email', $email);
  //       $this->changePassword();
  //     } else {
  //       $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
  //               Reset password failed! Token invalid.
  //               </div>');
  //       redirect(base_url('auth/login'));
  //     }
  //   } else {
  //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
  //               Reset password failed! Wrong email.
  //               </div>');
  //     redirect(base_url('auth/login'));
  //   }
  // }

  // public function changePassword()
  // {
  //   if (!$this->session->userdata('reset_email')) {
  //     redirect(base_url('auth'));
  //   }
  //   $data['title'] = 'Change Password';

  //   $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]');
  //   $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[8]|matches[password1]');

  //   if ($this->form_validation->run() == false) {
  //     $this->load->view('templates/auth_header', $data);
  //     $this->load->view('auth/change-password');
  //     $this->load->view('templates/auth_footer', $data);
  //   } else {
  //     $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
  //     $email = $this->session->userdata('reset_email');

  //     $this->db->set('password', $password);
  //     $this->db->where('email', $email);
  //     $this->db->update('user');

  //     $this->session->unset_userdata('reset_email');
  //     $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
  //               Password has been changed! Please login.
  //               </div>');
  //     redirect(base_url('auth/login'));
  //   }
  // }
}
