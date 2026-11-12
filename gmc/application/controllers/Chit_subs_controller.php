<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Chit_subs_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Chit_subs_model','chit_subs_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function chit_subs_management()
	{
		$this->load->view('chit_subs_management');
	}

	public function view_all_chit_subs()
	{
		$list = $this->chit_subs_model->view_all_chit_subs('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $chit_subs) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $chit_subs->asc_chit_id;
			$row[] = $chit_subs->asc_subscriber_id;
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' chit_id='".$chit_subs->asc_chit_id."' onclick='open_popup(this)'><i class='fa fa-edit'></i> Edit</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->chit_subs_model->view_all_chit_subs('count_all'),
			"recordsFiltered" => $this->chit_subs_model->view_all_chit_subs('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_chit_subs_details()
	{
		$chit_id=$this->input->post('chit_id');
		$result=$this->chit_subs_model->get_chit_subs_details($chit_id);
		
		$subscriber_ids='';
		for ($i=0; $i < count($result); $i++) { 
			$subscriber_ids.=$result[$i]['asc_subscriber_id'].',';
		}
		$data['cs_details']['asc_chit_id']=$result[0]['asc_chit_id'];
		$data['cs_details']['asc_subscriber_id']=$subscriber_ids;
		$data['cs_details']['c_subscribers_cnt']=$result[0]['c_subscribers_cnt'];

		echo json_encode($data);
	}

	public function chit_add_edit()
	{
		$condition=$this->input->post('condition');
		$data['chit_id']=$this->input->post('chit_id');
		$data['popup_chit_id']=$this->input->post('popup_chit_id');
		$data['subscriber_sno']=$this->input->post('subscriber_sno');
		$data['subscriber_id']=$this->input->post('subscriber_id');
		
		$this->chit_subs_model->chit_insert_update($condition,$data);

		redirect('Chit_subs_controller/chit_subs_management');
	}

	public function check_chit_subs_id()
	{
		$exp_chit_id=explode(" (", $this->input->post('chit_id'));
		$exp_popup_chit_id=explode(" (", $this->input->post('popup_chit_id'));

		$chit_id=$exp_chit_id[0];
		$popup_chit_id=$exp_popup_chit_id[0];
		$condition=$this->input->post('condition');
		$cnt=$this->chit_subs_model->check_chit_subs_id($chit_id,$popup_chit_id,$condition);
		if($cnt==0){
			echo 'true';
		} else {
			echo 'false';
		}
	}

	public function get_chits_json()
	{
		$chit_id=$this->input->post('chit_id');
		$data=$this->chit_subs_model->get_chits_json($chit_id);

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
		$subscriber_id=$this->input->post('subscriber_id');
		$sub_ids=$this->input->post('sub_ids');
		$sel_sub_ids='';
		foreach ($sub_ids as $sub_id) {
			if($subscriber_id!=$sub_id){
				$sub_id_exp=explode(" (", $sub_id);
				$sel_sub_ids.="'".$sub_id_exp[0]."',";
			}
		}
		$sel_sub_ids=rtrim($sel_sub_ids,",");

		$data=$this->chit_subs_model->get_subscribers_json($sel_sub_ids,$subscriber_id);

		$subscribers=array();
		foreach ($data as $subscriber) {
			$subscribers[]=array(
				'label' => $subscriber['s_party_id'].' ('.$subscriber['s_party_name'].')',
				'value' => $subscriber['s_party_id'].' ('.$subscriber['s_party_name'].')'
			);
		}

		echo json_encode($subscribers);
	}

	public function get_chit_sub_cnt()
	{
		$exp_id=explode(" (", $this->input->post('chit_id'));
		$id=$exp_id[0];
		$data=$this->chit_subs_model->get_chit_sub_cnt($id);

		$json['subscribers_cnt']=$data[0]['c_subscribers_cnt'];

		echo json_encode($json);
	}
}
