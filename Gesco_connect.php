<?php
$host="localhost";
$root="root";
$password="J3sco@20171";
$dbname="gescoindia";
$port = 3307;
$con=new mysqli($host,$root,$password,$dbname,$port);
print_r($con);exit();
?>