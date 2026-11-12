<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Login_controller extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Login_model','Login_model');
		$this->load->library('session');
		date_default_timezone_set('Asia/Calcutta');
	}

	public function index(){
		$this->load->view('login_page');
	}

	public function login(){
		if($this->input->post('condition')=="login"){
			$username=md5($this->input->post('username'));
			$password=md5($this->input->post('password'));

			$result=$this->Login_model->check_login($username,$password);
			if(!empty($result)){
				$user_details['log_id']=$result[0]['log_id'];
				$user_details['log_user_role']=$result[0]['log_user_role'];
				$user_details['log_user_name']=$result[0]['log_user_name'];
				$user_details['log_full_name']=$result[0]['log_first_name'].' '.$result[0]['log_last_name'];

				$condition='login';
				$ids='0';
				$data['ll_user_id']=$result[0]['log_id'];
				$data['ll_status_type']='1';
				$data['ll_date_in']=date('Y-m-d');
				$data['ll_time_in']=date('H:i:s');
				$data['ip_address']=$this->get_client_ip();

				$last_id=$this->Login_model->check_login_log($condition,$ids,$data);

				$user_details['last_login']=$last_id;

				$this->session->set_userdata('user_details', $user_details);
				echo "success";
			} else {
				echo "failed";
			}
		}
	}


	public function logout(){
		$condition='logout';
		$ids=$this->session->userdata('user_details')['last_login'];
		$data['ll_status_type']='2';
		$data['ll_date_out']=date('Y-m-d');
		$data['ll_time_out']=date('H:i:s');
		$data['ip_address']=$this->get_client_ip();
		$this->Login_model->check_login_log($condition,$ids,$data);

		$this->session->unset_userdata('user_details');
		redirect("Login_controller/index");
	}

	public function get_client_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP'])){
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];

		}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

		}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];

		}else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

		}else if(isset($_SERVER['HTTP_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED'];

		}else if(isset($_SERVER['REMOTE_ADDR'])){
			$ipaddress = $_SERVER['REMOTE_ADDR'];

		}else{
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}
}
?>