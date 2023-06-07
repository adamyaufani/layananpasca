<?php
	class Dashboard_model extends CI_Model{		
		public function for_graph($status){
      return $this->db->query("SELECT 
      DATE_FORMAT(date,'%b') as bulan, 
      DATE_FORMAT(date,'%m') as angka_bulan 
      FROM surat_status
      WHERE id_status = '$status'
      GROUP BY bulan, angka_bulan
      ORDER BY angka_bulan ASC      
      ");
		}

    public function notif() {
      //cek apakah ada kategori surat yg blm selesai
      if ($_SESSION['role'] == 1) {
        $where = "n.role = 1";
      } else if ($_SESSION['role'] == 2) {
        $where = "n.role = 2 AND n.id_prodi = " . $_SESSION['id_prodi'];
      } else if ($_SESSION['role'] == 3) {
        $where = "n.role = 3 AND n.kepada = " . $_SESSION['user_id'];
      } else if ($_SESSION['role'] == 4) {
        $where = "n.role = 4 AND n.kepada = " . $_SESSION['user_id'];
      } else if ($_SESSION['role'] == 5) {
        $where = "n.role = 5";
      } else if ($_SESSION['role'] == 6) {
        $where = "n.role = 6 AND n.id_prodi = " . $_SESSION['id_prodi'];
      }

      return $this->db->query("SELECT n.*, n.id as notif_id, sp.judul_notif, DATE_FORMAT(n.tanggal, '%H:%i') as time,  DATE_FORMAT(n.tanggal, '%d %M') as date_full, sp.badge, sp.icon, s.id_kategori_surat, ks.kategori_surat, u.fullname
        FROM notif n 	
        LEFT JOIN status_pesan sp ON sp.id = n.id_status_pesan
        LEFT JOIN surat s ON s.id = n.id_surat
        LEFT JOIN kategori_surat ks ON s.id_kategori_surat = ks.id
        LEFT JOIN users u ON n.kepada = u.id
        WHERE  $where AND n.status = 0 	
        ORDER BY id DESC LIMIT 3");
      }
	}
?>
