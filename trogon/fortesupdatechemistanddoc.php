<?php
include("connect23.php"); 
$dcid=$_REQUEST['dcid'];
$chemistid=$_REQUEST['chemistid'];
$rep_id=$_REQUEST['rep_id'];

$proid = explode(",",$chemistid);


for($i=0;$i< count($proid);$i++)
{
	$jjxx = mysql_query("SELECT * FROM tbl_cds_master WHERE tbl_cds_dcsid= '$dcid' AND mapping= '0' AND tbl_cds_status='D' AND tbl_cds_repid= '$rep_id'")or die(mysql_error());
	$jjxx_count = mysql_num_rows($jjxx);
	if($jjxx_count>0){
		$jjsdzz = mysql_query("UPDATE tbl_cds_master SET mapping='$proid[$i]' WHERE tbl_cds_dcsid= '$dcid' AND mapping= '0' AND tbl_cds_status='D' AND tbl_cds_repid= '$rep_id'")or die(mysql_error());
	}
	
	$jjxx1 = mysql_query("SELECT * FROM tbl_cds_master WHERE tbl_cds_dcsid= '$dcid' AND mapping= '$proid[$i]' AND tbl_cds_status='D' AND tbl_cds_repid= '$rep_id'")or die(mysql_error());
	$jjxx_count1 = mysql_num_rows($jjxx1);
	if($jjxx_count1==0){
		$select=mysql_query("select doc_district_id,doc_area_id,doc_pin_id,state_id,division_id,doc_pincode from doctors where id='$dcid'");
		$row=mysql_fetch_array($select);
		
		$jjsdzz1 = mysql_query("INSERT into tbl_cds_master(tbl_cds_dcsid, tbl_cds_pinid, tbl_cds_areaid, tbl_cds_stateid, tbl_cds_districtid, tbl_cds_repid, tbl_cds_divisionid, tbl_cds_pincode, tbl_cds_status, mapping) values('$dcid', '".$row['doc_pin_id']."', '".$row['doc_area_id']."', '".$row['state_id']."', '".$row['doc_district_id']."', '$rep_id', '".$row['division_id']."', '".$row['doc_pincode']."', 'D', '$proid[$i]')")or die(mysql_error());
	}
	


}


?>