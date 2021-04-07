<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends Mahasiswa_Controller {
		public function __construct(){
			parent::__construct();
		}

		public function index(){

			$data['title'] = 'Dashboard'; 
			$data['view'] = 'dashboard/index'; 
			$this->load->view('layout/layout', $data);
		}
		
	}
