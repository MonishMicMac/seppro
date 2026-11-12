<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login_model extends CI_Model {

	function check_login($username,$password){
		$sql="SELECT * FROM mst_users WHERE md5(log_user_name)=? AND log_password=? AND log_status=?";
		$query = $this->db->query($sql,array($username,$password,'0'));
		return $query->result_array();
	}

}
?>