<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Deposit_controller extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Deposit_model','deposit_model');
		$this->load->library('session');
	}

	public function deposit_management(){
		$this->load->view('deposit_management');
	}

	public function view_all_deposit()
	{
		$list = $this->deposit_model->view_all_deposit('datatable');
		$data = array();
		$no = $_POST['start'];
		/*$saleslistrep = $this->deposit_model->customer_id();*/
		
		$deposit_Coll_amount=0;
		foreach ($list as $deposit) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = date('d-m-Y',strtotime($deposit->collected_date));
			$row[] = $deposit->d_bill_no;
			$row[] = $deposit->d_sub_id;
			$row[] = $deposit->s_party_id;
			$row[] = $deposit->d_subscriber_name;
			$row[] = $deposit->d_amount;
			$row[] = $deposit->log_first_name;
			//$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' class='btn btn-sm purple' deposit_id='".$deposit->d_id."' onclick='open_popup(this)'><i class='fa fa-edit'></i> Edit</a>";
			$deposit_Coll_amount+=$deposit->d_amount;
			$data[] = $row;
		}

		// $amounts=$this->deposit_model->get_total_amt();
		// $prev_out_amount=$amounts->d_amount;

		$output = array(
			// "prev_out_amt" => $prev_out_amount,
			"dep_amt1" => $deposit_Coll_amount,
			"footerTotal" => '200',
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->deposit_model->view_all_deposit('count_all'),
			"recordsFiltered" => $this->deposit_model->view_all_deposit('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_deposit_details()
	{
		$id=$this->input->post('deposit_id');
		$data['deposit_details']=$this->deposit_model->get_deposit_details($id);
		echo json_encode($data);
	}

	public function deposit_add_edit()
	{
		$condition=$this->input->post('condition');
		$id=$this->input->post('auto_id');

		$chit_id=explode("-", $this->input->post('chit_id'));
		$subscriber_id=explode("-", $this->input->post('subscriber_id'));

		$data['collected_date']=date('Y-m-d',strtotime($this->input->post('collected_date')));
		$data['d_bill_no']=$this->input->post('d_bill_no');
		$data['d_subscriber_id']=$subscriber_id[1];
		$data['d_sub_id']=$subscriber_id[0];
		$data['d_subscriber_name']=$subscriber_id[2];
		$data['d_amount']=$this->input->post('amount');
		$data['d_user_id']=$this->session->userdata('user_details')['log_id'];

		$this->deposit_model->deposit_insert_update($condition,$id,$data);

		redirect('Deposit_controller/deposit_management');
	}

	public function get_chits_json()
	{
		$chit_id=$this->input->post('chit_id');
		$data=$this->deposit_model->get_chits_json($chit_id);

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
		$data=$this->deposit_model->get_subscribers_json2($subscriber_id);

		$subscribers=array();
		foreach ($data as $subscriber) {
			$subscribers[]=array(
				'label' => $subscriber['s_id'].'-'.$subscriber['s_party_id'].'-'.$subscriber['s_party_name'],
				'value' => $subscriber['s_id'].'-'.$subscriber['s_party_id'].'-'.$subscriber['s_party_name']
			);
		}

		echo json_encode($subscribers);
	}

	public function check_subscriber_id()
	{
		$auto_id=$this->input->post('auto_id');

		$chit_id=explode(" (", $this->input->post('chit_id'));
		$subscriber_id=explode(" (", $this->input->post('subscriber_id'));

		$chit_id=$chit_id[0];
		$subscriber_id=$subscriber_id[0];

		// $cnt=$this->deposit_model->check_subscriber_id($auto_id,$chit_id,$subscriber_id);
		// if($cnt==0){
		// 	echo 'true';
		// } else {
		// 	echo 'false';
		// }
	}


	public function deposite_report_management(){
		$this->load->view('deposite_report_management');
	}

	public function view_all_collections()
	{
		$list = $this->deposit_model->view_all_collections('datatable');
		$data = array();
		$no = $_POST['start'];
		$deposit_Coll_amount=0;
		foreach ($list as $collections) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = date('d-m-Y',strtotime($collections->collected_date));
			$row[] = $collections->s_party_id;
			$row[] = $collections->d_subscriber_name;
			$row[] = $collections->d_amount;
			if($this->session->userdata('user_details')['log_user_role']=='1')  {
				$row[] = $collections->log_first_name;
			}

			if($this->session->userdata('user_details')['log_user_role']=='1') {
				$view_option=" <a id='cancel_this' class='btn btn-sm red' coll_id='".$collections->d_id."' d_amount='".$collections->d_amount."' d_sub_id='".$collections->d_sub_id."' d_subscriber_name='".$collections->d_subscriber_name."' onclick='cancel_this(this)'><i class='fa fa-remove'></i> Cancel</a>";
			}
			elseif($this->session->userdata('user_details')['log_user_role']=='2')
			{
				if($collections->collected_date==date('Y-m-d') || $collections->collected_date==date('Y-m-d',strtotime("-1 days"))){
					$view_option=" <a id='cancel_this' class='btn btn-sm red' coll_id='".$collections->d_id."' d_amount='".$collections->d_amount."' d_sub_id='".$collections->d_sub_id."' d_subscriber_name='".$collections->d_subscriber_name."' onclick='cancel_this(this)'><i class='fa fa-remove'></i> Cancel</a>";
				}else{
					$view_option="Can't Cancel this Deposite";
				}
			}
			$row[] = $view_option;
			//$row[] = "<a id='cancel_this' class='btn btn-sm red' coll_id='".$collections->d_id."' d_amount='".$collections->d_amount."' d_sub_id='".$collections->d_sub_id."' d_subscriber_name='".$collections->d_subscriber_name."' onclick='cancel_this(this)'><i class='fa fa-remove'></i> Cancel</a>";
			
			$deposit_Coll_amount+=$collections->d_amount;
			$data[] = $row;
		}

		// $amounts=$this->deposit_model->get_total_amt();
		// $prev_out_amount=$amounts->d_amount;

		$output = array(
			// "prev_out_amt" => $prev_out_amount,
			"dep_amt" => $deposit_Coll_amount,
			"footerTotal" => '200',
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->deposit_model->view_all_collections('count_all'),
			"recordsFiltered" => $this->deposit_model->view_all_collections('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function cancel_deposite()
	{
		$info =& get_instance();

		$coll_id=$this->input->post('coll_id');
		$d_amount=$this->input->post('d_amount');

		$d_sub_id=$this->input->post('d_sub_id');
		$data2=$info->deposit_model->get_deposite_amount($d_sub_id);
		foreach($data2 as $datas2)
		{
			$overall_amount=$datas2->d_amount;
		}
		$new_amount=$overall_amount-$d_amount;

		$appoint['d_sub_id']=$this->input->post('d_sub_id');
		$appoint['new_amount']=$new_amount;
		$appoint['d_user_id']=$this->session->userdata('user_details')['log_id'];

		$this->deposit_model->deposite_amount_update($appoint,$this->input->post('d_sub_id'));
		$this->deposit_model->cancel_deposite($coll_id,$d_amount,$d_sub_id);
	}


}
?>