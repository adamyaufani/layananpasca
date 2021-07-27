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
	}

	public function index()
	{
		$data['notif'] = $this->dashboard_model->notif();
		$data['juml_surat'] = $this->dashboard_model->for_graph('11');

		echo '<pre>'; print_r($data['juml_surat']->result_array()); echo '</pre>';
	//	$data['survey'] = $this->survey_model->get_surveys();
		$data['title'] = 'Dashboard';
		$data['view'] = 'dashboard/index';
		$this->load->view('layout/layout', $data);
	}

}
