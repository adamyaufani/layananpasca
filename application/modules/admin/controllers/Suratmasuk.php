<?php defined('BASEPATH') or exit('No direct script access allowed');
class Suratmasuk extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('suratmasuk_model', 'suratmasuk_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->library('mailer');
	}

	public function index($role = 0)
	{
		$data['query'] = $this->suratmasuk_model->get_surat_masuk();
		$data['title'] = 'Arsip Surat Masuk';
		$data['view'] = 'suratmasuk/index';
		$this->load->view('layout/layout', $data);
	}

	public function detail($id_surat = 0)
	{
		$data['query'] = $this->suratmasuk_model->get_detail_surat_masuk($id_surat);
		$data['title'] = 'Detail Surat Masuk';
		$data['view'] = 'suratmasuk/detail';
		$this->load->view('layout/layout', $data);
	}

	/* Surat Masuk */

		//---------------------------------------------------
	// Advanced Search Example
	public function masuk($klien = null){
			
		$data['kategori_surat'] =  $this->suratmasuk_model->get_kategori_surat($klien);
		$data['klien'] =  $klien;

		$prodi = $this->db->select('*')->from('prodi')->get()->result_array();
		$data['prodi'] =  $prodi;

		$this->session->unset_userdata('kategori_surat');
		$this->session->unset_userdata('prodi');
		$this->session->unset_userdata('klien');
	
		$data['title'] = 'Arsip Surat Masuk';
		$data['view'] = 'surat/arsip2';
		$this->load->view('layout/layout', $data);
	}

	//-------------------------------------------------------
	function search_masuk(){

		$kategori_surat = $this->input->post('kategori_surat');
		// $klien = $this->input->post('klien');

	 	$this->session->set_userdata('kategori_surat' ,$this->input->post('kategori_surat'));
		$this->session->set_userdata('prodi' ,$this->input->post('prodi'));
		// $this->session->set_userdata('arsip_search_from',$this->input->post('arsip_search_from'));
		// $this->session->set_userdata('arsip_search_to',$this->input->post('arsip_search_to'));

		// echo "sesi";
		echo json_encode($kategori_surat);	
	}


	//---------------------------------------------------
	// Server-side processing Datatable Example with Advance Search
	public function arsip_masuk_json($klien = null){	

		$records['data'] = $this->suratmasuk_model->get_surat_arsip($klien);
		$data = array();	
		foreach ($records['data']  as $row) 
		{  			
			$data[]= array(
				$row['no_lengkap'],
				$row['tanggal_terbit'],
				$row['fullname'],
				$row['kategori_surat'],
				$row['prodi'],
				$row['instansi'],
				$row['hal'],
				'<a class="btn btn-sm btn-success" href="' . base_url('public/documents/pdfdata/'. $row['file']) . '"><i class="fas fa-file-pdf"></i></a>',				
			);
		}
		$records['data'] = $data;
		echo json_encode($records);	
	}

	public function baru()
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
				'hal',
				'Hal Surat',
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
				'pengirim',
				'Pengirim Surat',
				'trim|required',
				array('required' => '%s wajib diisi.')
			);

			

			if ($this->form_validation->run() == FALSE) {
			
				$data['title'] = 'Tambah Surat Masuk';
				$data['view'] = 'suratmasuk/baru';
				$this->load->view('layout/layout', $data);
			} else {		
			

					echo "tambah"	;
						// kirim notifikasi
					$data = array(
						'no_surat' => $this->input->post('no_surat'),
						'tanggal_surat' => $this->input->post('tanggal_surat'),
						'hal' => $this->input->post('hal'),
						'pengirim' => $this->input->post('pengirim'),
						'file' => $this->input->post('file'),
						'created_at' => date('Y-m-d : h:m:s'),
						
						);
	
						//tambah_surat masuk
	
					$data = $this->security->xss_clean($data);
					$result = $this->suratmasuk_model->tambah($data);

			}
		} else {
      
					$data['title'] = 'Tambah Surat Masuk';
					$data['view'] = 'suratmasuk/baru';
			

				$this->load->view('layout/layout', $data);		
    }
	}


}
