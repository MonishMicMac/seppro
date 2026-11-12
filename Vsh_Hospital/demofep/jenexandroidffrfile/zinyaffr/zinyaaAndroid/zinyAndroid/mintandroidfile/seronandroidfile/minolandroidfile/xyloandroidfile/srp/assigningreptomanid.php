<?php
include("connect2.php"); 


$managerid=$_REQUEST['managerid'];
$repid=$_REQUEST['repid'];






$proid = explode(",",$repid);
for($i=0;$i< count($proid);$i++)
{
      $jj = mysql_query("SELECT * FROM assigningreptomanager WHERE managerid = '$managerid' AND repid = '$proid[$i]'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
     mysql_query("INSERT INTO assigningreptomanager(managerid,repid)VALUES('$managerid','$proid[$i]')")or die(mysql_error());
     }
}










?>
