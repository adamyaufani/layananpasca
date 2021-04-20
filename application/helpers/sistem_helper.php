<?php 
# fungsi akses user
function in_access()
{
	$ci=& get_instance();
	if($ci->session->userdata('email_kat')){
		redirect('login');
	}
}
# fungsi penolakan akses
function no_access()
{
	$ci=& get_instance();
	if(!$ci->session->userdata('email_kat')){
		redirect('login');
	}
}

function GET_STUDENTID($email)
{

	$ci=& get_instance();
	$q = $ci->db->query("select * from SIMKatmawa.dbo.V_Mahasiswa where email='$email'")->row_array();
	return $q['STUDENTID'];
}

function GET_NAMA($email)
{

	$ci=& get_instance();
	$q = $ci->db->query("select * from SIMKatmawa.dbo.V_Mahasiswa where email='$email'")->row_array();
	return $q['FULLNAME'];
}

function cmb_dinamis($name, $table, $field, $pk, $selected = null, $extra = null) {
	$ci = & get_instance();
	$cmb = "<select name='$name' class='browser-default custom-select' $extra>";
	$data = $ci->db->get($table)->result();
	foreach ($data as $row) {
		$cmb .="<option value='" . $row->$pk . "'";
		$cmb .= $selected == $row->$pk ? 'selected' : '';
		$cmb .=">" . $row->$field . "</option>";
	}
	$cmb .= "</select>";
	return $cmb;
}

function cmb_dinamis_edit($name, $table, $field, $pk, $selected, $extra = null) {
	$ci = & get_instance();
	$cmb = "<select name='$name' class='browser-default custom-select' $extra>";
	$data = $ci->db->get($table)->result();
	foreach ($data as $row) {
		$cmb .="<option value='" . $row->$pk . "'";
		$cmb .= $selected == $row->$pk ? 'selected' : '';
		$cmb .=">" . $row->$field . "</option>";
	}
	$cmb .= "</select>";
	return $cmb;
}
