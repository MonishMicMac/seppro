<?php
include("include/connect.php");
session_start();
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {

	for ($d=1; $d < 29; $d++) {
		$blockopendate=date("Y-m-d",strtotime(date("Y-m-$d")));
		$cdate=date("Y-m-d");
		$ctime=date("H:i:s");
		$sql=mysql_query("SELECT id FROM representative WHERE id IN (8,9,10,23) order by id desc");
		while($row=mysql_fetch_array($sql)){
			$repid=$row['id'];

			mysql_query("INSERT INTO blockingopen(repid,blockopendate,cdate,ctime) VALUES ('$repid','$blockopendate','$cdate','$ctime')");
		}
	}

}
?>
