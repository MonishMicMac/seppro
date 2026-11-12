<?php
session_start();
include("connect1.php"); 


$schoolid=$_REQUEST['schoolid'];

$Phone_no=$_REQUEST['Phone_no'];

$strSQL = $je->prepare("SELECT `database`,school_id,db_pwd,db_user,db_host,school_app_url,school_logo,Curriculum,Achievements,Highlights,about FROM ymst_school WHERE school_id='$schoolid'");
$strSQL->execute();
$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

 $_SESSION['db']=$array[0]['database'];
 $_SESSION['user']=$array[0]['db_user'];
 $_SESSION['pwd']=$array[0]['db_pwd'];
 $_SESSION['host']=$array[0]['db_host'];
 $_SESSION['url']=$array[0]['school_app_url'];
 $_SESSION['sclog']=$array[0]['school_logo'];
 $_SESSION['about']=$array[0]['about'];
 $_SESSION['Highlights']=$array[0]['Highlights'];
 $_SESSION['Achievements']=$array[0]['Achievements'];
 $_SESSION['Curriculum']=$array[0]['Curriculum'];
// echo json_encode($array);
// $je1= new PDO('mysql:host='.$host.';dbname='."$db", "$user", "$pwd", 
          // array( PDO::ATTR_PERSISTENT => true));
// $strSQL1 = $je1->prepare("SELECT * FROM student_profile WHERE Phone_no='$Phone_no'");
// $strSQL1->execute();
// $array1 = $strSQL1->fetchAll(PDO::FETCH_ASSOC);
// $newarray=array_merge($array,$array1);
// echo json_encode($newarray);

// $con=mysql_connect("$host","$user","$pwd");
// mysql_select_db("$db",$con);
// date_default_timezone_set('Asia/Calcutta');

// include("connect.php"); 

$con=mysql_connect($array[0]['db_host'],$array[0]['db_user'],$array[0]['db_pwd']);
mysql_select_db($array[0]['database'],$con);
date_default_timezone_set('Asia/Calcutta');


$strSQL1 = "SELECT * FROM student_profile WHERE Phone_no='$Phone_no'";



$objQuery1 = mysql_query($strSQL1) or die(mysql_error());
	$intNumField1 = mysql_num_fields($objQuery1);
	$resultArray1 = array();
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol1 = array();
		for($i=0;$i<$intNumField1;$i++)
		{
			$arrCol1[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
		}
		$arrCol1['dpappurl'] = $_SESSION['url'];
		$arrCol1['schoollogo'] = $_SESSION['sclog'];
		$arrCol1['dphost'] = $_SESSION['host'];
		$arrCol1['dppwd'] = $_SESSION['pwd'];
		$arrCol1['dpuser'] = $_SESSION['user'];
		$arrCol1['dpname']=$_SESSION['db'];
		$arrCol1['about']=$_SESSION['about'];
		$arrCol1['Highlights']=$_SESSION['Highlights'];
		$arrCol1['Achievements']=$_SESSION['Achievements'];
		$arrCol1['Curriculum']=$_SESSION['Curriculum'];
		array_push($resultArray1,$arrCol1);

	}
	
	// mysql_close($con);
	
	echo json_encode($resultArray1);
	
?>