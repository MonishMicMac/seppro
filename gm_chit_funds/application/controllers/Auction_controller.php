<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Auction_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Auction_model','auction_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function auction_management()
	{
		$this->load->view('auction_management');
	}

	public function view_all_auctions()
	{
		$list = $this->auction_model->view_all_auctions('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $auctions) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $auctions->a_auction_id;
			$row[] = date('d-m-Y',strtotime($auctions->a_auction_date));
			$row[] = $auctions->a_chit_id;
			$row[] = $auctions->s_party_name;
			$row[] = $auctions->a_bid_amount;
			$row[] = $auctions->a_commission_amount;
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' subs_id='".$auctions->a_id."' onclick='open_popup(this)'><i class='fa fa-edit'></i> Edit</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->auction_model->view_all_auctions('count_all'),
			"recordsFiltered" => $this->auction_model->view_all_auctions('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_auction_details()
	{
		$id=$this->input->post('subs_id');
		$data['auction_details']=$this->auction_model->get_auction_details($id);
		echo json_encode($data);
	}

	public function auction_add_edit()
	{
		$condition=$this->input->post('condition');
		$id=$this->input->post('auto_id');

		if($condition=='add_auction'){
			$data['a_auction_id']=$this->get_auto_auction_id()['a_auction_id'];
		} else {
			$data['a_auction_id']=$this->input->post('auction_id');
		}

		$data['a_auction_date']=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('auction_date'))));

		$chit_id=explode(" (", $this->input->post('chit_id'));
		$bidder_id=explode(" (", $this->input->post('bidder_id'));

		$data['a_chit_id']=$chit_id[0];
		$data['a_bidder_id']=$bidder_id[0];
		$data['a_total_subsription']=$this->input->post('total_subsription');
		$data['a_bid_count']=$this->input->post('bid_count');
		$data['a_chit_amount']=$this->input->post('chit_amount');
		$data['a_bid_amount']=$this->input->post('bid_amount');
		$data['a_commission_amount']=$this->input->post('commission_amount');
		$data['a_balance_amount']=$this->input->post('balance_amount');
		$data['a_collect_amount']=$this->input->post('collect_amount');
		$data['a_auction_count']=$this->input->post('auction_cnt');
		$data['a_user_id']=$this->session->userdata('user_details')['log_id'];

		$this->auction_model->auction_insert_update($condition,$id,$data);

		redirect('Auction_controller/auction_management');
	}

	public function check_auction_id()
	{
		$auto_id=$this->input->post('auto_id');
		$auction_id=$this->input->post('auction_id');
		$cnt=$this->auction_model->check_auction_id($auto_id,$auction_id);
		if($cnt==0){
			echo 'true';
		} else {
			echo 'false';
		}
	}

	public function check_chit_id()
	{
		$chit_id=$this->input->post('chit_id');
		$condition=$this->input->post('condition');
		$auction_date=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('auction_date'))));

		$cnt=$this->auction_model->check_chit_id($chit_id,$auction_date,$condition);
		if($cnt==0){
			echo 'false';
		} else {
			echo 'true';
		}
	}

	public function check_bidder_id()
	{
		$exp_chit_id=explode(" (", $this->input->post('chit_id'));
		$chit_id=$exp_chit_id[0];
		$condition=$this->input->post('condition');
		$bidder_id=$this->input->post('bidder_id');
		$cnt=$this->auction_model->check_bidder_id($chit_id,$bidder_id,$condition);
		if($cnt==0){
			echo 'false';
		} else {
			echo 'true';
		}
	}

	public function get_chits_json()
	{
		$chit_id=$this->input->post('chit_id');
		$condition=$this->input->post('condition');
		$auction_date=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('auction_date'))));

		$data=$this->auction_model->get_chits_json($chit_id,$auction_date,$condition);		
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
		$condition=$this->input->post('condition');
		$subscriber_id=$this->input->post('subscriber_id');
		$data=$this->auction_model->get_subscribers_json($chit_id,$subscriber_id,$condition);

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
		$data=$this->auction_model->get_chit_amount($id);
		$data_cnt=$this->auction_model->get_auction_count($this->input->post('chit_id'));

		$json['chit_amount']=$data[0]['c_chit_amount'];
		$json['comm_percent']=$data[0]['c_commission'];
		$json['subscribers_cnt']=$data[0]['c_subscribers_cnt'];
		$json['auction_cnt']=$data_cnt+1;
		$json['company_chit_month']=$data[0]['company_chit_month'];
		
		echo json_encode($json);
	}

	public function get_auto_auction_id()
	{
		$a_auction_id=$this->auction_model->get_auto_auction_id()[0]['a_auction_id'];
		$f_word='TRA-';

		if($a_auction_id==""){
			$auction_id='100001';
			$full_auction_id=$f_word.$auction_id;
		}else{
			$auction_id=substr(($a_auction_id),4);
			$auction_id++;
			$full_auction_id=$f_word.$auction_id;
		}
		$data['a_auction_id']=$full_auction_id;

		return $data;
	}

	public function get_auto_auction_id_json()
	{
		echo json_encode($this->get_auto_auction_id());
	}
}
