<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Subscriber_model extends CI_Model {

	public function view_all_subscribers($condition)
	{
		$table = 'mst_subscribers';
		$column_order = array(null, 's_id', 's_party_id', 's_party_name', 's_gender', 's_dob', 's_father_or_husband', 's_nominee', 's_nominee_relation', 's_mobile_no', 's_phone_no', 's_city', 's_area', 's_address', 's_remarks', 's_status');
		$column_search = array('s_id', 's_party_id', 's_party_name', 's_gender', 's_dob', 's_father_or_husband', 's_nominee', 's_nominee_relation', 's_mobile_no', 's_phone_no', 's_city', 's_area', 's_address', 's_remarks', 's_status');
		$orderby = array('s_id' => 'desc');

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

	public function get_subscriber_details($id) {
		$sql="SELECT s_id, s_party_id, s_party_name, s_gender, s_dob, s_father_or_husband, s_aadhar_no, s_nominee, s_nominee_relation, s_mobile_no, s_phone_no, s_city, s_area, s_address, s_remarks, s_status,surety_no FROM mst_subscribers WHERE s_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function subscriber_insert_update($condition,$id,$data) {
		if($condition=='add_subscriber'){
			$this->db->insert('mst_subscribers',$data);
			$insert_id=$this->db->insert_id();
			return true;
		} elseif($condition=='edit_subscriber') {
			$this->db->where('s_id',$id);
			$this->db->update('mst_subscribers',$data);
			return true;
		}
	}

	public function check_subscriber_id($auto_id,$party_id) {
		$s_id='';
		if($auto_id!=''){
			$s_id="AND s_id!='".$auto_id."'";
		}
		
		$sql="SELECT s_id FROM mst_subscribers WHERE s_party_id='$party_id' $s_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function get_auto_party_id() {
		$sql="SELECT s_party_id FROM mst_subscribers ORDER BY s_id DESC LIMIT 1";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
}
?>