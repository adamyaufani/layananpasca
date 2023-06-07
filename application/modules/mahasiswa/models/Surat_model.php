<?php
class Surat_model extends CI_Model
{
    // public function get_surat($role)
    // {
    //     if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
    //         $prodi = '';
    //     } else {
    //         $prodi = "AND u.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
    //     }
    //     if ($role == '') {
    //         $id_status = '';
    //     } else if ($role == 1) {
    //         $id_status = "AND ss.id_status =  8 OR ss.id_status =  3";
    //     } else if ($role == 2) {
    //         $id_status = "AND (ss.id_status =  2 OR ss.id_status = 5)";
    //     } else if ($role == 5) {
    //         $id_status = "AND ss.id_status =  9";
    //     } else if ($role == 6) {
    //         $id_status = "AND (ss.id_status =  3 OR ss.id_status = 7)";
    //     } else if ($role == 100) {
    //         $id_status = "AND ss.id_status =  10";
    //     }

    //     $query = $this->db->query("SELECT s.id as id_surat, s.id_mahasiswa, u.fullname, ss.id_status, st.id as id_status, s.id_kategori_surat, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, u.id_prodi, pr.prodi
    //     FROM surat s
    //     LEFT JOIN users u ON u.id = s.id_mahasiswa
    //     LEFT JOIN prodi pr ON pr.id = u.id_prodi
    //     LEFT JOIN surat_status ss ON ss.id_surat = s.id
    //     LEFT JOIN status st ON st.id = ss.id_status
    //     LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat      
    //     WHERE ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat=s.id)
    //     AND ss.id_status != 1 AND ss.id_status != 11 AND ss.id_status != 20 AND s.id_kategori_surat != 6
    //     -- $id_status
    //     $prodi
    //     ORDER BY ss.date DESC      
    //     ");
    //     return $result = $query->result_array();
    // }

    public function get_surat($role)
    {
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
            $prodi = '';
        } else {
            $prodi = "AND u.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
        }
        if ($role == '') {
            $id_status = '';
        } else if ($role == 1) {
            $id_status = "AND ss.id_status =  8";
        } else if ($role == 2) {
            $id_status = "AND (ss.id_status =  2 OR ss.id_status = 5)";
        } else if ($role == 5) {
            $id_status = "AND ss.id_status =  9";
        } else if ($role == 6) {
            $id_status = "AND (ss.id_status =  3 OR ss.id_status = 7)";
        } else if ($role == 100) {
            $id_status = "AND ss.id_status =  10";
        }

        $query = $this->db->query("SELECT s.id as id_surat, s.id_mahasiswa, u.fullname, ss.id_status, st.id as id_status, s.id_kategori_surat, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, u.id_prodi, pr.prodi
        FROM surat s
        LEFT JOIN users u ON u.id = s.id_mahasiswa
        LEFT JOIN prodi pr ON pr.id = u.id_prodi
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat      
        WHERE ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat=s.id)
        AND ss.id_status != 1 AND ss.id_status != 11
        $id_status
        $prodi
        ORDER BY ss.date DESC     
        ");
        return $result = $query->result_array();
    }

    public function get_surat_internal($role)
    {

        if ($role == 1) {
            $klien = "AND k.klien='p'";
            $prodi = '';
        } else if ($role == 2) {
            $klien = "AND k.klien='j' ";
            $prodi = "AND u.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
        }

        $query = $this->db->query("SELECT s.id as id_surat, s.id_mahasiswa, u.fullname, ss.id_status, st.id as id_status, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, u.id_prodi, pr.prodi
        FROM surat s
        LEFT JOIN users u ON u.id = s.id_mahasiswa
        LEFT JOIN prodi pr ON pr.id = u.id_prodi
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat      
        WHERE ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat=s.id)
        $klien       
        $prodi
        ORDER BY s.id DESC      
        ");
        return $result = $query->result_array();
    }


    public function get_surat_bymahasiswa($id_mhs)
    {
        $query = $this->db->query("SELECT s.id as id_surat, ss.id_status, s.id_kategori_surat, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full
        FROM surat s
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat
        WHERE s.id_mahasiswa='$id_mhs' AND ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat=s.id)  AND ss.id_status NOT IN(20)
        ORDER BY s.id DESC        
        ");
        return $result = $query->result_array();
    }
    public function get_surat_bycat($id_mhs, $cat)
    {
        $query = $this->db->query("SELECT s.id as id_surat, ss.id_status, s.id_kategori_surat, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full
        FROM surat s
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat
        WHERE s.id_mahasiswa='$id_mhs' AND s.id_kategori_surat= '$cat' AND ss.id_status = (SELECT id_status FROM surat_status WHERE id_surat=s.id ORDER BY date desc LIMIT 1)  AND ss.id_status NOT IN(20)
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
        k.template as template_lama, 
        k.klien, 
        k.tujuan_surat, 
        k.tembusan, 
        k.kode, 
        ss.id_status, 
        ss.catatan, 
        st.status, 
        st.icon,
        st.badge, 
        st.alert, 
        u.id_prodi, 
        u.id as user_id, 
        pr.prodi, 
        u.fullname, 
        u.username,
        n.id as id_notif
        FROM 
        surat s
        LEFT JOIN users u ON u.id = s.id_mahasiswa        
        LEFT JOIN surat_status ss ON ss.id_surat = s.id        
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN prodi pr ON pr.id = u.id_prodi    
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat
        LEFT JOIN notif n ON n.id_surat = s.id
        WHERE 
        s.id = '$id_surat' 
        AND 
        ss.id_status= (
            SELECT 
            id_status
            FROM 
            surat_status 
            WHERE 
            id_surat ='$id_surat'
            ORDER BY date DESC limit 1
            )
        ");
        return $result = $query->row_array();
    }

    /*
    Mengambil kategori surat berdasarkan klien (user role) 

    $klien =
    m = mahasiswa
    d = dosen
    t = tu
    a = admin
    d = direktur pasca
    k = kaprodi

    $prodi = nama prodi, ada bbrp surat yang hanya khusus untuk prodi tertentu
    $aktif = status aktif/tidak aktif mahasiswa pada semester dan tahun ini jika $klien = 'm'
    */

    public function get_kategori_surat($klien, $excl)
    {

        if ($klien == '') {
            $where = '';
        } else {
            $where = "WHERE klien='$klien'";
        }

        if ($excl == '') {
            $where2 = '';
        } else {
            $where2 = "AND id NOT IN ('$excl')";
        }

        $query = $this->db->query("SELECT * FROM kategori_surat 
            $where $where2;
        ");


        return $result = $query->result_array();
    }

    function simpan_upload($judul, $gambar)
    {
        $hasil = $this->db->query("INSERT INTO keterangan_surat(ket_value,gambar) VALUES ('$judul','$gambar')");
        return $hasil;
    }

    public function getPembimbing($search)
    {
        // cek user ke tabel Mhs (SQLSERVER UMY)
        $db2 = $this->load->database('dbsqlsrv', TRUE);

        $db2->select('*');
        $db2->from('V_Import_Simpegawai');
        $db2->like('nama', $search);
        $db2->limit(10);
        return $db2->get()->result_array();
    }

    public function getMahasiswa($search)
    {
        // cek user ke tabel Mhs (SQLSERVER UMY)
        $db2 = $this->load->database('dbsqlsrv', TRUE);

        $result = $db2->query("SELECT * from V_Simpel_Pasca WHERE FULLNAME LIKE '%" . $search . "%' AND department_id =" . $_SESSION['id_prodi'])->result_array();

        return $result;
    }

    public function generate_no_surat($no_surat, $kat_tujuan_surat, $tujuan_surat, $urusan_surat)
    {

        $kat_tujuan_surat = $this->db->get_where('kat_tujuan_surat', ['id' => $kat_tujuan_surat])->row_array()['kode'];
        $tujuan_surat = $this->db->get_where('tujuan_surat', ['id' => $tujuan_surat])->row_array()['kode_tujuan'];
        $urusan_surat = $this->db->get_where('urusan_surat', ['id' => $urusan_surat])->row_array()['kode'];
        return $no_surat . "/" . $kat_tujuan_surat . "." . $tujuan_surat . "-" . $urusan_surat . "/" . bulan_romawi(date('n')) . "/" . date('Y');
    }
    public function get_no_surat($id_surat)
    {
        $no_surat = $this->db->query("select * FROM no_surat ns
			where ns.id_surat= $id_surat
            ")->row_array();

        return $no_surat;
    }


    public function get_kategori_surat_byid($id)
    {
        $query = $this->db->query("SELECT * FROM kategori_surat where id='$id'");
        return $result = $query->row_array();
    }
    public function tambah_kategori_surat($data)
    {
        return $this->db->insert('kategori_surat', $data);
    }
    public function edit_kategori_surat($data, $id)
    {
        return $this->db->update('kategori_surat', $data, array('id' => $id));
    }
    public function tambah($data)
    {
        return $this->db->insert('surat', $data);
    }

    public function get_fields_by_id_kat_surat($id)
    {
        $query = $this->db->query("SELECT * FROM kat_keterangan_surat where id_kategori_surat='$id' AND aktif=1 ORDER BY urutan ASC");
        return $result = $query->result_array();
    }

    public function editFieldsSurat($dataFieldCheck, $id)
    {
        $not_exist_fields_data = $dataFieldCheck['not_exist_fields_data'];
        $sent_fields_data = $dataFieldCheck['sent_fields_data'];

        foreach ($sent_fields_data as $key => $field) {

            $data = [
                'id_kategori_surat' => $id,
                'id' => $field,
                'aktif' => 1,
                'urutan' => $key
            ];

            // menambahkan field yang belum ada
            $datafield_exist = $this->db->query(
                "SELECT id FROM kat_keterangan_surat 
									WHERE id_kategori_surat = $id AND id IN (
										SELECT id FROM kat_keterangan_surat 
										WHERE id_kategori_surat = $id AND id = " . $data['id'] . " )"
            )->num_rows();

            if ($datafield_exist == 0) {
                $this->db->insert('kat_keterangan_surat', $data);
            } else {
                $field_property = [
                    'aktif' => 1,
                    'urutan' => $key
                ];

                $this->db->update(
                    'kat_keterangan_surat',
                    $field_property,
                    [
                        'id_kategori_surat' => $id,
                        'id' => $data['id'],
                    ]
                );
            }
            //1,3,69,70,71,72,73

            //mengecek field yang tidak digunakan
            // $id_field = $data['field_id'];
        }

        $query_fields = $this->db->query(
            "SELECT id FROM kat_keterangan_surat 
			WHERE id_kategori_surat = $id 
			-- AND field_id = $field
			 AND id NOT IN ($not_exist_fields_data)"
        );

        $non_exist_fields = $query_fields->result_array();

        $field_property = [
            'aktif' => 0
        ];

        if ($query_fields->num_rows() > 0) {
            foreach ($non_exist_fields as $field_tidak_dipakai) {
                $this->db->update(
                    'kat_keterangan_surat',
                    $field_property,
                    [
                        'id_kategori_surat' => $id,
                        'id' => $field_tidak_dipakai['id']
                    ]
                );
            }
        }

        // return $non_exist_fields;
        // return $datafield_exist;
    }

    public function edit_form_field($data, $id)
    {
        return $this->db->update('kat_keterangan_surat', $data, array('id' => $id));
    }

    public function get_surat_status($id_surat)
    {
        return $this->db->select('ss.*, DATE_FORMAT(ss.date,"%d %M %Y") as date, st.status')
            ->from('surat_status ss')
            ->join('status st', 'ss.id_status=st.id', 'left')
            ->where(array('ss.id_surat' => $id_surat, 'ss.id_status !=' => '0', 'ss.id_status !=' => '1'))->get()->result_array();
    }
    
    public function get_surat_yudisium()
    {
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
            $prodi = '';
            $hapus = '';
        } else {
            $prodi = "AND u.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
            $hapus = "AND ss.id_status != 20";
        }

        $query = $this->db->query("SELECT s.id as id_surat, s.id_mahasiswa, u.fullname, ss.id_status, st.id as id_status, s.id_kategori_surat, k.kategori_surat, st.status, st.badge, DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, u.id_prodi, pr.prodi
        FROM surat s
        LEFT JOIN users u ON u.id = s.id_mahasiswa
        LEFT JOIN prodi pr ON pr.id = u.id_prodi
        LEFT JOIN surat_status ss ON ss.id_surat = s.id
        LEFT JOIN status st ON st.id = ss.id_status
        LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat      
        WHERE ss.id_status = (SELECT id_status FROM surat_status WHERE id_surat=s.id ORDER BY date desc limit 1)
         AND s.id_kategori_surat = 6 AND ss.id_status != 1 $prodi
        $hapus
        -- GROUP BY ss.id_status
        ORDER BY ss.date DESC     
        ");
        return $result = $query->result_array();
    }

    //class Kategori
    public function get_kat_keterangan_surat($id_kategori_surat, $aktif)
    {
        $this->db->order_by("id", "desc");
        return $this->db->get_where('kat_keterangan_surat', ['id_kategori_surat' => $id_kategori_surat, 'aktif' => $aktif])->result_array();
    }

    public function get_timeline($id_surat)
    {
        $query = $this->db->query("SELECT DISTINCT(ss.id_status), DATE_FORMAT(ss.date, '%d %M') as date,  DATE_FORMAT(ss.date, '%H:%i') as time,  DATE_FORMAT(ss.date, '%d %M %Y') as date_full, s.status, s.badge, ss.catatan          
        FROM surat_status ss
        LEFT JOIN status s ON s.id = ss.id_status  
        where ss.id_surat='$id_surat'
        GROUP BY date
        ORDER BY ss.date  DESC
        ");
        return $result = $query->result_array();
    }

    //---------------------------------------------------
    // get all users for server-side datatable with advanced search
    public function get_arsip_surat()
    {

        $this->db->select('*');

        // if($this->session->userdata('user_search_type')!='')
        // $this->db->where('is_active',$this->session->userdata('user_search_type'));

        if ($this->session->userdata('arsip_search_from') != '')
            $this->db->where('tanggal_terbit >= ', date('Y-m-d', strtotime($this->session->userdata('user_search_from'))));

        if ($this->session->userdata('user_search_to') != '')
            $this->db->where('tanggal_terbit <= ', date('Y-m-d', strtotime($this->session->userdata('user_search_to'))));

        return $this->db->get('no_surat')->result_array();
    }

    public function get_surat_arsip($klien)
    {
        if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
            $where = "WHERE 1 ";
        } else {
            $where = "WHERE ns.id_prodi = '" . $this->session->userdata('id_prodi') . "'";
        }

        if ($klien) {
            $klien = "AND ks.klien='" . $klien . "'";
        } else {
            $klien = '';
        }

        if ($this->session->userdata('kategori_surat') != '') {
            $kat = "AND ks.id ='" . $this->session->userdata('kategori_surat') . "'";
        } else {
            $kat = '';
        }

        if ($this->session->userdata('prodi') != '') {
            $prodi = "AND p.id ='" . $this->session->userdata('prodi') . "'";
        } else {
            $prodi = '';
        }

        $query = $this->db->query("SELECT ns.id, ns.id_surat, ns.no_lengkap, ns.instansi, ns.hal, ns.file,u.fullname,ks.kategori_surat, kts.kat_tujuan_surat, ts.tujuan_surat, us.urusan as urusan_surat, p.prodi, DATE_FORMAT(ns.tanggal_terbit,'%d %M %Y') as tanggal_terbit FROM no_surat ns         
            LEFT JOIN users u ON u.id = ns.id_user
            LEFT JOIN kategori_surat ks ON ns.id_kategori_surat = ks.id
            LEFT JOIN kat_tujuan_surat kts ON ns.kat_tujuan_surat = kts.id
            LEFT JOIN tujuan_surat ts ON ns.tujuan_surat = ts.id
            LEFT JOIN urusan_surat us ON ns.urusan_surat = us.id
            LEFT JOIN prodi p ON ns.id_prodi = p.id
            $where $klien $kat $prodi         

            ORDER BY ns.id DESC      
        ");
        return $result = $query->result_array();
    }


}
