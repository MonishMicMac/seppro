<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Subscriber_detailed_report1 extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Subscriber_detailed_report_model1','subscriber_detailed_report_model');
		$this->load->library('session');
	}

	public function Subscriber_details_view(){
		$this->load->view('subscriber_details_report1');
	}

	public function get_subscribers_json()
	{
		$exp_chit_id=explode(" (", $this->input->post('chit_id'));
		$chit_id=$exp_chit_id[0];
		$subscriber_id=$this->input->post('subscriber_id');
		$data=$this->subscriber_detailed_report_model->get_subscribers_json($chit_id,$subscriber_id);

		$subscribers=array();
		foreach ($data as $subscriber) {
			$subscribers[]=array(
				'label' => $subscriber['s_party_id'].' ('.$subscriber['s_party_name'].')',
				'value' => $subscriber['s_party_id'].' ('.$subscriber['s_party_name'].')'
			);
		}

		echo json_encode($subscribers);
	}

	public function get_chits_json()
	{
		$chit_id=$this->input->post('chit_id');
		$data=$this->subscriber_detailed_report_model->get_chits_json($chit_id);

		$chits=array();
		foreach ($data as $chit) {
			$chits[]=array(
				'label' => $chit['c_chit_id'].' ('.$chit['c_chit_name'].')',
				'value' => $chit['c_chit_id'].' ('.$chit['c_chit_name'].')'
			);
		}

		echo json_encode($chits);
	}

	public function view_subscriber()
	{
		$exp_chit_id=explode(" (", $this->input->post('chit_id'));
		$chit_id=$exp_chit_id[0];
		$exp_sub_id=explode(" (", $this->input->post('subscriber_id'));
		$subscriber_id=$exp_sub_id[0];
		$id=$subscriber_id;
		$chit_id=$chit_id;
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data=$this->subscriber_detailed_report_model->get_subscriber_details($id,$chit_id,$fromdate,$todate);		
		foreach ($data as $action) {
			$no++;
			echo "<tr>
			<td>".$no."</td>
			<td><a id='open_popupnew' data-toggle='modal' href='#basicnew'  chit_id='".$action['asc_chit_id']."' subscriber_id='".$id."' onclick='open_popupnew(this)'>".$action['asc_chit_id']."</a></td>
			<td>".$action['c_chit_name']."</td>
			<td>".$action['c_chit_amount']."</td>
			<td>".$action['c_total_months']."</td>
			<td>".$action['c_monthly_amount']."</td>
			</tr>";
		}
	}

	public function view_action()
	{
		$chit_id=$this->input->post('chit_id');
		$subscriber_id=$this->input->post('subscriber_id');
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data=$this->subscriber_detailed_report_model->get_action_details($chit_id,$subscriber_id,$fromdate,$todate);		
		foreach ($data as $action) {
			$no++;
			echo "<tr>
			<td>".$no."</td>
			<td><a id='open_popupnew' data-toggle='modal' href='#basicnew'  chit_id='".$chit_id."' action_date='".$action['a_auction_date']."' subscriber_id='".$subscriber_id."' onclick='open_popupnew(this)'>".$action['a_auction_id']."</a></td>
			<td>".$action['a_auction_date']."</td>
			<td>".$action['a_bidder_id']."</td>
			<td>".$action['a_bid_amount']."</td>
			<td>".$action['a_collect_amount']."</td>
			</tr>";
		}
	}

	public function view_subscriber_new()
	{
		$chit_id=$this->input->post('chit_id');
		$subscriber_id=$this->input->post('subscriber_id');
		$autiondate=$this->input->post('autiondate');
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data=$this->subscriber_detailed_report_model->get_action_details_new($chit_id,$subscriber_id,$autiondate,$fromdate,$todate);

		$total_out_amt=0;
		$total_coll_amt=0;
		foreach ($data as $action) {
			$no++;
			echo "<tr>
			<td>".$no."</td>
			<td>".$action['cl_bill_no']."</td>
			<td>".date('d-m-Y',strtotime($action['cl_collected_date']))."</td>
			<td>".$action['cl_chit_id']."</td>
			<td>".$action['cl_subscriber_id']."</td>
			<td>".$action['cl_prev_out_amount']."</td>
			<td>".$action['cl_collection_amount']."</td>
			</tr>";

			$total_out_amt+=$action['cl_prev_out_amount'];
			$total_coll_amt+=$action['cl_collection_amount'];
		}
		echo "<tr>";
		echo "<td colspan='5' style='text-align: end;'>Total</td>";
		echo "<td>".$total_out_amt."</td>";
		echo "<td>".$total_coll_amt."</td>";
		echo "</tr>";
		
	}



}
?>