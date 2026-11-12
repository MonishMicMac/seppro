<?php
include("connect1.php");


$wp_date=$_REQUEST['wp_date'];
$wp_pin_id=$_REQUEST['wp_pin_id'];
$wp_dc=$_REQUEST['wp_dc'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_rep_id=$_REQUEST['wp_rep_id'];

$UP=$_REQUEST['UP'];
$morningevening=$_REQUEST['morningevening'];



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s');

$proid = explode(",",$wp_dc_id);


   $rep_id=$wp_rep_id;




for($i=0;$i< count($proid);$i++)
{



    // $chktwp1=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '".date('Y-m-d')."' AND wp_dc = 'D' and wp_rep_id='".$wp_rep_id."' AND wp_dc_id = '".$proid[$i]."'  ")or die(mysql_error());
    //     if(mysql_num_rows($chktwp1)==0)
    //     {

/*echo "INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$c_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date','$c_time','$morningevening')";*/
    
     mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,morningevening)VALUES('$wp_date','$wp_pin_id','$wp_dc','$proid[$i]','$wp_rep_id','$UP','$c_date','$c_time','$morningevening')")or die(mysql_error());
 		// }
     
     



}
     
     
     
    


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');

$strSQL = "SELECT doctors.doctor_addrs,tbl_work_plan.wp_date,doctors.id,doctors.doctor_name,tbl_work_plan.wp_id,tbl_work_plan.attendancestatus FROM doctors,tbl_work_plan where tbl_work_plan.wp_date ='$c_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";
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
		

                 
                 $arrCol['month'] = $c_date;

		array_push($resultArray,$arrCol);
	}
	mysql_close($con);
	
	echo json_encode($resultArray);



?>