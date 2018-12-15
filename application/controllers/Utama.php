<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utama extends CI_Controller {
    
    public $menu = '';
    
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->model('model_direktori');
        $this->menu = $this->model_direktori->get_menu();
    }

    public function index() {
        $data['breadcrumb'] = $this->model_direktori->get_breadcrumb();
        $data['menu'] = $this->menu;
        $data['organisasi'] = $this->model_direktori->get_sub_organisasi();
        
        $data['content'] = $this->load->view('utama', $data, TRUE);
        $this->load->view('template/AdminBSB/default', $data);
    }
    
    public function org($id = NULL) {
        if (empty($id)) {
            redirect('');
        } else {
            $data['kosong'] = '<code>[ KOSONG ]</code>';
            $data['breadcrumb'] = $this->model_direktori->get_breadcrumb($id);
            $data['menu'] = $this->menu;
            
            $data['papar_sub'] = $this->model_direktori->get_organisasi_papar_sub($id);
            
            $data['organisasi'] = $this->model_direktori->get_sub_organisasi($id);
            $data['penjawatan'] = $this->model_direktori->get_penjawatan($id);
            $data['alamat'] = $this->model_direktori->get_alamat($id);
            
            if ((1 == $data['papar_sub']) and (!empty($data['organisasi']))) {
                
                $sub_org = [];
                $sub_penjawatan = [];
                
                foreach ($data['organisasi'] as $value) {
                    $sub_org[$value->org_id] = "$value->org_nama";
                    $sub_penjawatan[$value->org_id] = $this->model_direktori->get_penjawatan($value->org_id);
                    
                    //search if contains sub org
                    $sub_org2 = $this->model_direktori->get_sub_organisasi($value->org_id);
                    if (!empty($sub_org2)) {
                        foreach ($sub_org2 as $sub_org2) {
                            $sub_org[$sub_org2->org_id] = "{$value->org_nama} / {$sub_org2->org_nama}";
                            $sub_penjawatan[$sub_org2->org_id] = $this->model_direktori->get_penjawatan($sub_org2->org_id);
                        }
                    }
                    
                }
                // get all organisasi link to this $id
                $data['sub_organisasi'] = $sub_org;
                $data['sub_penjawatan'] = $sub_penjawatan;
            }
            
            $data['content'] = $this->load->view('media_object', $data, TRUE);
            $this->load->view('template/AdminBSB/default', $data);
        }
    }
}
