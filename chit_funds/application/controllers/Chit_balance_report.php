<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Chit_balance_report extends CI_Controller{  
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Chit_balance_report_model','chit_balance_report_model');
		$this->load->library('session');
	}

	public function chit_balance_view(){
		$this->load->view('chit_balance_report');
	}

	public function view_all_chits()
	{
		$list = $this->chit_balance_report_model->view_all_chits('datatable');
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $chits) {
			$no++;
			$row = array();

			$data_cnt=$this->chit_balance_report_model->get_auction_count($chits->c_chit_id);

			$row[] = $no;
			$row[] = "<a id='open_popup' data-toggle='modal' href='#basicnew' chit_id='".$chits->c_chit_id."' onclick='open_popup(this)'>".$chits->c_chit_id."</a>";
			$row[] = date('d-m-Y',strtotime($chits->c_date));
			$row[] = $chits->c_time;
			$row[] = $chits->c_chit_amount;
			$row[] = $data_cnt;
			$row[] = $chits->c_total_months;

			$data[] = $row;
		}
		$amounts=$this->chit_balance_report_model->get_total_amt();
		$c_chit_amount=$amounts[0]['c_chit_amount'];

		$output = array(
			"c_chit_amount" => $c_chit_amount,
			"footerTotal" => '200',
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->chit_balance_report_model->view_all_chits('count_all'),
			"recordsFiltered" => $this->chit_balance_report_model->view_all_chits('count_filtered'),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function view_action_new()
	{
		$chit_id=$this->input->post('chit_id');
		$chit_data=$this->chit_balance_report_model->get_chit_details($chit_id)[0];

		echo "<br><div class='row'>";
		echo "<div class='col-md-12'>";
		echo "<div class='row'><div class='col-md-12' style='text-align:center;font-size: 20px;'><b>".$chit_data['c_chit_id']." (".$chit_data['c_chit_amount'].")"."</b></div></div>";
		echo "<div class='row'><div class='col-md-12' style='text-align:center;font-size: 15px;'><b>".date('d-m-Y',strtotime($chit_data['c_date']))." - ".$chit_data['c_time']."</b></div></div>";
		echo "</div>";
		echo "</div><br>";

		$data=$this->chit_balance_report_model->get_action_details_new($chit_id);
		$data_cnt=$this->chit_balance_report_model->get_auction_count($chit_id);
		$collectionamt=0;

		echo "<table class='table table-striped table-bordered table-hover' id='datatable_1'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th> S.No </th>";
		echo "<th> Subscriber Name </th>";
		echo "<th> Balance Amount </th>";
		echo "<th> Auction Taken</th>";                      
		echo "<th> Phone </th>";
		echo "<th> Mobile </th>";
		echo "<th> Surety </th>";              
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";

		foreach ($data as $action) {
			$no++;
			$data1=$this->chit_balance_report_model->get_action_details_new1($chit_id,$action['s_party_id']);
			$phone=$action['s_phone_no'];
			$collectionamt=$collectionamt+$data1;
			echo "<tr>";
			echo "<td>".$no."</td>";
			echo "<td>".$action['asc_chit_id'].' '.$action['asc_sno']." - ".$action['s_party_name']."</td>";
			echo "<td>".$data1."</td>";
			echo "<td>".$action['a_auction_count']."</td>";
			echo "<td>".$action['s_phone_no']."</td>";
			echo "<td>".$action['s_mobile_no']."</td>";
			echo "<td>".$action['surety_no']."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan='2' style='text-align:right;'><b>Total</b></td>";
		echo "<td colspan='3' style='text-align:left;'><b>".$collectionamt."</b></td>";
		echo "</tr>";
		echo "</tbody>";
		echo "</table>";
	}

	function ExportCSV()
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$chit_id=$this->uri->segment(3);
		$data=$this->chit_balance_report_model->get_action_details_new($chit_id);
		$data_cnt=$this->chit_balance_report_model->get_auction_count($chit_id);
		$collectionamt=0;

		$chit_data=$this->chit_balance_report_model->get_chit_details($chit_id)[0];


		$exp =$chit_data['c_chit_id']." (".$chit_data['c_chit_amount'].")\n";
		$exp .="(".date('d-m-Y',strtotime($chit_data['c_date']))." - ".$chit_data['c_time'].")\n";

		$exp .= "S.NO,";
		$exp .="Subscriber Name,";
		$exp .="Balance Amount,";
		$exp .="Auction Taken,";
		$exp .="Phone,";
		$exp .="Mobile,";
		$exp .="Surety\n";
		$no=0;
		foreach ($data as $action) {
			$no++;
			$data1=$this->chit_balance_report_model->get_action_details_new1($chit_id,$action['s_party_id']);

			$collectionamt=$collectionamt+$data1;

			$exp.='"'.$no.'"'.",";
			$exp.='"'.$action['asc_chit_id'].' '.$action['asc_sno']." - ".$action['s_party_name'].'"'.",";
			$exp.='"'.$data1.'"'.",";
			$exp.='"'.$action['a_auction_count'].'"'.",";
			$exp.='"'.$action['s_phone_no'].'"'.",";
			$exp.='"'.$action['s_mobile_no'].'"'.",";
			$exp.='"'.$action['surety_no'].'"'."\n";
		}

		$exp = strip_tags($exp);
		header("Content-Disposition: attachment; filename=all_student_details".date('d-m-Y').".csv");
		print $exp;


	}

	public function export_csv(){ 
		// file name 
		$filename = 'users_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
	   // get data

		// file creation 
		$chit_id=$this->uri->segment(3);
		$file = fopen('php://output','w');
		$header = array("Subscriber Name","Auction Taken","Balance Amount","Phone","Mobile"); 
		fputcsv($file, $header);
		$data=$this->chit_balance_report_model->get_action_details_new($chit_id);
		$data_cnt=$this->chit_balance_report_model->get_auction_count($chit_id);
		foreach ($data as $action) {
			$no++;
			$data1=$this->chit_balance_report_model->get_action_details_new1($chit_id,$action['s_party_id']);
			fputcsv($file,$action); 
		}
		/*foreach ($data1 as $key=>$line){ 
			fputcsv($file,$line); 
		}*/
		fclose($file); 
		exit; 
	}

	/*function ExportCSV()
{
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $chit_id=$this->uri->segment(3);
        $filename = "filename_you_wish.csv";
        $query = "SELECT s_party_name as SubscriberName,(SELECT a_auction_count FROM mst_auction WHERE mst_auction.`a_bidder_id` = mst_subscribers.s_party_id) as AuctionTaken,
        ((SELECT SUM(cl_collection_amount) as balance_amount FROM mst_collection WHERE cl_chit_id='$chit_id' AND mst_collection.cl_subscriber_id=mst_subscribers.s_party_id)-(SELECT SUM(a_collect_amount) as balance_amount1 FROM mst_auction WHERE a_chit_id='$chit_id')) as BalanceAmount,s_phone_no,s_mobile_no  FROM assign_subs_to_chit LEFT JOIN mst_subscribers ON  assign_subs_to_chit.asc_subscriber_id=mst_subscribers.s_party_id WHERE asc_chit_id='".$chit_id."'";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }*/


}
?>