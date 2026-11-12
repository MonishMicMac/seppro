<?php
include("connect1.php"); 

$pob_type=$_REQUEST['pob_type'];
$stockistid=$_REQUEST['stockistid'];
$client_id=$_REQUEST['client_id'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$paymentterms=$_REQUEST['paymentterms'];

$repid=$_REQUEST['repid'];


$latitude=$_REQUEST['latitude'];



$longitude=$_REQUEST['longitude'];


$wp_id=$_REQUEST['wp_id'];

$drunavailable=$_REQUEST['drunavailable'];
$reportstatus=$_REQUEST['reportstatus'];
$jointworkby=$_REQUEST['jointworkby'];
$drunavailablereason=$_REQUEST['drunavailablereason'];
$dr_id=$_REQUEST['dr_id'];
$prescriptionvalue=$_REQUEST['prescriptionvalue'];

$gift=$_REQUEST['gift'];

$podate=$_REQUEST['podate'];

$checkintime=$_REQUEST['checkintime'];

$redate=$_REQUEST['redate'];
$wpdrid=$_REQUEST['wpdrid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);
$image=$_REQUEST['imagename'];

$i=rand(10000000,99999999);
if($image!='')
{

// $target_dir = "image/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$code = md5(time());   
  $name ='img'.$i.'_'.$code.'.jpg';
  file_put_contents('image/'.$name, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image)));


}
else
{
	$name='';
}


global $leaverepid,$repname,$leavedate,$leavereason;







mysql_query("UPDATE tbl_work_plan SET attendancestatus='1' ,latitude='$latitude' ,longitude='$longitude' ,areaname='$address',gift='$gift',reporteddate='$c_date' ,reportedtime='$c_time',drunavailable='$drunavailable',reportstatus='$drunavailable',drunavailablereason='$drunavailablereason',jointworkby='$jointworkby',prescriptionvalue='$prescriptionvalue',checkintime='$checkintime',image_new='$name' WHERE wp_id='$wp_id'")or die(mysql_error());

$pobchwk=mysql_query("SELECT * FROM doctors WHERE dr_longitude='' AND dr_longitude='' AND id='$wpdrid'")or die(mysql_error());
$pobchwk_cnt=mysql_num_rows($pobchwk);
if($pobchwk_cnt>0)
{
mysql_query("UPDATE doctors SET dr_latitude='$latitude' ,dr_longitude='$longitude' WHERE id='$wpdrid'")or die(mysql_error());
}




if($redate=='0')
{

}
else
{



      $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$redate' AND wp_rep_id='$repid' AND wp_dc = 'D' AND wp_dc_id = '$wpdrid' AND drunavailable = '0'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
    
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening,image_new)VALUES('$redate','0','D','$wpdrid','$repid','P','$c_date','$c_time','1','$name')")or die(mysql_error());
     
     
     }

}

?>