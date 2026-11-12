<?php


include("connect2.php"); 

$customername=$_REQUEST['customername'];
$contactperson=$_REQUEST['contactperson'];
$repid=$_REQUEST['repid'];


$mobile=$_REQUEST['mobile'];
$pincode=$_REQUEST['pincode'];
$client_pinid=$_REQUEST['client_pinid'];
$custometype=$_REQUEST['custometype'];
$address=$_REQUEST['address'];

date_default_timezone_set("Asia/Kolkata");
$cdate=date('Y-m-d');
$c_time=date("H:i:s");


$target_path = "./uploads/";
 $uploaded_files=$_FILES['uploaded_file']['name'];
 move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path.$_FILES['uploaded_file']['name']);

$getname=mysql_query("SELECT id,doctor_name FROM doctors WHERE doctor_name='".$_REQUEST['customername']."'")or die(mysql_error());
if(mysql_num_rows($getname)>0)
{
	$getname_res=mysql_fetch_array($getname);
	$dcid=$getname_res['id'];$dcname=$getname_res['doctor_name'];$customername1=$getname_res['doctor_name'];
}
else
{
	mysql_query("INSERT INTO doctors(doctor_name,rep_assign,rep_id,doc_specilist_id,doctor_addrs,c_date)VALUES('".$_REQUEST['customername']."','$repid','$repid','".$_REQUEST['mobile']."','".$_REQUEST['address']."','$cdate')")or die(mysql_error());
	$getname=mysql_query("SELECT id,doctor_name FROM doctors ORDER BY id DESC LIMIT 1")or die(mysql_error());
	$getname_res=mysql_fetch_array($getname);
	$dcid=$getname_res['id'];$dcname=$getname_res['doctor_name'];$customername1=$getname_res['doctor_name'];

}



 $jjxx = mysql_query("SELECT * FROM  newlead WHERE customername='$customername' AND contactperson='$contactperson' AND repid='$repid' AND mobile= '$mobile' AND address='$address' AND client_pinid='$client_pinid' AND pincode='$pincode'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
   {

}
else
{
$jjsdzz = mysql_query("insert into newlead(customername,contactperson,repid,mobile,address,pincode,client_pinid,custometype,cdate,dc_id,doctor_name,client_image)values('$customername1','$contactperson','$repid','$mobile','$address','$pincode','$client_pinid','$custometype','$cdate','$dcid','$dcname','".$_FILES['uploaded_file']['name']."')")or die(mysql_error());


}

?>
