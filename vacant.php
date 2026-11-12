<?php

$con = mysql_connect("localhost","root","");
mysql_select_db("lupin");

$SQL = mysql_query("SELECT pincode FROM pincode_list WHERE pin_id IN (SELECT pin_id  FROM rep_area GROUP BY pin_id) GROUP BY pincode");
while($RS=mysql_fetch_assoc($SQL)){
	@$YUVI.=$RS["pincode"].",";
}
$mama=@$YUVI;
$SQL1=mysql_query("SELECT `pincode` FROM `areawise_temp` WHERE `pincode` NOT IN (".substr(@$mama,0,-1).") GROUP BY pincode ORDER BY pincode");
while($RS1=mysql_fetch_assoc($SQL1)){
	echo $RS1["pincode"];
}
//mysql_fetch_object();
?>