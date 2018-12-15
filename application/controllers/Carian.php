<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carian extends CI_Controller {
    
    public $menu = '';
    public $carian = NULL;
    
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model('model_direktori');
        $this->load->model('model_carian');
        $this->menu = $this->model_direktori->get_menu();
        $this->carian = trim($this->input->post('txtCarian'));
    }

    public function index() {
        $HasilCarian = NULL;
        $data['kosong'] = '<code>---[ KOSONG ]---</code>';
        if (!empty($this->carian)) {
            $HasilCarian['organisasi'] = $this->model_carian->get_carian_organisasi($this->carian);
            $HasilCarian['staf'] = $this->model_carian->get_carian_staf($this->carian);
        }
        
        $data['breadcrumb'] = ['Carian'];
        $data['menu'] = $this->menu;
        $data['carian'] = $HasilCarian;
        $data['katacarian'] = $this->carian;
        $data['content'] = $this->load->view('carian', $data, TRUE);
        $this->load->view('template/AdminBSB/default', $data);
    }
}
