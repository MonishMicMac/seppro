<?php
include("connect23.php"); 



$dcid=$_REQUEST['dcid'];
$chemistid=$_REQUEST['chemistid'];
$rep_id=$_REQUEST['rep_id'];

$proid = explode(",",$chemistid);



for($i=0;$i< count($proid);$i++)
{
 $jjxx = mysql_query("SELECT * FROM tbl_doctor_product_mapping  WHERE doctor_id= '$dcid' AND product_id= '$proid[$i]' AND rep_id= '$rep_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {
}
else
{
$jjsdzz = mysql_query("INSERT INTO tbl_doctor_product_mapping(doctor_id,product_id,rep_id)VALUES('$dcid','$proid[$i]','$rep_id')")or die(mysql_error());
}


}

?>
