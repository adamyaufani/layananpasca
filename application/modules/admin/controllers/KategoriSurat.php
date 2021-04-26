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
		$data['title'] = 'Tambah Kategori Surat';
		$data['view'] = 'kategori/tambah';
		$this->load->view('layout/layout', $data);
	}

	public function edit($id)
	{
		$directory = APPPATH . '/modules/admin/views/surat/template/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		$data['kat'] = $this->surat_model->get_kategori_surat_byid($id);
		$data['template'] = $scanned_directory;
		$data['keterangan_surat'] = $this->surat_model->get_kat_keterangan_surat($id, 0);
		$data['title'] = 'Edit Kategori Surat';
		$data['view'] = 'kategori/edit';
		$this->load->view('layout/layout', $data);
	}

	public function simpan_kategori_surat()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules(
				'kategori_surat',
				'Kategori Surat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);

			if ($this->form_validation->run() == FALSE) {			
				$data['title'] = 'Tambah';
				$data['view'] = 'kategori/tambah';
				$this->load->view('layout/layout', $data);
			} else {
				$data = array(
					'kategori_surat' => $this->input->post('kategori_surat')
				);

				$query = $this->surat_model->tambah_kategori_surat($data);
				$last_id = $this->db->insert_id();

				if ($query) {
					$field_baru = [
						'kat_keterangan_surat' => 'Hal',
						'id_kategori_surat' => $last_id,
						'key' => 'hal',
						'placeholder' => 'Hal',
						'type' => 'text',
						'required' => 1,
						'aktif' => 1,
					];

					$this->db->insert('kat_keterangan_surat', $field_baru);

					$this->session->set_flashdata('msg', 'Surat berhasil diterbitkan!');
					redirect(base_url('admin/kategorisurat/edit/' . $last_id));
				}
			}
		} else {
			redirect(base_url('admin/kategorisurat/tambah/'));
		}
	}

	public function edit_kategori_surat()
	{
		//ambil data prodi
		$pilih_prodi = (!$this->input->post('pilih_prodi') == '') ? implode(',', $this->input->post('pilih_prodi')) : '';

		$data = array(
			'kategori_surat' => $this->input->post('kategori_surat'),
			'kode' => $this->input->post('kode'),
			'klien' => $this->input->post('klien'),
			'prodi' => $pilih_prodi,
			'deskripsi' => $this->input->post('deskripsinya'),
			'tujuan_surat' => $this->input->post('tujuan_surat'),
			// 'tembusan' => $this->input->post('tembusan'),
			'template' => $this->input->post('template')
		);

		$id_kategori_surat = $this->input->post('id');

		$field_surat = $this->input->post('field_surat');

		$newarray = explode("&", $field_surat);

		foreach ($newarray as $key => $val) {

			$id_field = explode("=", $val);

			$arr[] = $id_field[1];
		}

		$dataFieldCheck = [
			'not_exist_fields_data' => implode(',', $arr),
			'sent_fields_data' => $arr,
		];

		$query = $this->surat_model->edit_kategori_surat($data, $id_kategori_surat);

		if ($query) {
			$fields = $this->surat_model->editFieldsSurat($dataFieldCheck, $id_kategori_surat);
		}

		$status = true;
		echo json_encode(array("status" => $fields));
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
