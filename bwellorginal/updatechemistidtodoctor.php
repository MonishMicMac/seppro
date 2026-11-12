<?php
include("connect1.php");

$dcid=$_REQUEST['dcid'];
$chemistid=$_REQUEST['chemistid'];
$rep_id=$_REQUEST['rep_id'];

$proid = explode(",",$chemistid);


for($i=0;$i< count($proid);$i++)
{

$jjsd = mysql_query("UPDATE tbl_customer_master SET doctor_id='$dcid' WHERE id = '$proid[$i]'")or die(mysql_error());

}


$jj = mysql_query("UPDATE doctors SET chemist_id='$chemistid' WHERE id = '$dcid'")or die(mysql_error());

for($i=0;$i< count($proid);$i++)
{
 $jjxx = mysql_query("SELECT * FROM tbl_doctor_chemist WHERE doctor_id= '$dcid' AND chemist_id= '$proid[$i]' AND rep_id= '$rep_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {
}
else
{
$jjsdzz = mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id)VALUES('$dcid','$proid[$i]','$rep_id')")or die(mysql_error());
}


}

?>
