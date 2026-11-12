<?php
include("../includes/connect_db.php");

$studid = $_REQUEST['studid'];
$phone = $_REQUEST['mobile'];

$jjchk= mysql_query("SELECT * FROM student_profile WHERE student_id = '$studid' AND Phone_no = '$phone'")or die(mysql_error());
$count = mysql_num_rows($jjchk);
if($count > 0)
{

$jjchk_res = mysql_fetch_array($jjchk);

$Phone_no = $jjchk_res['Phone_no'];


$jjinsertchk = mysql_query("SELECT * FROM admin_verification WHERE krm_id='
$studid' AND parent='$phone'")or die(mysql_error());

$insertcount = mysql_num_rows($jjinsertchk);

if($insertcount > 0)
{
 echo "";
}
mysql_query("INSERT INTO admin_verification(krm_id,parent,verification_status)VALUES('$studid','$Phone_no','0')")or die(mysql_error());
}
else
{
   echo "Invalid values";
}
?>