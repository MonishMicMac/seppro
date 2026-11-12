<?php
include("connect23.php"); 

$doc_id=$_REQUEST['doc_id'];

mysql_query("UPDATE doctors SET old_rep_id=rep_id,rep_id='',rep_assign='' WHERE id='$doc_id'");
?>