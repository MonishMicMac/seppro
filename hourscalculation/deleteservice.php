<?php
include('connect.php');



$wpid=$_REQUEST['wpid'];








mysql_query("UPDATE reorting SET repid='0' WHERE id='$wpid'")or die(mysql_error());





?>