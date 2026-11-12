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


$repid=$_REQUEST['repid'];
$type_status=$_REQUEST['type_status'];

$ladate=date('Y-m',strtotime($_REQUEST['month1']));



echo '[{';


// $erql = mysql_query("SELECT id FROM representative where id IN (select repid from assigningreptomanager where managerid='".$repid."')");
// $row=mysql_fetch_array($erql);
// $reid=$row['rep_id'];

global $str;

// echo "SELECT id FROM representative where id IN (select repid from assigningreptomanager where managerid='".$repid."')";

$erql=mysql_query("SELECT id FROM representative where id ='".$repid."'");

while($erql_row = mysql_fetch_array($erql))
{
	// echo "SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='C' AND drunavailable='0' AND jointworkby='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1'";

//

	$target_rep=mysql_query("SELECT * FROM `repwise_target` WHERE `rt_rep_id`='".$erql_row['id']."' AND rt_month_date LIKE '%".$ladate."%' ");
	$target_rep_row = mysql_fetch_array($target_rep);

	if($type_status=='1')
	{
		$typests="pobmonth";
		$monthpobtotal=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt,cdate FROM `pobbooking` WHERE `repid`='".$erql_row['id']."' AND cdate LIKE '%".$ladate."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal)!=0)
		{
			$m=1;
			while($monthpobtotal_row = mysql_fetch_array($monthpobtotal))
			{
				$totalpobmonth+=$monthpobtotal_row['totamt'];

				$str.='"target":"'.$target_rep_row['rt_amt'].'","pobamt":"'.$monthpobtotal_row['totamt'].'","type":"'.$typests.'","cdate":"'.$monthpobtotal_row['cdate'].'","count":"30","sno":"'.$m.'","type_status":"'.$type_status.'"},{';
				$m++;
			}
		}
		else
		{
			$totalpobmonth+='0';
		}

		

		// $str.='""target":"'.$target_rep_row['rt_amt'].'","pobamt":"'.$totalpobmonth.'","type":"'.$typests.'","cdate":"'.$ladate.'","count":"30"},{';
	}
	elseif($type_status=='2')
	{
		$start=rangeWeek(date('Y-m-d',strtotime($_REQUEST['month1'])));
		// $arrCol['totaldatepob'] = $totalpobmonth1;

		// (cdate BETWEEN '".$start['start']."' AND '".$start['end']."')
		// echo $lastday = date('t',strtotime('today'));
		$typests="pobweek";
		$week_current=(($target_rep_row['rt_amt']/date('t',strtotime('today')))*7);

		$monthpobtotal11=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt,cdate FROM `pobbooking` WHERE `repid`='".$erql_row['id']."' AND (cdate BETWEEN '".$start['start']."' AND '".$start['end']."') GROUP BY productid");
		if(mysql_num_rows($monthpobtotal11)!=0)
		{
			$w=1;
			while($monthpobtotal_row11 = mysql_fetch_array($monthpobtotal11))
			{
				$totalpobdate11+=$monthpobtotal_row11['totamt'];

				$str.='"target":"'.round($week_current,2).'","pobamt":"'.$monthpobtotal_row11['totamt'].'","type":"'.$typests.'","cdate":"'.$monthpobtotal_row11['cdate'].' to '.$start['end'].'","count":"30","sno":"'.$w.'","type_status":"'.$type_status.'"},{';
				$w++;

			}

		}
		else
		{
			$totalpobdate11='0';
		}

		
		
	}
	elseif($type_status=='3')
	{

		$typests="pobdate";		
		$date_current=(($target_rep_row['rt_amt']/date('t',strtotime('today'))));

		$d=1;

		$monthpobtotal1=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt,cdate FROM `pobbooking` WHERE `repid`='".$erql_row['id']."' AND cdate LIKE '%".date('Y-m-d',strtotime($_REQUEST['month1']))."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal1)!=0)
		{
			while($monthpobtotal_row1 = mysql_fetch_array($monthpobtotal1))
			{
				$totalpobdate1+=$monthpobtotal_row1['totamt'];

				$str.='"target":"'.round($date_current,2).'","pobamt":"'.$monthpobtotal_row1['totamt'].'","type":"'.$typests.'","cdate":"'.$monthpobtotal_row1['cdate'].'","count":"30","sno":"'.$d.'","type_status":"'.$type_status.'"},{';
				$d++;
			}
		}
		else
		{
			$totalpobdate1='0';
		}
		
		
	}
	elseif($type_status=='4')
	{
		$typests="pry";	
		$p=1;	
		$monthpobtotal1p=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking_prime.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking_prime.productid)) AS totamt,cdate FROM `pobbooking_prime` WHERE `repid`='".$erql_row['id']."' AND cdate LIKE '%".$ladate."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal1p)!=0)
		{
			while($monthpobtotal_row1p = mysql_fetch_array($monthpobtotal1p))
			{
				$totalpobdate1p+=$monthpobtotal_row1p['totamt'];

				$str.='"target":"'.$target_rep_row['rt_amt'].'","pobamt":"'.$monthpobtotal_row1p['totamt'].'","type":"'.$typests.'","cdate":"'.$monthpobtotal_row1p['cdate'].'","count":"30","sno":"'.$p.'","type_status":"'.$type_status.'"},{';
				$p++;
			}
		}
		else
		{
			$totalpobdate1p='0';
		}

		
		

	}
	elseif($type_status=='5')
	{
		$typests="sdy";	
		$s=1;
		$monthpobtotal1ps=mysql_query("SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking_second.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking_second.productid)) AS totamt FROM `pobbooking_second` WHERE `repid`='".$erql_row['id']."' AND cdate LIKE '%".$ladate."%' GROUP BY productid");
		if(mysql_num_rows($monthpobtotal1ps)!=0)
		{
			while($monthpobtotal_row1ps = mysql_fetch_array($monthpobtotal1ps))
			{
				$totalpobdate1ps+=$monthpobtotal_row1ps['totamt'];

				$str.='"target":"'.$target_rep_row['rt_amt'].'","pobamt":"'.$monthpobtotal_row1ps['totamt'].'","type":"'.$typests.'","cdate":"'.$ladate.'","count":"30","sno":"'.$s.'","type_status":"'.$type_status.'"},{';
				$s++;
			}
		}
		else
		{
			$totalpobdate1ps='0';
		}

			
		
	}







}

echo substr($str,0,-2).']';



?>