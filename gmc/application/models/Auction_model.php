<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Auction_model extends CI_Model {

	public function view_all_auctions($condition)
	{
		$table = 'mst_auction';
		$column_order = array(null, 'a_chit_id', 'a_auction_id', 'a_auction_date', 'a_bidder_id', 'a_bid_count', 'a_chit_amount', 'a_bid_amount', 'a_commission_amount', 'a_total_subsription', 'a_balance_amount', 'a_status');
		$column_search = array('a_chit_id', 'a_auction_id', 'a_auction_date', 'a_bidder_id', 'a_bid_count', 'a_chit_amount', 'a_bid_amount', 'a_commission_amount', 'a_total_subsription', 'a_balance_amount', 'a_status');
		$orderby = array('a_id' => 'desc');

		if($condition!='count_all'){

			$this->db->select('mst_auction.*,mst_subscribers.s_party_name');
			$this->db->from($table);
			$this->db->join('mst_subscribers', 'mst_auction.a_bidder_id=mst_subscribers.s_party_id');

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
			$this->db->join('mst_subscribers', 'mst_auction.a_bidder_id=mst_subscribers.s_party_id');
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_auction_details($id) {
		$sql="SELECT a_id, CONCAT(a_chit_id,' (',c_chit_name,')') a_chit_id, a_auction_id, a_auction_date, CONCAT(a_bidder_id,' (',s_party_name,')') a_bidder_id, a_bid_count, a_chit_amount, a_bid_amount, a_commission_amount, a_collect_amount, a_total_subsription, a_balance_amount, a_auction_count, a_status,company_chit_month,c_total_months FROM mst_auction, mst_chits, mst_subscribers WHERE mst_auction.a_chit_id=mst_chits.c_chit_id AND mst_auction.a_bidder_id=mst_subscribers.s_party_id AND a_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function auction_insert_update($condition,$id,$data) {
		if($condition=='add_auction'){
			$this->db->insert('mst_auction',$data);
			$insert_id=$this->db->insert_id();
			return true;
		} elseif($condition=='edit_auction') {
			$this->db->where('a_id',$id);
			$this->db->update('mst_auction',$data);
			return true;
		}
	}

	public function check_auction_id($auto_id,$auction_id) {
		$a_id='';
		if($auto_id!=''){
			$a_id="AND a_id!='".$auto_id."'";
		}
		
		$sql="SELECT a_id FROM mst_auction WHERE a_auction_id='$auction_id' $a_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function check_chit_id($chit_id,$auction_date,$condition) {
		$auction_d=date('d',strtotime($auction_date));

		$sql1="";
		if($condition=="add_auction"){
			$sql1="AND c_chit_id NOT IN (select a_chit_id from mst_auction where a_chit_id=mst_chits.c_chit_id AND a_auction_date='$auction_date')";
		}

		$sql="SELECT c_id FROM mst_chits,assign_subs_to_chit WHERE mst_chits.c_chit_id=assign_subs_to_chit.asc_chit_id AND CONCAT(c_chit_id,' (',c_chit_name,')')='$chit_id' AND DATE_FORMAT(c_date,'%d')='$auction_d' $sql1 GROUP BY asc_chit_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function check_bidder_id($chit_id,$bidder_id,$condition) {
		$sql1="";
		if($condition=="add_auction"){
			$sql1="AND s_party_id NOT IN (select a_bidder_id from mst_auction where a_chit_id='$chit_id')";
		}
		$sql="SELECT s_id FROM mst_subscribers,assign_subs_to_chit WHERE mst_subscribers.s_party_id=assign_subs_to_chit.asc_subscriber_id AND asc_chit_id='$chit_id' AND CONCAT(s_party_id,' (',s_party_name,')')='$bidder_id' $sql1";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function get_chits_json($chit_id,$auction_date,$condition) {
		$auction_d=date('d',strtotime($auction_date));

		$sql1="";
		if($condition=="add_auction"){
			$sql1="AND c_chit_id NOT IN (select a_chit_id from mst_auction where a_chit_id=mst_chits.c_chit_id AND a_auction_date='$auction_date')";
		}

		$sql="SELECT c_chit_id,c_chit_name FROM mst_chits,assign_subs_to_chit WHERE mst_chits.c_chit_id=assign_subs_to_chit.asc_chit_id AND CONCAT(c_chit_id,' (',c_chit_name,')') LIKE '%$chit_id%' AND DATE_FORMAT(c_date,'%d')='$auction_d' $sql1 GROUP BY asc_chit_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscribers_json($chit_id,$subscriber_id,$condition) {
		$sql1="";
		if($condition=="add_auction"){
			$sql1="AND s_party_id NOT IN (select a_bidder_id from mst_auction where a_chit_id='$chit_id')";
		}
		$sql="SELECT s_party_id,s_party_name FROM mst_subscribers,assign_subs_to_chit WHERE mst_subscribers.s_party_id=assign_subs_to_chit.asc_subscriber_id AND asc_chit_id='$chit_id' AND assign_subs_to_chit.asc_sno='$subscriber_id' $sql1";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_chit_amount($id) {
		$sql="SELECT c_chit_amount, c_commission, c_subscribers_cnt, c_total_months, company_chit_month FROM mst_chits WHERE c_chit_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_auto_auction_id() {
		$sql="SELECT a_auction_id FROM mst_auction ORDER BY a_id DESC LIMIT 1";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_auction_count($chit_id) {
		$sql="SELECT a_id FROM mst_chits,mst_auction WHERE mst_chits.c_chit_id=mst_auction.a_chit_id AND CONCAT(c_chit_id,' (',c_chit_name,')')='$chit_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}
}
?>