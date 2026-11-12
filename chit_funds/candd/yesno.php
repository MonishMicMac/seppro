<?php
include("connect.php"); 




mysql_query("UPDATE profileenrollment SET subpaid='".$_REQUEST['yes']."'  WHERE id= '".$_REQUEST['id']."'")or die(mysql_error());











?>
