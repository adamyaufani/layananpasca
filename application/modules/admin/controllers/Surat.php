<?php defined('BASEPATH') or exit('No direct script access allowed');
class Surat extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('surat_model', 'surat_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->library('mailer');
	}

	public function index($role = 0)
	{
		$data['query'] = $this->surat_model->get_surat($role);
		$data['title'] = 'Surat Admin';
		$data['view'] = 'surat/index';
		$this->load->view('layout/layout', $data);
	}

	public function arsip()
	{
		$data['query'] = $this->surat_model->get_surat(100);
		$data['title'] = 'Arsip Surat';
		$data['view'] = 'surat/arsip';
		$this->load->view('layout/layout', $data);
	}
	public function detail($id_surat = 0)
	{
		$data['status'] = $this->surat_model->get_surat_status($id_surat);
		$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
		$data['timeline'] = $this->surat_model->get_timeline($id_surat);

		//cek apakah admin atau pengguna prodi ( admin prodi, tu, kaprodi, kecuali mhs)
		if (($data['surat']['id_prodi'] == $this->session->userdata('id_prodi') && $this->session->userdata('role') !== 1) || $this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {

			$data['title'] = 'Detail Surat';
			$data['view'] = 'surat/detail';
		} else {
			$data['title'] = 'Forbidden';
			$data['view'] = 'restricted';
		}

		$this->load->view('layout/layout', $data);
	}
	public function proses_surat($id_surat = 0)
	{
		$this->db->set('id_status', 2)
			->set('date', 'NOW()', FALSE)
			->set('id_surat', $id_surat)
			->insert('surat_status');

		redirect(base_url('admin/surat/detail/' . $id_surat));
	}
	public function verifikasi()
	{
		if ($this->input->post('submit')) {

			$verifikasi = $this->input->post('verifikasi'); //ambil nilai 
			$id_surat = $this->input->post('id_surat');
			$id_notif = $this->input->post('id_notif');
			//set status
			$this->db->set('id_status', $this->input->post('rev2'))
				->set('pic', $this->session->userdata('user_id'))
				->set('date', 'NOW()', FALSE)
				->set('id_surat', $id_surat)
				->set('catatan', $this->input->post('catatan'))
				->insert('surat_status');

			foreach ($verifikasi as $id => $value_verifikasi) {

				$this->db->where(array('id_kat_keterangan_surat' => $id, 'id_surat' => $id_surat))
					->update(
						'keterangan_surat',
						array(
							'verifikasi' =>  $value_verifikasi,
						)
					);
			}

			if ($this->input->post('rev2') == 6) {
				$role = array(3, 2);
			} else if ($this->input->post('rev2') == 4) {
				$role = array(3, 2);
			} else if ($this->input->post('rev2') == 7) {
				$role = array(3, 6);
			}

			// buat notifikasi
			$data_notif = array(
				'id_surat' => $id_surat,
				'id_status' => $this->input->post('rev2'),
				'kepada' => $this->input->post('user_id'),
				'role' => $role
			);

			//sendmail & notif
			$this->mailer->send_mail($data_notif);

			// set notif, sudah dibaca"
			$set_notif = $this->db->set('status', 1)
				->set('dibaca', 'NOW()', FALSE)
				->where(array('id' => $id_notif, 'status' => 0))
				->update('notif');

			if ($set_notif) {
				$this->session->set_flashdata('msg', 'Surat sudah diperiksa oleh TU!');
				redirect(base_url('admin/surat/detail/' . $id_surat));
			}
		} else {
			$data['title'] = 'Forbidden';
			$data['view'] = 'restricted';
			$this->load->view('layout/layout', $data);
		}
	}

	public function disetujui()
	{
		if ($this->input->post('submit')) {

			if ($this->session->userdata('role') == 5) { // direktur
				$id_surat = $this->input->post('id_surat');
				$result = $this->db->set('id_status', 9)
					->set('date', 'NOW()', FALSE)
					->set('id_surat', $id_surat)
					->set('pic', $this->session->userdata('user_id'))
					->insert('surat_status');


				if ($result) {
					$data_notif = array(
						'id_surat' => $id_surat,
						'id_status' => 9,
						'kepada' => $this->input->post('user_id'),
						'role' => array(3, 1)
					);				

					//sendmail & notif
					$this->mailer->send_mail($data_notif);

					$this->session->set_flashdata('msg', 'Surat sudah diberi persetujuan oleh Direktur Pascasarjana!');
					redirect(base_url('admin/surat/detail/' . $id_surat));
				}
			} elseif ($this->session->userdata('role') == 6 && $this->session->userdata('id_prodi') == $this->input->post('prodi')) { // kaprodi

				$id_surat = $this->input->post('id_surat');
				$result = $this->db->set('id_status', 8)
					->set('date', 'NOW()', FALSE)
					->set('id_surat', $id_surat)
					->set('pic', $this->session->userdata('user_id'))
					->insert('surat_status');

				if ($result) {
					$data_notif = array(
						'id_surat' => $id_surat,
						'id_status' => 8,
						'kepada' => $this->input->post('user_id'),
						'role' => array(3, 5)
					);

					//sendmail & notif
					$this->mailer->send_mail($data_notif);

					$this->session->set_flashdata('msg', 'Surat sudah diberi persetujuan oleh Kaprodi!');
					redirect(base_url('admin/surat/detail/' . $id_surat));
				}
			}
		}
	}

	public function terbitkan_surat()
	{
		if ($this->input->post('submit')) {
			$id_surat = $this->input->post('id_surat');

			$this->form_validation->set_rules(
				'no_surat',
				'Nomor Surat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'kat_tujuan_surat',
				'Kategori Tujuan Surat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'tujuan_surat',
				'Tujuan Surat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'urusan_surat',
				'Urusan Surat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'instansi',
				'Instansi',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);

			if ($this->form_validation->run() == FALSE) {
				$data['status'] = $this->surat_model->get_surat_status($id_surat);
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);

				$data['title'] = 'Detail Surat';
				$data['view'] = 'surat/detail';
				$this->load->view('layout/layout', $data);
			} else {
				$data = array(
					'id_surat' => $id_surat,
					'id_kategori_surat' => $this->input->post('id_kategori_surat'),
					'no_surat' => $this->input->post('no_surat'),
					'kat_tujuan_surat' => $this->input->post('kat_tujuan_surat'),
					'tujuan_surat' => $this->input->post('tujuan_surat'),
					'urusan_surat' => $this->input->post('urusan_surat'),
					'instansi' => $this->input->post('instansi'),
					'tanggal_terbit' => date('Y-m-d'),
				);
	
				echo $user_id = $this->input->post('user_ids');
				$insert = $this->db->insert('no_surat', $data);
				if ($insert) {
					$this->db->set('id_status', 10)
						->set('date', 'NOW()', FALSE)
						->set('id_surat', $id_surat)
						->set('pic', $this->session->userdata('user_id'))
						->insert('surat_status');

					$data_notif = array(
						'id_surat' => $id_surat,
						'id_status' => 10,
						'kepada' => $this->input->post('user_id'),
						'role' => array(3)
					);

					echo '<pre>'; print_r($data_notif); echo '</pre>';

					// //sendmail & notif
					 $this->mailer->send_mail($data_notif);

					$this->session->set_flashdata('msg', 'Surat berhasil diterbitkan!');
					redirect(base_url('admin/surat/detail/' . $id_surat));
				}
			}
		} 
		// else {
		// 	$data['status'] = $this->surat_model->get_surat_status($id_surat);
		// 	$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
		// 	$data['timeline'] = $this->surat_model->get_timeline($id_surat);

		// 	$data['title'] = 'Detail Surat';
		// 	$data['view'] = 'surat/detail';
		// 	$this->load->view('layout/layout', $data);
		// }
	}

	public function get_tujuan_surat()
	{
		$kat_tujuan = $this->input->post('kat_tujuan_surat');
		$data = $this->db->query("SELECT * FROM tujuan_surat WHERE id_kat_tujuan_surat = $kat_tujuan")->result_array();
		echo json_encode($data);
	}


	public function ajukan($id_kategori = 0)
	{
		$data['kategori_surat'] = $this->surat_model->get_kategori_surat('p');
		$data['title'] = 'Buat Surat';
		$data['view'] = 'surat/ajukan';
		$this->load->view('layout/layout', $data);
	}

	public function buat_surat($id)
	{
		$data = array(
			'id_kategori_surat' => $id,
			'id_mahasiswa' => $this->session->userdata('user_id'),
		);

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		$data = $this->security->xss_clean($data);
		$result = $this->surat_model->tambah($data);
		//ambil last id surat yg baru diinsert
		$insert_id = $this->db->insert_id();
		// set status surat
		$this->db->set('id_surat', $insert_id)
			->set('id_status', 1)
			->set('pic', $this->session->userdata('user_id'))
			->set('date', 'NOW()', FALSE)
			->insert('surat_status');

		//ambil id surat berdasarkan last id status surat
		$insert_id2 = $this->db->select('id_surat')->from('surat_status')->where('id=', $this->db->insert_id())->get()->row_array();
		// ambil keterangan surat berdasar kategori surat
		$kat_surat = $this->db->select('kat_keterangan_surat')->from('kategori_surat')->where('id=', $id)->get()->row_array();

		// explode kterangan surat
		$kat_surat = explode(',', $kat_surat['kat_keterangan_surat']);

		// foreach keterangan surat, lalu masukkan nilai awal (nilai kosong) berdasakan keterangan dari kategori surat
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

		// // $data_notif = array(
		// // 	'id_surat' => $insert_id2['id_surat'],
		// // 	'id_status' => 1,
		// // 	'kepada' => $_SESSION['user_id'],
		// // 	'role' => array(3)
		// // );

		// $results = $this->notif_model->send_notif($data_notif);


		$this->load->library('email');


		$this->email->from('yaufani@gmail.com', 'yaufani Adam');
		$this->email->to('yaufani@gmail.com');

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');

		$this->email->send();

		// if ($results) {
		$this->session->set_flashdata('msg', 'Berhasil!');
		redirect(base_url('admin/surat/tambah/' . $insert_id));
		// }
	}

	public function tambah($id_surat = 0)
	{
		$id_notif = $this->input->post('id_notif');

		if ($this->input->post('submit')) {
			// validasi form, form ini digenerate secara otomatis
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
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);

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
					->set('pic', $this->session->userdata('user_id'))
					->set('date', 'NOW()', FALSE)
					->insert('surat_status');

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


					// kirim notifikasi
					$data_notif = array(
						'id_surat' => $id_surat,
						'id_status' => 2,
						'kepada' => $_SESSION['user_id'],
						'role' => array(2, 3)
					);

					$this->notif_model->send_notif($data_notif);

					// hapus notifikasi "Lengkapi dokumen"
					$set_status = $this->db->set('status', 1)
						->set('dibaca', 'NOW()', FALSE)
						->where(array('id' => $id_notif, 'status' => 0))
						->update('notif');

					if ($set_status) {
						redirect(base_url('mahasiswa/surat/tambah/' . $id_surat));
					}
				}
			}
		} else {
			$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
			//	$data['keterangan_surat'] = $this->surat_model->get_keterangan_surat($id_surat);
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$data['timeline'] = $this->surat_model->get_timeline($id_surat);

			if ($data['surat']['id_mahasiswa'] == $this->session->userdata('user_id')) {
				$data['title'] = 'Ajukan Surat';
				$data['view'] = 'surat/tambah';
			} else {
				$data['title'] = 'Forbidden';
				$data['view'] = 'restricted';
			}

			$this->load->view('layout/layout', $data);
		}
	}
}
