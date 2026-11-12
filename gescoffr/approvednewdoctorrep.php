<?php
include("connect.php"); 

$id=$_REQUEST['id'];


$proid = explode(",",$id);
for($i=0;$i< count($proid);$i++)
{

$b = $je->prepare("SELECT inrepid FROM doctors WHERE id=$proid[$i]")or die(mysql_error());

$b->execute();
$visited= $b->fetchColumn();

$b = $je->prepare("UPDATE doctors SET rep_assign='$visited',rep_id='$visited',inrepid='0' WHERE id = $proid[$i]")or die(mysql_error());

$b->execute();
}

?>
