<?php
session_start();
define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "root"); // set database user
define ("DB_PASS",""); // set database password
define ("DB_NAME","adsouq_zinnia"); // set database name

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

if($_GET["checkpoint"]==1){
	$SQL=mysql_query("SELECT * FROM representative WHERE rep_name = '".$_GET["u_name"]."' AND rep_pwd = '".$_GET["password"]."' "); 
	$CNT=mysql_num_rows($SQL);
	if($CNT==1){
		$R=mysql_fetch_object($SQL);
		$_SESSION["AUTH"]=1;
		$_SESSION['repid'] = $R->id;
		$_SESSION['id'] = $R->id;	
		$_SESSION['m_id16'] = $R->mark_id;			
		$_SESSION['u_id16']= $R->rep_id;
		$Leave=mysql_query("SELECT * FROM repgivenasleave WHERE repid='".$R->id."' and leaveapplieddate='".date("Y-m-d")."'");
		$LCNT=mysql_num_rows($Leave);
		if($LCNT==0){echo "Working Status";}if($LCNT>0){echo "Success";}
	}
	if($CNT==0)
	{
		echo "Check your UserName & Password??? Enter Correct Login Details";
	}	
}
if($_GET["checkpoint"]==2){
	$SQL=mysql_query("SELECT * FROM managers WHERE manager_id = '".$_GET["u_name"]."' AND manager_password = '".$_GET["password"]."' "); 
	$CNT=mysql_num_rows($SQL);
	if($CNT==1){
		$R=mysql_fetch_object($SQL);
		$_SESSION["AUTH"]=2;
		$_SESSION['id'] = $R->id;	
		$_SESSION['m_id16'] = $R->mark_id;			
		$_SESSION['u_id16']= $R->manager_id;
		echo "Success";
	}
	if($CNT==0)
	{
		echo "Check your UserName & Password??? Enter Correct Login Details";
	}	
}
if($_GET["checkpoint"]==3){
	$SQL=mysql_query("SELECT * FROM marketer WHERE mark_uid = '".$_GET["u_name"]."' AND mark_pwd = '".$_GET["password"]."' "); 
	$CNT=mysql_num_rows($SQL);
	if($CNT==1){
		$R=mysql_fetch_object($SQL);
		$_SESSION["AUTH"]=3;
		$_SESSION['id'] = $R->id;
		$_SESSION['repid'] ="";	
		$_SESSION['m_id16'] = $R->mark_id;			
		$_SESSION['u_id16']= $R->mark_abb;
		echo "Success";
	}
	if($CNT==0)
	{
		echo "Check your UserName & Password??? Enter Correct Login Details";
	}	
}	
?>
