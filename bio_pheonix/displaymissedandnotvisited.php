<?php

include("connect23.php"); 

ini_set('memory_limit', '-1');

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];


global $notvisitedcount;

$missedcount='0';
$bfgrt='0';
$vistedcalls='0';

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
   $no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$date=date("Y-m",strtotime($full_date));

$i=1;
$j=0;
while($i<=31){

$day=date("l",strtotime($date.'-'.$i));

if($j<=$no_of_days && $day!='Sunday'){

 $auto_date=date("Y-m-d",strtotime($date.'-'.$i));
$jj = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj) == 0) {

$month1=date("m",strtotime($date.'-'.$i));
$month2=date("m",strtotime($full_date));
if($month1==$month2){
$j++;
}

}
}
$i++;
}

 $j;
if ($j % 2 == 0) {
  $total=$j;
} else {
  $total=$j-1;
}

 $tot1=$total/2;

$i1=1;
$j1=1;
while($i1<=31){

$day1=date("l",strtotime($date.'-'.$i1));

if($j1<=$tot1 && $day1!='Sunday'){

$auto_date1=date("Y-m-d",strtotime($date.'-'.$i1));
$jj1 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date1' AND repid= '$rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj1) == 0) {
$v1_date=$auto_date1;

$j1++;
}
}
$i1++;
}


$i2=date('d', strtotime($v1_date.' +1 day'));
$j2=1;
while($i2<=31){

$day2=date("l",strtotime($date.'-'.$i2));

if($j2<=$tot1+1 && $day2!='Sunday'){

$auto_date2=date("Y-m-d",strtotime($date.'-'.$i2));
$jj2 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date2' AND repid= '$rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj2) == 0) {
$v2_date=$auto_date2;

$j2++;
}
}
$i2++;
}


$v1_first=date('Y-m', strtotime($full_date)).'-01';
$v1_last=$v1_date;

$v2_first=date('Y-m-d', strtotime($v1_last.' +1 day'));
$v2_last=$v2_date;


mysql_query("insert into visitsplit(v1first,v1last,v2first,v2last,repid)values('$v1_first','$v1_last','$v2_first','$v2_last','$rep_id')")or die(mysql_error());


   }
 
if (($full_date >= $v1_first) && ($full_date <= $v1_last)) 
{

$v1sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='1' and drunavailable='0'");

$v1sssCNT= mysql_num_rows($v1sss);
if($v1sssCNT==0)
{

}
if($v1sssCNT>0)
{
$row = mysql_fetch_array($v1sss);
$bfgrt=$row['wp_dc_id'];
$strSQL = mysql_query("SELECT GROUP_CONCAT(id) DID FROM doctors WHERE  `id` NOt IN ( $bfgrt) AND  `rep_assign` ='$rep_id'");
$D=mysql_fetch_array($strSQL);
//$D["DID"];


$splitdid = explode(",", $D["DID"]);
//print_r($splitdid);


$v5sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$previousday' and ((attendancestatus='1' and drunavailable='1') || (attendancestatus='0' and drunavailable='0'))");
$v5sssCNT= mysql_num_rows($v5sss);
if($v5sssCNT==0)
{

}
if($v5sssCNT>0)
{
$row5 = mysql_fetch_array($v5sss);
$splitdid2 = explode(",", $row5['wp_dc_id']);
//print_r($splitdid2);
}


$v6sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_date='$full_date' and attendancestatus='1' and drunavailable='1'");
$v6sssCNT= mysql_num_rows($v6sss);
if($v6sssCNT==0)
{

}
if($v6sssCNT>0)
{
$row6 = mysql_fetch_array($v6sss);
$splitdid3 = explode(",", $row6['wp_dc_id']);
//print_r($splitdid3);
}



}

$result=array_intersect($splitdid,$splitdid2);

if(count($result)=='0')
{

}
else
{

$resp=implode(",",$result);


}


$result11=array_intersect($splitdid,$splitdid3);

if(count($result11)=='0')
{
$resp11=0;
}
else
{

$resp11=implode(",",$result11);


}


$resspli=implode(",",$splitdid3);

if(strlen($resp)=='0')
{
  $pandiyan='0'.",".$resp11;
}
else
{	
  $pandiyan=$resp.",".$resp11;	
}	
$strSQL = "SELECT id,doctor_name,doc_contact_no,doc_pincode,doc_qualification,doc_specilist_id,doc_hospital_clinic_name,doc_specific,time_specific,favourite,doctor_addrs,territory
FROM doctors WHERE  id IN (".$pandiyan.") AND `rep_assign` =$rep_id";


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
		
		
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	
	echo json_encode($resultArray);

} 


else if (($full_date >= $v2_first) && ($full_date <= $v2_last)) 
{

$v1sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$v2_last' and attendancestatus='1' and drunavailable='0'");

$v1sssCNT= mysql_num_rows($v1sss);
if($v1sssCNT==0)
{

}
if($v1sssCNT>0)
{
$row = mysql_fetch_array($v1sss);
$bfgrt=$row['wp_dc_id'];
$strSQL = mysql_query("SELECT GROUP_CONCAT(id) DID FROM doctors WHERE  `id` NOt IN ( $bfgrt) AND  `rep_assign` ='$rep_id'");
$D=mysql_fetch_array($strSQL);
//$D["DID"];


$splitdid = explode(",", $D["DID"]);
//print_r($splitdid);


$v5sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$previousday' and ((attendancestatus='1' and drunavailable='1') || (attendancestatus='0' and drunavailable='0'))");
$v5sssCNT= mysql_num_rows($v5sss);
if($v5sssCNT==0)
{

}
if($v5sssCNT>0)
{
$row5 = mysql_fetch_array($v5sss);
$splitdid2 = explode(",", $row5['wp_dc_id']);
//print_r($splitdid2);
}


$v6sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_date='$full_date' and attendancestatus='1' and drunavailable='1'");
$v6sssCNT= mysql_num_rows($v6sss);
if($v6sssCNT==0)
{

}
if($v6sssCNT>0)
{
$row6 = mysql_fetch_array($v6sss);
$splitdid3 = explode(",", $row6['wp_dc_id']);
//print_r($splitdid3);
}



}

$result=array_intersect($splitdid,$splitdid2);

if(count($result)=='0')
{

}
else
{

$resp=implode(",",$result);


}


$result11=array_intersect($splitdid,$splitdid3);

if(count($result11)=='0')
{
$resp11=0;
}
else
{

$resp11=implode(",",$result11);


}


$resspli=implode(",",$splitdid3);

if(strlen($resp)=='0')
{
  $pandiyan='0'.",".$resp11;
}
else
{	
  $pandiyan=$resp.",".$resp11;	
}	
$strSQL = "SELECT id,doctor_name,doc_contact_no,doc_pincode,doc_qualification,doc_specilist_id,doc_hospital_clinic_name,doc_specific,time_specific,favourite,doctor_addrs,territory FROM doctors WHERE  id IN (".$pandiyan.") AND `rep_assign` =$rep_id";


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
		
		
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	
	echo json_encode($resultArray);

} 





	
?>