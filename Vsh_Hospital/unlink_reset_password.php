<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link rel="stylesheet" href="css/style.css">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">
<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}
</style>
   </head>

 <body style="background-image:url('css/sales.jpg')">
		<!-- topbar starts -->
	
	<!-- topbar ends -->
  <?php
session_start();
error_reporting(0);
if(isset($_REQUEST['comp_id'])){
    //echo $_REQUEST['company_name']; exit;
	mysql_connect("localhost","root","$3pp60@2016");mysql_select_db("adsouq_masterblaster");
	$COMPANY=mysql_query("SELECT * FROM mst_seppro WHERE seppro_companyid='".addslashes($_REQUEST['comp_id'])."'");
	$COMP_CNT=mysql_num_rows($COMPANY);
	if($COMP_CNT>0){$C=mysql_fetch_object($COMPANY);$_SESSION["HOST"]=$C->seppro_host;$_SESSION["CID"]=$C->seppro_companyid;$_SESSION["CNAME"]=$C->seppro_companyname;$_SESSION["DBUSR"]=$C->seppro_dbuser;$_SESSION["DBNAME"]=$C->seppro_dbname;$_SESSION["DBPWD"]=$C->seppro_dbpwd;$_SESSION["STATUS"]=$C->seppro_status;$_SESSION["LABEL"]=$C->session_label;$_SESSION["LABEL1"]=$C->session_label1;$flag=1;}
}else{$flag=0;}

if(@$flag==1){
	include("autosearch-y/connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	
	
 if(isset($_REQUEST['submit'])){	
	
	if($_REQUEST['role']==1)
	{
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
		
	 
	 $update3 = mysql_query("UPDATE adsouq_masterblaster.sent_email_details SET update_reason='".$_REQUEST['reasons']."',update_ip='$ipaddress',update_date='".date('Y-m-d')."',update_time='".date('H:i:s')."' WHERE sid='".$_REQUEST['last_id']."'") or die(mysql_error());	
	
	 $update1 = mysql_query("UPDATE representative SET temp_password='',reset_date_time='' WHERE id='".$_REQUEST['aid']."'") or die(mysql_error());
		if(update1)
		{
		echo '<script language="javascript" type="text/javascript">alert("Your Reasons are Updated Sucessfully");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
		}	
	}
	
	
	if($_REQUEST['role']==2){
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
		
	 
	 $update2 = mysql_query("UPDATE adsouq_masterblaster.sent_email_details SET update_reason='".$_REQUEST['reasons']."',update_ip='$ipaddress',update_date='".date('Y-m-d')."',update_time='".date('H:i:s')."' WHERE sid='".$_REQUEST['last_id']."'") or die(mysql_error());	
	 
	 $update2 = mysql_query("UPDATE representative SET temp_password='',reset_date_time='' WHERE id='".$_REQUEST['aid']."'") or die(mysql_error());
	if($update2)
		{
		echo '<script language="javascript" type="text/javascript">alert("Your Reasons are Updated Sucessfully");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
		}	
	}
	
	
	if($_REQUEST['role']==3){
	
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
		
	 
	 $update3 = mysql_query("UPDATE adsouq_masterblaster.sent_email_details SET update_reason='".$_REQUEST['reasons']."',update_ip='$ipaddress',update_date='".date('Y-m-d')."',update_time='".date('H:i:s')."' WHERE sid='".$_REQUEST['last_id']."'") or die(mysql_error());	
	
	
	 $update3 = mysql_query("UPDATE marketer SET temp_password='',reset_date_time='' WHERE id='".$_REQUEST['aid']."'") or die(mysql_error());
	if($update3)
		{
		echo '<script language="javascript" type="text/javascript">alert("Your Reasons are Updated Sucessfully");location.href="index.php";</script>';
		}	
	  }	
	}
 ?>
              
 <body>
  <h1 class="register-title">Welcome to Sales Enchancement Planner</h1>
  <form class="register" name="Login" method="post" action="" onSubmit="return valid();"> 
  <div class="register-switch">
  <?php if($_REQUEST['role']==1){?>
      <input type="radio" name="sex" value="1" id="sex_r" class="register-switch-input" checked>
      <label for="sex_r" class="register-switch-label" style="width: 100%;">Representative</label>
      <?php } if($_REQUEST['role']==2){ ?>
      <input type="radio" name="sex" value="2" id="sex_m" class="register-switch-input" checked>
      <label for="sex_m" class="register-switch-label" style="width: 100%;">Manager</label>
      <?php } if($_REQUEST['role']==3){ ?>
      <input type="radio" name="sex" value="3" id="sex_a" class="register-switch-input" checked>
      <label for="sex_a" class="register-switch-label" style="width: 100%;">Admininstrator</label>
      <?php } ?>
    </div>
  <input class="input-xlarge focused" type="hidden" name="comp_id" id="comp_id" value="<?php echo $_REQUEST['comp_id'];?>">
  <input type="text" id="reasons" name="reasons" class="register-input" placeholder="Reasons" required>
    <input type="submit" name="submit" id="Submit" value="Submit" class="register-button">
  </form>

  <div class="about">   
    <p class="about-author">
      Powered By <a href="http://micandmac.in" target="_blank">mic&amp;Mac Solutions Pvt Ltd</a>
    </p>
  </div>
    
    <?php 
	} 
	?>
   </body>
  </html>

 