<?php
include("connect23.php"); 

$takedate=$_REQUEST['takedate'];
$wp_date=$_REQUEST['wp_date'];
$wp_rep_id=$_REQUEST['wp_rep_id'];

date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s A');



$withoutrepeatedsss=mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$wp_rep_id' AND leaveapplieddate= '$takedate'");
while($rowssssss = mysql_fetch_array($withoutrepeatedsss))
{




$antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$wp_rep_id' AND leaveapplieddate= '$wp_date'")or die(mysql_error());
   $antony_countx = mysql_num_rows($antony);
   if($antony_countx > 0)
   {
mysql_query("UPDATE repgivenasleave SET reason='".$rowssssss['reason']."',expenses='".$rowssssss['expenses']."',date='$c_date',time='$c_time' WHERE repid= '$wp_rep_id' AND leaveapplieddate='$wp_date'")or die(mysql_error());
   }
   else
   {
mysql_query("insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time)values('$wp_rep_id','$wp_date','".$rowssssss['reason']."','".$rowssssss['expenses']."','$c_date','$c_time')")or die(mysql_error());

}

}


$withoutrepeated=mysql_query("select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$wp_rep_id' and wp_date='$takedate' and attendancestatus='0' and drunavailable='0'");
while($rowsss = mysql_fetch_array($withoutrepeated))
{

 
    $jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$wp_date' AND wp_rep_id='$wp_rep_id' AND wp_dc = 'D' AND wp_dc_id = '".$rowsss['wp_dc_id']."' AND drunavailable = '0'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {


    }
    else
     {
    
     
     
     
     
     
     
     
     $rep_id=$wp_rep_id;
     
$full_date=date("Y-m-d",strtotime($wp_date));

$tomorrow = date('Y-m-d',strtotime($full_date . "+1 days"));
$previousday= date('Y-m-d',strtotime($full_date . "-1 days"));

$dt = explode("-",$full_date);
 
$datr=$dt[0]."-".$dt[1]."-";



$jj = mysql_query("SELECT * FROM visitsplit WHERE repid= '$rep_id' AND v1first LIKE  '%".$datr."%' AND v2first LIKE  '%".$datr."%' AND v1last LIKE  '%".$datr."%' AND v2last LIKE  '%".$datr."%'")or die(mysql_error());
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


mysql_query("DELETE from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='".$rowsss['wp_dc_id']."' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='0' and drunavailable='0'");

 mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','0','D','".$rowsss['wp_dc_id']."','$wp_rep_id','P','$c_date','$c_time','1')")or die(mysql_error());
}
elseif (($full_date >= $v2_first) && ($full_date <= $v2_last)) 
{


mysql_query("DELETE from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_dc_id='".$rowsss['wp_dc_id']."' and date(wp_date) between '$v2_first' and '$v2_last' and attendancestatus='0' and drunavailable='0'");


 mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','0','D','".$rowsss['wp_dc_id']."','$wp_rep_id','P','$c_date','$c_time','1')")or die(mysql_error());
 
 
}
 

     }
     

}
















?>