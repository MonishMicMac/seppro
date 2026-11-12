<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class User_model extends CI_Model {

	public function view_all_users($condition)
	{
		$table = 'mst_users';
		$column_order = array(null, 'log_first_name','log_last_name','log_user_name','log_password','log_phone_no','log_email_id','log_user_role','log_status');
		$column_search = array('log_first_name','log_last_name','log_user_name','log_password','log_phone_no','log_email_id','log_user_role','log_status');
		$orderby = array('log_id' => 'desc');

		if($condition!='count_all'){

			$this->db->from($table);
			$i = 0;

			foreach ($column_search as $item)
			{
				if($_POST['search']['value'])
				{
					if($i===0)
					{
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					}
					else
					{
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if(count($column_search) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}

			if(isset($_POST['order']))
			{
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($orderby))
			{
				$order = $orderby;
				$this->db->order_by(key($order), $order[key($order)]);
			}

			if($condition=='datatable'){
				if($_POST['length'] != -1){
					$this->db->limit($_POST['length'], $_POST['start']);
				}
				$query = $this->db->get();
				return $query->result();
			}

			if($condition=='count_filtered'){
				$query = $this->db->get();
				return $query->num_rows();
			}
		} else {
			$this->db->from($table);
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_user_details($id) {
		$sql="SELECT log_id, log_first_name, log_last_name, log_user_name, log_password, log_phone_no, log_email_id, log_user_role, log_status FROM mst_users WHERE log_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function user_insert_update($condition,$id,$data) {
		if($condition=='add_user'){
			$this->db->insert('mst_users',$data);
			$insert_id=$this->db->insert_id();
			return true;
		} elseif($condition=='edit_user') {
			$this->db->where('log_id',$id);
			$this->db->update('mst_users',$data);
			return true;
		}
	}

	public function check_user_id($auto_id,$user_name) {
		$log_id='';
		if($auto_id!=''){
			$log_id="AND log_id!='".$auto_id."'";
		}
		
		$sql="SELECT log_id FROM mst_users WHERE log_user_name='$user_name' $log_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}
}
?>