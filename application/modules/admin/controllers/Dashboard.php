<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('dashboard_model', 'dashboard_model');
	}

	public function index()
	{
		$data['notif'] = $this->dashboard_model->notif();
		$data['juml_surat'] = $this->dashboard_model->for_graph(10);
		$data['title'] = 'Dashboard';
		$data['view'] = 'dashboard/index';
		$this->load->view('layout/layout', $data);
	}

	public function sendmail() {

		$penerima = ['yaufani@gmail.com','yaufaniadam@gmail.com','yaufaniadam@yahoo.com'];

		echo $sendmail = $this->mailer->send_mail($penerima, 'tugas ppdsasd', 'ppds mengunggah tugas baru', '');
		

	}
}
