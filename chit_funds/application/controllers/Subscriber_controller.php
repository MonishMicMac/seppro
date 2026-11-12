<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Subscriber_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Subscriber_model','subscriber_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function subscriber_management()
	{
		$this->load->view('subscriber_management');
	}

	public function view_all_subscribers()
	{
		$list = $this->subscriber_model->view_all_subscribers('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $subscribers) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $subscribers->s_party_id;
			/*$row[] = $subscribers->s_group_name;*/
			$row[] = $subscribers->s_party_name;
			$row[] = ($subscribers->s_gender==1)?"Male":"Female";
			$row[] = $subscribers->s_mobile_no;
			$row[] = $subscribers->s_phone_no;
			$row[] = $subscribers->surety_no;
			$row[] = $subscribers->s_aadhar_no;
			$row[] = $subscribers->s_area;
			$row[] = ($subscribers->s_status==0)?"<span class='label label-sm label-success'> Active </span>":"<span class='label label-sm label-danger'> Inactive </span>";
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' subs_id='".$subscribers->s_id."' onclick='open_popup(this)'><i class='fa fa-edit'></i> Edit</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->subscriber_model->view_all_subscribers('count_all'),
			"recordsFiltered" => $this->subscriber_model->view_all_subscribers('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_subscriber_details()
	{
		$id=$this->input->post('subs_id');
		$data['subscriber_details']=$this->subscriber_model->get_subscriber_details($id);
		echo json_encode($data);
	}

	public function subscriber_add_edit()
	{
		$condition=$this->input->post('condition');
		$id=$this->input->post('auto_id');
/*
		if($condition=='add_subscriber'){
			$data['s_party_id']=$this->get_auto_party_id()['s_party_id'];
		} else {*/
		$data['s_party_id']=$this->input->post('s_party_id');
		/*}*/
		/*$data['s_group_name']=$this->input->post('s_group_name');*/
		$party_name=str_replace("  "," ",$this->input->post('party_name'));
		$data['s_party_name']=str_replace("\\","/",$party_name);
		$data['s_gender']=$this->input->post('gender');
		$data['s_dob']=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('dob'))));
		$data['s_father_or_husband']=$this->input->post('father_or_husband');
		$data['s_nominee']=$this->input->post('nominee');
		$data['s_nominee_relation']=$this->input->post('nominee_relation');
		$data['s_aadhar_no']=$this->input->post('aadhar_no');
		$data['s_mobile_no']=$this->input->post('mobile_no');
		$data['s_phone_no']=$this->input->post('phone_no');
		$data['surety_no']=$this->input->post('surety_no');
		$data['s_area']=$this->input->post('area');
		$data['s_address']=$this->input->post('address');
		$data['s_remarks']=$this->input->post('remarks');
		$data['surety_no']=$this->input->post('surety_no');
		$data['s_user_id']=$this->session->userdata('user_details')['log_id'];
		$data['s_status']=($this->input->post('status')!='')?'0':'1';

		$this->subscriber_model->subscriber_insert_update($condition,$id,$data);

		redirect('Subscriber_controller/subscriber_management');
	}

	public function check_subscriber_id()
	{
		$auto_id=$this->input->post('auto_id');
		$party_id=$this->input->post('s_party_id');
		$cnt=$this->subscriber_model->check_subscriber_id($auto_id,$party_id);
		if($cnt==0){
			echo 'true';
		} else {
			echo 'false';
		}
	}

	public function get_auto_party_id()
	{
		$s_party_id=$this->subscriber_model->get_auto_party_id()[0]['s_party_id'];
		$f_word='SUB';

		if($s_party_id==""){
			$party_id='100001';
			$full_party_id=$f_word.$party_id;
		}else{
			$party_id=substr(($s_party_id),3);
			$party_id++;
			$full_party_id=$f_word.$party_id;
		}
		$data['s_party_id']=$full_party_id;

		return $data;
	}

	public function get_auto_party_id_json()
	{
		echo json_encode($this->get_auto_party_id());
	}
}
