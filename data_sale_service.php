<?php
include("include/connect.php");

$date = $_REQUEST['date'];

$arr 	= array();
$arr1 	= array();
$arr2 	= array();
$result	= array();
$repname = array();

$sql="SELECT (select rep_name from representative where id=reorting.repid) as rep_name,(select id from representative where id=reorting.repid) as repid FROM reorting WHERE tdate='$date' GROUP BY repid";
$q	 = mysql_query($sql);
$j = 0;
while($row = mysql_fetch_assoc($q)){
		$Sales1 = mysql_query("SELECT count(*) sales1 FROM reorting WHERE tdate='$date' AND repid='".$row['repid']."' AND typeofcall='SALES CALL'");
				$Rs_Sales1=mysql_fetch_assoc($Sales1);
				$service1 = mysql_query("SELECT count(*) service1 FROM reorting WHERE tdate='$date' AND repid='".$row['repid']."' AND typeofcall='SERVICE CALL'");
				$Rs_service1=mysql_fetch_assoc($service1);

				$Sales12 = mysql_query("SELECT count(*) sales12 FROM reorting WHERE tdate='$date' AND repid='".$row['repid']."' AND typeofcall='SALES CALL' AND attendance='1'");
				$Rs_Sales12=mysql_fetch_assoc($Sales12);
				$service12 = mysql_query("SELECT count(*) service12 FROM reorting WHERE tdate='$date' AND repid='".$row['repid']."' AND typeofcall='SERVICE CALL' AND attendance='1'");
				$Rs_service12=mysql_fetch_assoc($service12);
	if($j == 0){
	$arr['name'] = 'sales';
	$arr1['name'] = 'service';
		$j++;
	}
	$arr['data'][] = $Rs_Sales1['sales1'];
	$arr1['data'][] = $Rs_service1['service1'];
	$arr2[] = strtoupper($row['rep_name']);
}



array_push($result,$arr1);
array_push($result,$arr);

$values['values']=$result;
$values['repname']=$arr2;

print json_encode($values, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
