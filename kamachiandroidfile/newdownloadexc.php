<?php
include("connect2.php"); 

$month=$_REQUEST['month'];
$repid=$_REQUEST['repid'];
$year=$_REQUEST['year'];

$date =$year."-".$month;
 
 global $str;

echo '[';

$strSQL = mysql_query("SELECT tbl_work_plan.wp_date,tbl_work_plan.reporteddate,tbl_work_plan.drunavailablereason,tbl_work_plan.wp_dc_id,doctors.doctor_name,doctors.doc_pincode,doctors.prescriber,doctors.doc_qualification,doctors.doctor_addrs FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_date LIKE '$date%' AND tbl_work_plan.wp_rep_id='$repid'  AND doctors.id=tbl_work_plan.wp_dc_id");

$strSQL_count=mysql_num_rows($strSQL);

if($strSQL_count>0)
{
      while($strSQL_res = mysql_fetch_array($strSQL))
     {

     $jjcount = mysql_query("SELECT COUNT(pob_id) AS CNT FROM mst_pob WHERE cdate='".$strSQL_res['reporteddate']."' AND dc_id='".$strSQL_res['wp_dc_id']."'");
$jjcount_res=mysql_fetch_array($jjcount);


$str.='{"customername":"'.$strSQL_res['doctor_name'].'","type":"'.$strSQL_res['prescriber'].'","scheduleddate":"'.$strSQL_res['wp_date'].'","reporteddate":"'.$strSQL_res['reporteddate'].'","review":"'.$strSQL_res['drunavailablereason'].'","qtybooked":"'.$jjcount_res['CNT'].'"},';
   
     }


echo substr($str,0,-1).']';

}




?>