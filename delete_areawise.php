<?php
include("include/connect.php");
$comm=$_REQUEST['comm'];
$d_id=$_REQUEST['d_id'];
if($comm=='areawise')
{


mysql_query("delete from invalid_total where  record_id='$d_id'");

mysql_query("delete from areawise_temp where  record_id='$d_id'");

mysql_query("delete from excel_heading where  record_id='$d_id'");


$picture1=$_REQUEST['picture'];
$picture2='upload/';
$picture=$picture2.$picture1;
unlink($picture);


mysql_query("delete from excel_record where  id='$d_id'");

echo "<script type='text/javascript'>alert('Areawise deleted');window.location='view_areawise.php';</script>";
}

?>