<?php
include('connect.php');

mysql_query("INSERT INTO mst_feed_back(fe_repid,fe_feedback)VALUES('".$_REQUEST['fe_repid']."','".$_REQUEST['fe_feedback']."')")or die(mysql_error());

?>