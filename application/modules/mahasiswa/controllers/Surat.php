<?php defined('BASEPATH') or exit('No direct script access allowed');
class Surat extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('surat_model', 'surat_model');
	}

	public function index()
	{
		$data['query'] = $this->surat_model->get_surat_bymahasiswa($this->session->userdata('user_id'));
		$data['title'] = 'Surat Saya';
		$data['view'] = 'surat/index';
		$this->load->view('layout/layout', $data);
	}
	public function detail($id_surat = 0)
	{
		$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
		$data['title'] = 'Detail Surat';
		$data['view'] = 'surat/detail';
		$this->load->view('layout/layout', $data);
	}

	public function ajukan($id_kategori = 0)
	{
		$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
		$data['title'] = 'Ajukan Surat';
		$data['view'] = 'surat/ajukan';
		$this->load->view('layout/layout', $data);
	}

	public function buat_surat($id)
	{
		$data = array(
			'id_kategori_surat' => $id,
			'id_mahasiswa' => $this->session->userdata('user_id'),
		);

		$data = $this->security->xss_clean($data);
		$result = $this->surat_model->tambah($data);

		$insert_id = $this->db->insert_id();

		$this->db->set('id_surat', $insert_id)
			->set('id_status', 1)
			->set('date', 'NOW()', FALSE)
			->insert('surat_status');

		$insert_id2 = $this->db->select('id_surat')->from('surat_status')->where('id=', $this->db->insert_id())->get()->row_array();

		echo $insert_id2['id_surat'];

		$kat_surat = $this->db->select('kat_keterangan_surat')->from('kategori_surat')->where('id=', $id)->get()->row_array();

		$kat_surat = explode(',', $kat_surat['kat_keterangan_surat']);

		foreach ($kat_surat as $key => $id_kat) {
			$this->db->insert(
				'keterangan_surat',
				array(
					'value' => '',
					'id_surat' =>  $insert_id2['id_surat'],
					'id_kat_keterangan_surat' => $id_kat,

				)
			);
		}

		if ($result) {
			$this->session->set_flashdata('msg', 'Berhasil!');
			redirect(base_url('mahasiswa/surat/tambah/' . $insert_id));
		}
	}

	public function tambah($id_surat = 0)
	{

		if ($this->input->post('submit')) {

			foreach ($this->input->post('dokumen') as $id => $dokumen) {
				$this->form_validation->set_rules(
					'dokumen[' . $id . ']',
					kat_keterangan_surat($id)['kat_keterangan_surat'],
					'trim|required',
					array('required' => '%s wajib diisi.')
				);
			}

			if ($this->form_validation->run() == FALSE) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['keterangan_surat'] = $this->surat_model->get_keterangan_surat($id_surat);
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['title'] = 'Ajukan Surat';
				$data['view'] = 'surat/tambah';
				$this->load->view('layout/layout', $data);
			} else {

				//cek dulu apakah ini surat baru atau surat revisi
				if ($this->input->post('revisi')) {
					$id_status = 5;
				} else {
					$id_status = 2;
				}

				//tambah status ke tb surat_status
				$insert = $this->db->set('id_surat', $id_surat)
					->set('id_status', $id_status) //baru
					->set('date', 'NOW()', FALSE)
					->insert('surat_status');
			}

			//insert field ke tabel keterangan_surat
			if ($insert) {
				foreach ($this->input->post('dokumen') as $id => $dokumen) {
					$this->db->where(array('id_kat_keterangan_surat' => $id, 'id_surat' => $id_surat));
					$this->db->update(
						'keterangan_surat',
						array(
							'value' => $dokumen
						)
					);
				}
			}
			redirect(base_url('mahasiswa/surat/tambah/' . $id_surat));
		} else {
			$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
			$data['keterangan_surat'] = $this->surat_model->get_keterangan_surat($id_surat);
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$data['title'] = 'Ajukan Surat';
			$data['view'] = 'surat/tambah';
			$this->load->view('layout/layout', $data);
		}
	}


	public function edit()
	{
		$data['query'] = $this->surat_model->get_surat();
		$data['title'] = 'Ajukan Surat';
		$data['view'] = 'surat/tambah';
		$this->load->view('layout/layout', $data);
	}
	public function hapus($id_surat = 0)
	{
		$surat_exist = $this->surat_model->get_detail_surat($id_surat);
		if ($surat_exist['id_status'] == 4) {
			$this->db->delete('surat', array('id' => $id_surat));
			$this->session->set_flashdata('msg', 'Surat berhasil dihapus');
			redirect(base_url('mahasiswa/surat'));
		} else {
			$this->session->set_flashdata('msg', 'Surat Gagal dihapus');
			redirect(base_url('mahasiswa/surat'));
		}
	}

	public function doupload()
	{
		header('Content-type:application/json;charset=utf-8');
		$upload_path = 'uploads/dokumen';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, TRUE);
		}

		$config = array(
			'upload_path' => $upload_path,
			'allowed_types' => "jpg|png",
			'overwrite' => FALSE,
		);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());

			echo json_encode([
				'status' => 'error',
				'message' => $error
			]);
		} else {
			$data = $this->upload->data();

			$this->_create_thumbs($data['file_name']);

			$result = $this->db->insert(
				'media',
				array(
					'id_user' => $this->session->userdata('user_id'),
					'file' =>  $upload_path . '/' . $data['file_name'],
					'thumb' =>  $upload_path . '/' . $data['raw_name'] . '_thumb' . $data['file_ext']
				)
			);

			echo json_encode([
				'status' => 'Ok',
				'id' => $this->db->insert_id(),
				// 'path' => $upload_path . '/' . $data['file_name']
				'thumb' => $upload_path . '/' . $data['raw_name'] . '_thumb' . $data['file_ext'],
				'orig' => $upload_path . '/' . $data['file_name']
			]);
		}
	}

	function _create_thumbs($upload_data)
	{
		// Image resizing config
		$upload_data = $this->upload->data();
		$image_config["image_library"] = "gd2";
		$image_config["source_image"] = $upload_data["full_path"];
		$image_config['create_thumb'] = true;
		$image_config['maintain_ratio'] = TRUE;
		$image_config['thumb_marker'] = "_thumb";
		$image_config['new_image'] = $upload_data["file_path"];
		$image_config['quality'] = "100%";
		$image_config['width'] = 320;
		$image_config['height'] = 240;
		$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
		$image_config['master_dim'] = ($dim > 0) ? "height" : "width";

		$this->load->library('image_lib');
		$this->image_lib->initialize($image_config);

		if (!$this->image_lib->resize()) { //Resize image
			redirect("errorhandler"); //If error, redirect to an error page
		}
	}
}