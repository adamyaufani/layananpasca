<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategorisurat extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mahasiswa/surat_model', 'surat_model');
		$this->load->model('prodi_model', 'prodi_model');
	}

	public function index()
	{
		$data['query'] = $this->surat_model->get_surat('');
		$data['kategori_surat'] = $this->surat_model->get_kategori_surat('');
		$data['title'] = 'Kategori Surat';
		$data['view'] = 'kategori/index';
		$this->load->view('layout/layout', $data);
	}

	public function tambah()
	{

		$directory = APPPATH . '/modules/admin/views/surat/template/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));


		$data['keterangan_surat'] = $this->surat_model->get_kat_keterangan_surat();
		$data['prodi'] = $this->prodi_model->get_prodi();
		$data['template'] = $scanned_directory;
		$data['title'] = 'Tambah Kategori Surat';
		$data['view'] = 'kategori/tambah';
		$this->load->view('layout/layout', $data);
	}

	public function edit($id)
	{
		$directory = APPPATH . '/modules/admin/views/surat/template/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));


		$data['kat'] = $this->surat_model->get_kategori_surat_byid($id);
		$data['keterangan_surat'] = $this->surat_model->get_kat_keterangan_surat();
		$data['template'] = $scanned_directory;
		$data['title'] = 'Edit Kategori Surat';
		$data['view'] = 'kategori/edit';
		$this->load->view('layout/layout', $data);
	}
	
	public function simpan_kategori_surat()
	{
		// $field_surat = $this->input->post('field_surat');

		// $newarray = explode("&", $field_surat);

		// $urutan = array();
		// foreach ($newarray as $key => $value) {
		// 	$exp = explode("=", $value);

		// 	$urutan[] = array("id" => $exp[1]);
		// }

		// $serialize = serialize($urutan);

		// $pilih_prodi = (!$this->input->post('pilih_prodi') == '') ? implode(',', $this->input->post('pilih_prodi')) : '';

		$data = array(
			'kategori_surat' => $this->input->post('kategori_surat')
			// 'kat_keterangan_surat' => $serialize,
			// 'kode' => $this->input->post('kode'),
			// 'klien' => $this->input->post('klien'),
			// 'prodi' => $pilih_prodi,
			// 'deskripsi' => $this->input->post('deskripsinya'),
			// 'tujuan_surat' => $this->input->post('tujuan_surat'),
			// 'tembusan' => $this->input->post('tembusan'),
			// 'template' => $this->input->post('template')
		);

		$query = $this->surat_model->tambah_kategori_surat($data);

		$status = true;

		//$data = $this->surat_model->get_kategori_surat_by_id($id);

		echo json_encode(array("status" => "sakses"));
	}

	public function edit_kategori_surat()
	{
		$field_surat = $this->input->post('field_surat');

		$newarray = explode("&", $field_surat);

		$urutan = array();
		foreach ($newarray as $key => $value) {
			$exp = explode("=", $value);

			$urutan[] = array("id" => $exp[1]);
		}

		$serialize = serialize($urutan);

		$pilih_prodi = (!$this->input->post('pilih_prodi') == '') ? implode(',', $this->input->post('pilih_prodi')) : '';

		$data = array(
			'kategori_surat' => $this->input->post('kategori_surat'),
			'kat_keterangan_surat' => $serialize,
			'kode' => $this->input->post('kode'),
			'klien' => $this->input->post('klien'),
			'prodi' => $pilih_prodi,
			'deskripsi' => $this->input->post('deskripsinya'),
			'tujuan_surat' => $this->input->post('tujuan_surat'),
			'tembusan' => $this->input->post('tembusan'),
			'template' => $this->input->post('template')
		);

		$id = $this->input->post('id');

		$query = $this->surat_model->edit_kategori_surat($data, $id);

		$status = true;

		//$data = $this->surat_model->get_kategori_surat_by_id($id);

		echo json_encode(array("status" => $this->input->post('pilih_prodi')));
	}

	public function get_prodi()
	{
		$search = $this->input->post('search');
		$prodi = $this->db->select('*')
			->from('prodi')
			->like('prodi', $search)
			->limit(10)
			->get()->result_array();

		foreach ($prodi as $prodi) {
			$selectajax[] = [
				'value' => $prodi['id'],
				'id' => $prodi['id'],
				'text' => $prodi['prodi']
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
		}
	}
}
