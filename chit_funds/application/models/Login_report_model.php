<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login_report_model extends CI_Model {

	public function view_login_report($condition)
	{
		$table = 'login_log';
		$column_order = array(null, 'log_first_name', 'll_user_id', 'll_status_type', 'll_date_in', 'll_time_in', 'll_date_out', 'll_date_out', 'll_time_out', 'ip_address');
		$column_search = array('log_first_name', 'll_user_id', 'll_status_type', 'll_date_in', 'll_time_in', 'll_date_out', 'll_date_out', 'll_time_out', 'ip_address');
		$orderby = array('ll_id' => 'desc');

		if($condition!='count_all'){

			$this->db->select('login_log.*,mst_users.log_first_name');
			$this->db->from($table);
			$this->db->join('mst_users', 'login_log.ll_user_id=mst_users.log_id');

			if($this->input->post('user_name')!='')
			{
				$this->db->where("mst_users.log_first_name='".$this->input->post('user_name')."'");
			}

			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("login_log.ll_date_in BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
			}

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
			$this->db->join('mst_users', 'login_log.ll_user_id=mst_users.log_id');
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_users_json($user_name) {
		$sql="SELECT log_first_name FROM mst_users WHERE log_first_name LIKE '%$user_name%'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

}
?>