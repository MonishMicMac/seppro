<?php
	include("include/connect.php");
	$are=mysql_query("select * from  temp_rep")or die(mysql_error());
	$coun=mysql_num_rows($are);
	if($coun > 0)
	{
		while($row_a=mysql_fetch_array($are))
		{
			$pin_id = explode(",",$row_a['area_ids']);
			for($i=0;$i<=count($coun);$i++){				
				mysql_query("INSERT INTO rep_area (rep_id,district_id,pin_id,c_date,c_time) VALUES (1,".$row_a['district_id'].",".$pin_id[$i].",'".date("Y-m-d")."','".date("H:i:s")."')");
			}			
		}		
	}

?>