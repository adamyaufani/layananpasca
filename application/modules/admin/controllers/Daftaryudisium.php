<?php defined('BASEPATH') or exit('No direct script access allowed');
class Daftaryudisium extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mahasiswa/surat_model', 'surat_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->library('mailer');
		$this->load->model('survey/survey_model', 'survey_model');
		$this->load->model('admin/template_model', 'template_model');
	}

	public function index($role = 0)
	{
		$data['query'] = $this->surat_model->get_surat_yudisium();
		$data['title'] = 'Pendaftaran Yudisium';
		$data['view'] = 'daftaryudisium/index';
		$this->load->view('layout/layout', $data);
	}

	public function detail($id_surat = 0)
	{
		$id_surat = decrypt_url($id_surat);

		if ($id_surat) {

			$data['status'] = $this->surat_model->get_surat_status($id_surat);
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$data['timeline'] = $this->surat_model->get_timeline($id_surat);
			$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
			$data['template'] = $this->template_model->get_template_bykat($data['surat']['id_kategori_surat']);

			if ($data['surat']['id_status'] == 8 || $data['surat']['id_status'] == 9 || $data['surat']['id_status'] == 10) {

				$data['no_surat_data'] = $this->surat_model->get_no_surat($id_surat);

				if ($data['surat']['id'] < 785 && (!$data['no_surat_data'])) {
					// isi table no_surat untuk surat2 lama supaya bisa dipakai di sistem baru
					$this->db->insert('no_surat', ['id_surat' => $id_surat, 'hal' => $data['surat']['kategori_surat']]);

					// echo "surat lama yg baru diproses no suratnya";

					redirect(base_url('admin/daftaryudisium/detail/' . encrypt_url($id_surat)));
				}
			}

			//cek apakah admin atau pengguna prodi ( admin prodi, tu, kaprodi, kecuali mhs)
			if (($data['surat']['id_prodi'] == $this->session->userdata('id_prodi') && $this->session->userdata('role') !== 1) ||
				$this->session->userdata('role') == 1 || $this->session->userdata('role') == 5
			) {

				if ($data['surat']['id_status'] == 10) {

					//cek apakah sudah mengisi survey
					$survey = $this->survey_model->get_survey($id_surat, $data['surat']['id_mahasiswa']);
					if ($survey) {
						$data['sudah_survey'] = 1;
						$data['hasil_survey'] = $survey;
					} else {
						$data['sudah_survey'] = 0;
					}
				}
				$data['title'] = 'Yudisium';
				$data['view'] = 'daftaryudisium/detail';
			} else {
				$data['title'] = 'Forbidden';
				$data['view'] = 'restricted';
			}
		} else {
			$data['title'] = 'Halaman tidak ditemukan';
			$data['view'] = 'error404';
		}

		$this->load->view('layout/layout', $data);
	}

	public function hapus($kode, $id_kat, $id_surat)
	{

		$id_surat = decrypt_url($id_surat);
		if ($id_surat) {

			if ($kode == 'd') {

				$hapus_exist = $this->db->get_where('surat_status', ['id_surat' => $id_surat, 'id_status' => 20])->num_rows();

				if ($hapus_exist < 1) {

					$hapus = $this->db->set('id_status', '20')
						->set('date', 'NOW()', FALSE)
						->set('id_surat', $id_surat)
						->set('pic', $_SESSION['user_id'])
						->insert('surat_status');
				} else {
					redirect(base_url('admin/surat/index'));
				}

				//hapus notif yg berkaitan
				$this->db->where(['id_surat' => $id_surat]);
				$hapus = $this->db->delete('notif');

				//hapus yudisium yg berkaitan jika berhubungan drn kategori surat yudisium
				if ($id_kat == 6) {
					$this->db->where(['id_surat' => $id_surat]);
					$hapus = $this->db->update('yudisium', ['aktif' => 'd']);
				}
			} else if ($kode == 'r') {
				$this->db->where(['id_surat' => $id_surat, 'id_status' => '20']);
				$this->db->delete('surat_status');

				//kembalikan peserta di tabel yudisium yjika berhubungan drn kategori surat yudisium
				if ($id_kat == 6) {
					$this->db->where(['id_surat' => $id_surat]);
					$hapus = $this->db->update('yudisium', ['aktif' => '']);
				}
			}

			$this->session->set_flashdata('msg', 'Surat berhasil dihapus!');
			redirect(base_url('admin/surat/index'));
		} else {
			$data['title'] = 'Halaman tidak ditemukan';
			$data['view'] = 'error404';
			$this->load->view('layout/layout', $data);
		}
	}


	public function yudisium()
	{
		$data['query'] = $this->surat_model->get_surat_yudisium();
		$data['title'] = 'Surat Pendaftaran Yudisium';
		$data['view'] = 'surat/index_yudisium';
		$this->load->view('layout/layout', $data);
	}

	public function acc_yudisium()
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

			if ($this->input->post('rev2') === '6') { // ditolak
				$role = array(3);
				$id_status = 6;
			} else if ($this->input->post('rev2') == 4) { //revisi
				$role = array(3);
				$id_status = 4;	
			} else if ($this->input->post('rev2') == 11) { // acc yudisium
				$role = array(3);		
				$id_status = 12;		
						//set Yudisium
						$yudisium = $this->db->set('user_id', $this->input->post('user_id'))
						->insert('yudisium');
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

			// remove notif yg berkaitan sama surat ini
			$set_notif = $this->db->update('notif', ['dibaca' => date('Y-m-d H:i:s'), 'status' => 1], ['id_surat' => $id_surat, 'role' => $this->session->userdata('role')]);

		if ($set_notif) {
				$this->session->set_flashdata('msg', 'Pendaftaran Yudisium selesai diverifikasi!');
				redirect(base_url('admin/daftaryudisium/detail/' . encrypt_url($id_surat)));
			}
		} else {
			$data['title'] = 'Forbidden';
			$data['view'] = 'restricted';
			$this->load->view('layout/layout', $data);
		}
	}

	public function editfield()
	{

		$id = 	$this->input->post('id');
		$pengajuan_id = 	$this->input->post('pengajuan_id');


		$update_field = $this->db->where(array('id_kat_keterangan_surat' => $id, 'id_surat' => $pengajuan_id))
			->update(
				'keterangan_surat',
				array(
					'value' =>  $this->input->post('valfield'),
					// 'tanggal_edit' => date('Y-m-d h:m:s'),
					'diedit_oleh' =>  $this->session->userdata('user_id'),
				)
			);
		if ($update_field) {
			$data = [
				'status' => 'sukses',
				'id' => $this->input->post('id'),
				'pengajuan_id' => $this->input->post('pengajuan_id'),
				'value' => $this->input->post('valfield'),
			];
		}

		echo json_encode($data);
	}
}
