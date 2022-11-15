<?php defined('BASEPATH') or exit('No direct script access allowed');
class Surat extends Mahasiswa_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('surat_model', 'surat_model');
		$this->load->model('survey/survey_model', 'survey_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->helper('date');
		$this->load->model('admin/template_model', 'template_model');
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
		$data['title'] = $data['surat']['id_mahasiswa'];
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
		$kat_surat = $this->db->select('*')->from('kat_keterangan_surat')->where(['id_kategori_surat' => $id, 'aktif' => 1])->get()->result_array();

		if ($kat_surat) {

			foreach ($kat_surat as $row) {

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

		// $data_notif = array(
		// 	'id_surat' => $insert_id2['id_surat'],
		// 	'id_status' => 1,
		// 	'kepada' => $_SESSION['user_id'],
		// 	'role' => array(3)
		// );

		// $results = $this->notif_model->send_notif($data_notif);

		// if ($results) {
			// $this->session->set_flashdata('msg', 'Berhasil!');
			if($id == 6) {
				redirect(base_url('mahasiswa/surat/daftar_yudisium/' . encrypt_url($insert_id)));
			} else {
				redirect(base_url('mahasiswa/surat/tambah/' . encrypt_url($insert_id)));
			}
			
		// }
	}


	public function tambah($id_surat = 0)
	{
		$id_surat = decrypt_url($id_surat);
		$this->load->model('admin/template_model', 'template_model');

		$id_notif = $this->input->post('id_notif');

		if ($this->input->post('submit')) {

		$surat =	$this->surat_model->get_detail_surat($id_surat);

			$pengajuan_fields = $this->db->query(
				"SELECT * FROM kat_keterangan_surat kks
				WHERE kks.id_kategori_surat = " . $surat['id_kategori_surat'] . "
				AND kks.aktif = 1 
				ORDER BY urutan ASC"
			)->result_array();

			// generate validation
			foreach ($pengajuan_fields as $pengajuan_field) {
				//cek apakah field ini wajib
				//jika wajib
				if ($pengajuan_field['required'] == 1) {

					if ($pengajuan_field['type'] == 'url') {
						$callback = '|callback_url_check';
					} else {
						$callback = '';
					}

					$this->form_validation->set_rules(
						'dokumen[' . $pengajuan_field['id'] . ']',
						$this->getNamaField($pengajuan_field['id']),
						'trim|required' . $callback,
						[
							'required' => '%s wajib diisi!'
						]

					);
				} else {

					//jika tidak wajib, jika field typenya url, tetap dicek utk memeriksa urlnya benar atau salah
					if ($pengajuan_field['type'] == 'url') {


						$this->form_validation->set_rules(
							'dokumen[' . $pengajuan_field['id'] . ']',
							$this->getNamaField($pengajuan_field['id']),
							'trim|callback_url_check_notrequired',

						);
					}
				}
			}

			if ($this->form_validation->run() == FALSE) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
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

						echo $dokumen;
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
						'role' => array(2) // harus dalam bentuk array
					);

					//sendmail & notif
					$this->mailer->send_mail($data_notif);

					// hapus notifikasi "Lengkapi dokumen"
					$set_status = $this->db->set('status', 1)
						->set('dibaca', 'NOW()', FALSE)
						->where(array('id' => $id_notif, 'status' => 0))
						->update('notif');

					if ($set_status) {
						redirect(base_url('mahasiswa/surat/tambah/' . encrypt_url($id_surat)));
					}
				}
			}
		} else {

			if ($id_surat) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);
				$data['template'] = $this->template_model->get_template_bykat($data['surat']['id_kategori_surat']);

				//menghapus notifikasi
				$notif = $this->notif_model->get_notif_by_surat($id_surat);
				if ($notif) {
					foreach ($notif as $notif) {
						$this->notif_model->notif_read($notif['id'], $id_surat);
					}
				}

				if ($data['surat']['id_status'] == 10) {
					$data['no_surat_final'] = $this->surat_model->get_no_surat($id_surat);

					//cek apakah sudah mengisi survey
					$survey = $this->survey_model->get_survey($id_surat, $_SESSION['user_id']);
					if ($survey) {
						$data['sudah_survey'] = 1;
						$data['hasil_survey'] = $survey;
					} else {
						$data['sudah_survey'] = 0;
					}
				}

				if (($data['surat']['id_mahasiswa'] == $this->session->userdata('user_id')) || $this->session->userdata('role') == 2) {
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

	public function daftar_yudisium($id_surat = 0)
	{
		$id_surat = decrypt_url($id_surat);
		$this->load->model('admin/template_model', 'template_model');

		$id_notif = $this->input->post('id_notif');

		if ($this->input->post('submit')) {

			// echo $this->input->post('revisi'); die;

		$surat =	$this->surat_model->get_detail_surat($id_surat);

			$pengajuan_fields = $this->db->query(
				"SELECT * FROM kat_keterangan_surat kks
				WHERE kks.id_kategori_surat = " . $surat['id_kategori_surat'] . "
				AND kks.aktif = 1 
				ORDER BY urutan ASC"
			)->result_array();

			// generate validation
			foreach ($pengajuan_fields as $pengajuan_field) {
				//cek apakah field ini wajib
				//jika wajib
				if ($pengajuan_field['required'] == 1) {

					if ($pengajuan_field['type'] == 'url') {
						$callback = '|callback_url_check';
					} else {
						$callback = '';
					}

					$this->form_validation->set_rules(
						'dokumen[' . $pengajuan_field['id'] . ']',
						$this->getNamaField($pengajuan_field['id']),
						'trim|required' . $callback,
						[
							'required' => '%s wajib diisi!'
						]

					);
				} else {

					//jika tidak wajib, jika field typenya url, tetap dicek utk memeriksa urlnya benar atau salah
					if ($pengajuan_field['type'] == 'url') {


						$this->form_validation->set_rules(
							'dokumen[' . $pengajuan_field['id'] . ']',
							$this->getNamaField($pengajuan_field['id']),
							'trim|callback_url_check_notrequired',

						);
					}
				}
			}

			if ($this->form_validation->run() == FALSE) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);				

				$data['title'] = 'Daftar Yudisium';
				$data['view'] = 'surat/daftar_yudisium';
				$this->load->view('layout/layout', $data);
			} else {

				//cek dulu apakah ini surat baru atau surat revisi
				if ($this->input->post('revisi') == 1) {
					$id_status = 11;
				} else {
					$id_status = 3;
				}

				echo $id_status; 


				//tambah status ke tb surat_status
				$insert = $this->db->set('id_surat', $id_surat)
					->set('id_status', $id_status) //tunggu acc pasca
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
						'id_status' => $id_status,
						'kepada' => $_SESSION['user_id'],
						'role' => array(1) // harus dalam bentuk array
					);
					

					//sendmail & notif
					$mail = $this->mailer->send_mail($data_notif);

					redirect(base_url('mahasiswa/surat/daftar_yudisium/' . encrypt_url($id_surat)));


					if ($mail) {
						
					}
				}
			}
		} else {

			if ($id_surat) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);
				$data['template'] = $this->template_model->get_template_bykat($data['surat']['id_kategori_surat']);

				//menghapus notifikasi
				$notif = $this->notif_model->get_notif_by_surat($id_surat);
				if ($notif) {
					foreach ($notif as $notif) {
						$this->notif_model->notif_read($notif['id'], $id_surat);
					}
				}


				if (($data['surat']['id_mahasiswa'] == $this->session->userdata('user_id')) || $this->session->userdata('role') == 2) {
					$data['title'] = 'Ajukan Surat';
					$data['view'] = 'surat/daftar_yudisium';
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

	public function hapus_file()
	{
		$id = $_POST['id'];
		$media = $this->db->get_where('media', array('id' => $id))->row_array();
		$exist = is_file($media['thumb']);

		if ($media['thumb']) {
			if (is_file($media['thumb'])) {
				unlink($media['thumb']);
				$thumb = 'deleted';
			}
		}
		if ($media['file']) {
			if (is_file($media['file'])) {
				unlink($media['file']);
				$file = 'deleted';
			}
		}

		$hapus = $this->db->delete('media', array('id' => $id));
		// if ($hapus) {
		echo json_encode(array(
			"statusCode" => 200,
			"id" => $file,
			'thumb' => ($media['thumb']) ? $thumb : 'gada',
			'file' => ($media['file']) ? $file : 'gada',
			// 'hapus' => $hapus
		));
		//}
	}

	
	public function cetak_surat($id_surat)
	{
		$id_surat = decrypt_url($id_surat);
		$data['header'] = 'header';

		if ($id_surat) {
			$surat_terbit = $this->surat_model->get_no_surat($id_surat);
			$data['pratinjau'] = $surat_terbit;
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$tgl_surat = date("Y-m-j", strtotime($surat_terbit['tanggal_terbit']));
			$data['tanggal_surat'] = tgl_indo($tgl_surat);
			$data['template_surat'] = $this->template_model->get_template_byid($data['pratinjau']['template_surat']);
			$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
			
			//qrcode
			$this->load->library('ciqrcode');
			$params['data'] = base_url('validasi/cekvalidasi/' . encrypt_url($id_surat));
			$params['level'] = 'L';
			$params['size'] = 2;
			$params['savename'] = FCPATH . "public/documents/tmp/" . $id_surat . '-qr.png';
			$this->ciqrcode->generate($params);

			if ($data['surat']['kode'] == 'SU') {
				$kategori = $surat_terbit['hal'];
			} else {
				$kategori = $data['surat']['kategori_surat'];
			}

			$nim = $data['surat']['username'];

			$filename = strtolower(str_replace(' ', '-', $kategori) . '-' . $nim . '-' . date('Y-m-j') . '-' . $id_surat);

			$edit_nosurat = array(
				'file' => $filename . '.pdf',
			);
			$this->db->update('no_surat', $edit_nosurat, array('id' => $surat_terbit['id']));

			$now = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
			$now->setTimezone(new DateTimeZone('Asia/Jakarta'));    // Another way

			$view = $this->load->view('admin/surat/tampil_surat', $data, TRUE);
			// $this->load->view('surat/tampil_surat', $data);

				$mpdf = new \Mpdf\Mpdf([
					'tempDir' => 'public/documents/pdfdata',
					'mode' => 'utf-8',
					'format' => 'A4',
					'margin_left' => 0,
					'margin_right' => 0,
					'margin_footer' => 4,
					'margin_bottom' => 40,
					'margin_top' => 0,
					'float' => 'left',
					'setAutoTopMargin' => 'stretch'
				]);


				$mpdf->SetHTMLHeader('
				<div style="text-align: left; margin-left:85px;margin-bottom:10px;">
						<img width="390" height="" src="' . base_url() . '/public/dist/img/logokop-pasca.jpg" />
				</div>');

				$mpdf->SetHTMLFooter('		
				<div class="futer">
				<p>Digenerate oleh Sistem Layanan Pascasarjana UMY pada tanggal ' . $now->format("d-m-Y H:i") . '</p>				
				</div>');



				$mpdf->WriteHTML($view);

				$mpdf->Output($filename . '.pdf', 'D');
			
		}
	}
	
	public function cetak_surat_lama($id_surat)
	{
		$id_surat = decrypt_url($id_surat);

		if ($id_surat) {
			$surat_terbit = $this->surat_model->get_no_surat($id_surat);
			$data['pratinjau'] = $surat_terbit;
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$tgl_surat = date("Y-m-j", strtotime($surat_terbit['tanggal_terbit']));
			$data['tanggal_surat'] = tgl_indo($tgl_surat);
			// $data['template_surat'] = $this->template_model->get_template_byid($data['pratinjau']['template_surat']);
			$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
			$data['no_surat'] = $surat_terbit['no_lengkap'];

			//qrcode
			$this->load->library('ciqrcode');
			$params['data'] = base_url('validasi/cekvalidasi/' . encrypt_url($id_surat));
			$params['level'] = 'L';
			$params['size'] = 2;
			$params['savename'] = FCPATH . "public/documents/tmp/" . $id_surat . '-qr.png';
			$this->ciqrcode->generate($params);

			if ($data['surat']['kode'] == 'SU') {
				$kategori = $surat_terbit['hal'];
			} else {
				$kategori = $data['surat']['kategori_surat'];
			}

			$nim = $data['surat']['username'];

			$filename = strtolower(str_replace(' ', '-', $kategori) . '-' . $nim . '-' . date('Y-m-j') . '-' . $id_surat);

			$edit_nosurat = array(
				'file' => $filename . '.pdf',
			);
			$this->db->update('no_surat', $edit_nosurat, array('id' => $surat_terbit['id']));

			$now = new DateTime(null, new DateTimeZone('Asia/Jakarta'));
			$now->setTimezone(new DateTimeZone('Asia/Jakarta'));    // Another way

			$view = $this->load->view('admin/surat/tampil_surat_lama', $data, TRUE);
			// $this->load->view('surat/tampil_surat', $data);

				$mpdf = new \Mpdf\Mpdf([
					'tempDir' => 'public/documents/pdfdata',
					'mode' => 'utf-8',
					'format' => 'A4',
					'margin_left' => 0,
					'margin_right' => 0,
					'margin_footer' => 4,
					'margin_bottom' => 40,
					'margin_top' => 0,
					'float' => 'left',
					'setAutoTopMargin' => 'stretch'
				]);


				$mpdf->SetHTMLHeader('
				<div style="text-align: left; margin-left:85px;margin-bottom:10px;">
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

				$mpdf->Output($filename . '.pdf', 'D');
			
		}
	}


	public function doupload()
	{
		header('Content-type:application/json;charset=utf-8');
		$upload_path = 'uploads/dokumen'; // folder tempat menyimpan file yang diupload

		// cek, jika upload path belum ada, maka buat folder
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, TRUE);
		}

		// konfigurasi upload
		$config = array(
			'upload_path' => $upload_path,
			'allowed_types' => "jpg|png|jpeg|pdf",
			'overwrite' => FALSE,
		);
		//panggil library upload
		$this->load->library('upload', $config);

		//cek jika file gagal diupload
		if (!$this->upload->do_upload('file')) {
			//tampilkan pesan error
			$error = array('error' => $this->upload->display_errors());

			//kirim pesan error dalam format json
			echo json_encode([
				'status' => 'error',
				'message' => $error
			]);

			// jika file berhasil diupload
		} else {
			//masukkan hasil upload ke variabel $data
			$data = $this->upload->data();

			//cek file type apakah image atau bukan image
			//format file_type, contoh 'image/jpeg', 'application/pdf'
			$ext = explode('/', $data['file_type']);
			if ($ext[0] == 'image') {
				//jika image, maka file akan dibuatkan thumbnailnya
				$thumb = $this->_create_thumbs($data['file_name']);
				$thumb = $upload_path . '/' . $data['raw_name'] . '_thumb' . $data['file_ext'];
			} else {
				//jika bukan gambar, maka $thumb = '' (kosong)
				$thumb = '';
			}

			// insert file ke table 'media'
			$result = $this->db->insert(
				'media',
				array(
					'id_user' => $this->session->userdata('user_id'),
					'file' =>  $upload_path . '/' . $data['file_name'],
					'thumb' =>  $thumb,
					'extension' =>  $data['file_ext']
				)
			);

			//output dalam bentuk json
			echo json_encode([
				'status' => 'Ok',
				'id' => $this->db->insert_id(),
				'extension' =>  $data['file_ext'],
				'thumb' =>  $thumb,
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
		$image_config['quality'] = "90%";
		$image_config['width'] = 100;
		$image_config['height'] = 100;
		$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
		$image_config['master_dim'] = ($dim > 0) ? "height" : "width";

		$this->load->library('image_lib');
		$this->image_lib->initialize($image_config);

		if (!$this->image_lib->resize()) { //Resize image
			redirect("errorhandler"); //If error, redirect to an error page
		}
	}

	public function getPembimbing()
	{
		$search = $this->input->post('search');
		$result_anggota = $this->surat_model->getPembimbing($search);

		foreach ($result_anggota as $anggota) {
			$selectajax[] = [
				'value' => $anggota['id_pegawai'],
				'id' => $anggota['id_pegawai'],
				'text' => $anggota['nama']
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
		}
	}
	public function getmahasiswa()
	{
		$search = $this->input->post('search');
		$result_anggota = $this->surat_model->getMahasiswa($search);

		foreach ($result_anggota as $anggota) {
			$selectajax[] = [
				'value' => $anggota['STUDENTID'],
				'id' => $anggota['STUDENTID'],
				'text' => $anggota['FULLNAME'] . " -- " . $anggota['STUDENTID'] . " -- " . $anggota['name_of_department']
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($selectajax));
		}
	}

	public function feedback($id)
	{

		$survey = $this->survey_model->get_survey($id);

		if (!$survey) {

			$insert = $this->db->set('surat_id', $id)
				->set('user_id', $this->session->userdata('user_id'))
				->set('answer', $this->input->post('answer'))
				->set('created_at', 'NOW()', FALSE)
				->insert('surveys');

			if ($insert) {
				$status = "sukses";
			} else {
				$status = 'error';
			}
			echo json_encode(array("status" => $status, "answer" => $this->input->post('answer')));
		} else {
			echo json_encode(array("status" => 'sudah'));
		}
	}


	//dibuat untuk membypass proses entry data yudisium mahasiswa

	public function yudisium()
	{

		if ($this->input->post('submit')) {

			$this->form_validation->set_rules(
				'pilih_mhs',
				'Mahasiswa',
				'trim|required',
				array('required' => '%s wajib dipilih.')
			);


			if ($this->form_validation->run() == FALSE) {
				$data['title'] = 'Tambah Data Yudisium';
				$data['view'] = 'surat/yudisium';

				$this->load->view('layout/layout', $data);
			} else {

				$nim = $this->input->post('pilih_mhs');

				//load model auth
				$this->load->model('auth/auth_model', 'auth_model');

				// cek user ke tabel Mhs (SQLSERVER UMY)
				$db2 = $this->load->database('dbsqlsrv', TRUE);

				$data_mhs = $db2->query("SELECT * from V_Simpel_Pasca WHERE STUDENTID = '$nim' AND department_id =" . $_SESSION['id_prodi'])->row_array();

				$data = ['username' => $data_mhs['EMAIL']];
				$mhs_exist = $this->auth_model->user_exist($data);

				// jik mhs tidak ada maka buat dulu di table user
				if (!$mhs_exist) {
					$user_data = array(
						'username' => $data_mhs['STUDENTID'],
						'fullname' => $data_mhs['FULLNAME'],
						'email' => (isset($data_mhs['EMAIL'])) ? $data_mhs['EMAIL'] : '',
						'telp' => $data_mhs['TELP'],
						'id_prodi' => $data_mhs['department_id'],
						'role' => 3,
						'created_at' => date('Y-m-d : h:m:s'),
					);

					//inset into database
					$this->auth_model->register($user_data);
					$mhs_exist = $this->db->insert_id();
				}

				$data = array(
					'id_kategori_surat' => 6,
					'id_mahasiswa' => $mhs_exist,
				);

				//tambah surat
				$data = $this->security->xss_clean($data);
				$tambah = $this->surat_model->tambah($data);

				$insert_id = $this->db->insert_id();
				// set status surat
				$this->db->set('id_surat', $insert_id)
					->set('id_status', 1)
					->set('pic', $mhs_exist)
					->set('date', 'NOW()', FALSE)
					->insert('surat_status');

				//ambil id surat berdasarkan last id status surat
				$insert_id2 = $this->db->select('id_surat')->from('surat_status')->where('id=', $this->db->insert_id())->get()->row_array();
				// ambil keterangan surat berdasar kategori surat
				$kat_surat = $this->db->select('*')->from('kat_keterangan_surat')->where(['id_kategori_surat' => 6, 'aktif' => 1])->get()->result_array();

				if ($kat_surat) {

					foreach ($kat_surat as $row) {

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

				$this->session->set_flashdata('msg', 'Berhasil!');
				redirect(base_url('mahasiswa/surat/tambah_by_admin/' . encrypt_url($insert_id) . '/' . $mhs_exist));
			}
		} else {

			$data['title'] = 'Tambah Data Yudisium';
			$data['view'] = 'surat/yudisium';

			$this->load->view('layout/layout', $data);
		}
	}

	public function tambah_by_admin($id_surat = 0, $id_mhs)
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
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);

				$data['title'] = 'Ajukan Surat';
				$data['view'] = 'surat/tambah';
				$this->load->view('layout/layout', $data);
			} else {

				//tambah status ke tb surat_status
				$insert = $this->db->set('id_surat', $id_surat)
					->set('id_status', 7) // sudah diapprove admin TU
					->set('pic', $id_mhs)
					->set('date', 'NOW()', FALSE)
					->insert('surat_status');

				//insert field ke tabel keterangan_surat
				if ($insert) {
					foreach ($this->input->post('dokumen') as $id => $dokumen) {
						$this->db->where(array('id_kat_keterangan_surat' => $id, 'id_surat' => $id_surat));
						$this->db->update(
							'keterangan_surat',
							array(
								'value' => $dokumen,
								'verifikasi' => 1

							)
						);
					}

					// // kirim notifikasi
					// $data_notif = array(
					// 	'id_surat' => $id_surat,
					// 	'id_status' => 2,
					// 	'kepada' => $_SESSION['user_id'],
					// 	'role' => array(2) // harus dalam bentuk array
					// );

					//sendmail & notif
					// $this->mailer->send_mail($data_notif);

					// hapus notifikasi "Lengkapi dokumen"
					$set_status = $this->db->set('status', 1)
						->set('dibaca', 'NOW()', FALSE)
						->where(array('id' => $id_notif, 'status' => 0))
						->update('notif');

					if ($set_status) {
						redirect(base_url('admin/surat/detail/' . encrypt_url($id_surat) . '/' . $id_mhs));
					}
				}
			}
		} else {

			if ($id_surat) {
				$data['kategori_surat'] = $this->surat_model->get_kategori_surat('m');
				$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['surat']['id_kategori_surat']);
				$data['timeline'] = $this->surat_model->get_timeline($id_surat);

				//menghapus notifikasi
				$notif = $this->notif_model->get_notif_by_surat($id_surat);
				if ($notif) {
					foreach ($notif as $notif) {
						$this->notif_model->notif_read($notif['id'], $id_surat);
					}
				}

				if (($data['surat']['id_mahasiswa'] == $this->session->userdata('user_id')) || $this->session->userdata('role') == 2) {
					$data['title'] = 'Ajukan Surat';
					$data['view'] = 'surat/tambah_by_admin';
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

	private function getNamaField($id_field)
	{
		$this->db->select('*');
		$this->db->from('kat_keterangan_surat');
		$this->db->where('id', $id_field);
		$result = $this->db->get()->row_array();
		return $result['kat_keterangan_surat'];
	}

	
	function url_check($str)
	{


		$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
		if ($str != '') {
			if (!preg_match($pattern, $str)) {
				$this->form_validation->set_message('url_check', 'Format URL tidak valid. Contoh format URL yang benar: http://pascasarjana.umy.ac.id atau https://pascasarjana.umy.ac.id');
				return false;
			} else {
				return true;
			}
		} else {
			$this->form_validation->set_message('url_check', 'URL tidak boloh kosong');
			return false;
		}
	}
	function url_check_notrequired($str)
	{


		$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
		if ($str != '') {
			if (!preg_match($pattern, $str)) {
				$this->form_validation->set_message('url_check_notrequired', 'Format URL tidak valid. Contoh format URL yang benar: http://pascasarjana.umy.ac.id atau https://pascasarjana.umy.ac.id');
				return false;
			} else {
				return true;
			}
		} else {

			return true;
		}
	}


}
