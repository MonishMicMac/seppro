<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	if($_GET["content"]!="null"){
	mysql_query("INSERT INTO mst_calendar(calendar_title,calendar_startdate,calendar_enddate,calendar_starttime,calendar_endtime) VALUES('".$_GET["content"]."','".$_GET["startdate"]."','".$_GET["enddate"]."','".$_GET["starttime"]."','".$_GET["endtime"]."')");
	}
?>