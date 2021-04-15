<?php defined('BASEPATH') or exit('No direct script access allowed');
class Generatesurat extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('admin/surat_model', 'surat_model');
		$this->load->model('notif/Notif_model', 'notif_model');
		$this->load->helper('date');
	}

	public function index($id_surat = 0)
	{
		$decrypt = decrypt_url($id_surat);
		$data['title'] = 'Tampil Surat';
		$data['surat'] = $this->surat_model->get_detail_surat($decrypt);
		$data['no_surat'] = $this->surat_model->get_no_surat($decrypt);
		$kategori = $data['surat']['kategori_surat'];
		$nim = $data['surat']['username'];

		//$this->load->view('admin/surat/tampil_surat', $data);

		$this->load->library('ciqrcode');

		$params['data'] = base_url('generatesurat/validasi/'. $id_surat);
		$params['level'] = 'L';
		$params['size'] = 2;
		$params['savename'] = FCPATH. $decrypt.'-qr.png';
		$this->ciqrcode->generate($params);


		$mpdf = new \Mpdf\Mpdf([
			'tempDir' => __DIR__ . '/pdfdata',
			'mode' => 'utf-8',
			// 'format' => [24, 24],
			'format' => 'A4',
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_footer' => 0,
			'margin_top' => 0,
			'float' => 'left',
			'setAutoTopMargin' => 'stretch'
		]);

		$view = $this->load->view('generatesurat/tampil_surat', $data, TRUE);

		$mpdf->SetHTMLHeader('
		<div style="text-align: left; margin-left:2cm">
				<img width="390" height="" src="' . base_url() . '/public/dist/img/logokop-pasca.jpg" />
		</div>');
		$mpdf->SetHTMLFooter('

		<div class="futer">
		<img src="'.base_url(). $decrypt.'-qr.png" />
		</div>');

		$mpdf->WriteHTML($view);

		$mpdf->Output('Surat-' . $kategori . '-' . $nim . '.pdf', 'D');
	}
	
	public function validasi($id_surat = 0)
	{
		$id_surat = decrypt_url($id_surat);

		
		$data['title'] = 'Tampil Surat';
		if($id_surat) { 
			$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
			$data['no_surat'] = $this->surat_model->get_no_surat($id_surat);
			$kategori = $data['surat']['kategori_surat'];
			$nim = $data['surat']['username'];
			$this->load->view('generatesurat/validasi', $data);
		} else {
			$this->load->view('generatesurat/invalid', $data);
		}

		
	}
}
