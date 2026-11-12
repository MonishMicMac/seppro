<?php 
include("../includes/connect_db.php");

    $id=$_GET['id'];
    
mysql_query("DELETE FROM tbl_demo WHERE tbl_id='$id'")or die(mysql_error());
?>