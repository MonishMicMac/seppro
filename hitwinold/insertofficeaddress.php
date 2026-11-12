<?php
include('connect.php');





$latt=$_REQUEST['latt'];
$longg=$_REQUEST['longg'];




mysql_query("INSERT INTO officeloaction(latt,longg)VALUES('$latt','$longg')")or die(mysql_error());







?>