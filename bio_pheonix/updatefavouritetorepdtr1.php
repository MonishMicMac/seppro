<?php
include("connect23.php"); 



$id=$_REQUEST['id'];
$cata=$_REQUEST['cata'];

$proid = explode(",",$id);



for($i=0;$i< count($proid);$i++)
{

$jjsdzz = mysql_query("UPDATE doctors SET favourite='$cata' WHERE id=$proid[$i]")or die(mysql_error());


}

?>
