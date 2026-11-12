<?php

include("connect1.php");

	
$id=$_REQUEST['id'];

$manager_oldversion=$_REQUEST['manager_oldversion'];



mysql_query("UPDATE representative SET manager_oldversion='$manager_oldversion' WHERE id= '$id'")or die(mysql_error());

?>