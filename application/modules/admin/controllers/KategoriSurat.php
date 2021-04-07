<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategorisurat extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('surat_model', 'surat_model');
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
		$data['view'] = 'admin/borang/kategori/tambah_kategori';
		$this->load->view('admin/layout', $data);
	}


	public function edit($id)
	{
		$directory = APPPATH . '/modules/admin/views/surat/template/';
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));

		if ($this->input->post('submit')) {
			$this->form_validation->set_rules(
				'kategori_surat',
				'Kategori',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'kode',
				'Kode',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'klien',
				'Pengguna',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'deskripsinya',
				'Deskripsi',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'kat_keterangan_surat[]',
				'Formulir Isian',
				'required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'template',
				'Template',
				'required',
				array('required' => '%s wajib diisi.')
			);

			if ($this->form_validation->run() == FALSE) {
				$data['kat'] = $this->surat_model->get_kategori_surat_byid($id);
				$data['keterangan_surat'] = $this->surat_model->get_kat_keterangan_surat();
				$data['template'] = $scanned_directory;
				$data['title'] = 'Edit Kategori Surat';
				$data['view'] = 'kategori/edit';
				$this->load->view('layout/layout', $data);
			} else {

				$data = array(
					'kategori_surat' => $this->input->post('kategori_surat'),
					'kode' => $this->input->post('kode'),
					'klien' => $this->input->post('klien'),
					'deskripsi' => $this->input->post('deskripsinya'),
					'tujuan_surat' => $this->input->post('tujuan_surat'),
					'template' => $this->input->post('template'),
					'kat_keterangan_surat' => implode(',', $this->input->post('kat_keterangan_surat[]')),
				);
				// print_r($data);
				$data = $this->security->xss_clean($data);
				$result = $this->surat_model->edit_kategori_surat($data, $id);
				if ($result) {
					$this->session->set_flashdata('msg', 'Data kategory berhasil diubah!');
					redirect(base_url('admin/kategorisurat/edit/' . $id));
				}
			}
		} else {
			$data['kat'] = $this->surat_model->get_kategori_surat_byid($id);
			$data['keterangan_surat'] = $this->surat_model->get_kat_keterangan_surat();
			$data['template'] = $scanned_directory;
			$data['title'] = 'Edit Kategori Surat';
			$data['view'] = 'kategori/edit';
			$this->load->view('layout/layout', $data);
		}
	}

	public function store_kategori()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required');
			$this->form_validation->set_rules('singkatan', 'Singkatan', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/borang/kategori/tambah_kategori';
				$this->load->view('admin/layout', $data);
			} else {

				$data = array(
					'kategori_dokumen' => $this->input->post('nama'),
					'singkatan' => $this->input->post('singkatan'),
				);

				print_r($data);

				$data = $this->security->xss_clean($data);
				$result = $this->apt_model->add_kategori($data);
				if ($result) {
					$this->session->set_flashdata('msg', 'Kategori baru berhasil ditambahkan!');
					redirect(base_url('admin/kategori'));
				}
			}
		} else {
			$data['view'] = 'admin/borang/kategori/tambah_kategori';
			$this->load->view('admin/layout', $data);
		}
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
