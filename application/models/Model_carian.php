<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_carian extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    public function get_carian_staf($carian = NULL) {
        if (empty($carian)) {
            return NULL;
        } else {
            $sql = "SELECT 
     po.org_id AS po_org_id,
     po.org_nama AS po_org_nama,
     ppo.org_id AS ppo_org_id,
     ppo.org_nama AS ppo_org_nama,
     pppo.org_id AS pppo_org_id,
     pppo.org_nama AS pppo_org_nama,
     staf_id, staf_mykad, staf_gelaran, staf_nama, staf_jawatan, staf_gred, staf_taraf, staf_emel, staf_status, 
     pjwn_id, pjwn_staf_id, pjwn_penyelia_pjwn_id, pjwn_gelaran, pjwn_kod, pjwn_gred, pjwn_tel, pjwn_tel_samb, pjwn_org_id, pjwn_hirarki, 
     o.org_id, o.org_sub_org_id, o.org_nama, o.org_alamat, o.org_poskod, o.org_negeri, o.org_negara, o.org_tel, o.org_fax, o.org_emel, o.org_hirarki, o.org_papar_sub
FROM staf 
     LEFT JOIN penjawatan ON staf_id = pjwn_staf_id 
     LEFT JOIN organisasi AS o ON pjwn_org_id = o.org_id 
     LEFT JOIN organisasi AS po ON o.org_sub_org_id = po.org_id
     LEFT JOIN organisasi AS ppo ON po.org_sub_org_id = ppo.org_id
     LEFT JOIN organisasi AS pppo ON ppo.org_sub_org_id = pppo.org_id
WHERE 
     staf_status = 'Aktif' AND (
     staf_gelaran LIKE '%$carian%' OR 
     staf_nama LIKE '%$carian%' OR 
     staf_jawatan LIKE '%$carian%' OR 
     staf_gred LIKE '%$carian%' OR 
     staf_taraf LIKE '%$carian%' OR 
     staf_emel LIKE '%$carian%' OR 
     pjwn_gelaran LIKE '%$carian%' OR 
     pjwn_kod LIKE '%$carian%' OR 
     pjwn_gred LIKE '%$carian%' OR 
     pjwn_tel LIKE '%$carian%' OR 
     pjwn_tel_samb LIKE '%$carian%')";
            $query = $this->db->query($sql);
            return $query->result();
        }
    }
    
    public function get_carian_organisasi($carian = NULL) {
        if (empty($carian)) {
            return NULL;
        } else {
            $sql = "SELECT 
	o.org_id, 
	o.org_sub_org_id, 
	o.org_nama, 
	po.org_nama AS po_org_nama,
	ppo.org_nama AS ppo_org_nama,
	pppo.org_nama AS pppo_org_nama,
	o.org_alamat, 
	o.org_poskod, 
	o.org_negeri, 
	o.org_negara, 
	o.org_tel, 
	o.org_fax, 
	o.org_emel, 
	o.org_hirarki, 
	o.org_papar_sub
FROM organisasi AS o
	LEFT JOIN organisasi AS po ON o.org_sub_org_id = po.org_id
	LEFT JOIN organisasi AS ppo ON po.org_sub_org_id = ppo.org_id
	LEFT JOIN organisasi AS pppo ON ppo.org_sub_org_id = pppo.org_id
WHERE
o.org_nama LIKE '%$carian%' OR 
o.org_negeri LIKE '%$carian%' OR 
o.org_tel LIKE '%$carian%' OR 
o.org_fax LIKE '%$carian%' OR 
o.org_emel LIKE '%$carian%'";
            $query = $this->db->query($sql);
            return $query->result();
        }
    }

}
