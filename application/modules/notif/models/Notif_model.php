<?php
class Notif_model extends CI_Model
{
	public function get_all_notif()
	{
		
		$query = $this->db->select("n.*, sp.*, n.id as notif_id, DATE_FORMAT(n.tanggal, '%H:%i') as time,  DATE_FORMAT(n.tanggal, '%d %M %Y') as date_full")->from("notif n")
			->join('status_pesan sp', 'n.id_status_pesan = sp.id', 'right')
		
			->order_by('n.id', 'asc')
			->get();

		return $query;
	}
	public function get_notif()
	{
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
		$query = $this->db->select("n.*, sp.*, n.id as notif_id, DATE_FORMAT(n.tanggal, '%H:%i') as time,  DATE_FORMAT(n.tanggal, '%d %M %Y') as date_full")->from("notif n")
			->join('status_pesan sp', 'n.id_status_pesan = sp.id', 'left')
			->where($where)
			->order_by('n.id', 'desc')
			->get();

		return $query;
	}

	public function get_notif_by_surat($id_surat)
	{
		
		$query = $this->db->select("*")->from("notif")
			 ->where(["id_surat" => $id_surat, "role" => 3, "status" => 0])
			->get()->result_array();

		return $query;
	}

	public function notif_read($id_notif)
	{
		$data = [ "status" => 1,
			"dibaca" => date('Y-m-d H:i:s'),							
		];
		$query = $this->db->update('notif', $data, ["id" => $id_notif]);

		return $query;
	}


	public function send_notif($data)
	{
		$id_status = $data['id_status'];

		$notif = array();
		foreach ($data['role'] as $role) {
			$notif[] = array(
				"role" => $role,
				"id_surat" => $data['id_surat'],
				"pengirim" => $_SESSION['user_id'],
				"kepada" => $data['kepada'],
				"tanggal" => date('Y-m-d H:i:s'),
				"id_prodi" => $_SESSION['id_prodi'],
				"id_status_pesan" => $this->get_status_pesan($role, $id_status),
			);
		}

		$result = $this->db->insert_batch('notif', $notif);
		return $result;
	}
	//get status pesan by role dan status
	public function get_status_pesan($role, $id_status)
	{
		$status = $this->db->get_where('status_pesan', array('role' => $role, 'id_status' => $id_status))->row_array();
		return $status['id'];
	}
	//get status pesan by role dan status
	public function get_messages( $id_status, $role)
	{
		return $this->db->get_where('status_pesan', array('role' => $role, 'id_status' => $id_status))->row_array();
	
	}
}
