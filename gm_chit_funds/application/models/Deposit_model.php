<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Deposit_model extends CI_Model {

	public function view_all_deposit($condition)
	{
		$table = 'mst_deposit';
		$column_order = array(null, 'd_chit_id','DATE_FORMAT(collected_date,"%d-%m-%Y")','d_subscriber_id','d_sub_id','d_subscriber_id','d_subscriber_name','d_amount','s_party_id','d_user_id');
		$column_search = array('d_chit_id','DATE_FORMAT(collected_date,"%d-%m-%Y")','d_subscriber_id','d_sub_id','d_subscriber_id','d_subscriber_name','d_amount','s_party_id','d_user_id');
		$orderby = array('d_id' => 'desc');

		if($condition!='count_all'){

			
			$this->db->select('mst_deposit.*,mst_subscribers.s_party_id,mst_users.log_first_name');
			$this->db->from($table);
			$this->db->join('mst_subscribers', 'mst_deposit.d_sub_id=mst_subscribers.s_id');
			$this->db->join('mst_users', 'mst_deposit.d_user_id=mst_users.log_id');
			$this->db->where("mst_deposit.d_amount!='0'");

			if($this->input->post('chit_id')!='')
			{
				$this->db->where("mst_subscribers.s_party_id LIKE '%".$this->input->post('chit_id')."%'");
			}
			
			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("mst_deposit.collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
			} else {
				$this->db->where("mst_deposit.collected_date='".date('Y-m-d')."' ");
			}
			
			
			/*$this->db->from($table);*/
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
				$this->db->where("mst_deposit.d_amount!='0'");
				$query = $this->db->get();
				return $query->num_rows();
			}
		} else {
			$this->db->from($table);

			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("mst_deposit.collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
			} else {
				$this->db->where("mst_deposit.collected_date='".date('Y-m-d')."' ");
			}
			
			$this->db->join('mst_subscribers', 'mst_deposit.d_sub_id=mst_subscribers.s_id');
			$this->db->where("mst_deposit.d_amount!='0'");
			
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function customer_id()
	{

		$this->db->select('s_id,s_party_id');
		$this->db->from('mst_subscribers');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function get_deposit_details($id) {
		/*	$sql="SELECT d_id, CONCAT(d_chit_id,' (',c_chit_name,')') d_chit_id, CONCAT(d_subscriber_id,' (',s_party_name,')') d_subscriber_id, d_amount FROM mst_deposit, mst_chits, mst_subscribers WHERE mst_deposit.d_chit_id=mst_chits.c_chit_id AND mst_deposit.d_subscriber_id=mst_subscribers.s_party_id AND d_id=?";*/
		$sql="SELECT d_id, d_chit_id, CONCAT(d_subscriber_id,' (',s_party_name,')') d_subscriber_id, d_amount FROM mst_deposit, mst_chits, mst_subscribers WHERE  mst_deposit.d_subscriber_id=mst_subscribers.s_party_id AND d_id=?";

		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function deposit_insert_update($condition,$id,$data) {
		if($condition=='add_deposit'){

			// $sql_deposite="select d_id,d_subscriber_id,d_subscriber_name,d_amount as pre_amt,d_updatetime  from mst_deposit where d_subscriber_id='".$data['d_subscriber_id']."' and d_subscriber_name='".$data['d_subscriber_name']."' ";
			$sql_deposite="select d_id,d_subscriber_id,d_subscriber_name,d_amount as pre_amt,d_updatetime from mst_deposit where d_subscriber_id='".$data['d_subscriber_id']."'";
			$dep_query=$this->db->query($sql_deposite);
			$row_deposite=$dep_query->result_array();


			$pre_amt=$row_deposite[0]['pre_amt'];
			$cur_amt=$data['d_amount'];
			$new_amt=$pre_amt+$cur_amt;

			$db_deposite=$dep_query->num_rows();
			if($db_deposite=='0'){


				$this->db->insert('mst_deposit',$data);
				$insert_id=$this->db->insert_id();			

				$this->db->insert('tbl_deposit_history',$data);
				$insert_id=$this->db->insert_id();
				return true;
			}else{
				$sql_update_deposite="UPDATE `mst_deposit` SET `d_amount` = '".$new_amt."',d_user_id='".$data['d_user_id']."' WHERE `d_id` ='".$row_deposite[0]['d_id']."'";
				$this->db->query($sql_update_deposite);

				$this->db->insert('tbl_deposit_history',$data);
				$insert_id=$this->db->insert_id();
				return true;
			}
			
		} elseif($condition=='edit_deposit') {
			$this->db->where('d_id',$id);
			$this->db->update('mst_deposit',$data);
			return true;
		}
	}

	public function get_chits_json($chit_id) {
		$sql="SELECT c_chit_id,c_chit_name FROM mst_chits,assign_subs_to_chit WHERE mst_chits.c_chit_id=assign_subs_to_chit.asc_chit_id AND CONCAT(c_chit_id,' (',c_chit_name,')') LIKE '%$chit_id%' GROUP BY asc_chit_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscribers_json($chit_id,$subscriber_id) {
		$sql="SELECT s_id,s_party_id,s_party_name FROM mst_subscribers,assign_subs_to_chit WHERE mst_subscribers.s_party_id=assign_subs_to_chit.asc_subscriber_id AND CONCAT(s_party_id,' (',s_party_name,')') LIKE '%$subscriber_id%'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscribers_json2($subscriber_id) {
		$sql="SELECT s_id,s_party_id,s_party_name FROM mst_subscribers WHERE CONCAT(s_party_id,' (',s_party_name,')') LIKE '%$subscriber_id%' ORDER BY SUBSTRING(s_party_id, -2, 2) ASC";
		$query=$this->db->query($sql);
		return $query->result_array();
	}


	public function check_subscriber_id($auto_id,$chit_id,$subscriber_id) {
		$d_id='';
		if($auto_id!=''){
			$d_id="AND d_id!='".$auto_id."'";
		}
		
		$sql="SELECT d_id FROM mst_deposit WHERE d_chit_id='$chit_id' AND d_subscriber_id='$subscriber_id' $d_id";
		$query=$this->db->query($sql);
		return $query->num_rows();
	}

	public function view_all_collections($condition)
	{
		$table = 'tbl_deposit_history';
		$column_order = array(null, 'collected_date', 'd_subscriber_id', 'd_subscriber_name', 'd_updatetime','s_party_id');
		$column_search = array('collected_date', 'd_subscriber_id', 'd_subscriber_name', 'd_updatetime','s_party_id');
		$orderby = array('d_id' => 'desc');

		if($condition!='count_all'){


			$this->db->from($table);

			$this->db->select('tbl_deposit_history.*,mst_subscribers.s_party_id,,mst_users.log_first_name');
			$this->db->join('mst_subscribers', 'tbl_deposit_history.d_sub_id=mst_subscribers.s_id');
			$this->db->join('mst_users', 'tbl_deposit_history.d_user_id=mst_users.log_id');
			
			if($this->input->post('chit_id')!='')
			{
				$this->db->where("mst_subscribers.s_party_id LIKE '%".$this->input->post('chit_id')."%'");
			}
			
			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("tbl_deposit_history.collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
			} else {
				// $this->db->where("tbl_deposit_history.collected_date='".date('Y-m-d')."' ");
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

			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("tbl_deposit_history.collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
			} else {
				// $this->db->where("tbl_deposit_history.collected_date='".date('Y-m-d')."' ");
			}
			$this->db->join('mst_subscribers', 'tbl_deposit_history.d_sub_id=mst_subscribers.s_id');

			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_total_amt()
	{
		$this->db->select('SUM(d_amount) d_amount');
		$this->db->from('tbl_deposit_history');

		if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
		{
			$this->db->where("collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
		} else {
			$this->db->where("collected_date='".date('Y-m-d')."' ");
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function cancel_deposite($id,$d_amount,$d_sub_id) {
		$sql="DELETE FROM tbl_deposit_history WHERE d_id=?";
		$this->db->query($sql,array($id));
	}

	function get_deposite_amount($d_sub_id){
		return $this->db->where('d_sub_id',$d_sub_id)->get('mst_deposit')->result();
	}

	public function deposite_amount_update($data,$statestid)
	{
		if($data['new_amount']!='0'){
			$this->db->set('d_amount',$data['new_amount']);
			$this->db->where('d_sub_id', $statestid);
			$this->db->update('mst_deposit');
		}else{
			$sql="DELETE FROM mst_deposit WHERE d_sub_id=?";
			$this->db->query($sql,array($statestid));
		}	

	}
	
}
?>