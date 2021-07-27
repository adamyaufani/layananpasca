<?php defined('BASEPATH') or exit('No direct script access allowed');
class Yudisium extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('yudisium_model', 'yudisium_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->helper('date');
	}

	public function index()
	{
		$data['query'] = $this->yudisium_model->get_yudisium();
		$data['title'] = 'Yudisium';
		$data['view'] = 'yudisium/index';
		$this->load->view('layout/layout', $data);
	}

	public function detail($id)
	{

		$id_yudisium= decrypt_url($id);

		if ($this->input->post('submit')) {

			$this->form_validation->set_rules(
				'tanggal_yudisium',
				'Tanggal Yudisium',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			
			$this->form_validation->set_rules(
				'ipk',
				'IPK',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			
			$this->form_validation->set_rules(
				'lama_tahun',
				'Tahun',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);

			$this->form_validation->set_rules(
				'lama_bulan',
				'Bulan',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			
			$this->form_validation->set_rules(
				'lama_hari',
				'Hari',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			
			$this->form_validation->set_rules(
				'predikat',
				'Predikat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			
			if ($this->form_validation->run() == FALSE) {
				$data['yudisium'] = $this->yudisium_model->get_yudisium_by_id($id);
			
				$data['title'] = 'Detail Yudisium';
				$data['view'] = 'yudisium/detail';
				$this->load->view('layout/layout', $data);
			} else {

			
				$data = [
					"tanggal_yudisium" => $this->input->post('tanggal_yudisium'),
					"ipk" => $this->input->post('ipk'),
					"lama_tahun" => $this->input->post('lama_tahun'),
					"lama_bulan" => $this->input->post('lama_bulan'),
					"lama_hari" => $this->input->post('lama_hari'),
					"predikat" => $this->input->post('predikat')
				];
				
				$result = $this->yudisium_model->update($id, $data);

				if($result) {
					$this->session->set_flashdata('msg', 'Data Yudisium berhasil disimpan!');
					redirect(base_url('admin/yudisium/detail/' . encrypt_url($id)));
				}
			}
		} else {

			if($id_yudisium) {
				$data['yudisium'] = $this->yudisium_model->get_yudisium_by_id($id_yudisium);
				$data['title'] = 'Detail Mahasiswa';
				$data['view'] = 'yudisium/detail';
				
			} else {
				$data['title'] = 'Halaman tidak ditemukan';
				$data['view'] = 'error404';
			}

			$this->load->view('layout/layout', $data);
		}
	}

}
