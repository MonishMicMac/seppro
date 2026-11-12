<?php
include("connect2.php"); 





$route_name=$_REQUEST['route_name'];

$pandiyan = mysql_query("SELECT * FROM mst_route WHERE route_name='$route_name'")or die(mysql_error());
$pandiyan_res = mysql_fetch_array($pandiyan);

if($pandiyan_res['route_name'] == $route_name)
{


mysql_query("INSERT INTO tbl_route_details(route_id,route_shift,route_status,route_start_time,route_end_time,route_lat,route_long)VALUES('".$pandiyan_res['route_id']."','".$_REQUEST['route_shift']."','".$_REQUEST['route_status']."','".$_REQUEST['route_start_time']."','".$_REQUEST['route_end_time']."','".$_REQUEST['route_lat']."','".$_REQUEST['route_long']."')");
}

else
{

$jj = mysql_query("INSERT INTO mst_route(route_name)VALUES('$route_name')");
$anto = mysql_insert_id();


mysql_query("INSERT INTO tbl_route_details(route_id,route_shift,route_status,route_start_time,route_end_time,route_lat,route_long)VALUES('$anto','".$_REQUEST['route_shift']."','".$_REQUEST['route_status']."','".$_REQUEST['route_start_time']."','".$_REQUEST['route_end_time']."','".$_REQUEST['route_lat']."','".$_REQUEST['route_long']."')")or die(mysql_error());

}
?>
