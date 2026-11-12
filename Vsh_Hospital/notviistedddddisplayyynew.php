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
$resspli=implode(",",$splitdid3);


$v56sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_date='$full_date' and attendancestatus='0' and drunavailable='0'");
$v56sssCNT= mysql_num_rows($v56sss);
if($v56sssCNT==0)
{

}
if($v56sssCNT>0)
{
$row56 = mysql_fetch_array($v56sss);
$rto=$row56['wp_dc_id'];

}
else
{
$rto=0;
}



if(strlen($resp)=='0')
{
  $pandiyan='0'.",".$resspli.",".$bfgrt.",".$rto;
}
else
{	
  $pandiyan=$resp.",".$resspli.",".$bfgrt.",".$rto;	
}



$strSQL = "SELECT id,cust_id,doctor_name,doc_contact_no,doc_pincode,doc_qualification,doc_specilist_id,doc_hospital_clinic_name,doc_specific,time_specific,favourite FROM doctors WHERE  id NOT IN (".$pandiyan.") AND `rep_assign` =$rep_id";


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



$splitdid = explode(",", $D["DID"]);



$v5sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and date(wp_date) between '$v2_first' and '$previousday' and ((attendancestatus='1' and drunavailable='1') || (attendancestatus='0' and drunavailable='0'))");
$v5sssCNT= mysql_num_rows($v5sss);
if($v5sssCNT==0)
{

}
if($v5sssCNT>0)
{
$row5 = mysql_fetch_array($v5sss);
$splitdid2 = explode(",", $row5['wp_dc_id']);
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
$resspli=implode(",",$splitdid3);


$v56sss=mysql_query("select IFNULL(GROUP_CONCAT(DISTINCT wp_dc_id),0) AS wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$rep_id' and wp_date='$full_date' and attendancestatus='0' and drunavailable='0'");
$v56sssCNT= mysql_num_rows($v56sss);
if($v56sssCNT==0)
{

}
if($v56sssCNT>0)
{
$row56 = mysql_fetch_array($v56sss);
$rto=$row56['wp_dc_id'];

}
else
{
$rto=0;
}



if(strlen($resp)=='0')
{
  $pandiyan='0'.",".$resspli.",".$bfgrt.",".$rto;
}
else
{	
  $pandiyan=$resp.",".$resspli.",".$bfgrt.",".$rto;	
}


$strSQL = "SELECT id,cust_id,doctor_name,doc_contact_no,doc_pincode,doc_qualification,doc_specilist_id,doc_hospital_clinic_name,doc_specific,time_specific,favourite FROM doctors WHERE  id NOT IN (".$pandiyan.") AND `rep_assign` =$rep_id";


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