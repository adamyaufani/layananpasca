<?php
class Pengguna_model extends CI_Model
{

	public function add_user($data)
	{
		$this->db->insert('users', $data);
		return true;
	}

	public function import_pengguna($data)
	{
		$this->db->insert_batch('users', $data);
	}

	//---------------------------------------------------
	// get all users for server-side datatable processing (ajax based)
	public function get_pengguna( $role )
	{
		if ($role == '') {
			// $where ="WHERE a.role != 1";
			$where ="";
		} else {
			$where ="WHERE a.role=$role";
		}
		return $this->db->query("SELECT a.*, r.role FROM users a
		LEFT JOIN role r ON r.id = a.role
		$where ");
	}

	public function get_role() {
		return $this->db->get_where('role', array('id !='=>'1'))->result_array();
	}
	// Count total users by role
	public function count_all_users_by_role($role)
	{

		if ($role != '') {
			$this->db->where('role', $role);
		} else {
			$this->db->where('role !=', 1);
		}
		return $this->db->count_all_results('users');
	}



	//---------------------------------------------------
	// Get user detial by ID
	public function get_user_by_id($id)
	{
		$query = $this->db->query("SELECT * 
			FROM users a
			WHERE a.id='$id'
			");
		return $query->row_array();
	}

	//---------------------------------------------------
	// Edit user Record
	public function edit_user($data, $id)
	{
		$this->db->where('id', $id);
		
		$this->db->update('users', $data);
		return true;
	}

	public function role()
	{	
		$this->db->where('id !=', 1);
		return $this->db->get('role')->result_array();

	}


}
