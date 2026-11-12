<?php
include("connect.php");

$strSQL = mysql_query("INSERT INTO tbl_general_informaton_details (gen_info_id,user_id,status) VALUES ('".$_REQUEST['info_id']."','".$_REQUEST['user_id']."','".$_REQUEST['status']."')");
?>