<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{

    public function index()
    {
        check_logout();
        $this->load->view('auth/auth-caleg');
    }

    public function validation_login()
    {
        validation_ajax_request();
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email harap di isi',
            'trim' => 'Tidak boleh ada spasi di awal',
            'valid_email' => 'Email harus valid'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password harap di isi',
            'trim' => 'Tidak boleh ada spasi di awal'
        ]);
        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_email' => form_error('email'),
                'err_pass' => form_error('password')
            ];
            echo json_encode($params);
            die;
        } else {
            $this->process_login();
        }
    }

    private function process_login()
    {
        $email = htmlspecialchars($this->input->post('email', true));
        $password = md5(sha1($this->input->post('password')));
        $user = $this->db->where(['email' => $email, 'password' => $password])->get('user')->row();

        if ($user) {
            $role = $this->db->get_where('role_user', ['id_role' => $user->id_role])->row();

            if ($user->status) {

                if($role->status == 1){
                    $data = [
                        'email' => $user->email,
                        'id_role' => $user->id_role,
                        'status' => $user->status,
                    ];

                    $this->session->set_userdata($data);
                    $params = [
                        'type' => 'result',
                        'success' => true,
                        'msg' => 'Login Success',
                        'redirect' => base_url('dashboard')
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'success' => false,
                        'msg' => 'Role is not active'
                    ];
                }
            } else {
                $params = [
                    'type' => 'result',
                    'success' => false,
                    'msg' => 'Account is not active'
                ];
            }
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Invalid username or password'
            ];
        }
        echo json_encode($params);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            //INI BAWAAN DARI GOOGLE
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'didikarpuz@gmail.com',
            'smtp_pass' => 'jmqyoqpqxbhryefr',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];


        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('Eko Wahyudi','Sistem Informasi Pemenangan Eko Wahyudi');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a
            href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a
            href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('auth/forgot-password');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'status' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);

                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message_scs', 'Please check your email to reset your password!');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message_err', 'Email is not registered or activated!');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token, 'email' => $email])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message_err', 'Reset password failed! Wrong token');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message_err', 'Reset password failed! Wrong email');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[5]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[5]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('auth/change-password', $data);
        } else {
            $password = md5(sha1($this->input->post('password1')));
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            if($this->db->affected_rows() > 0){

              $this->db->delete('user_token',['email' => $email]);
              $this->session->unset_userdata('reset_email');
              $this->session->set_flashdata('message_scs', 'Password has been changed! Please login');
              redirect('auth');

            } else {
              $this->session->unset_userdata('reset_email');
              $this->session->set_flashdata('message_err', 'Error to update your password. please try again');
              redirect('auth');
            }


        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])
                ->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('status', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message_scs', '<div class="alert alert-success" role="alert">
            ' . $email . ' has been activated! Please Login</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message_err', '<div class="alert alert-danger" role="alert">
            Account activation failed! Token expired!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message_err', '<div class="alert alert-danger" role="alert">
            Account activation failed! Wrong token!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message_err', '<div class="alert alert-danger" role="alert">
            Account activation failed! Wrong email</div>');
            redirect('auth');
        }
    }


}
