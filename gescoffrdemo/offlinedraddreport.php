<?php
include("connect1.php");


$dridexp=explode("*",$_REQUEST['drid']);
$drnameexp=explode("*",$_REQUEST['drname']);
$drpincodeexp=explode("*",$_REQUEST['drpincode']);
$draddrexp=explode("*",$_REQUEST['draddr']);
$drmobileexp=explode("*",$_REQUEST['drmobile']);
$drlatexp=explode("*",$_REQUEST['latitude']);
$drlongexp=explode("*",$_REQUEST['longitude']);
$drjointworkbyexp=explode("*",$_REQUEST['jointworkby']);
$drunavailable=explode("*",$_REQUEST['drunavailable']);
$promotion_service=explode("*",$_REQUEST['promotion_service']);
$prescriptionvalue=explode("*",$_REQUEST['prescriptionvalue']);



for($j=0;$j<count($dridexp);$j++)
{
	if($dridexp[$j]=='0')
	{

		
		mysql_query("insert into doctors(doctor_name,doc_pincode,doctor_addrs,doc_contact_no,rep_id,rep_assign,dr_latitude,dr_longitude)values('$drnameexp[$j]','$drpincodeexp[$j]','$draddrexp[$j]','$drmobileexp[$j]','".$_REQUEST['repid']."','".$_REQUEST['repid']."','$drlatexp[$j]','$drlongexp[$j]')")or die(mysql_error());

    $getdrid=mysql_query("SELECT * FROM doctors WHERE id=".mysql_insert_id()."")or die(mysql_error());
    $getdrid_res=mysql_fetch_array($getdrid);
     $chktwp1=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '".date('Y-m-d')."' AND wp_dc = 'D' and wp_rep_id='".$_REQUEST['repid']."' AND wp_dc_id = '".$getdrid_res['id']."'  AND attendancestatus='1'")or die(mysql_error());
        if(mysql_num_rows($chktwp1)>0)
        {}
        else
        {

         
          mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby,promotion_service,prescriptionvalue)VALUES('".date('Y-m-d')."','0','D','".$getdrid_res['id']."','".$_REQUEST['repid']."','U','".date('Y-m-d')."','".date('H:i:s A')."','1','1','$drlatexp[$j]','$drlongexp[$j]','".date('Y-m-d')."','".date('H:i:s A')."','0','$drunavailable[$j]','$drjointworkbyexp[$j]','$promotion_service[$j]','$prescriptionvalue[$j]')")or die(mysql_error());
        }

	}
	else
	{
    // echo "SELECT * FROM tbl_work_plan WHERE wp_date = '".date('Y-m-d')."' AND wp_dc = 'D' and wp_rep_id='".$_REQUEST['repid']."' AND wp_dc_id = '".$dridexp[$j]."'  AND attendancestatus='1'";
		$chktwp=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '".date('Y-m-d')."' AND wp_dc = 'D' and wp_rep_id='".$_REQUEST['repid']."' AND wp_dc_id = '".$dridexp[$j]."'  AND attendancestatus='1'")or die(mysql_error());
      	if(mysql_num_rows($chktwp)>0)
      	{}
      	else
      	{
          // echo "INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby,promotion_service,prescriptionvalue)VALUES('".date('Y-m-d')."','0','D','$dridexp[$j]','".$_REQUEST['repid']."','U','".date('Y-m-d')."','".date('H:i:s A')."','1','1','$drlatexp[$j]','$drlongexp[$j]','".date('Y-m-d')."','".date('H:i:s A')."','0','$drunavailable[$j]','$drjointworkbyexp[$j]','$promotion_service[$j]','$prescriptionvalue[$j]')";
         
      		mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby,promotion_service,prescriptionvalue)VALUES('".date('Y-m-d')."','0','D','$dridexp[$j]','".$_REQUEST['repid']."','U','".date('Y-m-d')."','".date('H:i:s A')."','1','1','$drlatexp[$j]','$drlongexp[$j]','".date('Y-m-d')."','".date('H:i:s A')."','0','$drunavailable[$j]','$drjointworkbyexp[$j]','$promotion_service[$j]','$prescriptionvalue[$j]')")or die(mysql_error());
      	}

        /*$getdrid=mysql_query("SELECT * FROM doctors WHERE rep_id='".$_REQUEST['repid']."' ORDER BY id  DESC LIMIT ".count($dridexp)."")or die(mysql_error());
     while($getdrid_res=mysql_fetch_array($getdrid))
     {
     $chktwp1=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '".date('Y-m-d')."' AND wp_dc = 'D' and wp_rep_id='".$_REQUEST['repid']."' AND wp_dc_id = '".$dridexp[$j]."'  AND attendancestatus='1'")or die(mysql_error());
        if(mysql_num_rows($chktwp1)>0)
        {}
        else
        {
          mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby,promotion_service,prescriptionvalue)VALUES('".date('Y-m-d')."','0','D','".$dridexp[$j]."','".$_REQUEST['repid']."','U','".date('Y-m-d')."','".date('H:i:s A')."','1','1','".$drlatexp[$j]."','".$drlongexp[$j]."','".date('Y-m-d')."','".date('H:i:s A')."','0','".$drunavailable[$j]."','".$drjointworkbyexp[$j]."','".$promotion_service[$j]."','".$prescriptionvalue[$j]."')")or die(mysql_error());
        }
      }*/
    }
}

        /*$getdrid=mysql_query("SELECT * FROM doctors WHERE rep_id='".$_REQUEST['repid']."' ORDER BY id  DESC LIMIT ".count($dridexp)."")or die(mysql_error());
     while($getdrid_res=mysql_fetch_array($getdrid))
     {
     $chktwp1=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '".date('Y-m-d')."' AND wp_dc = 'D' and wp_rep_id='".$_REQUEST['repid']."' AND wp_dc_id = '".$getdrid_res['id']."'  AND attendancestatus='1'")or die(mysql_error());
        if(mysql_num_rows($chktwp1)>0)
        {}
        else
        {
          mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,attendancestatus,latitude,longitude,reporteddate,reportedtime,drunavailable,drunavailablereason,jointworkby,promotion_service,prescriptionvalue)VALUES('".date('Y-m-d')."','0','D','$dridexp[$j]','".$_REQUEST['repid']."','U','".date('Y-m-d')."','".date('H:i:s A')."','1','1','$drlatexp[$j]','$drlongexp[$j]','".date('Y-m-d')."','".date('H:i:s A')."','0','$drunavailable[$j]','$drjointworkbyexp[$j]','$promotion_service[$j]','$prescriptionvalue[$j]')")or die(mysql_error());
        }
      }*/

?>