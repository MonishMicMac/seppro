<?php
include('connect.php');

$repid=$_REQUEST['repid'];
$feedback=$_REQUEST['feedback'];
$title=$_REQUEST['title'];



mysql_query("INSERT INTO mst_feed_back(fe_repid,fe_feedback,fe_title)VALUES('$repid','$feedback','$title')")or die(mysql_error());

?>