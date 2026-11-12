<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Chit_balance_report_model extends CI_Model {

	public function view_all_chits($condition)
	{
		$table = 'mst_chits';
		$column_order = array(null, 'c_chit_id','c_chit_name','c_subscribers_cnt','c_total_months','c_chit_amount','c_commission','c_date','c_time');
		$column_search = array('c_chit_id','c_chit_name','c_subscribers_cnt','c_total_months','c_chit_amount','c_commission','c_date','c_time');
		$orderby = array('c_id' => 'desc');

		if($condition!='count_all'){
			$this->db->from($table);
			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("c_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
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

	public function get_auction_count($chit_id) {
		$sql="SELECT a_id FROM mst_chits,mst_auction WHERE mst_chits.c_chit_id=mst_auction.a_chit_id AND c_chit_id='$chit_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function get_action_details_new($chit_id) {
		$sql="SELECT asc_sno,asc_chit_id,s_party_id,s_party_name,s_phone_no,s_mobile_no,surety_no,(SELECT a_auction_count FROM mst_auction WHERE mst_auction.`a_bidder_id` = mst_subscribers.s_party_id) as a_auction_count  FROM assign_subs_to_chit LEFT JOIN mst_subscribers ON  assign_subs_to_chit.asc_subscriber_id=mst_subscribers.s_party_id WHERE asc_chit_id='".$chit_id."'";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_chit_details($id) {
		$sql="SELECT c_id, c_chit_id, c_chit_name, c_subscribers_cnt, c_total_months, c_monthly_amount, c_chit_amount, c_commission, c_date, c_time, c_status,company_chit_month FROM mst_chits WHERE c_chit_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details_new1($chit_id,$subid) {
		$idate1=date('Y-m-d');

		$sql="SELECT c_date FROM mst_chits WHERE c_chit_id='$chit_id'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$c_date=$result[0]['c_date'];

		$sql1="SELECT SUM(cl_collection_amount) as balance_amount FROM mst_collection WHERE cl_chit_id='$chit_id' AND cl_subscriber_id='$subid' ";
		$query1=$this->db->query($sql1);
		$result1=$query1->result_array();
		$balance_amount1=$result1[0]['balance_amount'];

		$sql2="SELECT SUM(a_collect_amount) as balance_amount1 FROM mst_auction WHERE a_chit_id='$chit_id'/* AND (a_auction_date BETWEEN '$c_date' AND '$idate1')*/ ";
		$query2=$this->db->query($sql2);
		$result2=$query2->result_array();
		$balance_amount=$result2[0]['balance_amount1'];

		$balance_amount3= $balance_amount- $balance_amount1;
		return $balance_amount3;
		
	}
}
?>