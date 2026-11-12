<?php
include('connect.php');


$repid=$_REQUEST['repid'];











mysql_query("UPDATE representative SET offlineproduct='0' WHERE id='$repid'")or die(mysql_error());











?>