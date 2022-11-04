<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Templatesurat extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/template_model', 'template_model');
		$this->load->model('mahasiswa/surat_model', 'surat_model');
	}

	public function index()
	{
		$data['query'] = $this->template_model->get_template();
		$data['title'] = 'Template Surat';
		// $data['view'] = 'templatesurat/index';
		// $this->load->view('layout/layout', $data);

    echo '<pre>'; print_r($data['query']); echo '</pre>';
	}

	public function tambah()
	{
		if ($this->input->post('submit')) {

			echo "submit";

			$data = array(
				'id_kategori_surat' =>$this->input->post('id_kategori_surat')
			);

			$this->template_model->tambah_template_surat($data);
			$last_id = $this->db->insert_id();

			echo $last_id;

			if($last_id) {
				redirect(base_url('admin/templatesurat/edit/' . $last_id));
			}
		} else {
			echo "blom submit";
		}
		
	}

	public function edit($id)
	{		

		
		if ($this->input->post('submit')) {
			// echo '<pre>'; print_r($this->input->post()); echo '</pre>';
			// exit;
			
			$this->form_validation->set_rules(
				'isi',
				'Template surat',
				'required',
				array('required' => '%s wajib diisi.')
			);
			$this->form_validation->set_rules(
				'nama_template',
				'Nama Template surat',
				'required',
				array('required' => '%s wajib diisi.')
			);

			if ($this->form_validation->run() == FALSE) {
				$data['template'] = $this->template_model->get_template_byid($id);
				$data['kat'] = $this->surat_model->get_kategori_surat_byid($data['template']['id_kategori_surat']);
				$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['template']['id_kategori_surat']);
				$data['title'] = 'Edit Template Surat';
				$data['view'] = 'templatesurat/edit';
				$this->load->view('layout/layout', $data);
			} else {

				$data = array(
					'nama_template'=> $this->input->post('nama_template'),
					'isi'=> $this->input->post('isi'),
				);

				$insert = $this->db->update('template', $data, array('id'=> $id));

				if($insert) {
					$this->session->set_flashdata('msg', 'Tempate berhasil disimpan!');
					redirect(base_url('admin/templatesurat/edit/' . $id ));
				}
			}
		} else {
			$data['template'] = $this->template_model->get_template_byid($id);
			$data['kat'] = $this->surat_model->get_kategori_surat_byid($data['template']['id_kategori_surat']);
			$data['fields'] = $this->surat_model->get_fields_by_id_kat_surat($data['template']['id_kategori_surat']);
			$data['title'] = 'Edit Template Surat';
			$data['view'] = 'templatesurat/edit';
			$this->load->view('layout/layout', $data);
		}
		
	}

	public function preview($id) {
		$data['template'] = $this->template_model->get_template_byid($id);

		echo $data['template']['isi'];
	}

}
