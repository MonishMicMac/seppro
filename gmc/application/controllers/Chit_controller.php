<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Chit_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Chit_model','chit_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function chit_management()
	{
		$this->load->view('chit_management');
	}

	public function view_all_chits()
	{
		$list = $this->chit_model->view_all_chits('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $chits) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $chits->c_chit_id;
			$row[] = $chits->c_chit_name;
			$row[] = $chits->c_chit_amount;
			$row[] = $chits->c_subscribers_cnt;
			$row[] = $chits->c_total_months;
			$row[] = $chits->c_monthly_amount;
			$row[] = date('d-m-Y',strtotime($chits->c_date));
			$row[] = ($chits->c_status==0)?"<span class='label label-sm label-success'> Active </span>":"<span class='label label-sm label-danger'> Inactive </span>";
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' chit_id='".$chits->c_id."' onclick='open_popup(this)'><i class='fa fa-edit'></i> Edit</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->chit_model->view_all_chits('count_all'),
			"recordsFiltered" => $this->chit_model->view_all_chits('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_chit_details()
	{
		$id=$this->input->post('chit_id');
		$data['chit_details']=$this->chit_model->get_chit_details($id);
		echo json_encode($data);
	}

	public function chit_add_edit()
	{
		$condition=$this->input->post('condition');
		$id=$this->input->post('auto_id');

		$data['c_chit_id']=$this->input->post('c_chit_id');
		$data['c_chit_name']=$this->input->post('chit_name');
		$data['c_chit_amount']=$this->input->post('chit_amount');
		$data['c_subscribers_cnt']=$this->input->post('subscribers');
		$data['c_total_months']=$this->input->post('total_months');
		$data['c_monthly_amount']=$this->input->post('monthly_amount');
		$data['company_chit_month']=$this->input->post('company_chit_month');
		$data['c_commission']=$this->input->post('commission');
		$data['c_date']=date('Y-m-d',strtotime(str_replace("/", "-", $this->input->post('chit_date'))));
		$data['c_time']=$this->input->post('chit_time');
		$data['c_user_id']=$this->session->userdata('user_details')['log_id'];
		$data['c_status']=($this->input->post('status')!='')?'0':'1';

		$this->chit_model->chit_insert_update($condition,$id,$data);

		redirect('Chit_controller/chit_management');
	}

	public function check_chit_id()
	{
		$auto_id=$this->input->post('auto_id');
		$chit_id=$this->input->post('c_chit_id');
		$cnt=$this->chit_model->check_chit_id($auto_id,$chit_id);
		if($cnt==0){
			echo 'true';
		} else {
			echo 'false';
		}
	}

	public function get_auto_chit_id()
	{
		$c_chit_id=$this->chit_model->get_auto_chit_id()[0]['c_chit_id'];
		$f_word='GMC';

		if($c_chit_id==""){
			$chit_id='100001';
			$full_chit_id=$f_word.$chit_id;
		}else{
			$chit_id=substr(($c_chit_id),3);
			$chit_id++;
			$full_chit_id=$f_word.$chit_id;
		}
		$data['c_chit_id']=$full_chit_id;

		return $data;
	}

	public function get_auto_chit_id_json()
	{
		echo json_encode($this->get_auto_chit_id());
	}
}
