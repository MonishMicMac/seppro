<?php
include("connect23.php"); 


$wp_dc_id=$_REQUEST['wp_dc_id'];


$proid = explode(",",$wp_dc_id);
for($i=0;$i< count($proid);$i++)
{

mysql_query("UPDATE representative SET deleteopen='0',managertourplanopen='0'  WHERE id= '$proid[$i]'")or die(mysql_error());

}










?>