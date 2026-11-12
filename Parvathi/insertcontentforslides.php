<?php
include("connect1.php");


date_default_timezone_set("Asia/Kolkata"); 

$productid=$_REQUEST['productid'];
$managerid=$_REQUEST['managerid'];
$imagevideoname=$_REQUEST['imagevideoname'];
$heading=$_REQUEST['heading'];
$content1=$_REQUEST['content1'];
$content2=$_REQUEST['content2'];
$content3=$_REQUEST['content3'];
$type=$_REQUEST['type'];

$cdate = date('Y-m-d');

$ctime = date('H:i');
mysql_query("insert into tbl_product_adde_slide(productid,managerid,imagevideoname,heading,content1,content2,content3,cdate,ctime,type)values('$productid','$managerid','$imagevideoname','$heading','$content1','$content2','$content3','$cdate','$ctime','$type')")or die(mysql_error());













?>