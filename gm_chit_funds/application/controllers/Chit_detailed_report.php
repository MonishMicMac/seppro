<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Chit_detailed_report extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Chit_detailed_report_model','chit_detailed_report_model');
		$this->load->library('session');
	}

	public function chit_details_view(){
		$this->load->view('chit_details_report');
	}

	public function view_all_chits()
	{
		$list = $this->chit_detailed_report_model->view_all_chits('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $chits) {
			$no++;
			$row = array();

			$data_cnt=$this->chit_detailed_report_model->get_auction_count($chits->c_chit_id);

			$row[] = $no;
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basic' chit_id='".$chits->c_chit_id."' onclick='open_popup(this)'>".$chits->c_chit_id."</a>";
			$row[] = date('d-m-Y',strtotime($chits->c_date));
			$row[] = $chits->c_time;
			$row[] = $chits->c_chit_name;
			$row[] = $chits->c_chit_amount;
			$row[] = $chits->c_subscribers_cnt;
			$row[] = $data_cnt;
			$row[] = $chits->c_total_months;			
			$row[] = $chits->c_monthly_amount;

			$data[] = $row;
		}
		$amounts=$this->chit_detailed_report_model->get_total_amt();
		$c_chit_amount=$amounts[0]['c_chit_amount'];

		$output = array(
			"c_chit_amount" => $c_chit_amount,
			"footerTotal" => '200',
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->chit_detailed_report_model->view_all_chits('count_all'),
			"recordsFiltered" => $this->chit_detailed_report_model->view_all_chits('count_filtered'),
			"data" => $data,
			);
		echo json_encode($output);
	}

	public function view_action()
	{
		$id=$this->input->post('chit_id');
		$data=$this->chit_detailed_report_model->get_action_details($id);		
		foreach ($data as $action) {
			$no++;
			echo "<tr>
			<td>".$no."</td>
			<td><a id='open_popupnew' data-toggle='modal' href='#basicnew' auction_id_name='".$action['a_auction_id']."'  auction_id='".$action['a_chit_id']."' action_date='".$action['a_auction_date']."' onclick='open_popupnew(this)'>".$action['a_auction_id']."</a></td>
			<td>".date('d-m-Y',strtotime($action['a_auction_date']))."</td>
			<td>".$action['sub_id'].' - '.$action['s_party_name']."</td>
			<td>".$action['a_bid_amount']."</td>
			<td>".$action['a_collect_amount']."</td>
			<td>".$action['a_commission_amount']."</td>
			<td>".($action['a_balance_amount']+$action['a_commission_amount'])."</td>
			<td>".$action['a_balance_amount']."</td>
		</tr>";

		$collectionamt1 +=$action['a_bid_amount'];
		$collectionamt2 +=$action['a_collect_amount'];
		$collectionamt3 +=$action['a_commission_amount'];
		$collectionamt4 +=($action['a_balance_amount']+$action['a_commission_amount']);
		$collectionamt5 +=$action['a_balance_amount'];
	}

echo "<tr>";
echo "<td colspan='4' style='text-align:right;'><b>Total</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt1."</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt2."</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt3."</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt4."</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt5."</b></td>";
echo "</tr>";
}

public function view_action_new()
{
	$id=$this->input->post('auction_id');
	$idate=$this->input->post('auction_date');
	$auction_id_name=$this->input->post('auction_id_name');
	$data=$this->chit_detailed_report_model->get_action_details_new1($id,$idate,$auction_id_name);
	foreach ($data as $action) {
		$data1=$this->chit_detailed_report_model->get_action_details_new($id,$idate,$auction_id_name,$action['asc_subscriber_id']);

		$collectionamt='0';
		$collamt=0;
		if($data1[0]['cl_collection_amount']=='')
		{
			$collectionamt='0';
		}
		else
		{
			$collectionamt=$data1[0]['cl_collection_amount'];
		}

		$no++;
		// echo $collamt;
		$collectionamt1 =$collectionamt1+$action['a_collect_amount'];
		$col2=$action['a_collect_amount']-$collectionamt;
		$collectionamt4 =$collectionamt4+$col2;
		$collectionamt5 =$collectionamt5+$collectionamt;

		echo "<tr>
		<td>".$no."</td>			
		<td>".$action['subscribername']."</td>			
		<td>".$action['a_collect_amount']."</td>
		<td>".$collectionamt."</td>
		<td>".($action['a_collect_amount']-$collectionamt)."</td>
		<td>".$action['s_phone_no']."</td>
		<td>".$action['s_mobile_no']."</td>
	</tr>";


}

echo "<tr>";
echo "<td colspan='2' style='text-align:right;'><b>Total</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt1."</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt5."</b></td>";
echo "<td  style='text-align:left;'><b>".$collectionamt4."</b></td>";
echo "</tr>";
// exit();
}
}
?>