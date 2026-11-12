<?php
include("connect1.php");
$dcid=$_REQUEST['dcid'];


$jjsdzz = mysql_query("DELETE FROM tbl_customer_master WHERE id='$dcid'")or die(mysql_error());

?>
