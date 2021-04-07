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
		$id_surat = decrypt_url($id_surat);
		$data['title'] = 'Tampil Surat';
		$data['surat'] = $this->surat_model->get_detail_surat($id_surat);
		$data['no_surat'] = $this->surat_model->get_no_surat($id_surat);
		$kategori = $data['surat']['kategori_surat'];
		$nim = $data['surat']['username'];

		//$this->load->view('admin/surat/tampil_surat', $data);

		$mpdf = new \Mpdf\Mpdf([
			'tempDir' => __DIR__ . '/pdfdata',
			'mode' => 'utf-8',
			// 'format' => [24, 24],
			'format' => 'A4',
			'margin_left' => 0,
			'margin_right' => 0,
			'margin_bottom' => 20,
			'margin_top' => 30,
			'float' => 'left'
		]);

		$view = $this->load->view('generatesurat/tampil_surat', $data, TRUE);

		$mpdf->SetHTMLHeader('
		<div style="text-align: left; margin-left:2cm">
				<img width="390" height="" src="' . base_url() . '/public/dist/img/logokop-pasca.jpg" />
		</div>');
		$mpdf->SetHTMLFooter('

		<div style="text-align:center; background:red;">
			<img width="" height="" src="' . base_url() . '/public/dist/img/footerkop-pasca.jpg" />
		</div>');

		$mpdf->WriteHTML($view);

		$mpdf->Output('Surat-' . $kategori . '-' . $nim . '.pdf', 'D');
	}

}
