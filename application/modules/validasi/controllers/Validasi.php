<?php defined('BASEPATH') or exit('No direct script access allowed');
class Validasi extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('admin/surat_model', 'surat_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->helper('date');
	}

	public function cekvalidasi($id_surat = 0)
	{
		$id_surat = decrypt_url($id_surat);


		$data['title'] = 'Tampil Surat';
		if ($id_surat) {
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$data['no_surat'] = $this->surat_model->get_no_surat($id_surat);
			$kategori = $data['surat']['kategori_surat'];
			$nim = $data['surat']['username'];
			$this->load->view('validasi', $data);
		} else {
			$this->load->view('invalid', $data);
		}
	}
}
