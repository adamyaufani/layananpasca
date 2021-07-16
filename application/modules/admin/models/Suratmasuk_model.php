<?php
class Suratmasuk_model extends CI_Model
{
    public function get_surat_masuk()
    {
        return $this->db->select('*')->from('surat_masuk')->get()->result_array();
    }
    
    public function get_detail_surat_masuk($id_surat)
    {
        $query = $this->db->query("SELECT 
        -- s.id, 
        -- s.id_kategori_surat, 
        -- s.id_mahasiswa, 
        -- k.kategori_surat, 
        -- k.klien, 
        -- k.template, 
        -- k.tujuan_surat, 
        -- k.tembusan, 
        -- ss.id_status, 
        -- st.status, 
        -- st.badge, 
        -- u.id as user_id, 
        -- u.fullname,
        -- u.username,  
        -- k.kat_keterangan_surat, 
        -- u.id_prodi, 
        -- pr.prodi,
        -- n.id as id_notif
        *
        FROM surat_masuk sm      
        -- LEFT JOIN surat_status ss ON ss.id_surat = s.id 
        -- LEFT JOIN users u ON u.id = s.id_mahasiswa 
        -- LEFT JOIN prodi pr ON pr.id = u.id_prodi              
        -- LEFT JOIN status st ON st.id = ss.id_status
        -- LEFT JOIN kategori_surat k ON k.id = s.id_kategori_surat
        -- LEFT JOIN notif n ON n.id_surat = s.id
        WHERE sm.id_surat_masuk = '$id_surat' 
        -- AND ss.id_status = (SELECT MAX(id_status) FROM surat_status WHERE id_surat ='$id_surat')
        
        ");
        return $result = $query->row_array();
    }

    public function tambah($data)
    {
        return $this->db->insert('surat_masuk', $data);
    }

    
}
