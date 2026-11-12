<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Collection_model extends CI_Model {

	public function view_all_collections($condition)
	{
		$table = 'mst_collection';
		$column_order = array(null, 'cl_bill_no', 'cl_bill_month', 'cl_collected_date', 'cl_chit_id', 'cl_subscriber_id', 'cl_collection_amount', 'cl_outstanding_amount', 'cl_remarks', 'cl_status','deposit_Coll_amount','cl_user_id');
		$column_search = array('cl_bill_no', 'cl_bill_month', 'cl_collected_date', 'cl_chit_id', 'cl_subscriber_id', 'cl_collection_amount', 'cl_outstanding_amount', 'cl_remarks', 'cl_status','deposit_Coll_amount','cl_user_id');
		$orderby = array('cl_chit_id' => 'asc');

		if($condition!='count_all'){

			$this->db->select('mst_collection.*,mst_subscribers.s_party_name,mst_users.log_first_name');
			$this->db->from($table);
			$this->db->join('mst_subscribers', 'mst_collection.cl_subscriber_id=mst_subscribers.s_party_id');
			$this->db->join('mst_users', 'mst_collection.cl_user_id=mst_users.log_id');
			$this->db->where("mst_collection.cl_collected_date BETWEEN '".date('Y-m-d', strtotime('-1 day'))."' AND '".date('Y-m-d')."'");
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
			$this->db->join('mst_subscribers', 'mst_collection.cl_subscriber_id=mst_subscribers.s_party_id');
			$this->db->where("mst_collection.cl_collected_date BETWEEN '".date('Y-m-d', strtotime('-1 day'))."' AND '".date('Y-m-d')."'");
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_collection_details($id) {
		$sql="SELECT cl_id, cl_bill_no, cl_collected_date, CONCAT(cl_chit_id,' (',c_chit_name,')') cl_chit_id, CONCAT(cl_subscriber_id,' (',s_party_name,')') cl_subscriber_id, cl_prev_out_amount, cl_collection_amount, cl_outstanding_amount, cl_remarks, cl_status,payment_type,cheque_no FROM mst_collection, mst_chits, mst_subscribers WHERE mst_collection.cl_chit_id=mst_chits.c_chit_id AND mst_collection.cl_subscriber_id=mst_subscribers.s_party_id AND cl_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function collection_insert_update($condition,$id,$data) {
		if($condition=='add_collection'){
			$this->db->insert('mst_collection',$data);
			$insert_id=$this->db->insert_id();
			return true;
		} elseif($condition=='edit_collection') {
			$this->db->where('cl_id',$id);
			$this->db->update('mst_collection',$data);
			return true;
		}
	}

	public function collection_deposit_insert_update($sids,$data1) {		
		$this->db->where('d_sub_id',$sids);
		$this->db->update('mst_deposit',$data1);
		
		return true;
	}

	public function check_bill_no($auto_id,$bill_no) {
		$a_id='';
		if($auto_id!=''){
			$a_id="AND cl_id!='".$auto_id."'";
		}
		
		$sql="SELECT cl_id FROM mst_collection WHERE cl_bill_no='$bill_no' $a_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function check_chit_id($chit_id) {
		$sql="SELECT c_id FROM mst_chits WHERE CONCAT(c_chit_id,' (',c_chit_name,')')='$chit_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function check_subscriber_id($subscriber_id) {
		$sql="SELECT s_id FROM mst_subscribers WHERE CONCAT(s_party_id,' (',s_party_name,')')='$subscriber_id'";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function get_chits_subs_json($chit_and_sub_id) {
		$sql="SELECT c_chit_id,c_chit_name,s_party_id,s_party_name,s_id FROM mst_chits,mst_subscribers,assign_subs_to_chit WHERE mst_chits.c_chit_id=assign_subs_to_chit.asc_chit_id AND mst_subscribers.s_party_id=assign_subs_to_chit.asc_subscriber_id AND CONCAT(c_chit_id,' ',asc_sno) LIKE '%$chit_and_sub_id%' ORDER BY SUBSTRING(s_party_id, -2, 2) ASC";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_chits_json($chit_id) {
		$sql="SELECT c_chit_id,c_chit_name FROM mst_chits,assign_subs_to_chit WHERE mst_chits.c_chit_id=assign_subs_to_chit.asc_chit_id AND CONCAT(c_chit_id,' (',c_chit_name,')') LIKE '%$chit_id%' GROUP BY asc_chit_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscribers_json($chit_id,$subscriber_id) {
		$sql="SELECT s_party_id,s_party_name,s_id FROM mst_subscribers,assign_subs_to_chit WHERE mst_subscribers.s_party_id=assign_subs_to_chit.asc_subscriber_id AND asc_chit_id='$chit_id' AND CONCAT(s_party_id,' (',s_party_name,')') LIKE '%$subscriber_id%'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_chit_amount($id) {
		$sql="SELECT c_chit_amount, c_commission FROM mst_chits WHERE c_chit_id=?";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_bill_amount($chit_id) {
		$sql="SELECT a_commission_amount, a_balance_amount, c_subscribers_cnt FROM mst_auction, mst_chits WHERE a_chit_id=? AND mst_auction.a_chit_id=mst_chits.c_chit_id";
		$query=$this->db->query($sql,array($chit_id));
		return $query->result_array();
	}

	public function get_outstanding_amount($collected_date,$chit_id,$sub_id) {

		$sql="SELECT c_date,c_total_months FROM mst_chits WHERE c_chit_id=?";
		$query=$this->db->query($sql,array($chit_id));
		$result=$query->result_array();
		$chit_date=$result[0]['c_date'];
		$total_months=$result[0]['c_total_months'];

		$collected_date=date("Y-m", strtotime($collected_date));

		$total_outstanding=0;
		for ($i=0; $i < $total_months; $i++) {
			$c_date=date("Y-m", strtotime("+$i month", strtotime($chit_date)));

			$sql1="SELECT a_collect_amount FROM mst_auction, mst_chits WHERE DATE_FORMAT(a_auction_date,'%Y-%m')='$c_date' AND a_chit_id='$chit_id' AND mst_auction.a_chit_id=mst_chits.c_chit_id";
			$query1=$this->db->query($sql1);
			$result1=$query1->result_array();

			$total_outstanding+=$result1[0]['a_collect_amount'];
		}

		$sql2="SELECT SUM(cl_collection_amount) collection_amount FROM mst_collection WHERE cl_chit_id=? AND cl_subscriber_id=? GROUP BY cl_chit_id";
		$query2=$this->db->query($sql2,array($chit_id,$sub_id));
		$result2=$query2->result_array();
		$collection_amount=$result2[0]['collection_amount'];

		$current_outstanding=$total_outstanding-$collection_amount;

		return $current_outstanding;
	}

	public function get_deposit_amount($collected_date,$chit_id,$sub_id) {

		$collected_date=date("Y-m", strtotime($collected_date));
		// echo "SELECT SUM(d_amount) d_amount FROM mst_deposit WHERE  d_sub_id='".$sub_id."' ";
		$sql2="SELECT SUM(d_amount) d_amount FROM mst_deposit WHERE  d_sub_id='".$sub_id."' ";
		$query2=$this->db->query($sql2,array($chit_id,$sub_id));
		$result2=$query2->result_array();
		$current_outstanding=$result2[0]['d_amount'];


		return $current_outstanding;
	}

	public function cancel_collection($id) {
		$sql1="SELECT cl_subscriber_id,deposit_Coll_amount FROM mst_collection WHERE cl_id=?";
		$query1=$this->db->query($sql1,array($id));
		$row1=$query1->result_array();

		$sql_dep="UPDATE mst_deposit SET d_amount=d_amount+".$row1[0]['deposit_Coll_amount']." WHERE d_subscriber_id='".$row1[0]['cl_subscriber_id']."'";
		$this->db->query($sql_dep);

		$sql="DELETE FROM mst_collection WHERE cl_id=?";
		$this->db->query($sql,array($id));
	}

	public function last_collection_date($cl_collected_date) {
		$sql="SELECT cl_collected_date FROM mst_collection  order by  cl_collected_date desc limit 1";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
}
?>