<?php

include("connect23.php"); 



$repid=$_REQUEST['repid'];


global $str;
echo '[{';

for ($i = 0; $i <= 12; $i++) {

    $months = date("Y-m-", strtotime( date( 'Y-m-01' )." -$i months"));

  $year= substr($months,0,-4);
  $monthname = date("F", strtotime( " -$i months"));

$a = mysql_query("SELECT COUNT(wp_id),wp_date FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_dc='D' AND attendancestatus='1' AND wp_date LIKE '$months%'")or die(mysql_error());

while($a_res = mysql_fetch_array($a))
{

   //echo $a_res['COUNT(wp_id)']." - ".$months;
   //echo "<br>";

if($a_res['COUNT(wp_id)']=='0')
{
}
else
{

$str.='"count":'.'"'.$a_res['COUNT(wp_id)'].'","month":"'.substr($monthname,0,3).' '.$year.'"},{';
}
}

}


 $pan =$str; 

echo $jj = substr($pan,0, -2).']';



?>