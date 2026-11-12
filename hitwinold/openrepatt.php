<?php
include('connect.php');



$repid=$_REQUEST['repid'];









mysql_query("DELETE enquiry SET repid='$repid',date='$date' WHERE id='$proid[$i]'")or die(mysql_error());




?>