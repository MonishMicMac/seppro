<?php


	
	
	$user="root";
$pass="$3pp60@2016";
$database="kamachitmt";
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');

$rep_id=$_REQUEST['rep_id'];
$succesdays=$_REQUEST['succesdays'];
$rep_idjk='0';

$strSQL = "SELECT * FROM representative where rep_imeino='$rep_id'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
$rep_idjk='1';
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


if($rep_idjk=='0')
{
}
else
{

if($succesdays==1)
{
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');
$rid = $_REQUEST['rep_id'];


$repimieno= mysql_query("SELECT id FROM representative WHERE rep_imeino='".$_REQUEST['rep_id']."'")or die(mysql_error());


$repimieno_res = mysql_fetch_array($repimieno);





$schedule = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$repimieno_res['id']."' AND wp_dc='D' AND wp_date='".date('Y-m-d')."'")or die(mysql_error());

$schedule_count = mysql_num_rows($schedule);

if($schedule_count > 0)
{





}

else
{

$predate = date('Y-m-d', strtotime('-7 days'));

$cdate = date('Y-m-d');
 date_default_timezone_set('Asia/kolkatta');
$ctime =date('H:i:s');

$schedule = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='".$repimieno_res['id']."' AND wp_dc='D' AND wp_date='$predate'")or die(mysql_error());

while($schedule_res = mysql_fetch_array($schedule))
{




mysql_query("INSERT INTO tbl_work_plan (wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time,attendancestatus,UP) VALUES('$cdate','0','D','".$schedule_res['wp_dc_id']."','".$repimieno_res['id']."','$cdate','$ctime','0','U')")or die(mysql_error());


}


  


}



}
}


?>