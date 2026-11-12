<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Subscriber_detailed_report_model extends CI_Model {


public function get_subscribers_json($subscriber_id) {

	

		$sql="SELECT s_party_id,s_party_name FROM mst_subscribers WHERE  CONCAT(s_party_id,' (',s_party_name,')') LIKE '%$subscriber_id%'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	public function get_subscriber_details($id) {
		$subsplit=explode(' -', $id);
		// print_r($subsplit[0]);
		// exit();
		$sql="SELECT * FROM assign_subs_to_chit,mst_chits WHERE assign_subs_to_chit.asc_chit_id=mst_chits.c_chit_id AND assign_subs_to_chit.asc_subscriber_id='".$subsplit[0]."'";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details($chit_id,$subscriber_id) {
		$subsplit=explode(' -', $subscriber_id);
		$sql="SELECT * FROM mst_auction WHERE  a_chit_id='".$chit_id."' AND a_bidder_id='".$subsplit[0]."'";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details_new($chit_id,$subscriber_id,$autiondate) {

		$idate1=date('Y-m-d', strtotime("+1 month",strtotime($autiondate)));
		$subsplit=explode(' -', $subscriber_id);
		$sql="SELECT * FROM mst_collection WHERE cl_chit_id='".$chit_id."' AND cl_subscriber_id='".$subsplit[0]."' AND (cl_collected_date BETWEEN '".$autiondate."' AND '".$idate1."')";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}

	public function get_action_details_new1($chit_id,$subscriber_id,$autiondate) {

		$idate1=date('Y-m-d', strtotime("+1 month",strtotime($autiondate)));
		$subsplit=explode(' -', $subscriber_id);
		$sql="SELECT * FROM mst_collection INNER JOIN mst_subscribers ON mst_collection.cl_subscriber_id=mst_subscribers.s_party_id WHERE mst_collection.cl_chit_id='".$chit_id."' AND mst_collection.cl_subscriber_id='".$subsplit[0]."' ";
		$query=$this->db->query($sql,array($id));
		return $query->result_array();
	}
	
}
?>