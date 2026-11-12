<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Collection_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Collection_model','collection_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function collection_management()
	{
		$data['cl_collected_date'] = $this->collection_model->last_collection_date();
		
		$this->load->view('collection_management',$data);
	}

	public function view_all_collections()
	{
		$list = $this->collection_model->view_all_collections('datatable');
		$data = array();
		$no = $_POST['start'];

		$collection_amount=0;
		$outstanding_amount=0;
		$prev_out_amount=0;
		$deposit_Coll_amount=0;
		foreach ($list as $collections) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $collections->cl_bill_no;
			$row[] = date('d-m-Y',strtotime($collections->cl_collected_date));
			$row[] = $collections->cl_chit_id;
			$row[] = $collections->s_party_name;
			$row[] = $collections->cl_prev_out_amount;
			$row[] = $collections->cl_collection_amount;
			$row[] = $collections->deposit_Coll_amount;
			$row[] = $collections->cl_outstanding_amount;
			if($this->session->userdata('user_details')['log_user_role']=='1')  {
				$row[] = $collections->log_first_name;
			}

			$edit_option='';
			$view_option='';

			$edit_option="<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' coll_id='".$collections->cl_id."' onclick='open_popup(this)'><i class='fa fa-eye'></i> View</a>";

			if($this->session->userdata('user_details')['log_user_role']=='1') {
				$view_option=" <a id='cancel_this' class='btn btn-sm red' coll_id='".$collections->cl_id."' bill_no='".$collections->cl_bill_no."' onclick='cancel_this(this)'><i class='fa fa-remove'></i> Cancel</a>";
			}
			elseif($this->session->userdata('user_details')['log_user_role']=='2')
			{
				if($collections->cl_collected_date==date('Y-m-d') || $collections->cl_collected_date==date('Y-m-d',strtotime("-1 days")))
				{
					$view_option=" <a id='cancel_this' class='btn btn-sm red' coll_id='".$collections->cl_id."' bill_no='".$collections->cl_bill_no."' onclick='cancel_this(this)'><i class='fa fa-remove'></i> Cancel</a>";
				} else {
					$view_option="Can't Cancel this Collection";
				}
			}

			$row[] = $edit_option.$view_option;


			$prev_out_amount+=$collections->cl_prev_out_amount;
			$collection_amount+=$collections->cl_collection_amount;
			$deposit_Coll_amount+=$collections->deposit_Coll_amount;
			$outstanding_amount+=$collections->cl_outstanding_amount;

			$data[] = $row;
		}

		$output = array(
			"prev_out_amt" => $prev_out_amount,
			"coll_amt" => $collection_amount,
			"dep_amt" => $deposit_Coll_amount,
			"out_amt" => $outstanding_amount,
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->collection_model->view_all_collections('count_all'),
			"recordsFiltered" => $this->collection_model->view_all_collections('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_collection_details()
	{
		$id=$this->input->post('coll_id');
		$data['collection_details']=$this->collection_model->get_collection_details($id);
		echo json_encode($data);
	}

	public function collection_add_edit()
	{
		$condition=$this->input->post('condition');
		$id=$this->input->post('auto_id');
		$data['cl_bill_no']=$this->input->post('bill_no');
		$data['cl_collected_date']=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('collected_date'))));

		$chit_id=explode(" (", $this->input->post('chit_id'));
		$subscriber_id=explode(" (", $this->input->post('subscriber_id'));

		$subscriber_id_no=explode("  ", $this->input->post('chit_and_sub_id'));

		$data['cl_chit_id']=$chit_id[0];
		$data['cl_subscriber_id']=$subscriber_id[0];
		$data['cl_prev_out_amount']=$this->input->post('prev_out_amount');
		$data['deposit_Coll_amount']=$this->input->post('deposit_Coll_amount');
		$data['deposit_amount']=$this->input->post('deposit_amount');
		$data['cl_collection_amount']=$this->input->post('coll_amount')+$this->input->post('deposit_Coll_amount');
		// $data['cl_collection_amount']=$this->input->post('coll_amount');
		$data['cl_outstanding_amount']=$this->input->post('out_amount');
		$data['payment_type']=$this->input->post('cashcheque');
		$data['cheque_no']=$this->input->post('chequeno');
		$data['cl_remarks']=$this->input->post('remarks');
		$data['cl_user_id']=$this->session->userdata('user_details')['log_id'];
		if($chit_id[0]!=''){
			$this->collection_model->collection_insert_update($condition,$id,$data);
			$sids=$subscriber_id_no[2];

		// $data1['deposit_Coll_amount']=$this->input->post('deposit_Coll_amount');

			$data1['d_amount']=$this->input->post('deposit_amount')-$this->input->post('deposit_Coll_amount');

			$this->collection_model->collection_deposit_insert_update($sids,$data1);
		}
		redirect('Collection_controller/collection_management');
	}

	public function check_bill_no()
	{
		$auto_id=$this->input->post('auto_id');
		$bill_no=$this->input->post('bill_no');
		$cnt=$this->collection_model->check_bill_no($auto_id,$bill_no);
		if($cnt==0){
			echo 'true';
		} else {
			echo 'false';
		}
	}

	public function check_chit_id()
	{
		$chit_id=$this->input->post('chit_id');
		$cnt=$this->collection_model->check_chit_id($chit_id);
		if($cnt==0){
			echo 'false';
		} else {
			echo 'true';
		}
	}

	public function check_subscriber_id()
	{
		$subscriber_id=$this->input->post('subscriber_id');
		$cnt=$this->collection_model->check_subscriber_id($subscriber_id);
		if($cnt==0){
			echo 'false';
		} else {
			echo 'true';
		}
	}

	public function get_chits_subs_json()
	{
		$chit_and_sub_id=$this->input->post('chit_and_sub_id');
		$data=$this->collection_model->get_chits_subs_json($chit_and_sub_id);

		$chits=array();
		foreach ($data as $chit) {
			$chits[]=array(
				'label' => $chit['c_chit_id'].' ('.$chit['c_chit_name'].')  '.$chit['s_party_id'].' ('.$chit['s_party_name'].')',
				'value' => $chit['c_chit_id'].' ('.$chit['c_chit_name'].')  '.$chit['s_party_id'].' ('.$chit['s_party_name'].')  '.$chit['s_id']
			);
		}

		echo json_encode($chits);
	}

	public function get_chits_json()
	{
		$chit_id=$this->input->post('chit_id');
		$data=$this->collection_model->get_chits_json($chit_id);

		$chits=array();
		foreach ($data as $chit) {
			$chits[]=array(
				'label' => $chit['c_chit_id'].' ('.$chit['c_chit_name'].')',
				'value' => $chit['c_chit_id'].' ('.$chit['c_chit_name'].')'
			);
		}

		echo json_encode($chits);
	}

	public function get_subscribers_json()
	{
		$exp_chit_id=explode(" (", $this->input->post('chit_id'));
		$chit_id=$exp_chit_id[0];
		$subscriber_id=$this->input->post('subscriber_id');
		$data=$this->collection_model->get_subscribers_json($chit_id,$subscriber_id);

		$subscribers=array();
		foreach ($data as $subscriber) {
			$subscribers[]=array(
				'label' => $subscriber['s_party_id'].' ('.$subscriber['s_party_name'].')',
				'value' => $subscriber['s_party_id'].' ('.$subscriber['s_party_name'].')'
			);
		}

		echo json_encode($subscribers);
	}

	public function get_chit_amount()
	{
		$exp_id=explode(" (", $this->input->post('chit_id'));
		$id=$exp_id[0];
		$data=$this->collection_model->get_chit_amount($id);

		$json['chit_amount']=$data[0]['c_chit_amount'];
		$json['comm_percent']=$data[0]['c_commission'];

		echo json_encode($json);
	}

	public function get_outstanding_amount()
	{
		$collected_date=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('collected_date'))));
		$chit_exp_id=explode(" (", $this->input->post('chit_id'));
		$chit_id=$chit_exp_id[0];
		$sub_exp_id=explode(" (", $this->input->post('subscriber_id'));
		$sub_id=$sub_exp_id[0];

		$current_outstanding=$this->collection_model->get_outstanding_amount($collected_date,$chit_id,$sub_id);

		$json['outstading_amount']=($current_outstanding=='')?'0':$current_outstanding;

		echo json_encode($json);
	}

	public function get_deposit_amount()
	{
		$collected_date=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('collected_date'))));
		$chit_exp_id=explode(" (", $this->input->post('chit_id'));
		$chit_id=$chit_exp_id[0];
		$sub_exp_id=explode(" (", $this->input->post('subscriber_id'));
		$sub_id=$sub_exp_id[0];

		$current_outstanding=$this->collection_model->get_deposit_amount($collected_date,$chit_id,$sub_id);

		$json['deposit_amount']=($current_outstanding=='')?'0':$current_outstanding;

		echo json_encode($json);
	}

	public function cancel_collection()
	{
		$id=$this->input->post('coll_id');
		$this->collection_model->cancel_collection($id);
	}
}
