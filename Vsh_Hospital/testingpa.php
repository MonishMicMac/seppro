<?php
include("connect23.php"); 


$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];











if($rep_id=='1')
{

 $strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.visitcardclinicphoto,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";
}
else
{


global $missedcount,$notvisitedcount;

$totalvistedwithoutrepeatedcount='0';

$v1contforvis='0';

$full_date=date("Y-m-d",strtotime($date));

$tomorrow = date('Y-m-d',strtotime($full_date . "+1 days"));
$previousday= date('Y-m-d',strtotime($full_date . "-1 days"));

$dt = explode("-",$full_date);
 
$datr=$dt[0]."-".$dt[1]."-";



$jj = mysql_query("SELECT * FROM visitsplit WHERE repid= '$rep_id' AND v1first LIKE  '%".$datr."%' AND v2first LIKE  '%".$datr."%' AND v1last LIKE  '%".$datr."%'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0 )
    {
    
    $row=mysql_fetch_array($jj);
    $v1_first=$row['v1first'];
    $v1_last=$row['v1last'];
    $v2_first=$row['v2first'];
    $v2_last=$row['v2last'];


 
  
   }
   else
   {

   }





$totaldr=mysql_query("select count(*) as v1to_cnt from doctors WHERE rep_assign='$rep_id'");
$v1_totaldr= mysql_fetch_array($totaldr);
$totaldrcount=$v1_totaldr['v1to_cnt'];


$v1count=mysql_query("select count(*) as v1todd_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='1' and drunavailable='0'");
$v1_count= mysql_fetch_array($v1count);
$v1contforvis1=$v1_count['v1todd_cnt'];

$v1contforvis=$totaldrcount-$v1contforvis1;


$v1sssww=mysql_query("select count(DISTINCT dc_id) AS dc_id from v1visitmissed where attendace='1' and repid='$rep_id' AND date LIKE  '$datr%'");

$v112_count= mysql_fetch_array($v1sssww);
$v1contforvis122=$v112_count['dc_id'];
$v1contforvis=$v1contforvis-$v1contforvis122;


if (($full_date >= $v1_first) && ($full_date <= $v1_last)) 
{

$v1=mysql_query("select count(*) as v1_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='1' and drunavailable='0'");
$v1_dr_list= mysql_fetch_array($v1);
$visitedcount=$v1_dr_list['v1_cnt'];



$withoutrepeated=mysql_query("select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='1' and drunavailable='0' group by wp_dc_id");
while($row = mysql_fetch_array($withoutrepeated))
{

 $totalvistedwithoutrepeatedcount++;

}





$strSQL = "SELECT doctors.id,doctors.doctor_name FROM doctors WHERE rep_assign='$rep_id' AND id not in (select wp_dc_id from tbl_work_plan where wp_rep_id='$rep_id' and wp_dc='D' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='1' and drunavailable='0')";

$result = mysql_query($strSQL) or die ("no query");

$result_array = array();
while($row = mysql_fetch_assoc($result))
{

  $result_array[] = $row[id];
}

for($i = 0; $i < sizeof($result_array);$i++)
{
  

$v12=mysql_query("select count(*) as v12_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$result_array[$i]' and date(wp_date) between '$v1_first' and '$previousday' and ((attendancestatus='0' and drunavailable='0') or (attendancestatus='1' and drunavailable='1'))");

$missedcountw= mysql_fetch_array($v12);



if($missedcountw['v12_cnt']=='0')
{



$v123=mysql_query("select count(*) as v123_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$result_array[$i]' and wp_date='$full_date' AND attendancestatus='1' and drunavailable='1'");



$missedcountw3= mysql_fetch_array($v123);



if($missedcountw3['v123_cnt']>'0')
{
$missedcount++;
}
else
{

}

}
else
{

 $result_array[$i];

$v123=mysql_query("select count(*) as v123_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$result_array[$i]' and wp_date='$full_date' AND attendancestatus='1' and drunavailable='1'");

$missedcountw3= mysql_fetch_array($v123);

if($missedcountw3['v123_cnt']>'0')
{
$missedcount++;
}
else
{
  $missedcount++;
}



}




}

} 
elseif (($full_date >= $v2_first) && ($full_date <= $v2_last)) 
{

$v1=mysql_query("select count(*) as v1_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$v2_last' and attendancestatus='1' and drunavailable='0'");
$v1_dr_list= mysql_fetch_array($v1);
$visitedcount=$v1_dr_list['v1_cnt'];



$withoutrepeated=mysql_query("select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$v2_last' and attendancestatus='1' and drunavailable='0' group by wp_dc_id");
while($row = mysql_fetch_array($withoutrepeated))
{

 $totalvistedwithoutrepeatedcount++;

}




$strSQL = "SELECT doctors.id,doctors.doctor_name FROM doctors WHERE rep_assign='$rep_id' AND id not in (select wp_dc_id from tbl_work_plan where wp_rep_id='$rep_id' and wp_dc='D' and date(wp_date) between '$v2_first' and '$v2_last' and attendancestatus='1' and drunavailable='0')";

$result = mysql_query($strSQL) or die ("no query");

$result_array = array();
while($row = mysql_fetch_assoc($result))
{

  $result_array[] = $row[id];
}

for($i = 0; $i < sizeof($result_array);$i++)
{


$v12=mysql_query("select count(*) as v12_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$result_array[$i]' and date(wp_date) between '$v2_first' and '$previousday' and ((attendancestatus='0' and drunavailable='0') or (attendancestatus='1' and drunavailable='1'))");

$missedcountw= mysql_fetch_array($v12);



if($missedcountw['v12_cnt']=='0')
{



$v123=mysql_query("select count(*) as v123_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$result_array[$i]' and wp_date='$full_date' AND attendancestatus='1' and drunavailable='1'");



$missedcountw3= mysql_fetch_array($v123);



if($missedcountw3['v123_cnt']>'0')
{
$missedcount++;
}
else
{

}

}
else
{

 $result_array[$i];

$v123=mysql_query("select count(*) as v123_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='$result_array[$i]' and wp_date='$full_date' AND attendancestatus='1' and drunavailable='1'");

$missedcountw3= mysql_fetch_array($v123);

if($missedcountw3['v123_cnt']>'0')
{
$missedcount++;
}
else
{
  $missedcount++;
}



}




}


}

if(strlen($missedcount)==0)
{
$missedcount='0';

}
else
{

}





$minus=$missedcount+$totalvistedwithoutrepeatedcount;

$notvisited=$totaldrcount-$minus;

 $extra=$visitedcount-$totalvistedwithoutrepeatedcount;

$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.visitcardclinicphoto,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,tbl_work_plan.drunavailable FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";
}




}




$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
                  $arrCol['v1vis'] = "$v1contforvis";
		
		$arrCol['missedvalue'] = "$missedcount";
		$arrCol['visitedvalue'] = $totalvistedwithoutrepeatedcount;
		$arrCol['notvisitedvalue'] = "$notvisited";
		$arrCol['extra'] = "$extra";
		$arrCol['count'] = "1";
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	if(strlen(json_encode($resultArray))<=2)
	{
	
	echo '[{"missedvalue":"'.$missedcount.'","v1vis":"'.$v1contforvis.'","visitedvalue":"'.$totalvistedwithoutrepeatedcount.'","notvisitedvalue":"'.$notvisited.'"'.',"extra":"'.$extra.'"'.',"count":"0"'.'}]';
	}
	else
	{
	echo json_encode($resultArray);
	}
	
	
	
	
	
	
	
	
?>