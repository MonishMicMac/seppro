<?php
	include("include/connect.php");
	$_SESSION["_REP"] ="";
	$S=mysql_query("SELECT id FROM representative WHERE rep_name='".$_GET["Catagory"]."'");
	$R = mysql_fetch_object($S);
	echo $_SESSION["_REP"] = $R->id;	
?>


