<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$eventdate=$_REQUEST['eventdate'];
$eventstarttime=$_REQUEST['eventstarttime'];
$eventopictitle=$_REQUEST['eventopictitle'];
$eventlocation=$_REQUEST['eventlocation'];
$locationurl=$_REQUEST['locationurl'];
$posteddate=$_REQUEST['posteddate'];
$eventname=$_REQUEST['eventname'];
$standradid=$_REQUEST['standradid'];
$sectionid=$_REQUEST['sectionid'];
$standardname=$_REQUEST['standardname'];
$sectionname=$_REQUEST['sectionname'];





$a=mysql_query("insert into eventdetails(eventdate,eventstarttime,eventopictitle,eventlocation,locationurl,posteddate,eventname,standradid,sectionid,standardname,sectionname)values('$eventdate','$eventstarttime','$eventopictitle','$eventlocation','$locationurl','$posteddate','$eventname','$standradid','$sectionid','$standardname','$sectionname')")or die(mysql_error());

?>