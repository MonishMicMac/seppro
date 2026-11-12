<?php

include("connect23.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];


global $notvisitedcount;

$missedcount='0';
$bfgrt='0';
$vistedcalls='0';
$vistedcalls2='0';


$full_date=date("Y-m-d",strtotime($date));

$tomorrow = date('Y-m-d',strtotime($full_date . "+1 days"));
$previousday= date('Y-m-d',strtotime($full_date . "-1 days"));

$dt = explode("-",$full_date);
 
$datr=$dt[0]."-".$dt[1]."-";



$jj = mysql_query("SELECT * FROM visitsplit WHERE repid= '$rep_id' AND v1first LIKE  '%".$datr."%' AND v2first LIKE  '%".$datr."%'")or die(mysql_error());
      $jj_count = mysql_num_rows($jj);
     if($jj_count > 0 )
    {
    
    $row=mysql_fetch_array($jj);
   $v1_first=$row['v1first'];
   $v2_first=$row['v2first'];
   $v1_last=$row['v1last'];
   $v2_last=$row['v2last'];

    
   }

   


$v1sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v1_first' and '$v1_last' and attendancestatus='1' and drunavailable='0'");

$v1sssCNT= mysql_num_rows($v1sss);
if($v1sssCNT==0)
{
$bfgrt=0;
}
if($v1sssCNT>0)
{
$row = mysql_fetch_array($v1sss);
$bfgrt=$row['wp_dc_id'];
}







if (($full_date >= $v2_first) && ($full_date <= $v2_last)) 
{



$v1sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$v2_last' and attendancestatus='1' and drunavailable='0'");

$v1sssCNT= mysql_num_rows($v1sss);
if($v1sssCNT==0)
{
$vistedcalls2=0;
}
if($v1sssCNT>0)
{
$row = mysql_fetch_array($v1sss);
$vistedcalls2=$row['wp_dc_id'];
}

$vistedcalls2;
}


if(substr( $bfgrt, 0, 1 ) === ",")
{
$bfgrt=substr($bfgrt,1);
}





$strSQL = "SELECT * FROM doctors WHERE  `id`  NOT IN ($bfgrt) AND  `rep_assign` =$rep_id";


$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
$viscall=array();
	while($obResult = mysql_fetch_array($objQuery))
	{
        $idchk=",".$obResult['id'].",";
        $viscall=",".$vistedcalls2.",";

if (strpos($viscall, $idchk)!== false)
{
   
 $status=1;
}
else
{

 $status=0;
}

 
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{


			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}		
		
		$arrCol['status'] = $status;
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	
	echo json_encode($resultArray);
	
	

	
	
	
	
?>