<?php
include('connect.php');
mysql_query("DELETE FROM representative WHERE id='".$_REQUEST['repid']."' AND rep_id='".$_REQUEST['catid']."'")or die(mysql_error());
echo "Deleted";
?>