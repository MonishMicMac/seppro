<?php

include("connect1.php");

function rangeWeek ($datestr) {
   date_default_timezone_set (date_default_timezone_get());
   $dt = strtotime ($datestr);
   return array (
     "start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('last monday', $dt)),
     "end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
   );
 }

 // echo "SELECT id,rep_name FROM representative where id='".$_REQUEST['repid']."'";

 // echo "SELECT id,rep_name FROM representative where id IN (select repid from assigningreptomanager where managerid='".$_REQUEST['repid']."')";

	$strSQL = "SELECT id,rep_name FROM representative where id IN (select repid from assigningreptomanager where managerid='".$_REQUEST['repid']."')";

	$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	// $resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		// $arrCol = array();
		// for($i=0;$i<$intNumField;$i++)
		// {
		// 	$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		// }
		// $arrCol['v1'] ='0';
		// $arrCol['v2'] = '0';
		// $arrCol['dr_full_cnt'] = '0';
		
		// $arrCol['primarytotaldatepob'] = '0';
		// $arrCol['primarytotalmonthpob'] = '0';

		//month

		$target_rep=mysql_query("SELECT * FROM `repwise_target` WHERE `rt_rep_id`='".$obResult['id']."' AND rt_month_date LIKE '%".date('Y-m')."%' ");
		$target_rep_row = mysql_fetch_array($target_rep);
		// $arrCol['target_rep'] = $target_rep_row['rt_amt'];
		// echo "SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt FROM `pobbooking` WHERE `repid`='".$obResult['id']."' AND cdate LIKE '%".date('Y-m')."%' GROUP BY productid";

		$monthpobtotal=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt FROM `pobbooking` WHERE `repid`='".$obResult['id']."' AND cdate LIKE '%".date('Y-m')."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal)!=0)
		{
			while($monthpobtotal_row = mysql_fetch_array($monthpobtotal))
			{
				$totalpobmonth+=$monthpobtotal_row['totamt'];
			}
		}
		else
		{
			$totalpobmonth+='0';
		}
		// $arrCol['totalmonthpob'] = $totalpobmonth;

		//week

		$start=rangeWeek(date('Y-m-d'));
		// $arrCol['totaldatepob'] = $totalpobmonth1;

		// (cdate BETWEEN '".$start['start']."' AND '".$start['end']."')
		// echo $lastday = date('t',strtotime('today'));

		$monthpobtotal11=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt FROM `pobbooking` WHERE `repid`='".$obResult['id']."' AND (cdate BETWEEN '".$start['start']."' AND '".$start['end']."') GROUP BY productid");
		if(mysql_num_rows($monthpobtotal11)!=0)
		{
			while($monthpobtotal_row11 = mysql_fetch_array($monthpobtotal11))
			{
				$totalpobdate11+=$monthpobtotal_row11['totamt'];
			}
		}
		else
		{
			$totalpobdate11+='0';
		}

		//date

		$monthpobtotal1=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt FROM `pobbooking` WHERE `repid`='".$obResult['id']."' AND cdate LIKE '%".date('Y-m-d')."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal1)!=0)
		{
			while($monthpobtotal_row1 = mysql_fetch_array($monthpobtotal1))
			{
				$totalpobdate1+=$monthpobtotal_row1['totamt'];
			}
		}
		else
		{
			$totalpobdate1+='0';
		}

		

		// array_push($resultArray,$arrCol);

		//primary

		$monthpobtotal1p=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking_prime.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking_prime.productid)) AS totamt FROM `pobbooking_prime` WHERE `repid`='".$obResult['id']."' AND cdate LIKE '%".date('Y-m')."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal1p)!=0)
		{
			while($monthpobtotal_row1p = mysql_fetch_array($monthpobtotal1p))
			{
				$totalpobdate1p+=$monthpobtotal_row1p['totamt'];
			}
		}
		else
		{
			$totalpobdate1p+='0';
		}


		//secondary

		$monthpobtotal1ps=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking_second.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking_second.productid)) AS totamt FROM `pobbooking_second` WHERE `repid`='".$obResult['id']."' AND cdate LIKE '%".date('Y-m')."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal1ps)!=0)
		{
			while($monthpobtotal_row1ps = mysql_fetch_array($monthpobtotal1ps))
			{
				$totalpobdate1ps+=$monthpobtotal_row1ps['totamt'];
			}
		}
		else
		{
			$totalpobdate1ps+='0';
		}
		 

		 // print_r($start['start']);
		$week_current+=(($target_rep_row['rt_amt']/date('t',strtotime('today')))*7);
		$date_current+=(($target_rep_row['rt_amt']/date('t',strtotime('today'))));

		$totaltarget+=$target_rep_row['rt_amt'];
		 

		

	}

	echo '[{"type":"month","target":'.'"'.$totaltarget.'","pobamt":'.'"'.$totalpobmonth.'","rount":"1","cdate":"'.date('Y-m').'"}'.',{"type":"week","target":'.'"'.round($week_current,2).'","pobamt":'.'"'.$totalpobdate11.'","rount":"1","cdate":"'.date('Y-m').'"},{"type":"day","target":'.'"'.round($date_current,2).'","pobamt":'.'"'.$totalpobdate1.'","rount":"1","cdate":"'.date('Y-m').'"},{"type":"pry","target":'.'"'.$totaltarget.'","pobamt":'.'"'.$totalpobdate1p.'","rount":"1","cdate":"'.date('Y-m').'"},{"type":"sdy","target":'.'"'.$totaltarget.'","pobamt":'.'"'.$totalpobdate1ps.'","rount":"1","cdate":"'.date('Y-m').'"}]';


	// mysql_close($con);
	
	// echo json_encode($resultArray);





?>