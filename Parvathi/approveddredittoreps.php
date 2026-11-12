<?php
include("connect.php"); 

$id=$_REQUEST['id'];

$proid = explode(",",$id);
for($i=0;$i< count($proid);$i++)
{

$b = $je->prepare("UPDATE doctors SET applyforedit='0',managerapprovestatus='1' WHERE id = $proid[$i]")or die(mysql_error());

$b->execute();
}

?>
