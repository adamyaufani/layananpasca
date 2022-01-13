<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
	 $this->load->model('dashboard_model', 'dashboard_model');		
	//	$this->load->model('survey/survey_model', 'survey_model');		
		$this->load->model('mahasiswa/surat_model', 'surat_model');		
	}

	public function index()
	{
		$data['notif'] = $this->dashboard_model->notif();
		$data['juml_surat'] = $this->dashboard_model->for_graph('11');

		
		$data['total_surat'] = $this->surat_model->get_surat_arsip('');

	//	$data['survey'] = $this->survey_model->get_surveys();
		$data['title'] = 'Dashboard';
		$data['view'] = 'dashboard/index';
		$this->load->view('layout/layout', $data);
	}

}
