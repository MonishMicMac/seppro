<?php
include("connect23.php"); 


$managerid=$_REQUEST['managerid'];
$repid=$_REQUEST['repid'];






$proid = explode(",",$repid);
for($i=0;$i< count($proid);$i++)
{

       mysql_query("DELETE FROM assigningreptomanager WHERE managerid='$managerid' AND repid='$proid[$i]'")or die(mysql_error());
       
}










?>