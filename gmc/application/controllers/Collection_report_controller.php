<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Collection_report_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Collection_report_model','collection_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function collection_management()
	{
		$this->load->view('collection_report_management');
	}

	public function view_all_collections()
	{
		$list = $this->collection_model->view_all_collections('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $collections) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $collections->cl_bill_no;
			$row[] = date('d-m-Y',strtotime($collections->cl_collected_date));
			$row[] = $collections->cl_chit_id;
			$row[] = $collections->s_party_id.'-'.$collections->s_party_name;
			$row[] = $collections->cl_prev_out_amount;
			$row[] = $collections->cl_collection_amount;
			$row[] = $collections->cl_outstanding_amount;

			
			if($this->session->userdata('user_details')['log_user_role']=='1')  {
				$view_option=" <a id='cancel_this' class='btn btn-sm red' coll_id='".$collections->cl_id."' bill_no='".$collections->cl_bill_no."' onclick='cancel_this(this)'><i class='fa fa-remove'></i> Cancel</a>";
				$row[] = $view_option;
			}

			$data[] = $row;
		}

		$amounts=$this->collection_model->get_total_amt();
		$prev_out_amount=$amounts[0]['cl_prev_out_amount'];
		$collection_amount=$amounts[0]['cl_collection_amount'];
		$outstanding_amount=$amounts[0]['cl_outstanding_amount'];

		$output = array(
			"prev_out_amt" => $prev_out_amount,
			"coll_amt" => $collection_amount,
			"out_amt" => $outstanding_amount,
			"footerTotal" => '200',
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->collection_model->view_all_collections('count_all'),
			"recordsFiltered" => $this->collection_model->view_all_collections('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function cancel_collection()
	{
		$id=$this->input->post('coll_id');
		$this->collection_model->cancel_collection($id);
	}

	
}
