<?php
class Yudisium_model extends CI_Model
{
    public function get_yudisium() {
      $query = $this->db->query("SELECT y.*, u.fullname, u.username from yudisium y
        LEFT JOIN users u ON y.user_id = u.id
        ORDER BY y.id DESC      
      ");
      return $result = $query->result_array();
    }

    public function get_yudisium_by_id($id) {
      return $this->db->select('y.*, u.fullname, u.username, p.prodi')->from('yudisium y')->where(['y.id'=>$id])
      ->join('users u','u.id=y.user_id', 'left')
      ->join('prodi p','p.id=u.id_prodi', 'left')
      ->get()->row_array();
    }

    public function update($id, $data) {      
      $this->db->where(['id' => $id]);
      return $this->db->update('yudisium', $data);
    }
}
