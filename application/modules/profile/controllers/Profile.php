<?php defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('profile_model', 'profile_model');
	}
	//-------------------------------------------------------------------------
	public function index()
	{
		if ($this->input->post('submit')) {

			$this->form_validation->set_rules('email', 'E-mail', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['user'] = $this->profile_model->get_user_detail();
				$data['title'] = 'Profil Saya';
				$data['view'] = 'profile/index';
				$this->load->view('layout/layout', $data);
			} else {			

				$data = array(
				
					'email' => $this->input->post('email'),
					'password' => ($this->input->post('password') !== "" ? password_hash($this->input->post('password'), PASSWORD_BCRYPT) : $this->input->post('password_hidden')),
					'updated_at' => date('Y-m-d : h:m:s'),
				);

				$data = $this->security->xss_clean($data);
				$result = $this->profile_model->update_user($data);
				if ($result) {
					$this->session->set_flashdata('msg', 'Profil Anda berhasil diubah!');
					redirect(base_url('profile'), 'refresh');
				}
			}
		} else {
			$data['user'] = $this->profile_model->get_user_detail();
			$data['title'] = 'Profil Saya';
			$data['view'] = 'profile/index';
			$this->load->view('layout/layout', $data);
		}
	}
}
