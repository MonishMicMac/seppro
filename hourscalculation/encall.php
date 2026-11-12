<?php
include('connect.php');



$wpid=$_REQUEST['wpid'];
$name=$_REQUEST['name'];









mysql_query("UPDATE enquiry SET resultof='$name' WHERE id='$wpid'")or die(mysql_error());





?>