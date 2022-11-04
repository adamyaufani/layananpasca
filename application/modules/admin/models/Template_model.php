<?php
class Template_model extends CI_Model
{
    public function get_template()
    {
        $query = $this->db->query("SELECT * from template");
        return $result = $query->result_array();
    }
    public function get_template_byid($id)
    {
        $query = $this->db->query("SELECT * from template WHERE id = $id");
        return $result = $query->row_array();
    }
    public function get_template_bykat($kat)
    {
        $query = $this->db->query("SELECT * from template WHERE id_kategori_surat = $kat");
        return $result = $query->result_array();
    }

    public function tambah_template_surat($data)
    {
        return $this->db->insert('template', $data);
    }
   
}
