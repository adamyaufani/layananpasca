<?php defined('BASEPATH') or exit('No direct script access allowed');
class Surat extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mahasiswa/surat_model', 'surat_model');
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
	public function internal($role = 0)
	{
		$role = $_SESSION['role'];
		$data['query'] = $this->surat_model->get_surat_internal($role);
		$data['title'] = 'Surat Internal';
		$data['view'] = 'surat/internal';
		$this->load->view('layout/layout', $data);
	}

	public function arsip()
	{
		$data['query'] = $this->surat_model->get_surat_arsip();
		$data['title'] = 'Arsip Surat';
		$data['view'] = 'surat/arsip';
		$this->load->view('layout/layout', $data);
	}
	public function detail($id_surat = 0)
	{

		$id_surat = decrypt_url($id_surat);

		if ($id_surat) {

			$data['status'] = $this->surat_model->get_surat_status($id_surat);
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$data['timeline'] = $this->surat_model->get_timeline($id_surat);

			if ($data['surat']['id_status'] == 9 || $data['surat']['id_status'] == 10 ) {
				$data['no_surat_data'] = $this->surat_model->get_no_surat($id_surat);		
			}

			//cek apakah admin atau pengguna prodi ( admin prodi, tu, kaprodi, kecuali mhs)
			if (($data['surat']['id_prodi'] == $this->session->userdata('id_prodi') && $this->session->userdata('role') !== 1) ||
				$this->session->userdata('role') == 1 || $this->session->userdata('role') == 5
			) {

				$data['title'] = 'Detail Surat';
				$data['view'] = 'surat/detail';
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
				redirect(base_url('admin/surat/detail/' . encrypt_url($id_surat)));
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

					//setelah diacc dir pasca, isi tbl no_surat
					$insert = $this->db->insert('no_surat', ['id_surat'=> $id_surat]);

					//sendmail & notif
					$this->mailer->send_mail($data_notif);

					$this->session->set_flashdata('msg', 'Surat sudah diberi persetujuan oleh Direktur Pascasarjana!');
					redirect(base_url('admin/surat/detail/' . encrypt_url($id_surat)));
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
					redirect(base_url('admin/surat/detail/' . encrypt_url($id_surat)));
				}
			}
		}
	}

	public function pratinjau()
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
			$this->form_validation->set_rules(
				'hal',
				'hal',
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

				$stempel_basah = $this->input->post('stempel_basah');
				$id_kategori_surat = $this->input->post('id_kategori_surat');
				$no_surat = $this->input->post('no_surat');
				$kat_tujuan_surat = $this->input->post('kat_tujuan_surat');
				$tujuan_surat = $this->input->post('tujuan_surat');
				$urusan_surat = $this->input->post('urusan_surat');
				$date = date('Y-m-d');
				$tanggal_surat = date("d F Y", strtotime($date));
				$no_surat =	 $this->surat_model->generate_no_surat($no_surat, $kat_tujuan_surat, $tujuan_surat, $urusan_surat, $date);	

				$pratinjau = array(
					'stempel_basah' => $stempel_basah,
				//	'id_surat' => $id_surat,
					'id_user' => $this->input->post('user_id'),
					'id_prodi' => $this->input->post('id_prodi'),
					'id_kategori_surat' => $id_kategori_surat,
					'no_surat' => $no_surat,
					'kat_tujuan_surat' => $kat_tujuan_surat,
					'tujuan_surat' => $tujuan_surat,
					'urusan_surat' => $urusan_surat,
					'tembusan' => $this->input->post('tembusan'),					
					'instansi' => $this->input->post('instansi'),
					'lamp' => $this->input->post('lamp'),
					'hal' => $this->input->post('hal'),
					'tanggal_terbit' => $date,
					'no_lengkap' => $no_surat,
				);
				
				$update = $this->db->update('no_surat', $pratinjau, array('id_surat' => $id_surat));
					
	
				$data['pratinjau'] = $pratinjau;
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['no_surat'] = $no_surat;
				$data['tanggal_surat'] = $tanggal_surat;
	

				if($update) {

					$data['title'] = 'Pratinjau Surat';
					$data['view'] = 'surat/pratinjau_surat';
				} else {
					$data['title'] = 'Terjadi kesalahan';
					$data['view'] = 'surat/pratinjau_surat_error';
				}

				$this->load->view('layout/layout', $data);			

			}
		}
	}

	public function terbitkan_surat($id_surat)
	{

		$id_surat = decrypt_url($id_surat);

			if ($id_surat) {
			
			 $no_surat = $this->surat_model->get_no_surat($id_surat);			 
				
				if ($no_surat) {

					$this->load->library('ciqrcode');

					$params['data'] = base_url('validasi/cekvalidasi/' . encrypt_url($id_surat));
					$params['level'] = 'L';
					$params['size'] = 2;
					$params['savename'] = FCPATH . "public/documents/tmp/" . $id_surat . '-qr.png';
					$this->ciqrcode->generate($params);

					$mpdf = new \Mpdf\Mpdf([
						'tempDir' => 'public/documents/pdfdata',
						'mode' => 'utf-8',
						// 'format' => [24, 24],
						'format' => 'A4',
						'margin_left' => 0,
						'margin_right' => 0,
						'margin_footer' => 0,
						'margin_bottom' => 40,
						'margin_top' => 20,
						'float' => 'left',
						'setAutoTopMargin' => 'stretch'
					]);

					$data['pratinjau'] = $no_surat;
					$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
					$data['no_surat'] = $no_surat['no_lengkap'];
					$data['tanggal_surat'] = date("d F Y", strtotime($no_surat['tanggal_terbit']));

				if($data['surat']['kode'] == 'SU') {
					$kategori = $no_surat['hal'];
				} else {
					$kategori = $data['surat']['kategori_surat'];
				}

					$nim = $data['surat']['username'];

					$filename = strtolower(str_replace(' ', '-', $kategori) . '-' . $nim . '-' . date('Y-m-d') . '-' . $id_surat . '.pdf');

					$edit_nosurat = array(
						'file' => $filename,
					);
					$this->db->update('no_surat', $edit_nosurat, array('id' => $no_surat['id']));

					$view = $this->load->view('surat/tampil_surat', $data, TRUE);
					$data['view'] = 'surat/tampil_surat';		

					$now = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
					$now->setTimezone(new DateTimeZone('Asia/Jakarta'));    // Another way
				

					$mpdf->SetHTMLHeader('
					<div style="text-align: left; margin-left:85px;margin-bottom:20px;">
							<img width="390" height="" src="' . base_url() . '/public/dist/img/logokop-pasca.jpg" />
					</div>');
					$mpdf->SetHTMLFooter('
			
					<div class="futer">
						<table style="width:100%">
							<tr>
								<td style="width:85%; vertical-align:bottom; padding-bottom:9px;"><p style="text-align:left; font-size:7pt;font-style:italic;">Digenerate oleh Sistem Layanan Pascasarjana UMY pada tanggal ' . $now->format("d-m-Y H:i") . '</p></td>
								<td style="text-align:right;padding-bottom:40px;"><img src="' . base_url('public/documents/tmp/') . $id_surat . '-qr.png" /></td>
							</tr>
						</table>					
					</div>');

					$mpdf->WriteHTML($view);

					$mpdf->Output(FCPATH . 'public/documents/pdfdata/' . $filename, 'F');				

					$this->db->set('id_status', 10)
						->set('date', 'NOW()', FALSE)
						->set('id_surat', $id_surat)
						->set('pic', $data['pratinjau']['id_user'])
						->insert('surat_status');

					$data_notif = array(
						'id_surat' => $id_surat,
						'id_status' => 10,
						'kepada' => $data['pratinjau']['id_user'],
						'role' => array(3)
					);

					//sendmail & notif
					$this->mailer->send_mail($data_notif);

					$this->session->set_flashdata('msg', 'Surat berhasil diterbitkan!');
					redirect(base_url('admin/surat/detail/' . encrypt_url($id_surat)));
				
			}
		}
	}

	public function get_tujuan_surat()
	{
		$kat_tujuan = $this->input->post('kat_tujuan_surat');
		$data = $this->db->query("SELECT * FROM tujuan_surat WHERE id_kat_tujuan_surat = $kat_tujuan")->result_array();
		echo json_encode($data);
	}


	/* 
	Pengajuan Susrat oleh Admin Pasca */

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

		// echo '<pre>';
		// print_r($kat_surat['kat_keterangan_surat']);
		// echo '</pre>';
		// foreach keterangan surat, lalu masukkan nilai awal (nilai kosong) berdasakan keterangan dari kategori surat
		if ($kat_surat) {
			$unserial = unserialize($kat_surat['kat_keterangan_surat']);

			foreach ($unserial as $row) {

				$this->db->insert(
					'keterangan_surat',
					array(
						'value' => '',
						'id_surat' =>  $insert_id2['id_surat'],
						'id_kat_keterangan_surat' => $row['id'],
					)
				);
			}
		}

		$data_notif = array(
			'id_surat' => $insert_id2['id_surat'],
			'id_status' => 1,
			'kepada' => $_SESSION['user_id'],
			'role' => array(3)
		);

		$results = $this->notif_model->send_notif($data_notif);

		if ($results) {
			$this->session->set_flashdata('msg', 'Berhasil!');
			redirect(base_url('admin/surat/tambah/' . encrypt_url($insert_id)));
		}
	}

	public function tambah($id_surat = 0)
	{
		$id_surat = decrypt_url($id_surat);

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
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('p');
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
					$id_status = 8;
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
						'id_status' => 8,
						'kepada' => $_SESSION['user_id'],
						'role' => array(5) // harus dalam bentuk array
					);

					//sendmail & notif
					$this->mailer->send_mail($data_notif);

					// hapus notifikasi "Lengkapi dokumen"
					$set_status = $this->db->set('status', 1)
						->set('dibaca', 'NOW()', FALSE)
						->where(array('id' => $id_notif, 'status' => 0))
						->update('notif');

					if ($set_status) {
						redirect(base_url('admin/surat/tambah/' . encrypt_url($id_surat)));
					}
				}
			}
		} else {

			if ($id_surat) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('p');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);

				if ($data['surat']['id_status'] == 10) {
					$data['no_surat_final'] = $this->surat_model->get_no_surat($id_surat);
				}

				if ($data['surat']['id_mahasiswa'] == $this->session->userdata('user_id')) {
					$data['title'] = 'Ajukan Surat';
					$data['view'] = 'surat/tambah';
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
	}
}
