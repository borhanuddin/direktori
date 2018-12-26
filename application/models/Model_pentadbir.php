<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pentadbir extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    
    /*
     * GET Functions
     */
    
    public function get_auth($inpEmail = NULL, $inpKataLaluan = NULL) {
        if (!empty($inpEmail) and empty($inpKataLaluan)) {
            // from callback__semak_emel
            $sql = "SELECT ptdb_id FROM pentadbir INNER JOIN staf ON ptdb_staf_id = staf_id WHERE staf_emel = '$inpEmail' AND staf_status = 'Aktif'";
            $query = $this->db->query($sql);
            return ($query->num_rows() > 0) ? TRUE : FALSE;
        } else if (!empty($inpEmail) and ! empty($inpKataLaluan)) {
            // from callback__semak_katalaluan
            $inpKataLaluan = md5($inpKataLaluan);
            $sql = "SELECT ptdb_id, ptdb_aks_id, staf_id, staf_nama, staf_emel FROM pentadbir INNER JOIN staf ON ptdb_staf_id = staf_id WHERE staf_emel = '$inpEmail' AND ptdb_katalaluan = '$inpKataLaluan' AND staf_status = 'Aktif'";
            $query = $this->db->query($sql);
            if ($query->num_rows() == 1) {
                $row = $query->row();
                if (isset($row)) {
                    $pentadbirData = [
                        'staf_id' => $row->staf_id,
                        'ptdb_id' => $row->ptdb_id,
                        'staf_nama' => $row->staf_nama,
                        'staf_emel' => $row->staf_emel,
                        'ptdb_aks_id' => $row->ptdb_aks_id,
                        'masa_kemaskini' => time()
                    ];
                    $this->session->set_userdata($pentadbirData);
                }
                return TRUE;
            } else {
                return FALSE;
            }
        } else if (empty($inpEmail) and empty($inpKataLaluan) and $this->session->has_userdata('staf_id')) {
            $staf_id = ($this->session->has_userdata('staf_id')) ? $this->session->userdata('staf_id') : NULL;
            $ptdb_id = ($this->session->has_userdata('ptdb_id')) ? $this->session->userdata('ptdb_id') : NULL;
            $staf_nama = ($this->session->has_userdata('staf_nama')) ? $this->session->userdata('staf_nama') : NULL;
            $staf_emel = ($this->session->has_userdata('staf_emel')) ? $this->session->userdata('staf_emel') : NULL;
            $ptdb_aks_id = ($this->session->has_userdata('ptdb_aks_id')) ? $this->session->userdata('ptdb_aks_id') : NULL;
            $sql = "SELECT 
    ptdb_id, ptdb_aks_id, staf_id, staf_nama, staf_emel
FROM
    pentadbir
        INNER JOIN
    staf ON ptdb_staf_id = staf_id
WHERE
    staf_id = $staf_id
        AND ptdb_id = $ptdb_id
        AND staf_nama = '$staf_nama'
        AND staf_emel = '$staf_emel'
        AND ptdb_aks_id = '$ptdb_aks_id'
        AND staf_status = 'Aktif'";
            $query = $this->db->query($sql);
            if ($query->num_rows() == 1) {
                $this->session->set_userdata('masa_kemaskini', time());
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_profail() {
        
        if (!$this->session->has_userdata('staf_id') AND !$this->session->has_userdata('ptdb_id') AND
                !$this->session->has_userdata('staf_nama') AND !$this->session->has_userdata('staf_emel') AND !$this->session->has_userdata('ptdb_aks_id')) {
            return FALSE;
        } else {
            
            $staf_id = $this->session->userdata('staf_id');
            $ptdb_id = $this->session->userdata('ptdb_id');
            $staf_nama = $this->session->userdata('staf_nama');
            $staf_emel = $this->session->userdata('staf_emel');
            $ptdb_aks_id = $this->session->userdata('ptdb_aks_id');
            
            // query data Staf
            $query = $this->db->query("SELECT 
    *
FROM
    staf
LEFT JOIN
    penjawatan ON staf.staf_id = penjawatan.pjwn_staf_id
LEFT JOIN
    pentadbir ON staf.staf_id = pentadbir.ptdb_staf_id
LEFT JOIN
    akses ON akses.aks_id = pentadbir.ptdb_aks_id
LEFT JOIN
    organisasi ON penjawatan.pjwn_org_id = organisasi.org_id
WHERE
    staf_id = $staf_id AND 
    ptdb_id = $ptdb_id AND 
    ptdb_aks_id = $ptdb_aks_id AND 
    staf_nama = '$staf_nama' AND 
    staf_emel = '$staf_emel' AND 
    staf_status = 'Aktif'");
            $data = $query->row();
            $data->pjwn_penyelia_nama = '';
            
            if (!empty($data->pjwn_penyelia_pjwn_id)) {
                $query = $this->db->query("SELECT 
    staf_nama
FROM
    staf
        LEFT JOIN
    penjawatan ON penjawatan.pjwn_staf_id = staf.staf_id
WHERE
    pjwn_id = {$data->pjwn_penyelia_pjwn_id}");
                $row = $query->row();
                if (isset($row)) {
                    $data->pjwn_penyelia_nama = $row->staf_nama;
                }
            }
            
            return $data;
            
        }
    }
    
    public function get_organisasi($opt = FALSE, $id = 0) {
        
        if ('checkID' == $opt) {
            $query = $this->db->query("SELECT * FROM organisasi WHERE org_id = $id");
            return (1 == $query->num_rows()) ? $query->row() : FALSE;
        } else if ('HTMLselect' == $opt) {
            $query = $this->db->query("SELECT 
    org_id, org_sub_org_id, org_nama
FROM
    organisasi
ORDER BY org_sub_org_id IS NULL DESC , org_sub_org_id ASC , org_hirarki ASC , org_nama ASC , org_id DESC");
            $senarai = NULL;
            foreach ($query->result() as $row) {
                $senarai[$row->org_id] = ['org_nama' => $row->org_nama, 'org_sub_org_id' => $row->org_sub_org_id];
            }
            
            $parent_org = [];
            $child_org = [];
            
            // split between main and child org
            foreach ($senarai as $id => $details) {
                if (empty($details['org_sub_org_id'])) {
                    $parent_org[$id] = $details['org_nama'];
                } else {
                    $child_org[$id] = $details;
                    ksort($child_org);
                }
            }
            
            for ($i = 1; count($senarai) <> count($parent_org); $i++) {
                $tempArray = [];
                foreach ($parent_org as $ParentID => $ParentNama) {
                    foreach ($child_org as $ChildID => $ChildData) {
                        if ($ChildData['org_sub_org_id'] == $ParentID) {
                            $tempArray[$ChildID] = str_repeat("&emsp;", ($i - 1)) . '&#10149; ' . $ChildData['org_nama'];
                            unset($child_org[$ChildID]); // remove array after copy to temp
                        }
                    }
                    $ParentIndex = array_search($ParentID, array_keys($parent_org)) + 1;
                    $parent_org = array_slice($parent_org, 0, $ParentIndex, true) + $tempArray + array_slice($parent_org, $ParentIndex, NULL, true);
                }
            }
            
            return $parent_org;
        } else {
            $query = $this->db->query("SELECT 
    parent.org_id,
    parent.org_nama,
    child.org_nama AS org_sub,
    child1.org_nama AS org_sub1,
    child2.org_nama AS org_sub2,
    parent.org_hirarki,
    parent.org_alamat,
    parent.org_poskod,
    parent.org_negeri,
    parent.org_tel,
    parent.org_tel_samb,
    parent.org_fax,
    parent.org_emel,
    parent.org_papar_sub,
    parent.org_catatan,
    COUNT(DISTINCT sub.org_id) AS org_sub_bil,
    COUNT(DISTINCT pjwn_id) AS org_pjwn_bil
FROM
    organisasi AS parent
        LEFT JOIN
    organisasi AS child ON parent.org_sub_org_id = child.org_id
        LEFT JOIN
    organisasi AS child1 ON child.org_sub_org_id = child1.org_id
        LEFT JOIN
    organisasi AS child2 ON child1.org_sub_org_id = child2.org_id
        LEFT JOIN
    organisasi AS sub ON parent.org_id = sub.org_sub_org_id
        LEFT JOIN
    penjawatan ON parent.org_id = penjawatan.pjwn_org_id
GROUP BY org_id");
            $senarai = NULL;
            
            foreach ($query->result() as $row) {
                // full name organisasi
                $f_org_sub = $row->org_sub;
                $f_org_sub .= (empty($row->org_sub1)) ? '' : ", {$row->org_sub1}";
                $f_org_sub .= (empty($row->org_sub2)) ? '' : ", {$row->org_sub2}";
                
                $senarai[$row->org_id] = [
                    'org_id' => $row->org_id,
                    'org_nama' => $row->org_nama,
                    'org_sub' => $row->org_sub,
                    'org_sub1' => $row->org_sub1,
                    'org_sub2' => $row->org_sub2,
                    'f_org_sub' => $f_org_sub,
                    'org_hirarki' => $row->org_hirarki,
                    'org_alamat' => (empty($row->org_alamat)) ? '' : $row->org_alamat,
                    'org_poskod' => (empty($row->org_poskod)) ? '' : $row->org_poskod,
                    'org_negeri' => (empty($row->org_negeri)) ? '' : $row->org_negeri,
                    'org_tel' => (empty($row->org_tel)) ? '' : $row->org_tel,
                    'org_tel_samb' => (empty($row->org_tel_samb)) ? '' : $row->org_tel_samb,
                    'org_fax' => (empty($row->org_fax)) ? '' : $row->org_fax,
                    'org_emel' => (empty($row->org_emel)) ? '' : $row->org_emel,
                    'org_papar_sub' => $row->org_papar_sub,
                    'org_catatan' => (empty($row->org_catatan)) ? '' : $row->org_catatan,
                    'org_sub_bil' => $row->org_sub_bil,
                    'org_pjwn_bil' => $row->org_pjwn_bil
                ];
            }
            return $senarai;
        }
        
    }
    
    public function get_penjawatan($opt = FALSE, $id = 0) {
        
        if ('checkID' == $opt) {
            $query = $this->db->query("SELECT * FROM penjawatan WHERE pjwn_id = $id");
            return (1 == $query->num_rows()) ? $query->row() : FALSE;
        } else if ('checkStafID' == $opt) {
            $query = $this->db->query("SELECT * FROM penjawatan WHERE pjwn_staf_id = $id");
            return $query->num_rows();
        } else if ('HTMLselect' == $opt) {
            $query = $this->db->query("SELECT 
    pjwn_id, pjwn_penyelia_pjwn_id, pjwn_gelaran, pjwn_hirarki
FROM
    penjawatan
ORDER BY pjwn_penyelia_pjwn_id IS NULL DESC , pjwn_hirarki DESC , pjwn_gelaran ASC , pjwn_id DESC;");
            $senarai = NULL;
            foreach ($query->result() as $row) {
                $senarai[$row->pjwn_id] = ['pjwn_gelaran' => $row->pjwn_gelaran, 'pjwn_penyelia_pjwn_id' => $row->pjwn_penyelia_pjwn_id, 'pjwn_hirarki' => $row->pjwn_hirarki];
            }
            
            $parent_pjwn = [];
            $child_pjwn = [];
            
            // split between main and child org
            foreach ($senarai as $id => $details) {
                if (empty($details['pjwn_penyelia_pjwn_id'])) {
                    $parent_pjwn[$id] = $details['pjwn_gelaran'];
                } else {
                    $child_pjwn[$id] = $details;
                    ksort($child_pjwn);
                }
            }
            
            for ($i = 1; count($senarai) <> count($parent_pjwn); $i++) {
                $tempArray = [];
                $CountParent = 1;
                foreach ($parent_pjwn as $ParentID => $ParentNama) {
                    foreach ($child_pjwn as $ChildID => $ChildData) {
                        if ($ChildData['pjwn_penyelia_pjwn_id'] == $ParentID) {
                            $tempArray[$ChildID] = str_repeat("&emsp;", ($i - 1)) . '&#10149; ' . $ChildData['pjwn_gelaran'];
                            unset($child_pjwn[$ChildID]); // remove array after copy to temp
                        }
                    }
                    $parent_pjwn = array_slice($parent_pjwn, 0, $CountParent, true) + $tempArray + array_slice($parent_pjwn, $CountParent, NULL, true);
                    $CountParent++;
                }
            }
            
            return $parent_pjwn;
        } else if ('ajaxReload' == $opt) {
            $query = $this->db->query("SELECT 
    p.pjwn_id,
    p.pjwn_staf_id,
    staf_nama,
    p.pjwn_penyelia_pjwn_id,
    y.pjwn_gelaran AS pjwn_penyelia_pjwn_gelaran,
    p.pjwn_gelaran,
    p.pjwn_kod,
    p.pjwn_gred,
    p.pjwn_tel,
    p.pjwn_tel_samb,
    p.pjwn_org_id,
    o.org_nama,
    po.org_id AS po_org_id,
    po.org_nama AS po_org_nama,
    ppo.org_id AS ppo_org_id,
    ppo.org_nama AS ppo_org_nama,
    pppo.org_id AS pppo_org_id,
    pppo.org_nama AS pppo_org_nama,
    p.pjwn_hirarki,
    p.pjwn_catatan
FROM
    penjawatan AS p
        LEFT JOIN
    staf ON p.pjwn_staf_id = staf_id
        LEFT JOIN
    penjawatan AS y ON p.pjwn_penyelia_pjwn_id = y.pjwn_id
        LEFT JOIN
    organisasi AS o ON p.pjwn_org_id = o.org_id
        LEFT JOIN
    organisasi AS po ON o.org_sub_org_id = po.org_id
        LEFT JOIN
    organisasi AS ppo ON po.org_sub_org_id = ppo.org_id
        LEFT JOIN
    organisasi AS pppo ON ppo.org_sub_org_id = pppo.org_id
WHERE o.org_id = $id");
            $senarai = NULL;
            
            foreach ($query->result() as $row) {
                // full name organisasi
                $f_org_nama = $row->org_nama;
                $f_org_nama .= (empty($row->po_org_nama)) ? '' : ", {$row->po_org_nama}";
                $f_org_nama .= (empty($row->ppo_org_nama)) ? '' : ", {$row->ppo_org_nama}";
                $f_org_nama .= (empty($row->pppo_org_nama)) ? '' : ", {$row->pppo_org_nama}";
                
                $senarai[$row->pjwn_id] = [
                    'pjwn_id' => $row->pjwn_id,
                    'pjwn_staf_id' => $row->pjwn_staf_id,
                    'staf_nama' => (empty($row->staf_nama)) ? '' : $row->staf_nama,
                    'pjwn_penyelia_pjwn_id' => $row->pjwn_penyelia_pjwn_id,
                    'pjwn_penyelia_pjwn_gelaran' => (empty($row->pjwn_penyelia_pjwn_gelaran)) ? '' : $row->pjwn_penyelia_pjwn_gelaran,
                    'pjwn_gelaran' => $row->pjwn_gelaran,
                    'pjwn_kod' => $row->pjwn_kod,
                    'pjwn_gred' => $row->pjwn_gred,
                    'pjwn_tel' => (empty($row->pjwn_tel)) ? '' : $row->pjwn_tel,
                    'pjwn_tel_samb' => (empty($row->pjwn_tel_samb)) ? '' : $row->pjwn_tel_samb,
                    'pjwn_org_id' => $row->pjwn_org_id,
                    'org_nama' => $row->org_nama,
                    'po_org_nama' => (empty($row->po_org_nama)) ? '' : $row->po_org_nama,
                    'ppo_org_nama' => (empty($row->ppo_org_nama)) ? '' : $row->ppo_org_nama,
                    'pppo_org_nama' => (empty($row->pppo_org_nama)) ? '' : $row->pppo_org_nama,
                    'f_org_nama' => $f_org_nama,
                    'pjwn_hirarki' => $row->pjwn_hirarki,
                    'pjwn_catatan' => (empty($row->pjwn_catatan)) ? '' : $row->pjwn_catatan,
                ];
            }
            return $senarai;
        } else {
            $query = $this->db->query("SELECT 
    p.pjwn_id,
    p.pjwn_staf_id,
    staf_nama,
    p.pjwn_penyelia_pjwn_id,
    y.pjwn_gelaran AS pjwn_penyelia_pjwn_gelaran,
    p.pjwn_gelaran,
    p.pjwn_kod,
    p.pjwn_gred,
    p.pjwn_tel,
    p.pjwn_tel_samb,
    p.pjwn_org_id,
    o.org_nama,
    po.org_id AS po_org_id,
    po.org_nama AS po_org_nama,
    ppo.org_id AS ppo_org_id,
    ppo.org_nama AS ppo_org_nama,
    pppo.org_id AS pppo_org_id,
    pppo.org_nama AS pppo_org_nama,
    p.pjwn_hirarki,
    p.pjwn_catatan
FROM
    penjawatan AS p
        LEFT JOIN
    staf ON p.pjwn_staf_id = staf_id
        LEFT JOIN
    penjawatan AS y ON p.pjwn_penyelia_pjwn_id = y.pjwn_id
        LEFT JOIN
    organisasi AS o ON p.pjwn_org_id = o.org_id
        LEFT JOIN
    organisasi AS po ON o.org_sub_org_id = po.org_id
        LEFT JOIN
    organisasi AS ppo ON po.org_sub_org_id = ppo.org_id
        LEFT JOIN
    organisasi AS pppo ON ppo.org_sub_org_id = pppo.org_id");
            $senarai = NULL;
            
            foreach ($query->result() as $row) {
                // full name organisasi
                $f_org_nama = $row->org_nama;
                $f_org_nama .= (empty($row->po_org_nama)) ? '' : ", {$row->po_org_nama}";
                $f_org_nama .= (empty($row->ppo_org_nama)) ? '' : ", {$row->ppo_org_nama}";
                $f_org_nama .= (empty($row->pppo_org_nama)) ? '' : ", {$row->pppo_org_nama}";
                
                $senarai[$row->pjwn_id] = [
                    'pjwn_id' => $row->pjwn_id,
                    'pjwn_staf_id' => $row->pjwn_staf_id,
                    'staf_nama' => (empty($row->staf_nama)) ? '' : $row->staf_nama,
                    'pjwn_penyelia_pjwn_id' => $row->pjwn_penyelia_pjwn_id,
                    'pjwn_penyelia_pjwn_gelaran' => (empty($row->pjwn_penyelia_pjwn_gelaran)) ? '' : $row->pjwn_penyelia_pjwn_gelaran,
                    'pjwn_gelaran' => $row->pjwn_gelaran,
                    'pjwn_kod' => $row->pjwn_kod,
                    'pjwn_gred' => $row->pjwn_gred,
                    'pjwn_tel' => (empty($row->pjwn_tel)) ? '' : $row->pjwn_tel,
                    'pjwn_tel_samb' => (empty($row->pjwn_tel_samb)) ? '' : $row->pjwn_tel_samb,
                    'pjwn_org_id' => $row->pjwn_org_id,
                    'org_nama' => $row->org_nama,
                    'po_org_nama' => (empty($row->po_org_nama)) ? '' : $row->po_org_nama,
                    'ppo_org_nama' => (empty($row->ppo_org_nama)) ? '' : $row->ppo_org_nama,
                    'pppo_org_nama' => (empty($row->pppo_org_nama)) ? '' : $row->pppo_org_nama,
                    'f_org_nama' => $f_org_nama,
                    'pjwn_hirarki' => $row->pjwn_hirarki,
                    'pjwn_catatan' => (empty($row->pjwn_catatan)) ? '' : $row->pjwn_catatan,
                ];
            }
            return $senarai;
        }
        
    }
    
    public function get_staf($opt = FALSE, $id = 0, $ShowAll = FALSE) {
        
        if ('checkID' == $opt) {
            $query = $this->db->query("SELECT * FROM staf WHERE staf_id = $id");
            return (1 == $query->num_rows()) ? $query->row() : FALSE;
        } else if ('HTMLselect' == $opt) {
            
            $SQL = "SELECT 
    staf_id, staf_nama, staf_gred, org_nama
FROM
    penjawatan
        INNER JOIN
    staf ON staf_id = pjwn_staf_id
        INNER JOIN
    organisasi ON pjwn_org_id = org_id
WHERE
    staf_status = 'Aktif'
ORDER BY org_sub_org_id IS NULL DESC, org_hirarki DESC, org_nama ASC, org_id DESC";
            
            if ($ShowAll) {
                $SQL = "SELECT 
    staf_id, staf_nama, staf_gred, org_nama
FROM
    staf
        LEFT JOIN
    penjawatan ON staf_id = pjwn_staf_id
        LEFT JOIN
    organisasi ON pjwn_org_id = org_id
WHERE
    staf_status = 'Aktif'
ORDER BY org_sub_org_id IS NULL DESC , org_hirarki DESC , pjwn_hirarki ASC , org_nama ASC , org_id DESC";
            }
            
            $query = $this->db->query($SQL);

            $senarai_staf = [];
            foreach ($query->result() as $row) {
                if (array_key_exists($row->org_nama, $senarai_staf)) {
                    $senarai_staf[$row->org_nama] += [$row->staf_id => "[ {$row->staf_gred} ] {$row->staf_nama}"];
                } else {
                    $senarai_staf[$row->org_nama] = [$row->staf_id => "[ {$row->staf_gred} ] {$row->staf_nama}"];
                }
            }
            return $senarai_staf;
            
        } else {
            $query = $this->db->query("SELECT * FROM staf");
            $senarai = NULL;
            
            foreach ($query->result() as $row) {
                $senarai[$row->staf_id] = [
                    'staf_id' => $row->staf_id,
                    'staf_mykad' => (empty($row->staf_mykad)) ? '' : $row->staf_mykad,
                    'staf_gelaran' => (empty($row->staf_gelaran)) ? '' : $row->staf_gelaran,
                    'staf_nama' => $row->staf_nama,
                    'staf_jawatan' => (empty($row->staf_jawatan)) ? '' : $row->staf_jawatan,
                    'staf_gred' => (empty($row->staf_gred)) ? '' : $row->staf_gred,
                    'staf_taraf' => (empty($row->staf_taraf)) ? '' : $row->staf_taraf,
                    'staf_emel' => (empty($row->staf_emel)) ? '' : $row->staf_emel,
                    'staf_status' => $row->staf_status,
                    'staf_catatan' => (empty($row->staf_catatan)) ? '' : $row->staf_catatan,
                ];
            }
            return $senarai;
        }
    }
    
    public function get_enum($table = NULL, $column = NULL) {
        if (!empty($table) and !empty($column)) {
            $query = $this->db->query("SELECT 
    TRIM(TRAILING ')' FROM SUBSTRING(COLUMN_TYPE, 6)) AS enum_list
FROM
    information_schema.COLUMNS
WHERE
    TABLE_NAME = '$table'
        AND COLUMN_NAME = '$column'");
            $row = $query->row();
            if (isset($row)) {
                return explode(",", str_replace("'","",$row->enum_list));
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function get_senarai($table = NULL, $column = NULL) {
        if (!empty($table) and !empty($column)) {
            $query = $this->db->query("SELECT DISTINCT
    ($column) AS senarai
FROM
    $table
WHERE
    $column IS NOT NULL AND TRIM($column) <> ''
ORDER BY $column ASC");
            $senarai = NULL;
            foreach ($query->result() as $row) {
                $senarai[] = $row->senarai;
            }
            return $senarai;
        } else {
            return FALSE;
        }
    }
    
    public function get_bil($table = NULL, $column = NULL) {
        
        if (!empty($table) and !empty($column)) {
            $query = $this->db->query("SELECT $column FROM $table");
            return $query->num_rows();
        } else {
            return FALSE;
        }
    }
    
    public function get_penyelia($gelaran = FALSE) {
        $query = $this->db->query("SELECT 
    pjwn_id, staf_nama, staf_gred, pjwn_gelaran, org_nama
FROM
    penjawatan
        INNER JOIN
    staf ON staf_id = pjwn_staf_id
        INNER JOIN
    organisasi ON pjwn_org_id = org_id
ORDER BY org_sub_org_id IS NULL DESC , org_hirarki DESC , org_nama ASC , org_id DESC");
        
        $senarai_penyelia = [];
        foreach ($query->result() as $row) {
            
            if ($gelaran) {
                if (array_key_exists($row->org_nama, $senarai_penyelia)) {
                    $senarai_penyelia[$row->org_nama] += [$row->pjwn_id => ["[ {$row->staf_gred} ] {$row->staf_nama}", $row->pjwn_gelaran]];
                } else {
                    $senarai_penyelia[$row->org_nama] = [$row->pjwn_id => ["[ {$row->staf_gred} ] {$row->staf_nama}", $row->pjwn_gelaran]];
                }
            } else {
                if (array_key_exists($row->org_nama, $senarai_penyelia)) {
                    $senarai_penyelia[$row->org_nama] += [$row->pjwn_id => "[ {$row->staf_gred} ] {$row->staf_nama}"];
                } else {
                    $senarai_penyelia[$row->org_nama] = [$row->pjwn_id => "[ {$row->staf_gred} ] {$row->staf_nama}"];
                }
            }
        }
        return $senarai_penyelia;
    }
    
    public function get_pjwn_kod($pjwn_kod = NULL, $pjwn_id = NULL) {
        
        // from callback__semak_pjwn_kod
        $sql = '';
        
        if(empty($pjwn_id)) {
            $sql = "SELECT pjwn_id FROM penjawatan WHERE pjwn_kod = '$pjwn_kod'";
        } else {
            $sql = "SELECT pjwn_id FROM penjawatan WHERE pjwn_kod = '$pjwn_kod' AND pjwn_id <> $pjwn_id";
        }
        
        $query = $this->db->query($sql);
        return ($query->num_rows() > 0) ? FALSE : TRUE;
    }
    
    public function get_pentadbir($opt = FALSE, $id = 0) {
        if ('checkStafID' == $opt) {
            $query = $this->db->query("SELECT * FROM pentadbir WHERE ptdb_staf_id = $id");
            return $query->num_rows();
        }
    }
    
    /*
     * SET Functions
     */
    
    public function set_organisasi($dataOrganisasi = NULL, $action = '') {
        if ((!empty($dataOrganisasi))) {
            $org_id = '';
            $org_sub_org_id = '';
            $org_nama = '';
            $org_alamat = '';
            $org_poskod = '';
            $org_negeri = '';
            $org_negara = '';
            $org_tel = '';
            $org_tel_samb = '';
            $org_fax = '';
            $org_emel = '';
            $org_hirarki = '';
            $org_papar_sub = '';
            $org_catatan = '';
            extract($dataOrganisasi, EXTR_OVERWRITE);
            
            $query = '';
            
            if ('insert' == $action) {
                $query = "INSERT INTO organisasi 
( 
    org_sub_org_id, 
    org_nama, 
    org_alamat, 
    org_poskod, 
    org_negeri, 
    org_negara, 
    org_tel, 
    org_tel_samb, 
    org_fax, 
    org_emel, 
    org_hirarki, 
    org_papar_sub, 
    org_catatan 
) 
VALUES 
( 
    {$this->_sqldata($org_sub_org_id, FALSE)}, 
    {$this->_sqldata($org_nama)}, 
    {$this->_sqldata($org_alamat)}, 
    {$this->_sqldata($org_poskod)}, 
    {$this->_sqldata($org_negeri)}, 
    {$this->_sqldata($org_negara)}, 
    {$this->_sqldata($org_tel)}, 
    {$this->_sqldata($org_tel_samb)}, 
    {$this->_sqldata($org_fax)}, 
    {$this->_sqldata($org_emel)}, 
    {$this->_sqldata($org_hirarki, FALSE, 0)}, 
    {$this->_sqldata($org_papar_sub, TRUE, 'Tidak')}, 
    {$this->_sqldata($org_catatan)} 
)";
            } else if ('update' == $action) {
                $query = "UPDATE organisasi 
SET 
    org_sub_org_id = {$this->_sqldata($org_sub_org_id, FALSE)}, 
    org_nama = {$this->_sqldata($org_nama)}, 
    org_alamat = {$this->_sqldata($org_alamat)}, 
    org_poskod = {$this->_sqldata($org_poskod)}, 
    org_negeri = {$this->_sqldata($org_negeri)}, 
    org_negara = {$this->_sqldata($org_negara)}, 
    org_tel = {$this->_sqldata($org_tel)}, 
    org_tel_samb = {$this->_sqldata($org_tel_samb)}, 
    org_fax = {$this->_sqldata($org_fax)}, 
    org_emel = {$this->_sqldata($org_emel)}, 
    org_hirarki = {$this->_sqldata($org_hirarki, FALSE)}, 
    org_papar_sub = {$this->_sqldata($org_papar_sub, TRUE, 'Tidak')}, 
    org_catatan = {$this->_sqldata($org_catatan)} 
WHERE 
    org_id = {$this->_sqldata($org_id, FALSE)}";
            } else if ('delete' == $action) {
                $query = "DELETE FROM organisasi WHERE org_id = {$this->_sqldata($org_id, FALSE)}";
            }
            
            $queryResult = ($this->db->simple_query($query)) ? 1 : $this->db->error();
            
            if ('insert' == $action) {
                $org_id = $this->db->insert_id();
            }
            if (('insert' == $action) OR (('update' == $action))) {
                //$this->session->set_flashdata('NewID', $org_id);
                $_SESSION['NewID'] = $org_id;
            }
            
            return $queryResult;
        } else {
            return 2;
        }
    }
    
    public function set_staf($dataStaf = NULL, $action = '') {
        if ((!empty($dataStaf))) {
            $staf_id = '';
            $staf_mykad = '';
            $staf_gelaran = '';
            $staf_nama = '';
            $staf_jawatan = '';
            $staf_gred = '';
            $staf_taraf = '';
            $staf_emel = '';
            $staf_status = '';
            $staf_catatan = '';
            extract($dataStaf, EXTR_OVERWRITE);
            
            $query = '';
            
            if ('insert' == $action) {
                $query = "INSERT INTO staf 
( 
    staf_mykad, 
    staf_gelaran, 
    staf_nama, 
    staf_jawatan, 
    staf_gred, 
    staf_taraf, 
    staf_emel, 
    staf_status, 
    staf_catatan
) 
VALUES 
( 
    {$this->_sqldata($staf_mykad)}, 
    {$this->_sqldata($staf_gelaran)}, 
    {$this->_sqldata($staf_nama)}, 
    {$this->_sqldata($staf_jawatan)}, 
    {$this->_sqldata($staf_gred)}, 
    {$this->_sqldata($staf_taraf)}, 
    {$this->_sqldata($staf_emel)}, 
    {$this->_sqldata($staf_status, TRUE, 'Aktif')}, 
    {$this->_sqldata($staf_catatan)}
)";
            } else if ('update' == $action) {
                $query = "UPDATE staf 
SET 
    staf_mykad = {$this->_sqldata($staf_mykad)}, 
    staf_gelaran = {$this->_sqldata($staf_gelaran)}, 
    staf_nama = {$this->_sqldata($staf_nama)}, 
    staf_jawatan = {$this->_sqldata($staf_jawatan)}, 
    staf_gred = {$this->_sqldata($staf_gred)}, 
    staf_taraf = {$this->_sqldata($staf_taraf)}, 
    staf_emel = {$this->_sqldata($staf_emel)}, 
    staf_status = {$this->_sqldata($staf_status, TRUE, 'Aktif')}, 
    staf_catatan = {$this->_sqldata($staf_catatan)} 
WHERE 
    staf_id = {$this->_sqldata($staf_id, FALSE)}";
            } else if ('delete' == $action) {
                $query = "DELETE FROM staf WHERE staf_id = {$this->_sqldata($staf_id, FALSE)}";
            }
            
            $queryResult = ($this->db->simple_query($query)) ? 1 : $this->db->error();
            
            if ('insert' == $action) {
                $staf_id = $this->db->insert_id();
            }
            if (('insert' == $action) OR (('update' == $action))) {
                //$this->session->set_flashdata('NewID', $org_id);
                $_SESSION['NewID'] = $staf_id;
            }
            
            return $queryResult;
            
        } else {
            return 2;
        }
    }
    
    public function set_penjawatan($dataPenjawatan = NULL, $action = '') {
        if ((!empty($dataPenjawatan))) {
            $pjwn_id = '';
            $pjwn_staf_id = '';
            $pjwn_penyelia_pjwn_id = '';
            $pjwn_gelaran = '';
            $pjwn_kod = '';
            $pjwn_gred = '';
            $pjwn_tel = '';
            $pjwn_tel_samb = '';
            $pjwn_org_id = '';
            $pjwn_hirarki = '';
            $pjwn_catatan = '';
            extract($dataPenjawatan, EXTR_OVERWRITE);
            
            $query = '';
            
            if ('insert' == $action) {
                
                $query = "INSERT INTO penjawatan 
( 
    pjwn_staf_id, 
    pjwn_penyelia_pjwn_id, 
    pjwn_gelaran, 
    pjwn_kod, 
    pjwn_gred, 
    pjwn_tel,
    pjwn_tel_samb,
    pjwn_org_id, 
    pjwn_hirarki, 
    pjwn_catatan
) 
VALUES 
( 
    {$this->_sqldata($pjwn_staf_id, FALSE)}, 
    {$this->_sqldata($pjwn_penyelia_pjwn_id, FALSE)}, 
    {$this->_sqldata($pjwn_gelaran)}, 
    {$this->_sqldata($pjwn_kod)}, 
    {$this->_sqldata($pjwn_gred)}, 
    {$this->_sqldata($pjwn_tel)}, 
    {$this->_sqldata($pjwn_tel_samb)},
    {$this->_sqldata($pjwn_org_id, FALSE)}, 
    {$this->_sqldata($pjwn_hirarki, FALSE)}, 
    {$this->_sqldata($pjwn_catatan)}
)";
                
            } else if ('update' == $action) {
                
                $query = "UPDATE penjawatan 
    SET 
        pjwn_staf_id = {$this->_sqldata($pjwn_staf_id, FALSE)}, 
        pjwn_penyelia_pjwn_id = {$this->_sqldata($pjwn_penyelia_pjwn_id, FALSE)}, 
        pjwn_gelaran = {$this->_sqldata($pjwn_gelaran)}, 
        pjwn_kod = {$this->_sqldata($pjwn_kod)}, 
        pjwn_gred = {$this->_sqldata($pjwn_gred)}, 
        pjwn_tel = {$this->_sqldata($pjwn_tel)}, 
        pjwn_tel_samb = {$this->_sqldata($pjwn_tel_samb)},
        pjwn_org_id = {$this->_sqldata($pjwn_org_id, FALSE)}, 
        pjwn_hirarki = {$this->_sqldata($pjwn_hirarki, FALSE)}, 
        pjwn_catatan = {$this->_sqldata($pjwn_catatan)} 
    WHERE 
        pjwn_id = {$this->_sqldata($pjwn_id, FALSE)}";
                
            } else if ('update_profail' == $action) {
                
                $query = "UPDATE penjawatan 
    SET 
        pjwn_gelaran = {$this->_sqldata($pjwn_gelaran)}, 
        pjwn_kod = {$this->_sqldata($pjwn_kod)}, 
        pjwn_gred = {$this->_sqldata($pjwn_gred)}, 
        pjwn_tel = {$this->_sqldata($pjwn_tel)}, 
        pjwn_tel_samb = {$this->_sqldata($pjwn_tel_samb)}, 
        pjwn_org_id = {$this->_sqldata($pjwn_org_id, FALSE)}, 
        pjwn_penyelia_pjwn_id = {$this->_sqldata($pjwn_penyelia_pjwn_id, FALSE)}, 
        pjwn_catatan = {$this->_sqldata($pjwn_catatan)} 
    WHERE 
        pjwn_id = {$this->_sqldata($pjwn_id, FALSE)}";
                
            } else if ('delete' == $action) {
                $query = "DELETE FROM penjawatan WHERE pjwn_id = {$this->_sqldata($pjwn_id, FALSE)}";
            }
            
            $queryResult = ($this->db->simple_query($query)) ? 1 : $this->db->error();
            
            if ('insert' == $action) {
                $pjwn_id = $this->db->insert_id();
            }
            if (('insert' == $action) OR (('update' == $action))) {
                //$this->session->set_flashdata('NewID', $org_id);
                $_SESSION['NewID'] = $pjwn_id;
            }
            
            return $queryResult;
            
        } else {
            return 2;
        }
    }
    
    
    /*
     * PRIVATE FUNCTIONS - by using underscore
     */
    
    function _sqldata($data = '', $string = TRUE, $default = FALSE) {
        if (empty($default) && !is_numeric($default)) {
            if ($string) {
                return (empty($data) && !is_numeric($data)) ? 'NULL' : "{$this->db->escape($data)}";
            } else {
                return (empty($data) && !is_numeric($data)) ? 'NULL' : $data;
            }
        } else {
            if ($string) {
                return (empty($data) && !is_numeric($data)) ? "{$this->db->escape($default)}" : "{$this->db->escape($data)}";
            } else {
                return (empty($data) && !is_numeric($data)) ? $default : $data;
            }
        }
    }
}
