<?php
include("connect23.php"); 


$id=$_REQUEST['id'];

$proid = explode(",",$id);



for($i=0;$i< count($proid);$i++)
{

$jjsdzz = mysql_query("UPDATE doctors SET favourite='0' WHERE id=$proid[$i]")or die(mysql_error());


}

?>