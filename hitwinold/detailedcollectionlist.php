<?php
include("connect.php");
$proid=mysql_query("SELECT * FROM rental WHERE r_clid='".$_REQUEST['clientid']."' AND r_id='".$_REQUEST['addid']."' AND r_status!='1'")or die(mysql_error());
$proid_res=mysql_fetch_array($proid);


$proidlist="SELECT * FROM product WHERE id IN (".$proid_res['r_pro_id'].")";
$objQuery = mysql_query($proidlist);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		  $arrCol['rentolid']=$proid_res['r_id'];
		 $arrCol['r_pay_type']=$proid_res['r_pay_type'];
		 $arrCol['r_day_supply']=$proid_res['r_day_supply'];
		 $arrCol['r_ren_amt']=$proid_res['r_ren_amt'];
		 $arrCol['r_dop_amt']=$proid_res['r_dop_amt'];
		 $arrCol['r_accessories']=$proid_res['r_accessories'];
		 $arrCol['r_update']=$proid_res['r_update'];
		}
		array_push($resultArray,$arrCol);
	}
	
	
	
	echo json_encode($resultArray);	?>