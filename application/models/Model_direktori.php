<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_direktori extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    public function get_menu($id = null) {
        if (empty($id)) {
            $query = $this->db->query("SELECT * FROM organisasi WHERE org_sub_org_id IS NULL ORDER BY org_hirarki");
        } else {
            $query = $this->db->query("SELECT * FROM organisasi WHERE org_sub_org_id = $id ORDER BY org_hirarki");
        }
        return $query->result();
    }
    
    public function get_organisasi($id = null) {
        if (empty($id)) {
            return false;
        } else {
            $query = $this->db->query("SELECT * FROM organisasi WHERE org_id = $id");
            return $query->result();
        }
    }
    
    public function get_sub_organisasi($id = null) {
        if (empty($id)) {
            $query = $this->db->query("SELECT * FROM organisasi WHERE org_sub_org_id IS NULL ORDER BY org_hirarki");
        } else {
            $query = $this->db->query("SELECT * FROM organisasi WHERE org_sub_org_id = $id ORDER BY org_hirarki");
        }
        return $query->result();
    }
    
    public function get_organisasi_papar_sub($id = null) {
        if (empty($id)) {
            return false;
        } else {
            $query = $this->db->query("SELECT org_papar_sub FROM organisasi WHERE org_id = $id and org_papar_sub = 'Ya'");
            return $query->num_rows();
        }
    }
    
    public function get_penjawatan($id = null) {
        if (empty($id)) {
            return false;
        } else {
            $query = $this->db->query("SELECT * FROM penjawatan LEFT JOIN staf ON penjawatan.pjwn_staf_id = staf.staf_id AND staf_status = 'Aktif' where pjwn_org_id = $id ORDER BY pjwn_hirarki");
            return $query->result();
        }
    }
    
    public function get_alamat($id = null) {
        if (empty($id)) {
            return false;
        } else {
            $query = $this->db->query("SELECT org_alamat, org_poskod, org_negeri, org_tel, org_fax, org_emel FROM organisasi WHERE org_id = $id");
            return $query->row();
        }
    }
    
    public function get_breadcrumb($id = null) {
        $breadcrumb = [];
        while(!empty($id)) {
            $query = $this->db->query("SELECT org_sub_org_id, org_nama FROM organisasi WHERE org_id = $id ORDER BY org_hirarki");
            $row = $query->row();
            //$breadcrumb[$id] = $row->org_nama;
            $breadcrumb = [$id => $row->org_nama] + $breadcrumb;
            $id = $row->org_sub_org_id;
        }
        return $breadcrumb;
    }

}
