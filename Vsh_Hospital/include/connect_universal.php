<?php
	error_reporting(0);
	if(!isset($_SESSION)) { 
        session_start(); 
    } 
	$con=mysql_connect(@$_SESSION["HOST"],@$_SESSION["DBUSR"],@$_SESSION["DBPWD"]);
	mysql_select_db("sep_universal_master",$con);
?>
