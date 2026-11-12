<?php
	include("include/connect.php");
	/*$SQL = mysql_query("SELECT id,state_id,dist_id,pin_id,pincode FROM pincode_list WHERE id IN (SELECT area_id FROM tbl_customer_master WHERE pincode = 0)");	
	while($RS=mysql_fetch_object($SQL)){
		mysql_query("UPDATE tbl_customer_master SET state_id = '".$RS->state_id."',district_id='".$RS->dist_id."',pin_id='".$RS->pin_id."',pincode = '".$RS->pincode."' WHERE pincode = 0 AND area_id = '".$RS->id."'");
		echo mysql_error();
	}*/
	
	$SQL = mysql_query("SELECT id,`state_id`,`dist_id`,`pin_id`,`pincode` FROM `pincode_list` WHERE `pincode` IN (613006,614037,614702,620005,621207,621215,623305,625531,628103,628552,630009,630405,630551,630611,631009,635107,636016,636105,636183,636201,636351,636705,637002,637006,637013,637015,637020,637205,637206,637207,637208,637402,637404,637406,637409,637410,638005,638405,638407,639003,639005,641013,641016,641032,641038,641039,641089,641111,641302,641606,641608,641609,641650,641652,641660,641663,643201,643211) GROUP BY pincode");
	while($RS=mysql_fetch_object($SQL)){
		mysql_query("UPDATE areawise_temp SET `state_id`='".$RS->state_id."',`district_id`='".$RS->dist_id."',`pin_id`='".$RS->pin_id."',`area_id`='".$RS->id."' WHERE `pincode`='".$RS->pincode."'");
	}
?>