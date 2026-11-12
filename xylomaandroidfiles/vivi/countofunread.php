<?php

include("../includes/connect_db.php");
$teacherid=$_REQUEST['teacherid'];
$id=$_REQUEST['id'];

//$teacherid='AK11M1';
//$id='1';
$strSQL=mysql_query("SELECT MAX(id) AS ids FROM teachersparentchat where teacherid='$teacherid' and id >'$id' and Teacherstatus='0'")or die(mysql_error());
$row_strsql=mysql_fetch_array($strSQL);
$ids = $row_strsql['ids'];
$a=mysql_query("SELECT * FROM teachersparentchat where id = '$ids' ")or die(mysql_error());
$row_a=mysql_fetch_assoc($a);
if($row_a == false)
{
$result=array();
}
else
{
$result=array($row_a);
}


echo json_encode($result);

?>