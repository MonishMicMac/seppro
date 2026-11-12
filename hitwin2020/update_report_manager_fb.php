<?php
include('connect.php');


$id=$_REQUEST['id'];

$mid=$_REQUEST['mid'];
$mfb=$_REQUEST['mfb'];


mysql_query("UPDATE reorting SET manager_fb_id='$mid',manager_feedback='$mfb' WHERE id='$id'")or die(mysql_error());


?>