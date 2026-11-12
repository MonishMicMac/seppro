<?php
mysql_connect("localhost","root","$3pp60@2016");mysql_select_db("adsouq_masterblaster");
$COMPANY=mysql_query("SELECT seppro_host,seppro_companyname,seppro_dbuser,seppro_dbname,seppro_dbpwd,seppro_app_status FROM mst_seppro WHERE seppro_app_status='1'  ORDER BY seppro_id DESC ");
while($COMP_CNT=mysql_num_rows($COMPANY)){
	$C=mysql_fetch_object($COMPANY);
		$_SESSION["HOST"]=$C->seppro_host;$_SESSION["CNAME"]=$C->seppro_companyname;$_SESSION["DBUSR"]=$C->seppro_dbuser;$_SESSION["DBNAME"]=$C->seppro_dbname;$_SESSION["DBPWD"]=$C->seppro_dbpwd;$_SESSION["appatatus"]=$C->seppro_app_status;$flag=1;
		if(@$flag==1){
			define ("DB_HOST", $_SESSION["HOST"]); // set database host
		define ("DB_USER", $_SESSION["DBUSR"]); // set database user
		define ("DB_PASS",$_SESSION["DBPWD"]); // set database password
		define ("DB_NAME",$_SESSION["DBNAME"]); // set database name
		echo $_SESSION["HOST"];
		echo $_SESSION["DBUSR"];
		echo $_SESSION["DBPWD"];
		echo $_SESSION["DBNAME"];
		
		$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
		$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
		echo $_SESSION["appatatus"];
		if($_SESSION["appatatus"]=='0')
		{	
			echo "hello";
		$SQL=mysql_query("SELECT rep_name FROM tbl_work_plan,representative WHERE representative.id=tbl_work_plan.wp_rep_id AND tbl_work_plan.reporteddate LIKE '%".date('Y-m-')."%' GROUP BY tbl_work_plan.wp_rep_id");
		echo $CNT=mysql_num_rows($SQL);
		
		// if($CNT==1){
		// 	while($R=mysql_fetch_object($SQL))
		// 	{
		// 	echo $R->rep_name;
		// 	echo $_SESSION["CNAME"];
		// 	exit();
		// }

		// }
		}
		elseif($_SESSION["appatatus"]=='1')
		{
			echo "hi"; 
			
		$SQL=mysql_query("SELECT rep_name FROM reorting, representative WHERE representative.id = reorting.repid AND reorting.reporteddate LIKE  '%2017-08-%' GROUP BY reorting.repid");
		echo $CNT=mysql_num_rows($SQL);
		}
		// exit();

	}
}
?>