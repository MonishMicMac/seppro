<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Chit_subs_model extends CI_Model {

	public function view_all_chit_subs($condition)
	{
		$table = 'assign_subs_to_chit';
		$column_order = array(null, 'asc_chit_id','asc_subscriber_id');
		$column_search = array('asc_chit_id','asc_subscriber_id');
		$orderby = array('asc_id' => 'desc');

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
				$this->db->select('asc_id, asc_chit_id, COUNT(asc_subscriber_id) as asc_subscriber_id');
				$this->db->group_by("asc_chit_id");
				$query = $this->db->get();
				return $query->result();
			}

			if($condition=='count_filtered'){
				$this->db->group_by("asc_chit_id");
				$query = $this->db->get();
				return $query->num_rows();
			}
		} else {
			$this->db->from($table);
			$this->db->group_by("asc_chit_id");
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_chit_subs_details($chit_id) {
		$sql="SELECT CONCAT(asc_chit_id,' (',c_chit_name,')') asc_chit_id, CONCAT(asc_subscriber_id,' (',s_party_name,')') asc_subscriber_id,c_subscribers_cnt FROM assign_subs_to_chit, mst_chits, mst_subscribers WHERE assign_subs_to_chit.asc_chit_id=mst_chits.c_chit_id AND assign_subs_to_chit.asc_subscriber_id=mst_subscribers.s_party_id AND asc_chit_id=? ORDER BY assign_subs_to_chit.asc_sno";
		$query=$this->db->query($sql,array($chit_id));
		return $query->result_array();
	}

	public function chit_insert_update($condition,$data) {
		if($condition=='edit_chit_subs'){
			$popup_chit_id=explode(" (", $data['popup_chit_id']);
			$sql="DELETE FROM assign_subs_to_chit WHERE asc_chit_id='$popup_chit_id[0]'";
			$this->db->query($sql);
		}

		$query='';
		$i=0;
		foreach ($data['subscriber_id'] as $subscriber_id) {
			$subscriber_sno=$data['subscriber_sno'][$i];
			$chit_id=explode(" (", $data['chit_id']);
			$subscriber_id=explode(" (", $subscriber_id);

			$query.="('$subscriber_sno','$chit_id[0]','$subscriber_id[0]','".$this->session->userdata('user_details')['log_id']."'),";
			$i++;
		}
		if($query!=''){
			$query=rtrim($query,",");
			$sql="INSERT INTO assign_subs_to_chit (asc_sno,asc_chit_id,asc_subscriber_id,asc_user_id) VALUES $query";
			$this->db->query($sql);
			return true;
		}
	}

	public function check_chit_subs_id($chit_id,$popup_chit_id,$condition) {

		if($condition=='edit_chit_subs'){
			$condition="AND asc_chit_id!='".$popup_chit_id."'";
		} else {
			$condition="";
		}

		$sql="SELECT asc_chit_id FROM assign_subs_to_chit WHERE asc_chit_id='$chit_id' $condition";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function get_chits_json($chit_id) {
		$sql="SELECT c_chit_id,c_chit_name FROM mst_chits WHERE CONCAT(c_chit_id,' (',c_chit_name,')') LIKE '%$chit_id%'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscribers_json($sel_sub_ids,$subscriber_id) {
		if($sel_sub_ids!=''){
			$sel_sub_ids="AND s_party_id NOT IN ($sel_sub_ids)";
		}

		$sql="SELECT s_party_id,s_party_name FROM mst_subscribers WHERE CONCAT(s_party_id,' (',s_party_name,')') LIKE '%$subscriber_id%' $sel_sub_ids";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_chit_sub_cnt($id) {
		$sql="SELECT c_chit_amount, c_commission, c_subscribers_cnt FROM mst_chits WHERE c_chit_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}
}
?>