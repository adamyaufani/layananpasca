<?php
	class Profile_model extends CI_Model{

		//--------------------------------------------------------------------
		public function get_user_detail(){
			$id = $this->session->userdata('user_id');
			return	$query = $this->db->select('*')->from('users')->where(array('id' => $id))->get()->row_array();
		}
		//--------------------------------------------------------------------
		public function update_user($data){
			$id = $this->session->userdata('user_id');
			$this->db->where('id', $id);			
			return $this->db->update('users', $data);
		}	
		

	}

?>