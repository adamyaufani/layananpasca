<?php defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('auth_model', 'auth_model');
	}
	//--------------------------------------------------------------
	public function index()
	{
		if (!$this->session->has_userdata('is_login')) {
			redirect('auth/login');
		} else {
			if ($this->session->has_userdata('role') == 3) {
				redirect('mahasiswa/surat');
			} else {
				redirect('admin/surat');
			}
		}
	}
	//--------------------------------------------------------------
	public function login($referrer = null)
	{
		//check referer page
		if (isset($referrer)) {
			// jika referrernya non sso
			if ($referrer === 'non-sso') {
				if ($this->input->post('submit')) {
					$this->form_validation->set_rules('username', 'Username', 'trim|required');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');

					if ($this->form_validation->run() == FALSE) {
						$data['ref'] = $referrer;
						$this->load->view('auth/login', $data);
					} else {
						$data = array(
							'username' => $this->input->post('username'),
							'password' => $this->input->post('password')
						);
						$result = $this->auth_model->login($data);
						if ($result) {
							$user_data = array(
								'user_id' => $result['id'],
								'username' => $result['username'],
								'fullname' => $result['fullname'],
								'role' => $result['role'],
								'id_prodi' => $result['id_prodi'],
								'is_login' => TRUE,
							);

							$this->session->set_userdata($user_data);
							if ($result['role'] != 3) {
								redirect(base_url('admin/surat'), 'refresh');
							} else {
								redirect(base_url('mahasiswa/surat'), 'refresh');
							}
						} else {
							$data['msg'] = 'Invalid Username or Password!';
							$data['ref'] = $referrer;
							$this->load->view('auth/login', $data);
						}
					}
				} else {
					$data['ref'] = $referrer;
					$this->load->view('auth/login', $data);
				}
				// jika referrernya salah
			} else {
				echo "404";
			}
			//jika tanpa referrer maka menggunakan SSO UMY
		} else {
			if ($this->input->post('submit')) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['ref'] = $referrer;
					$this->load->view('auth/login', $data);
				} else {

					$data = array(
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password')
					);

					$params = http_build_query($data);

					$email = $this->input->post('username');

					$body = array('http' =>
					array(
						'method' => 'POST',
						'header' => 'Content-type: application/x-www-form-urlencoded',
						'content' => $params
					));
					$context = stream_context_create($body);
					$link = file_get_contents('https://sso.umy.ac.id/api/Authentication/Login', false, $context);
					$json = json_decode($link);

					$ceknum = $json->{'code'};

					// jika login benar
					if ($ceknum == 0) {
						// cek user ke tabel Mhs (SQLSERVER UMY)
						$db2 = $this->load->database('dbsqlsrv', TRUE);

						$result = $db2->query("SELECT * from V_Simpel_Pasca WHERE EMAIL ='$email' ")->row_array();


						//cek apakah mahasiswa pasca
						// jika iya, diperbolehkan login
						if ($result['name_of_faculty'] === "PASCA SARJANA") {

							//cek keaktifan semester ini
							$thn_ajaran = date('Y');
							$cur_semester = (date("n") <= 6) ?  0 : 1;
							$nim = $result['STUDENTID'];

							$cek_aktif = $db2->query("select* FROM [s1makumyny4].[dbo].[V_Simpel_Pasca]  where studentid in (select studentid from STUDENT_COURSE_KRS where thajaranid='$thn_ajaran' and termid='$cur_semester')
					and studentid='$nim'");

							$user_data = array(
								'username' => $result['STUDENTID'],
								'fullname' => $result['FULLNAME'],
								'email' => $result['EMAIL'],
								'telp' => $result['TELP'],
							//	'fakultas' => $result['name_of_faculty'],
								'id_prodi' => $result['department_id'],
								'role' => 3,
							//	'aktif' => ($cek_aktif->num_rows() > 0) ? 1 : 0,
								'created_at' => date('Y-m-d : h:m:s'),
							);

							$this->session->set_userdata($user_data);
							$this->session->set_userdata('is_login', TRUE);

							// cek di db lokal user apakah data user ada
							$result = $this->auth_model->user_exist($data);
							// jika tidak ada, isikan data ini ke table user
							if (!$result) {
								$reg = $this->auth_model->register($user_data);
								$this->session->set_userdata('user_id', $reg);
							} else {
								$this->session->set_userdata('user_id', $result);
							}
							redirect(base_url('mahasiswa/dashboard'), 'refresh');
						} else {
							$data['ref'] = $referrer;
							$data['msg'] = 'Anda tidak berhak mengakses!';
							$this->load->view('auth/login', $data);
						}
					} else {
						$data['ref'] = $referrer;
						$data['msg'] = 'Invalid Username or Password!';
						$this->load->view('auth/login', $data);
					}
				}
			} else {
				$data['ref'] = $referrer;
				$this->load->view('auth/login', $data);
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth/login'), 'refresh');
	}
}  // end class
