<?php
include('connect.php');



$wpid=$_REQUEST['wpid'];








mysql_query("UPDATE enquiry SET closed='1' WHERE id='$wpid'")or die(mysql_error());





?>