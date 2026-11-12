<?php
session_start();
if (file_exists("../include/db_config.php")) {
    include_once("../include/db_config.php");
} elseif (file_exists("../../include/db_config.php")) {
    include_once("../../include/db_config.php");
}
$db_host_sfp = defined('DB_HOST') ? DB_HOST : (getenv('DB_HOST') ?: 'seppro_db');
$db_user_sfp = defined('DB_USER') ? DB_USER : (getenv('DB_USER') ?: 'root');
$db_pass_sfp = defined('DB_PASS') ? DB_PASS : (getenv('DB_PASS') ?: '$3pp60@2016');
$db_master_sfp = defined('DB_MASTER_NAME') ? DB_MASTER_NAME : (getenv('DB_MASTER_NAME') ?: 'adsouq_masterblaster');

if(isset($_GET["company_name"])){
	mysql_connect($db_host_sfp, $db_user_sfp, $db_pass_sfp);
	mysql_select_db($db_master_sfp);
	$COMPANY=mysql_query("SELECT * FROM mst_seppro WHERE seppro_companyid='".addslashes($_GET["company_name"])."'");
	$COMP_CNT=mysql_num_rows($COMPANY);
	if($COMP_CNT>0){
		$C=mysql_fetch_object($COMPANY);
		$_SESSION["HOST"]=$C->seppro_host;
		if(($_SESSION["HOST"]==="localhost"||empty($_SESSION["HOST"])) && $db_host_sfp!=="localhost"){
			$_SESSION["HOST"]=$db_host_sfp;
		}
		$_SESSION["CID"]=$C->seppro_companyid;
		$_SESSION["CNAME"]=$C->seppro_companyname;
		$_SESSION["DBUSR"]=$C->seppro_dbuser;
		$_SESSION["DBNAME"]=$C->seppro_dbname;
		$_SESSION["DBPWD"]=$C->seppro_dbpwd;
		$_SESSION["STATUS"]=$C->seppro_status;
		$_SESSION["LABEL"]=$C->session_label;
		$_SESSION["LABEL1"]=$C->session_label1;
		$_SESSION["TRACKING"]=$C->live_tracking;
		$flag=1;
	}
}else{$flag=0;}

if(@$flag==1){
	include("connect_db.php");
	
	$target_db = !empty($_SESSION["DBNAME"]) ? $_SESSION["DBNAME"] : DB_NAME;
	$target_host = !empty($_SESSION["HOST"]) ? $_SESSION["HOST"] : DB_HOST;
	if ($target_host === 'localhost' && defined('DB_HOST') && DB_HOST !== 'localhost') {
		$target_host = DB_HOST;
	}
	$target_user = !empty($_SESSION["DBUSR"]) ? $_SESSION["DBUSR"] : DB_USER;
	$target_pass = isset($_SESSION["DBPWD"]) ? $_SESSION["DBPWD"] : DB_PASS;

	$link = mysql_connect($target_host, $target_user, $target_pass) or die("Couldn't make connection.");
	$db = mysql_select_db($target_db, $link) or die("Couldn't select database: " . mysql_error());
	
	$d_sql=mysql_query("SELECT * FROM doctors");
	$d_num=mysql_num_rows($d_sql);
	$c_sql=mysql_query("SELECT * FROM tbl_customer_master");
	$c_num=mysql_num_rows($c_sql);

	if(@$_GET["checkpoint"]==1){
		if($_SESSION["CID"]=='SEP1053')
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE email = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);
				$_SESSION["AUTH"]=3;
				$_SESSION["user"]=$R->user_group_id;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->mark_id;			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "Rep Success";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}	
		}
		elseif($_SESSION["CID"]=='SEP1069')
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE rep_user = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);
				$_SESSION["AUTH"]=1;
				$_SESSION["user"]=$R->user_group_id;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->mark_id;			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "Rep Success";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}	
		}
		elseif($_SESSION["CID"]=='SEP1080')
		{
			// print_r($_GET);exit();

			$SQL=mysql_query("SELECT * FROM nurse_details WHERE username = '".addslashes($_GET["u_name"])."' AND password = '".addslashes($_GET["password"])."' ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){

				$R=mysql_fetch_object($SQL);
				// print_r($R);exit();

				$_SESSION["AUTH"]=3;
				$_SESSION["user"]=$R->user_group_id;
				$_SESSION['id'] =$R->id;	
				$_SESSION['m_id16'] = $R->nurse_status;
				$_SESSION['nurse_status'] = $R->nurse_status;
				$_SESSION['nurse_login'] = '1';			
			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "Rep login Success";
				
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}	
		}
		else
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE rep_name = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);
				$_SESSION["AUTH"]=1;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->mark_id;			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "Rep Success";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}	
		}


	}
	if(@$_GET["checkpoint"]==2){
		if($_SESSION["CID"]=='SEP1053')
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE email = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' AND rep_id>0 ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);
				$_SESSION["AUTH"]=3;
				$_SESSION["user"]=$R->user_group_id;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->mark_id;			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "MGR Success";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}
		}
		elseif($_SESSION["CID"]=='SEP1069')
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE rep_user = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);
				$_SESSION["AUTH"]=1;
				$_SESSION["user"]=$R->user_group_id;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->mark_id;			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "Rep Success";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}	
		}
		elseif($_SESSION["CID"]=='SEP1090')
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE rep_name = '".addslashes($_GET["u_name"])."' AND rep_imeino = '".addslashes($_GET["password"])."' ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);

			// print_r($R);exit();


				$_SESSION["AUTH"]=1;
				// $_SESSION["user"]=$R->user_group_id;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->rep_name;			
				$_SESSION['u_id16']= $R->rep_imeino;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "Rep Successeeee";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}	
		}

		else
		{
			$SQL=mysql_query("SELECT * FROM representative WHERE rep_name = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' AND rep_id>0 ");
			$CNT=mysql_num_rows($SQL);
			if($CNT==1){
				$R=mysql_fetch_object($SQL);
				$_SESSION["AUTH"]=2;
				$_SESSION['id'] = $R->id;	
				$_SESSION['m_id16'] = $R->mark_id;			
				$_SESSION['u_id16']= $R->rep_id;
				$_SESSION['doc_cnt']= $d_num;
				$_SESSION['chem_cnt']= $c_num;
				echo "MGR Success";
			}
			if($CNT==0)
			{
				echo "Check your UserName & Password??? Enter Correct Login Details";
			}
		}
		// $SQL=mysql_query("SELECT * FROM representative WHERE rep_name = '".addslashes($_GET["u_name"])."' AND rep_pwd = '".addslashes($_GET["password"])."' AND rep_id>0 "); 

	}
	if(@$_GET["checkpoint"]==3){
		$SQL=mysql_query("SELECT * FROM marketer WHERE mark_uid = '".addslashes($_GET["u_name"])."' AND mark_pwd = '".addslashes($_GET["password"])."' "); 
		$CNT=mysql_num_rows($SQL);
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			// $_SESSION["AUTH"]=3;
			if($C->seppro_companyid=='SEP1062' || $C->seppro_companyid=='SEP1071')
			{
				$_SESSION["AUTH"]=$R->userrole;
			}
			else
			{
				$_SESSION["AUTH"]=3;
			}
			$_SESSION["user"]=0;
			$_SESSION['id'] = $R->id;	
			$_SESSION["state_id"]=$R->state_id;
			$_SESSION["division_id"]=$R->division_id;
			$_SESSION['m_id16'] = $R->mark_id;			
			$_SESSION['u_id16']= $R->mark_abb;
			$_SESSION['doc_cnt']= $d_num;
			$_SESSION['chem_cnt']= $c_num;
			echo "Success";
		}
		if($CNT==0)
		{
			echo "Check your UserName & Password??? Enter Correct Login Details";
		}	
	}		
}
?>
