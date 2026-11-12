<?php 
include("../includes/connect_db.php");


    
mysql_query("UPDATE  tbl_demo SET status='1' WHERE tbl_id='".$_REQUEST['tblid']."'")or die(mysql_error());
?>