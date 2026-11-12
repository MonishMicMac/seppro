<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Collection_report_model  extends CI_Model {

	public function view_all_collections($condition)
	{
		$table = 'mst_collection';
		$column_order = array(null, 'cl_bill_no', 'cl_bill_month', 'cl_collected_date', 'cl_chit_id', 'cl_subscriber_id', 'cl_collection_amount', 'cl_outstanding_amount', 'cl_remarks', 'cl_status');
		$column_search = array('cl_bill_no', 'cl_bill_month', 'cl_collected_date', 'cl_chit_id', 'cl_subscriber_id', 'cl_collection_amount', 'cl_outstanding_amount', 'cl_remarks', 'cl_status');
		$orderby = array('cl_id' => 'desc');

		if($condition!='count_all'){

			$this->db->select('mst_collection.*,mst_subscribers.s_party_name,mst_subscribers.s_party_id');
			$this->db->from($table);
			$this->db->join('mst_subscribers', 'mst_collection.cl_subscriber_id=mst_subscribers.s_party_id');

			if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
			{
				$this->db->where("cl_collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
			} else {
				$this->db->where("cl_id='0'");
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
			$this->db->join('mst_subscribers', 'mst_collection.cl_subscriber_id=mst_subscribers.s_party_id');
			$query = $this->db->get();
			return $query->num_rows();
		}
	}

	public function get_total_amt()
	{
		$this->db->select('SUM(cl_collection_amount) cl_collection_amount,SUM(cl_outstanding_amount) cl_outstanding_amount');
		$this->db->from('mst_collection');
		$this->db->join('mst_subscribers', 'mst_collection.cl_subscriber_id=mst_subscribers.s_party_id');

		if($this->input->post('from_date')!='' && $this->input->post('to_date')!='')
		{
			$this->db->where("cl_collected_date BETWEEN '".date('Y-m-d',strtotime($this->input->post('from_date')))."' AND '".date('Y-m-d',strtotime($this->input->post('to_date')))."'");
		} else {
			$this->db->where("cl_id='0'");
		}
		$query = $this->db->get();
		return $query->result_array();
	}
}
?>