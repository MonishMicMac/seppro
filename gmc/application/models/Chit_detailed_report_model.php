<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Chit_detailed_report_model extends CI_Model {

	public function view_all_chits($condition)
	{
		$table = 'mst_chits';
		$column_order = array(null, 'c_chit_id','c_chit_name','c_subscribers_cnt','c_total_months','c_chit_amount','c_commission','c_date','c_time');
		$column_search = array('c_chit_id','c_chit_name','c_subscribers_cnt','c_total_months','c_chit_amount','c_commission','c_date','c_time');
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

		public function get_total_amt()
	{
		$this->db->select('SUM(c_chit_amount) c_chit_amount');
		$this->db->from('mst_chits');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_action_details($id) {
		$sql="SELECT *,(select concat(asc_chit_id,' ',asc_sno) from assign_subs_to_chit where asc_chit_id=mst_auction.a_chit_id and asc_subscriber_id=mst_auction.a_bidder_id) as sub_id FROM mst_auction INNER JOIN mst_subscribers ON mst_auction.a_bidder_id=mst_subscribers.s_party_id WHERE mst_auction.a_chit_id='".$id."' order by a_auction_date asc";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_count($id) {
		$sql="SELECT count(*) AS auction_count FROM mst_auction  WHERE  mst_auction.a_chit_id='".$id."'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_action_details_new($id,$idate,$auction_id_name,$subid) {
		$idate1=date('Y-m-d', strtotime("+1 month",strtotime($idate)));

		$sql="SELECT sum(cl_collection_amount) AS cl_collection_amount,cl_subscriber_id,cl_collected_date,(select a_collect_amount from mst_auction where a_auction_id='".$auction_id_name."') AS payment_amount,s_party_name FROM mst_collection INNER JOIN mst_subscribers ON mst_collection.cl_subscriber_id=mst_subscribers.s_party_id WHERE  (mst_collection.cl_collected_date BETWEEN '".$idate."' AND '".$idate1."') AND mst_collection.cl_chit_id='".$id."' AND mst_collection.cl_subscriber_id='".$subid."' GROUP BY mst_collection.cl_subscriber_id  ";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details_new1($id,$idate,$auction_id_name) {
		$idate1=date('Y-m-d', strtotime("+1 month",strtotime($idate)));

		$sql="SELECT asc_subscriber_id,a_collect_amount,CONCAT(asc_chit_id,' ',asc_sno,' - ',s_party_name) AS subscribername,s_phone_no,s_mobile_no FROM assign_subs_to_chit LEFT JOIN mst_auction ON assign_subs_to_chit.asc_chit_id=mst_auction.a_chit_id LEFT JOIN mst_subscribers ON  assign_subs_to_chit.asc_subscriber_id=mst_subscribers.s_party_id WHERE  asc_chit_id='".$id."' AND a_auction_id='".$auction_id_name."'";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_auction_count($chit_id) {
		$sql="SELECT a_id FROM mst_chits,mst_auction WHERE mst_chits.c_chit_id=mst_auction.a_chit_id AND c_chit_id='$chit_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}
	
}
?>