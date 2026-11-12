<?php
include("connect1.php");
date_default_timezone_set('Asia/Kolkata');
mysql_query("INSERT INTO posters(p_repid,p_doctorid,p_name,p_qty,p_datetime,p_status)VALUES('".$_REQUEST['repid']."','".$_REQUEST['docid']."','".$_REQUEST['name']."','".$_REQUEST['qty']."','".date('Y-m-d H:i:s')."','0')");
?>
