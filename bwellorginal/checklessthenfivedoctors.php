<?php


include("connect1.php");

$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];



 $jjxx = mysql_query("SELECT * FROM repgivenasleave WHERE repid='$repid'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count == 0)
    {




echo '[{"data":"Success"}]';





}
else
{

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$date2=$leaveapplieddate;
if(strtotime($c_date) <= strtotime($date2)){






 $jjxx = mysql_query("SELECT * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

echo '[{"data":"Success"}]';



}
else
{

echo '[{"data":"No date"}]';
}

}
else
{




 $jjxx = mysql_query("SELECT * FROM repgivenasleave WHERE repid='$repid'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count == 1)
    {
    
    echo '[{"data":"Success"}]';
    
}
else
{

$jjxx = mysql_query("SELECT * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {



 $jjxxsd = mysql_query("SELECT * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate' AND (expenses='leave' || expenses='others')")or die(mysql_error());
      $jjxxsd_count = mysql_num_rows($jjxxsd);
     if($jjxxsd_count > 0)
{
echo '[{"data":"Success"}]';
}
else
{


$chk_rep = mysql_query("SELECT * FROM `tbl_work_plan` WHERE `wp_date` = '$leaveapplieddate' AND `wp_rep_id` = '$repid' and `wp_dc`='D' and `attendancestatus`=1");

$rep_cunt=mysql_num_rows($chk_rep);

if($rep_cunt > 5){

echo '[{"data":"Success"}]';

}else{



 $jjxxsd = mysql_query("SELECT * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate' AND reasonforlessdr!=''")or die(mysql_error());
      $jjxxsd_count = mysql_num_rows($jjxxsd);
     if($jjxxsd_count > 0)
{
echo '[{"data":"Success"}]';
}
else
{
echo '[{"data":"Failure"}]';
}





}



}




}
else
{

echo '[{"data":"No date"}]';
}
}






}






 

}







?>
