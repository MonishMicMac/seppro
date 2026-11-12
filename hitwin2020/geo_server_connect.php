<?php
    error_reporting(0);
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    $con=mysql_connect("35.154.166.167","root","$3pp60@2016");
	mysql_select_db("Tracking");
?>