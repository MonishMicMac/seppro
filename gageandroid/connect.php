<?php
session_start();
$con=mysql_connect($_SESSION['host'],$_SESSION['user'],$_SESSION['pwd']);
mysql_select_db($_SESSION['db'],$con);
date_default_timezone_set('Asia/Calcutta');
?>