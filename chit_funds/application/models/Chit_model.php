<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Chit_model extends CI_Model {

	public function view_all_chits($condition)
	{
		$table = 'mst_chits';
		$column_order = array(null, 'c_chit_id','c_chit_name','c_subscribers_cnt','c_total_months','c_chit_amount','c_commission','c_date');
		$column_search = array('c_chit_id','c_chit_name','c_subscribers_cnt','c_total_months','c_chit_amount','c_commission','c_date');
		$orderby = array('c_id' => 'desc');

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

	public function get_chit_details($id) {
		$sql="SELECT c_id, c_chit_id, c_chit_name, c_subscribers_cnt, c_total_months, c_monthly_amount, c_chit_amount, c_commission, c_date, c_time, c_status,company_chit_month FROM mst_chits WHERE c_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function chit_insert_update($condition,$id,$data) {
		if($condition=='add_chit'){
			$this->db->insert('mst_chits',$data);
			$insert_id=$this->db->insert_id();
			return true;
		} elseif($condition=='edit_chit') {
			$this->db->where('c_id',$id);
			$this->db->update('mst_chits',$data);
			return true;
		}
	}

	public function check_chit_id($auto_id,$chit_id) {
		$c_id='';
		if($auto_id!=''){
			$c_id="AND c_id!='".$auto_id."'";
		}
		
		$sql="SELECT c_id FROM mst_chits WHERE c_chit_id='$chit_id' $c_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}
	

	public function get_auto_chit_id() {
		$sql="SELECT c_chit_id FROM mst_chits ORDER BY c_id DESC LIMIT 1";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
}
?>