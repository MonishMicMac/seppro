<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Subscriber_detailed_report extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Subscriber_detailed_report_model','subscriber_detailed_report_model');
		$this->load->library('session');
	}

	public function Subscriber_details_view(){
		$this->load->view('subscriber_details_report');
	}

	public function get_subscribers_json()
	{
		// $exp_chit_id=explode(" (", $this->input->post('chit_id'));
		// $chit_id=$exp_chit_id[0];
		$subscriber_id=$this->input->post('subscriber_id');
		$data=$this->subscriber_detailed_report_model->get_subscribers_json($subscriber_id);

		$subscribers=array();
		foreach ($data as $subscriber) {
			$subscribers[]=array(
				'label' => $subscriber['s_party_id'].' -('.$subscriber['s_party_name'].')' ,
				'value' => $subscriber['s_party_id'].' -('.$subscriber['s_party_name'].')'
			);
		}

		echo json_encode($subscribers);
	}

	public function view_subscriber()
	{
		$id=$this->input->post('subscriber_id');
		$data=$this->subscriber_detailed_report_model->get_subscriber_details($id);		
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
		$data=$this->subscriber_detailed_report_model->get_action_details($chit_id,$subscriber_id);		
		foreach ($data as $action) {
			$no++;
			echo "<tr>
			<td>".$no."</td>
			<td><a id='open_popupnew' data-toggle='modal' href='#basicnew'  chit_id='".$chit_id."' action_date='".$action['a_auction_date']."' subscriber_id='".$subscriber_id."' onclick='open_popupnew(this)'>".$action['a_auction_id']."</a></td>
			<td>".date('d-m-Y',strtotime($action['a_auction_date']))."</td>
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
		$data=$this->subscriber_detailed_report_model->get_action_details_new1($chit_id,$subscriber_id,$autiondate);

		// print_r($data);
		// exit;
		foreach ($data as $action) {
			$total+=$action['cl_collection_amount'];
			$no++;
			echo "<tr>
			<td>".$no."</td>
			<td>".date('d-m-Y',strtotime($action['cl_collected_date']))."</td>
			<td>".$action['cl_chit_id']."</td>
			<td>".$action['cl_subscriber_id'].'-'.$action['s_party_name']."</td>
			<td>".$action['cl_collection_amount']."</td>
			<td>".$action['cl_remarks']."</td>
			</tr>";
		}
		echo "<tr><td colspan=\"4\" style=\"text-align:right;\">Total</td><td  style=\"text-align:left;\">".$total."</td></tr>";
	
	}



}
?>