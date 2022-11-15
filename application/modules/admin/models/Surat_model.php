<?php
class Surat_model extends CI_Model
{
    public function get_surat($role)
    {
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
            $prodi = '';
        } else {
            $prodi = "AND u.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
        }
        if ($role == '55') {
            $id_status = '';
        } else if ($role == 1) {
            $id_status = "AND ss.id_status =  9";
        } else if ($role == 2) {
            $id_status = "AND (ss.id_status =  2 OR ss.id_status = 5)";
        } else if ($role == 5) {
            $id_status = "AND ss.id_status =  8";
        } else if ($role == 6) {
            $id_status = "AND (ss.id_status =  3 OR ss.id_status = 7)";
        } else if ($role == 100) {
            $id_status = "AND ss.id_status =  10";
        }

        $query = $this->db->query("SELECT s.id as id_surat, s.id_mahasiswa, u.fullname, ss.id_status, st.id as id_status, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, u.id_prodi, pr.prodi
        FROM surat s
        LEFT JOIN users u ON u.id = s.id_mahasiswa
        LEFT JOIN prodi pr ON pr.id = u.id_prodi
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat      
        WHERE ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat=s.id)
        AND ss.id_status != 1 $id_status
        $prodi
        ORDER BY s.id DESC      
        ");
        return $result = $query->result_array();
    }
    public function get_surat_internal($role)
    {
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
            $prodi = '';
        } else {
            $prodi = "AND u.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
        }
        if ($role == '') {
            $id_status = '';
        } else if ($role == 1) {
            $id_status = "AND ss.id_status =  9";
        } else if ($role == 2) {
            $id_status = "AND (ss.id_status =  2 OR ss.id_status = 5)";
        } else if ($role == 5) {
            $id_status = "AND ss.id_status =  8";
        } else if ($role == 6) {
            $id_status = "AND (ss.id_status =  3 OR ss.id_status = 7)";
        } else if ($role == 100) {
            $id_status = "AND ss.id_status =  10";
        }

        $query = $this->db->query("SELECT s.id as id_surat, s.id_mahasiswa, u.fullname, ss.id_status, st.id as id_status, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, u.id_prodi, pr.prodi
        FROM surat s
        LEFT JOIN users u ON u.id = s.id_mahasiswa
        LEFT JOIN prodi pr ON pr.id = u.id_prodi
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat      
        -- WHERE ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat=s.id)
        WHERE k.klien='p'
       -- AND ss.id_status != 1 $id_status
       -- $prodi
        ORDER BY s.id DESC      
        ");
        return $result = $query->result_array();
    }

    public function get_detail_surat($id_surat)
    {
        $query = $this->db->query("SELECT 
        s.id, 
        s.id_kategori_surat, 
        s.id_mahasiswa, 
        k.kategori_surat, 
        k.klien, 
        k.template, 
        k.tujuan_surat, 
        k.tembusan, 
        ss.id_status, 
        st.status, 
        st.badge, 
        u.id as user_id, 
        u.fullname,
        u.username,  
        k.kat_keterangan_surat, 
        u.id_prodi, 
        pr.prodi,
        n.id as id_notif
        FROM surat s      
        LEFT JOIN surat_status ss ON ss.id_surat = s.id 
        LEFT JOIN users u ON u.id = s.id_mahasiswa 
        LEFT JOIN prodi pr ON pr.id = u.id_prodi              
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat
        LEFT JOIN notif n ON n.id_surat = s.id
        WHERE s.id = '$id_surat' AND ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat ='$id_surat')
        
        ");
        return $result = $query->row_array();
    }

    public function get_no_surat($id_surat)
    {
        $no_surat = $this->db->query("select ns.no_surat, ns.instansi, kts.kode, ts.kode_tujuan, us.kode as kode_us, tanggal_terbit, file, no_lengkap, DATE_FORMAT(tanggal_terbit, '%c') as bulan, DATE_FORMAT(tanggal_terbit, '%Y') as tahun, DATE_FORMAT(tanggal_terbit, '%c %M %Y') as tanggal_full from no_surat ns 
			LEFT JOIN kat_tujuan_surat kts ON kts.id=ns.kat_tujuan_surat
			LEFT JOIN tujuan_surat ts ON ts.id=ns.tujuan_surat
			LEFT JOIN urusan_surat us ON us.id=ns.urusan_surat
			where ns.id_surat= $id_surat
            ")->row_array();

        return $no_surat;
    }
    public function get_kategori_surat($klien)
    {

        if ($klien == '') {
            $where = '';
        } else {
            $where = "WHERE klien='$klien'";
        }

        $query = $this->db->query("SELECT * FROM kategori_surat 
            $where;
        ");


        return $result = $query->result_array();
    }
    public function get_kategori_surat_byid($id)
    {
        $query = $this->db->query("SELECT * FROM kategori_surat where id='$id'");
        return $result = $query->row_array();
    }
    public function edit_kategori_surat($data, $id)
    {
        return $this->db->update('kategori_surat', $data, array('id' => $id));
    }

  
    public function tambah($data)
    {
        return $this->db->insert('surat', $data);
    }

    public function get_surat_status($id_surat)
    {
        return $this->db->select('ss.*, DATE_FORMAT(ss.date,"%d %M %Y") as date, st.status')
            ->from('surat_status ss')
            ->join('status st', 'ss.id_status=st.id', 'left')
            ->where(array('ss.id_surat' => $id_surat, 'ss.id_status !=' => '0', 'ss.id_status !=' => '1'))->get()->result_array();
    }

    //class Kategori
    public function get_kat_keterangan_surat()
    {
        return $this->db->get('kat_keterangan_surat')->result_array();
    }

    public function get_timeline($id_surat)
    {
        $query = $this->db->query("SELECT ss.id_status, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, s.status, s.badge          
        FROM surat_status ss
        LEFT JOIN status s ON s.id = ss.id_status  
        where ss.id_surat='$id_surat'
        ORDER BY ss.id DESC
        ");
        return $result = $query->result_array();
    }
}
