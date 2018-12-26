<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pentadbir extends CI_Controller {
    
    public $kosong = '<code>---[ KOSONG ]---</code>';
    public $id = NULL;
    public $stafImageDir = '/images/staf/';

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        if ($this->input->is_ajax_request()) { $this->output->enable_profiler(FALSE); } // disable profiler for ajax request
        $this->load->library('session');
    }

    public function index() {
        if ($this->session->has_userdata('staf_id')) { redirect('/pentadbir/dashboard'); }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpEmail', 'Emel', 'trim|required|valid_email|callback__semak_emel');
        $this->form_validation->set_rules('inpKataLaluan', 'Kata Laluan', 'trim|required|callback__semak_katalaluan');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/AdminBSB/logmasuk');
        } else {
            $emel = $this->input->post('inpEmail');
            $katalaluan = $this->input->post('inpKataLaluan');
            $this->load->model('model_pentadbir');
            $this->model_pentadbir->get_auth($emel, $katalaluan);
            redirect('/pentadbir/dashboard');
        }
        
    }
    
    public function dashboard() {
        $this->semak_log_masuk();
        $data = [
            'title' => 'DASHBOARD',
            'userdata' => $this->session->userdata()
        ];
        
        $dir = getcwd() . $this->stafImageDir;
        $files = glob($dir . "*.jpg");
        
        $data['bil_org'] = $this->model_pentadbir->get_bil('organisasi', 'org_id');
        $data['bil_pjwn'] = $this->model_pentadbir->get_bil('penjawatan', 'pjwn_id');
        $data['bil_staf'] = $this->model_pentadbir->get_bil('staf', 'staf_id');
        $data['bil_gambar'] = count($files);
        
        $data['content'] = $this->load->view('pentadbir/dashboard', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    public function organisasi($action = '', $id = 0) {
        $this->semak_log_masuk();
        
        $this->load->model('model_pentadbir');
        
        if ('ajax_datatables' == $action) {
            
            $organisasi = $this->model_pentadbir->get_organisasi();
            $data = [];
            foreach ($organisasi as $value) {
                $data['data'][] = $value;
            }
            echo json_encode($data);
            
        } else if ('tambah' == $action) {
            
            $this->_organisasi_tambah();
            
        } else if ('kemaskini' == $action) {
            
            // check if id not valid
            if (!$this->model_pentadbir->get_organisasi('checkID', $id)) {
                $this->session->set_flashdata('alert-danger', 'Maklumat Organisasi TIDAK SAH!');
                redirect('/pentadbir/organisasi');
            }
            
            $this->_organisasi_kemaskini($id);
            
        } else if ('hapus' == $action) {
            $status = '';
            
            // check if id not valid
            if (!$this->model_pentadbir->get_organisasi('checkID', $id)) {
                $status = "ID Organisasi tidak sah!";
            } else {
                // check if delete condition met; total sub org and penjawatan = 0
                $OrgDetails  = $this->model_pentadbir->get_organisasi(FALSE, $id);
                
                if ((0 < (int)$OrgDetails[$id]['org_sub_bil']) OR (0 < (int)$OrgDetails[$id]['org_pjwn_bil'])) {
                    $status = "Sila pastikan organisasi ini tidak mempunyai Sub Organisasi dan Penjawatan dibawahnya!";
                } else {
                    $dataOrganisasi['org_id'] = $id;
                    $queryResult = $this->model_pentadbir->set_organisasi($dataOrganisasi, 'delete');
                    if (1 === $queryResult) {
                        $status = "success";
                    } else {
                        $status = $queryResult;
                    }
                }
            }
            
            echo $status;
            exit();
        } else {
            $this->_organisasi();
            
            // remove flashdata if exist from previous kemaskini
            if (isset($_SESSION['org_id'])) { unset($_SESSION['org_id']); }
        }
    }
    
    public function penjawatan($action = '', $id = 0) {
        $this->semak_log_masuk();
        
        $this->load->model('model_pentadbir');
        
        if ('ajax_datatables' == $action) {
            $penjawatan = $this->model_pentadbir->get_penjawatan();
            $data = [];
            foreach ($penjawatan as $value) {
                $data['data'][] = $value;
            }
            echo json_encode($data);
        } else if ('ajax_datatables_reload' == $action) {
            $penjawatan = $this->model_pentadbir->get_penjawatan('ajaxReload', $id);
            $data = [];
            foreach ($penjawatan as $value) {
                $data['data'][] = $value;
            }
            
            if (empty($data)) {
                $data['data'] =  [sEcho =>1, iTotalRecords =>0, iTotalDisplayRecords =>0, aaData => []];
            }
            
            echo json_encode($data);
        } else if ('tambah' == $action) {
            
            $this->_penjawatan_tambah();
            
        } else if ('kemaskini' == $action) {
            
            // check if id not valid
            if (!$this->model_pentadbir->get_penjawatan('checkID', $id)) {
                $this->session->set_flashdata('alert-danger', 'Maklumat Penjawatan TIDAK SAH!');
                redirect('/pentadbir/penjawatan');
            }
            
            $this->_penjawatan_kemaskini($id);
            
        } else if ('hapus' == $action) {
            $status = '';
            
            // check if id not valid
            if (!$this->model_pentadbir->get_penjawatan('checkID', $id)) {
                $status = "ID Penjawatan tidak sah!";
            } else {
                $dataPenjawatan['pjwn_id'] = $id;
                $queryResult = $this->model_pentadbir->set_penjawatan($dataPenjawatan, 'delete');
                if (1 === $queryResult) {
                    $status = "success";
                } else {
                    $status = $queryResult;
                }
            }
            
            echo $status;
            exit();
        } else {
            $this->_penjawatan();
            
            // remove flashdata if exist from previous kemaskini
            if (isset($_SESSION['pjwn_id'])) { unset($_SESSION['pjwn_id']); }
        }
    }
    
    public function staf($action = '', $id = 0) {
        $this->semak_log_masuk();
        
        $this->load->model('model_pentadbir');
        
        if ('ajax_datatables' == $action) {
            
            $staf = $this->model_pentadbir->get_staf();
            $data = [];
            foreach ($staf as $value) {
                $data['data'][] = $value;
            }
            echo json_encode($data);
            
        } else if ('tambah' == $action) {
            
            $this->_staf_tambah();
            
        } else if ('kemaskini' == $action) {
            
            // check if id not valid
            if (!$this->model_pentadbir->get_staf('checkID', $id)) {
                $this->session->set_flashdata('alert-danger', 'Maklumat Staf TIDAK SAH!');
                redirect('/pentadbir/staf');
            }
            
            $this->_staf_kemaskini($id);
            
        } else if ('hapus' == $action) {
            $status = '';
            
            // check if id not valid
            if (!$this->model_pentadbir->get_staf('checkID', $id)) {
                $status = "ID Staf tidak sah!";
            } else {
                // check if staf_id found in table pentadbir
                $StafPentadbir  = $this->model_pentadbir->get_pentadbir('checkStafID', $id);
                $StafPenjawatan  = $this->model_pentadbir->get_penjawatan('checkStafID', $id);
                
                if (0 < (int)$StafPentadbir) {
                    $status = "Staf ini merupakan Pentadbir!<br />Sila keluarkan staf ini dari senarai pentadbir.";
                } else if (0 < (int)$StafPenjawatan) {
                    $status = "Staf ini terdapat di dalam penjawatan!<br />Sila keluarkan staf ini dari penjawatan.";
                } else {
                    $dataStaf['staf_id'] = $id;
                    $queryResult = $this->model_pentadbir->set_staf($dataStaf, 'delete');
                    if (1 === $queryResult) {
                        $status = "success";
                    } else {
                        $status = $queryResult;
                    }
                }
            }
            
            echo $status;
            exit();
        } else {
            $this->_staf();
            
            // remove flashdata if exist from previous kemaskini
            //if (isset($_SESSION['staf_id'])) { unset($_SESSION['staf_id']); }
        }
    }
    
    public function gambar($a = NULL) {
        $this->semak_log_masuk();
        
        if ($a == 'muatnaik') {
            if (!empty($_FILES)) {
                $tempFile = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                //$targetPath = getcwd() . '/images/staf/';
                $targetPath = getcwd() . $this->stafImageDir;
                $targetFile = $targetPath . $fileName;
                move_uploaded_file($tempFile, $targetFile);
                exit();
            }
        }
        
        $extraCSS = [
            'Dropzone Css' => 'plugins/dropzone/dropzone.css',
            'JQuery DataTable Css' => 'plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'jQuery FancyBox Lightbox Css' => 'plugins/jquery-fancybox/dist/jquery.fancybox.min.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Dropzone Plugin Js' => 'plugins/dropzone/dropzone.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Jquery DataTable Plugin Js' => ['plugins/jquery-datatable/jquery.dataTables.js', 'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js'],
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'jQuery FancyBox Lightbox Js' => 'plugins/jquery-fancybox/dist/jquery.fancybox.min.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/gambar.js'];
        
        $data = [
            'title' => 'GAMBAR',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata()
        ];
        $data['content'] = $this->load->view('pentadbir/gambar', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    public function profail($a = NULL) {
        $this->semak_log_masuk();
        
        $this->load->model('model_pentadbir');
        $profail = $this->model_pentadbir->get_profail();
        
        if ("kemaskini_staf" == $a) {
            $this->_profail_kemaskini_staf($profail);
        } else if ('kemaskini_penjawatan' == $a) {
            $this->_profail_kemaskini_penjawatan($profail);
        } else {
            $this->_profail($profail);
        }
    }
    
    public function log_keluar() {
        session_destroy();
        redirect('/pentadbir');
    }
    
    private function semak_log_masuk() {
        if (!$this->session->has_userdata('staf_id')) {
            redirect('/pentadbir');
        } else {
            // check session and update masa_aktif
            $this->load->model('model_pentadbir');
            if (!$this->model_pentadbir->get_auth()) {
                redirect('/pentadbir/log_keluar');
            }
        }
    }

    function dir_gambar() {
        $dir = getcwd() . $this->stafImageDir;
        $StafImages = [];
        $files = glob($dir . "*.jpg");
        foreach ($files as $file) {
            //$StafImages['data'][] = [basename($file), filesize($file)];
            $filename = basename($file);
            $targetPath = base_url($this->stafImageDir);
            $targetFile = $targetPath . $filename;
            $link = "<a href=\"$targetFile\" data-fancybox data-caption=\"$filename\">$filename</a>";
            //$StafImages['data'][] = [basename($file), filesize($file)];
            $deleteImage = "<button type=\"button\" class=\"btn btn-danger btn-xs waves-effect\" onclick=\"deleteImage('$filename')\" data-file=\"$filename\">HAPUS FAIL</button>";
            
            $StafImages['data'][] = [$link, filesize($file), $deleteImage];
        }
        
        if (empty($StafImages)) {
            //echo '{"sEcho": 1, "iTotalRecords": "0", "iTotalDisplayRecords": "0", "aaData": []}';
            echo json_encode(["sEcho" => 1, "iTotalRecords" => 0, "iTotalDisplayRecords" => 0, "aaData" => []]);
        } else {
            echo json_encode($StafImages);
        }
        
    }
    
    function del_gambar($img = NULL) {
        if (NULL == $img) {
            return FALSE;
        } else {
            $img = FCPATH . '/images/staf/' . $img;
            return (unlink(urldecode($img)));
        }
    }
    
    
    /*
     * PRIVATE FUNCTIONS - by using underscore
     */
    
    // form_validation
    function _semak_emel() {
        $inpEmail = $this->input->post('inpEmail');
        $this->load->model('model_pentadbir');
        if ($this->model_pentadbir->get_auth($inpEmail)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_semak_emel', "{field} tidak wujud dalam senarai pentadbir.");
            return FALSE;
        }
    }
    
    function _semak_katalaluan() {
        $inpEmail = $this->input->post('inpEmail');
        $inpKataLaluan = $this->input->post('inpKataLaluan');
        $this->load->model('model_pentadbir');
        if ($this->model_pentadbir->get_auth($inpEmail, $inpKataLaluan)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_semak_katalaluan', "{field} tidak sah.");
            return FALSE;
        }
    }
    
    function _semak_pjwn_kod() {
        $inpKod = $this->input->post('inpKod');
        $id = $this->input->post('inpID');
        
        $this->load->model('model_pentadbir');
        if ($this->model_pentadbir->get_pjwn_kod($inpKod, $id)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_semak_pjwn_kod', "{field} sudah wujud.");
            return FALSE;
        }
    }
    
    // Organisasi
    
    function _organisasi() {
        // Prepare to view
        $extraCSS = [
            'JQuery DataTable Css' => 'plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Jquery DataTable Plugin Js' => [
                'plugins/jquery-datatable/jquery.dataTables.js', 
                'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'plugins/jquery-datatable/plugins/page.jumpToData().js'
                ],
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/organisasi.js'];
        $data = [
            'title' => 'ORGANISASI',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'senarai_org' => $this->model_pentadbir->get_organisasi()
        ];

        $data['content'] = $this->load->view('pentadbir/organisasi', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _organisasi_tambah() {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpNama', 'Nama Organisasi', 'trim|required');
        $this->form_validation->set_rules('slcNamaSub', 'Organisasi Induk', 'trim|is_natural_no_zero');
        $this->form_validation->set_rules('txtAlamat', 'Alamat', 'trim');
        $this->form_validation->set_rules('inpPoskod', 'Poskod', 'trim|is_natural_no_zero');
        $this->form_validation->set_rules('inpNegeri', 'Negeri', 'trim');
        $this->form_validation->set_rules('inpNegara', 'Negara', 'trim');
        $this->form_validation->set_rules('inpTel', 'No. Telefon', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('inpTelSamb', 'Sambungan', 'trim');
        $this->form_validation->set_rules('inpFax', 'No. Faks', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('inpEmel', 'Emel', 'trim|valid_email');
        $this->form_validation->set_rules('inpHirarki', 'Hirarki', 'trim|is_natural');
        $this->form_validation->set_rules('chkPaparSub', 'Papar Sub', 'trim');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $dataOrganisasi = [
                'org_sub_org_id' => $this->input->post('slcNamaSub'),
                'org_nama' => $this->input->post('inpNama'),
                'org_alamat' => $this->input->post('txtAlamat'),
                'org_poskod' => $this->input->post('inpPoskod'),
                'org_negeri' => $this->input->post('inpNegeri'),
                'org_negara' => $this->input->post('inpNegara'),
                'org_tel' => $this->input->post('inpTel'),
                'org_tel_samb' => $this->input->post('inpTelSamb'),
                'org_fax' => $this->input->post('inpFax'),
                'org_emel' => $this->input->post('inpEmel'),
                'org_hirarki' => $this->input->post('inpHirarki'),
                'org_papar_sub' => ('Ya' == $this->input->post('chkPaparSub')) ? 'Ya' : 'Tidak',
                'org_catatan' => $this->input->post('txtCatatan')
            ];
            
            if ($this->model_pentadbir->set_organisasi($dataOrganisasi, 'insert')) {
                $this->session->set_flashdata('alert-success', 'Maklumat Organisasi berjaya ditambah.');
            } else {
                $this->session->set_flashdata('alert-danger', 'Maklumat Organisasi TIDAK berjaya ditambah.');
            }
            redirect('/pentadbir/organisasi/');
        }
        
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/organisasi_tambah.js'];
        $data = [
            'title' => 'ORGANISASI',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata()
        ];
        
        $data['senarai_org'] = $this->model_pentadbir->get_organisasi('HTMLselect');
        
        $data['content'] = $this->load->view('pentadbir/organisasi_tambah', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _organisasi_kemaskini($id) {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpNama', 'Nama Organisasi', 'trim|required');
        $this->form_validation->set_rules('slcNamaSub', 'Organisasi Induk', 'trim|is_natural_no_zero');
        $this->form_validation->set_rules('txtAlamat', 'Alamat', 'trim');
        $this->form_validation->set_rules('inpPoskod', 'Poskod', 'trim|is_natural_no_zero');
        $this->form_validation->set_rules('inpNegeri', 'Negeri', 'trim');
        $this->form_validation->set_rules('inpNegara', 'Negara', 'trim');
        $this->form_validation->set_rules('inpTel', 'No. Telefon', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('inpTelSamb', 'Sambungan', 'trim');
        $this->form_validation->set_rules('inpFax', 'No. Faks', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('inpEmel', 'Emel', 'trim|valid_email');
        $this->form_validation->set_rules('inpHirarki', 'Hirarki', 'trim|is_natural');
        $this->form_validation->set_rules('chkPaparSub', 'Papar Sub', 'trim');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $dataOrganisasi = [
                'org_id' => $id,
                'org_sub_org_id' => $this->input->post('slcNamaSub'),
                'org_nama' => $this->input->post('inpNama'),
                'org_alamat' => $this->input->post('txtAlamat'),
                'org_poskod' => $this->input->post('inpPoskod'),
                'org_negeri' => $this->input->post('inpNegeri'),
                'org_negara' => $this->input->post('inpNegara'),
                'org_tel' => $this->input->post('inpTel'),
                'org_tel_samb' => $this->input->post('inpTelSamb'),
                'org_fax' => $this->input->post('inpFax'),
                'org_emel' => $this->input->post('inpEmel'),
                'org_hirarki' => $this->input->post('inpHirarki'),
                'org_papar_sub' => ('Ya' == $this->input->post('chkPaparSub')) ? 'Ya' : 'Tidak',
                'org_catatan' => $this->input->post('txtCatatan')
            ];
            
            if ($this->model_pentadbir->set_organisasi($dataOrganisasi, 'update')) {
                $this->session->set_flashdata('alert-success', 'Maklumat Organisasi berjaya dikemaskini.');
            } else {
                $this->session->set_flashdata('alert-danger', 'Maklumat Organisasi TIDAK berjaya dikemaskini.');
            }
            //redirect('pentadbir/organisasi/kemaskini/' . $id);
            redirect('/pentadbir/organisasi/');
            
        }
        
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/organisasi_kemaskini.js'];
        $data = [
            'title' => 'ORGANISASI',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'organisasi' => $this->model_pentadbir->get_organisasi('checkID', $id)
        ];
        
        $data['senarai_org'] = $this->model_pentadbir->get_organisasi('HTMLselect');
        unset($data['senarai_org'][$id]); // remove own organisasi
        
        $data['content'] = $this->load->view('pentadbir/organisasi_kemaskini', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
        
    }
    
    
    // Penjawatan
    
    function _penjawatan() {
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'JQuery DataTable Css' => 'plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Jquery DataTable Plugin Js' => [
                'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
                'plugins/jquery-datatable/jquery.dataTables.js', 
                'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'plugins/jquery-datatable/plugins/page.jumpToData().js'
                ],
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/penjawatan.js'];
        $data = [
            'title' => 'PENJAWATAN',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata()
        ];
        
        $data['senarai_org'] = $this->model_pentadbir->get_organisasi('HTMLselect');

        $data['content'] = $this->load->view('pentadbir/penjawatan', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _penjawatan_tambah() {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpGelaran', 'Gelaran', 'trim|required');
        $this->form_validation->set_rules('inpKod', 'Singkatan Gelaran', 'trim|callback__semak_pjwn_kod');
        $this->form_validation->set_rules('inpGred', 'Gred', 'trim');
        $this->form_validation->set_rules('inpHirarki', 'Hirarki', 'trim|is_natural|required');
        $this->form_validation->set_rules('inpTel', 'No. Telefon', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('inpTelSamb', 'Sambungan', 'trim');
        $this->form_validation->set_rules('slcStaf', 'Nama Pegawai', 'trim');
        $this->form_validation->set_rules('slcPenyelia', 'Gelaran Penyelia', 'trim');
        $this->form_validation->set_rules('slcOrg', 'Organisasi', 'trim|required');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $dataPenjawatan = [
                'pjwn_staf_id' => $this->input->post('slcStaf'),
                'pjwn_penyelia_pjwn_id' => $this->input->post('slcPenyelia'),
                'pjwn_gelaran' => $this->input->post('inpGelaran'),
                'pjwn_kod' => $this->input->post('inpKod'),
                'pjwn_gred' => $this->input->post('inpGred'),
                'pjwn_tel' => $this->input->post('inpTel'),
                'pjwn_tel_samb' => $this->input->post('inpTelSamb'),
                'pjwn_org_id' => $this->input->post('slcOrg'),
                'pjwn_hirarki' => $this->input->post('inpHirarki'),
                'pjwn_catatan' => $this->input->post('txtCatatan')
            ];
            
            if ($this->model_pentadbir->set_penjawatan($dataPenjawatan, 'insert')) {
                $this->session->set_flashdata('alert-success', 'Maklumat Penjawatan berjaya ditambah.');
            } else {
                $this->session->set_flashdata('alert-danger', 'Maklumat Penjawatan TIDAK berjaya ditambah.');
            }
            redirect('pentadbir/penjawatan/');
            
        }
        
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/penjawatan_tambah.js'];
        $data = [
            'title' => 'PENJAWATAN',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata()
        ];
        
        $data['senarai_penyelia'] = $this->model_pentadbir->get_penyelia(TRUE);
        $data['senarai_org'] = $this->model_pentadbir->get_organisasi('HTMLselect');
        $data['senarai_staf'] = $this->model_pentadbir->get_staf('HTMLselect', 0, TRUE);
        $data['senarai_gelaran_penjawatan'] = $this->model_pentadbir->get_senarai('penjawatan', 'pjwn_gelaran');
        
        $data['content'] = $this->load->view('pentadbir/penjawatan_tambah', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
        
    }
    
    function _penjawatan_kemaskini($id) {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpGelaran', 'Gelaran', 'trim|required');
        $this->form_validation->set_rules('inpKod', 'Singkatan Gelaran', 'trim|callback__semak_pjwn_kod');
        $this->form_validation->set_rules('inpGred', 'Gred', 'trim');
        $this->form_validation->set_rules('inpHirarki', 'Hirarki', 'trim|is_natural');
        $this->form_validation->set_rules('inpTel', 'No. Telefon', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('inpTelSamb', 'Sambungan', 'trim');
        $this->form_validation->set_rules('slcStaf', 'Nama Pegawai', 'trim');
        $this->form_validation->set_rules('slcPenyelia', 'Gelaran Penyelia', 'trim');
        $this->form_validation->set_rules('slcOrg', 'Organisasi', 'trim|required');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $dataPenjawatan = [
                'pjwn_id' => $id,
                'pjwn_staf_id' => $this->input->post('slcStaf'),
                'pjwn_penyelia_pjwn_id' => $this->input->post('slcPenyelia'),
                'pjwn_gelaran' => $this->input->post('inpGelaran'),
                'pjwn_kod' => $this->input->post('inpKod'),
                'pjwn_gred' => $this->input->post('inpGred'),
                'pjwn_tel' => $this->input->post('inpTel'),
                'pjwn_tel_samb' => $this->input->post('inpTelSamb'),
                'pjwn_org_id' => $this->input->post('slcOrg'),
                'pjwn_hirarki' => $this->input->post('inpHirarki'),
                'pjwn_catatan' => $this->input->post('txtCatatan')
            ];
            
            if ($this->model_pentadbir->set_penjawatan($dataPenjawatan, 'update')) {
                $this->session->set_flashdata('alert-success', 'Maklumat Penjawatan berjaya dikemaskini.');
            } else {
                $this->session->set_flashdata('alert-danger', 'Maklumat Penjawatan TIDAK berjaya dikemaskini.');
            }
            //redirect('pentadbir/penjawatan/kemaskini/' . $id);
            redirect('pentadbir/penjawatan/');
            
        }
        
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/penjawatan_kemaskini.js'];
        $data = [
            'title' => 'PENJAWATAN',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'penjawatan' => $this->model_pentadbir->get_penjawatan('checkID', $id)
        ];
        
        $data['inpID'] = $id;
        $data['senarai_penyelia'] = $this->model_pentadbir->get_penyelia(TRUE);
        $data['senarai_org'] = $this->model_pentadbir->get_organisasi('HTMLselect');
        $data['senarai_staf'] = $this->model_pentadbir->get_staf('HTMLselect', 0, TRUE);
        $data['senarai_gelaran_penjawatan'] = $this->model_pentadbir->get_senarai('penjawatan', 'pjwn_gelaran');
        
        $data['content'] = $this->load->view('pentadbir/penjawatan_kemaskini', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
        
    }
    
    
    // Staf
    
    function _staf() {
        // Prepare to view
        $extraCSS = [
            'JQuery DataTable Css' => 'plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Jquery DataTable Plugin Js' => [
                'plugins/jquery-datatable/jquery.dataTables.js', 
                'plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
                'plugins/jquery-datatable/plugins/page.jumpToData().js'
                ],
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/staf.js'];
        $data = [
            'title' => 'STAF',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata()
        ];

        $data['content'] = $this->load->view('pentadbir/staf', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _staf_tambah() {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpGelaran', 'Gelaran', 'trim');
        $this->form_validation->set_rules('inpNama', 'Nama Penuh', 'trim|required');
        $this->form_validation->set_rules('inpMyKad', 'MyKad', 'trim|regex_match[/^(\d{6}-?\d{2}-?\d{4}|XXX-XX-XXXX)$/]'); //(^\d{6}-?\d{2}-?\d{4}$|^XXX-XX-XXXX$)
        $this->form_validation->set_rules('inpJawatan', 'Jawatan', 'trim');
        $this->form_validation->set_rules('inpGred', 'Gred', 'trim');
        $this->form_validation->set_rules('inpTaraf', 'Taraf Jawatan', 'trim');
        $this->form_validation->set_rules('inpEmel', 'Emel', 'trim|valid_email');
        $this->form_validation->set_rules('slcStatus', 'Status', 'trim|required');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $dataStaf = [
                'staf_mykad' => $this->input->post('inpMyKad'),
                'staf_gelaran' => $this->input->post('inpGelaran'),
                'staf_nama' => $this->input->post('inpNama'),
                'staf_jawatan' => $this->input->post('inpJawatan'),
                'staf_gred' => strtoupper($this->input->post('inpGred')),
                'staf_taraf' => $this->input->post('inpTaraf'),
                'staf_emel' => $this->input->post('inpEmel'),
                'staf_status' => $this->input->post('slcStatus'),
                'staf_catatan' => $this->input->post('txtCatatan')
            ];
            
            if ($this->model_pentadbir->set_staf($dataStaf, 'insert')) {
                $this->session->set_flashdata('alert-success', 'Maklumat Staf berjaya ditambah.');
            } else {
                $this->session->set_flashdata('alert-danger', 'Maklumat Staf TIDAK berjaya ditambah.');
            }
            redirect('/pentadbir/staf/');
        }
        
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/staf_tambah.js'];
        $data = [
            'title' => 'STAF',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata()
        ];
        
        $data['senarai_status'] = $this->model_pentadbir->get_enum('staf', 'staf_status');
        $data['senarai_gelaran'] = $this->model_pentadbir->get_senarai('staf', 'staf_gelaran');
        $data['senarai_jawatan'] = $this->model_pentadbir->get_senarai('staf', 'staf_jawatan');
        $data['senarai_gred'] = $this->model_pentadbir->get_senarai('staf', 'staf_gred');
        $data['senarai_taraf'] = $this->model_pentadbir->get_senarai('staf', 'staf_taraf');
        
        $data['content'] = $this->load->view('pentadbir/staf_tambah', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _staf_kemaskini($id) {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpGelaran', 'Gelaran', 'trim');
        $this->form_validation->set_rules('inpNama', 'Nama Penuh', 'trim|required');
        $this->form_validation->set_rules('inpMyKad', 'MyKad', 'trim|regex_match[/^(\d{6}-?\d{2}-?\d{4}|XXX-XX-XXXX)$/]'); //(^\d{6}-?\d{2}-?\d{4}$|^XXX-XX-XXXX$)
        $this->form_validation->set_rules('inpJawatan', 'Jawatan', 'trim');
        $this->form_validation->set_rules('inpGred', 'Gred', 'trim');
        $this->form_validation->set_rules('inpTaraf', 'Taraf Jawatan', 'trim');
        $this->form_validation->set_rules('inpEmel', 'Emel', 'trim|valid_email');
        $this->form_validation->set_rules('slcStatus', 'Status', 'trim|required');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');

        if ($this->form_validation->run() == TRUE) {
            $dataStaf = [
                'staf_id' => $id,
                'staf_mykad' => $this->input->post('inpMyKad'),
                'staf_gelaran' => $this->input->post('inpGelaran'),
                'staf_nama' => $this->input->post('inpNama'),
                'staf_jawatan' => $this->input->post('inpJawatan'),
                'staf_gred' => strtoupper($this->input->post('inpGred')),
                'staf_taraf' => $this->input->post('inpTaraf'),
                'staf_emel' => $this->input->post('inpEmel'),
                'staf_status' => $this->input->post('slcStatus'),
                'staf_catatan' => $this->input->post('txtCatatan')
            ];
            
            if ($this->model_pentadbir->set_staf($dataStaf, 'update')) {
                $this->session->set_flashdata('alert-success', 'Maklumat Staf berjaya ditambah.');
            } else {
                $this->session->set_flashdata('alert-danger', 'Maklumat Staf TIDAK berjaya ditambah.');
            }
            //redirect('pentadbir/staf/kemaskini/' . $id);
            redirect('pentadbir/staf/');
            
        }
        
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/staf_kemaskini.js'];
        $data = [
            'title' => 'STAF',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'staf' => $this->model_pentadbir->get_staf('checkID', $id)
        ];
        
        $data['inpID'] = $id;
        $data['senarai_status'] = $this->model_pentadbir->get_enum('staf', 'staf_status');
        $data['senarai_gelaran'] = $this->model_pentadbir->get_senarai('staf', 'staf_gelaran');
        $data['senarai_jawatan'] = $this->model_pentadbir->get_senarai('staf', 'staf_jawatan');
        $data['senarai_gred'] = $this->model_pentadbir->get_senarai('staf', 'staf_gred');
        $data['senarai_taraf'] = $this->model_pentadbir->get_senarai('staf', 'staf_taraf');
        
        $data['content'] = $this->load->view('pentadbir/staf_kemaskini', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
        
    }
    
    // Profail
    
    function _profail($profail) {
        
        // Prepare to view
        $data = [
            'title' => 'PROFAIL',
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'profail' => $profail
        ];
        
        $data['content'] = $this->load->view('pentadbir/profail', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _profail_kemaskini_staf($profail) {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpGelaran', 'Gelaran', 'trim');
        $this->form_validation->set_rules('inpNama', 'Nama Penuh', 'trim|required');
        $this->form_validation->set_rules('inpMyKad', 'MyKad', 'trim|regex_match[/^(\d{6}-?\d{2}-?\d{4}|XXX-XX-XXXX)$/]'); //(^\d{6}-?\d{2}-?\d{4}$|^XXX-XX-XXXX$)
        $this->form_validation->set_rules('inpJawatan', 'Jawatan', 'trim');
        $this->form_validation->set_rules('inpGred', 'Gred', 'trim');
        $this->form_validation->set_rules('inpTaraf', 'Taraf Jawatan', 'trim');
        $this->form_validation->set_rules('inpEmel', 'Emel', 'trim|required|valid_email');
        $this->form_validation->set_rules('slcStatus', 'Status', 'trim|required');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');
        
        if ($this->form_validation->run() == TRUE) {
            
            $dataStaf = [
                'staf_id' => $this->session->userdata('staf_id'),
                'staf_mykad' => $this->input->post('inpMyKad'),
                'staf_gelaran' => $this->input->post('inpGelaran'),
                'staf_nama' => $this->input->post('inpNama'),
                'staf_jawatan' => $this->input->post('inpJawatan'),
                'staf_gred' => strtoupper($this->input->post('inpGred')),
                'staf_taraf' => $this->input->post('inpTaraf'),
                'staf_emel' => $this->input->post('inpEmel'),
                'staf_status' => $this->input->post('slcStatus'),
                'staf_catatan' => $this->input->post('txtCatatan')
            ];
            
            $statusSQL  = $this->model_pentadbir->set_staf($dataStaf, 'update');
            
            if (1 === $statusSQL) {
                $this->session->set_flashdata('alert-success', 'Maklumat Staf berjaya dikemaskini.');
            } else if (2 === $statusSQL) {
                $this->session->set_flashdata('alert-danger', 'Maklumat Staf KOSONG!');
            } else {
                $this->session->set_flashdata('errSQL', $statusSQL);
                $this->session->set_flashdata('alert-danger', 'Maklumat Staf TIDAK berjaya dikemaskini!');
            }
            //redirect('pentadbir/profail/kemaskini_staf');
            redirect('pentadbir/profail');
        }
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/profail.js'];
        
        $data = [
            'title' => 'PROFAIL',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'profail' => $profail
        ];
        
        $data['senarai_status'] = $this->model_pentadbir->get_enum('staf', 'staf_status');
        $data['senarai_gelaran'] = $this->model_pentadbir->get_senarai('staf', 'staf_gelaran');
        $data['senarai_jawatan'] = $this->model_pentadbir->get_senarai('staf', 'staf_jawatan');
        $data['senarai_gred'] = $this->model_pentadbir->get_senarai('staf', 'staf_gred');
        $data['senarai_taraf'] = $this->model_pentadbir->get_senarai('staf', 'staf_taraf');
        
        $data['content'] = $this->load->view('pentadbir/profail_kemaskini_staf', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
    function _profail_kemaskini_penjawatan($profail) {
        
        // Form Validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('inpGelaran', 'Gelaran', 'trim');
        $this->form_validation->set_rules('inpKod', 'Singkatan', 'trim');
        $this->form_validation->set_rules('inpGred', 'Gred', 'trim');
        $this->form_validation->set_rules('inpTel', 'No. Telefon', 'trim|regex_match[/^((\d{2}-\d{4}|\d{3}-\d{3}) \d{3,4} ?\d{0,4})$/]');
        $this->form_validation->set_rules('slcOrg', 'Organisasi', 'trim|required');
        $this->form_validation->set_rules('slcPenyelia', 'Penyelia', 'trim');
        $this->form_validation->set_rules('txtCatatan', 'Catatan', 'trim');
        
        if ($this->form_validation->run() == TRUE) {
            $dataPenjawatan = [
                'pjwn_id' => $profail->pjwn_id,
                'pjwn_gelaran' => $this->input->post('inpGelaran'),
                'pjwn_kod' => strtoupper($this->input->post('inpKod')),
                'pjwn_gred' => strtoupper($this->input->post('inpGred')),
                'pjwn_tel' => $this->input->post('inpTel'),
                'pjwn_org_id' => $this->input->post('slcOrg'),
                'pjwn_penyelia_pjwn_id' => $this->input->post('slcPenyelia'),
                'pjwn_catatan' => $this->input->post('txtCatatan')
            ];
            
            
            $statusSQL  = $this->model_pentadbir->set_penjawatan($dataPenjawatan, 'update_profail');
            
            if (1 === $statusSQL) {
                $this->session->set_flashdata('alert-success', 'Maklumat Penjawatan berjaya dikemaskini.');
            } else if (2 === $statusSQL) {
                $this->session->set_flashdata('alert-danger', 'Maklumat Penjawatan KOSONG!');
            } else {
                $this->session->set_flashdata('errSQL', $statusSQL);
                $this->session->set_flashdata('alert-danger', 'Maklumat Penjawatan TIDAK berjaya dikemaskini!');
            }
            //redirect('pentadbir/profail/kemaskini_penjawatan');
            redirect('pentadbir/profail');
        }
        
        // Prepare to view
        $extraCSS = [
            'Bootstrap Select Css' => 'plugins/bootstrap-select/css/bootstrap-select.css',
            'Sweetalert Css' => 'plugins/sweetalert/sweetalert.css'
        ];
        $extraJS = [
            'Bootstrap Select Plugin Js' => 'plugins/bootstrap-select/js/bootstrap-select.js',
            'SweetAlert Plugin Js' => 'plugins/sweetalert/sweetalert.min.js',
            'Input Mask Plugin Js' => 'plugins/jquery-inputmask/jquery.inputmask.bundle.js',
            'Autosize Plugin Js' => 'plugins/autosize/autosize.js',
            'Typeahead Js' => 'plugins/bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ];
        $customCSS = ['css/form.css'];
        $customJS = ['js/profail.js'];
        
        $data = [
            'title' => 'PROFAIL',
            'extraCSS' => $extraCSS,
            'extraJS' => $extraJS,
            'customCSS' => $customCSS,
            'customJS' => $customJS,
            'kosong' => $this->kosong,
            'userdata' => $this->session->userdata(),
            'profail' => $profail
        ];
        
        $data['senarai_gelaran'] = $this->model_pentadbir->get_senarai('penjawatan', 'pjwn_gelaran');
        $data['senarai_gred'] = $this->model_pentadbir->get_senarai('penjawatan', 'pjwn_gred');
        $data['senarai_org'] = $this->model_pentadbir->get_organisasi('HTMLselect');
        $data['senarai_penyelia'] = $this->model_pentadbir->get_penyelia();
        
        $data['content'] = $this->load->view('pentadbir/profail_kemaskini_penjawatan', $data, TRUE);
        $this->load->view('template/AdminBSB/pentadbir', $data);
    }
    
}
