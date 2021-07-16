<?php defined('BASEPATH') or exit('No direct script access allowed');
class Layout extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //--------------------------------------------------------------
    public function error404()
    {
        $data['title'] = 'Error!';

        if ($this->session->has_userdata('is_login')) {
            $data['view'] = 'error404';
            $this->load->view('layout/layout', $data);
        }
    }

    
    
}
