<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class User_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('User_model','user_model');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function user_management()
	{
		$this->load->view('user_management');
	}

	public function view_all_users()
	{
		$list = $this->user_model->view_all_users('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $users) {
			$no++;
			$row = array();

			if($users->log_user_role==1){
				$user_role='Super Admin';
			}elseif($users->log_user_role==2){
				$user_role='Admin';
			}elseif($users->log_user_role==3){
				$user_role='Front Desk';
			}elseif($users->log_user_role==4){
				$user_role='Collection';
			}

			$row[] = $no;
			$row[] = $users->log_first_name;
			$row[] = $users->log_last_name;
			$row[] = $users->log_user_name;
			$row[] = $users->log_phone_no;
			$row[] = $users->log_email_id;
			$row[] = $user_role;
			$row[] = ($users->log_status==0)?"<span class='label label-sm label-success'> Active </span>":"<span class='label label-sm label-danger'> Inactive </span>";
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' user_id='".$users->log_id."' onclick='open_popup(this)'><i class='fa fa-edit'></i> Edit</a>";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->user_model->view_all_users('count_all'),
			"recordsFiltered" => $this->user_model->view_all_users('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_user_details()
	{
		$id=$this->input->post('user_id');
		$data['user_details']=$this->user_model->get_user_details($id);
		echo json_encode($data);
	}

	public function user_add_edit()
	{
		$condition=$this->input->post('condition');
		$id=$this->input->post('auto_id');
		$data['log_first_name']=$this->input->post('first_name');
		$data['log_last_name']=$this->input->post('last_name');
		$data['log_user_name']=$this->input->post('user_name');
		$data['log_password']=md5($this->input->post('password'));
		$data['log_phone_no']=$this->input->post('phone_no');
		$data['log_email_id']=$this->input->post('email_id');
		$data['log_user_role']=$this->input->post('user_role');
		$data['log_status']=($this->input->post('status')!='')?'0':'1';

		$this->user_model->user_insert_update($condition,$id,$data);

		redirect('User_controller/user_management');
	}

	public function check_user_id()
	{
		$auto_id=$this->input->post('auto_id');
		$user_name=$this->input->post('user_name');
		$cnt=$this->user_model->check_user_id($auto_id,$user_name);
		if($cnt==0){
			echo 'true';
		} else {
			echo 'false';
		}
	}
}
