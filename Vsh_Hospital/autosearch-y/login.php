<?php
session_start();

if(isset($_GET["company_name"])){

	mysql_connect("localhost","root","$3pp60@2016");mysql_select_db("adsouq_masterblaster");
	$COMPANY=mysql_query("SELECT * FROM mst_seppro WHERE seppro_companyid='".addslashes($_GET["company_name"])."'");
	$COMP_CNT=mysql_num_rows($COMPANY);
	if($COMP_CNT>0){$C=mysql_fetch_object($COMPANY);$_SESSION["HOST"]=$C->seppro_host;$_SESSION["CID"]=$C->seppro_companyid;$_SESSION["CNAME"]=$C->seppro_companyname;$_SESSION["DBUSR"]=$C->seppro_dbuser;$_SESSION["DBNAME"]=$C->seppro_dbname;$_SESSION["DBPWD"]=$C->seppro_dbpwd;$_SESSION["STATUS"]=$C->seppro_status;$_SESSION["LABEL"]=$C->session_label;$_SESSION["LABEL1"]=$C->session_label1;$_SESSION["TRACKING"]=$C->live_tracking;$flag=1;}
}else{$flag=0;}

if(@$flag==1){
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	
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
				echo "Failure";
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
				echo "Failure";
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
				echo "Failure";
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
				echo "Failure";
			}
		}
	}
	if(@$_GET["checkpoint"]==3){
		$SQL=mysql_query("SELECT * FROM marketer WHERE mark_uid = '".addslashes($_GET["u_name"])."' AND mark_pwd = '".addslashes($_GET["password"])."' "); 
		$CNT=mysql_num_rows($SQL);
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			if($C->seppro_companyid=='SEP1062')
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
			echo "Failure";
		}	
	}
	if(@$_GET["checkpoint"]==4){
		$SQL=mysql_query("SELECT * FROM doctors1 WHERE doctor_user_name = '".addslashes($_GET["u_name"])."' AND password = '".addslashes($_GET["password"])."' "); 
		$CNT=mysql_num_rows($SQL);
		if($CNT==1){
			$R=mysql_fetch_object($SQL);
			
			$_SESSION["AUTH"]=4;
			$_SESSION["user"]=$R->id;
			$_SESSION['id']=$R->id;
			$_SESSION['m_id16'] = '1';			
			$_SESSION['u_id16']= '1';
			$_SESSION['doc_cnt']=$d_num;
			$_SESSION['chem_cnt']=$c_num;
			echo "DIST Success";
		}
		if($CNT==0)
		{
			echo "Failure";
		}	
	}
}
?>
