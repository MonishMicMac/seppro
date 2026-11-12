<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Subscriber_detailed_report_model2 extends CI_Model {


	public function get_subscribers_json($chit_id,$subscriber_id) {
		$sql="SELECT s_party_id,s_party_name FROM mst_subscribers,assign_subs_to_chit WHERE mst_subscribers.s_party_id=assign_subs_to_chit.asc_subscriber_id AND asc_chit_id='$chit_id' AND CONCAT(s_party_id,' (',s_party_name,')') LIKE '%$subscriber_id%'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_chits_json($chit_id) {
		$sql="SELECT c_chit_id,c_chit_name FROM mst_chits,assign_subs_to_chit WHERE mst_chits.c_chit_id=assign_subs_to_chit.asc_chit_id AND CONCAT(c_chit_id,' (',c_chit_name,')') LIKE '%$chit_id%' GROUP BY asc_chit_id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscriber_details($id,$chit_id,$fromdate,$todate) {
		// echo "SELECT * FROM assign_subs_to_chit,mst_chits WHERE assign_subs_to_chit.asc_chit_id=mst_chits.c_chit_id AND assign_subs_to_chit.asc_subscriber_id='".$id."' AND assign_subs_to_chit.asc_chit_id='".$chit_id."'";
		$sql="SELECT * FROM assign_subs_to_chit,mst_chits WHERE assign_subs_to_chit.asc_chit_id=mst_chits.c_chit_id AND assign_subs_to_chit.asc_subscriber_id='".$id."' AND assign_subs_to_chit.asc_chit_id='".$chit_id."'";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details($chit_id,$subscriber_id,$fromdate,$todate) {
		// echo "SELECT * FROM mst_auction WHERE  a_chit_id='".$chit_id."' AND a_bidder_id='".$subscriber_id."' AND (a_auction_date BETWEEN '".date('Y-m-d',strtotime(str_replace("/", "-", $fromdate)))."' AND '".date('Y-m-d',strtotime(str_replace("/", "-", $todate)))."')";
		$sql="SELECT * FROM mst_auction WHERE  a_chit_id='".$chit_id."' AND a_bidder_id='".$subscriber_id."' AND (a_auction_date BETWEEN '".date('Y-m-d',strtotime(str_replace("/", "-", $fromdate)))."' AND '".date('Y-m-d',strtotime(str_replace("/", "-", $todate)))."')";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details_new($chit_id,$subscriber_id,$autiondate,$fromdate,$todate) {

		// $idate1=date('Y-m-d', strtotime("+1 month",strtotime($autiondate)));
		// echo "SELECT * FROM mst_collection WHERE cl_chit_id='".$chit_id."' AND cl_subscriber_id='".$subscriber_id."' AND (cl_collected_date BETWEEN '".$fromdate."' AND '".$todate."')";
		// echo "SELECT * FROM mst_collection WHERE cl_chit_id='".$chit_id."' AND cl_subscriber_id='".$subscriber_id."' AND (cl_collected_date BETWEEN '".date('Y-m-d',strtotime(str_replace("/", "-", $fromdate)))."' AND '".date('Y-m-d',strtotime(str_replace("/", "-", $todate)))."')";
		$sql="SELECT * FROM mst_collection WHERE cl_chit_id='".$chit_id."' AND cl_subscriber_id='".$subscriber_id."' AND (cl_collected_date BETWEEN '".date('Y-m-d',strtotime(str_replace("/", "-", $fromdate)))."' AND '".date('Y-m-d',strtotime(str_replace("/", "-", $todate)))."')";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}
	
}
?>