<?php
		include("connect_db.php");
		
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
		$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

		echo "DELETE FROM areawise_temp WHERE id='".$_GET["delId"]."'";
		mysql_query("DELETE FROM areawise_temp WHERE id='".$_GET["delId"]."'");			
?>
