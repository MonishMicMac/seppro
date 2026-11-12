<?php
include('connect.php');



$wpid=$_REQUEST['wpid'];
$date=$_REQUEST['date'];









mysql_query("UPDATE enquiry SET date='$date' WHERE id='$wpid'")or die(mysql_error());





?>