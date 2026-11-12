<?php
include("connect23.php"); 
mysql_query("UPDATE doctors SET dr_latitude='".$_REQUEST['lat']."',dr_longitude='".$_REQUEST['long']."',plotid='".$_REQUEST['repid']."' WHERE id= '".$_REQUEST['id']."'")or die(mysql_error());
?>
