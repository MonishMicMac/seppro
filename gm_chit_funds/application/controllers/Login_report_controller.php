<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Login_report_controller extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Login_report_model','login_report_model');
		$this->load->library('session');
	}

	public function login_report(){
		$this->load->view('login_report');
	}

	public function view_login_report()
	{
		$list = $this->login_report_model->view_login_report('datatable');
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $login) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $login->log_first_name;
			$row[] = $login->ip_address;
			$row[] = date('d-m-Y',strtotime($login->ll_date_in)).' '.$login->ll_time_in;
			$row[] = ($login->ll_date_out=='0000-00-00')?'0000-00-00 00:00:00':date('d-m-Y',strtotime($login->ll_date_out)).' '.$login->ll_time_out;
			$data[] = $row;
		}

		$output = array(
			"footerTotal" => '200',
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->login_report_model->view_login_report('count_all'),
			"recordsFiltered" => $this->login_report_model->view_login_report('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_users_json()
	{
		$user_name=$this->input->post('user_name');
		$data=$this->login_report_model->get_users_json($user_name);

		$users=array();
		foreach ($data as $user) {
			$users[]=array(
				'label' => $user['log_first_name'],
				'value' => $user['log_first_name']
			);
		}

		echo json_encode($users);
	}

}
?>