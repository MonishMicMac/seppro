<?php
	include("connect23.php"); 

$rep_id=$_REQUEST['rep_id'];


$year =$_REQUEST['year'];

date_default_timezone_set("Asia/Kolkata");
 
    
 $date = date("Y-m-d");
$date = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");
$date = date("Y-m-d",$date);

  


 $full_date=$date;
 
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
//echo $v1_date.'<br>';
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
//echo $v2_date.'<br>';
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
 


$dt = explode("-",$full_date);
 
$datr=$dt[0]."-".$dt[1]."-";


$strSQL = "SELECT expenses,leaveapplieddate,reason,filename FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%'";


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
		$arrCol['v1first'] = "$v1_first";
		$arrCol['v2first'] = "$v2_first";
		$arrCol['count'] = "1";
		
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	


if(strlen(json_encode($resultArray))<=2)
	{
	
	echo '[{"v1first":"'.$v1_first.'","v2first":"'.$v2_first.'","count":"0"}]';
	}
	else
	{
	echo json_encode($resultArray);
	}


?>