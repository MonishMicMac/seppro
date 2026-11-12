<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<!--<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">-->
<link rel="stylesheet" href="css/style.css">
<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}
</style>
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
   <script type="text/javascript">
function valid()
{
	var y=document.getElementById("n_pass").value;
	if(y=="null" || y=="")
	{
	alert("Please Enter New Password to set");
	return false; 
	}
	var z=document.getElementById("r_pass").value;
	if(z=="null" || z=="")
	{
	alert("Please Enter Confirmation Password");
	return false; 
	}
	
return true;
}
</script>
<script language="javascript">
function pswcheck()
{
var psw=document.getElementById("n_pass").value;
var rpsw=document.getElementById("r_pass").value;
if(psw!=rpsw)
{
alert("password Mismatch");
document.getElementById("n_pass").value="";
document.getElementById("r_pass").value="";
document.getElementById("n_pass").focus();
}
}
</script>

</head>

 <body>
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
	 $update1 = mysql_query("UPDATE representative SET rep_pwd='".$_REQUEST['n_pass']."',r_status='1',temp_password='' WHERE id='".$_REQUEST['aid']."'") or die(mysql_error());
		if(update1)
		{
		echo '<script language="javascript" type="text/javascript">alert("Your New Password Updated Sucessfully");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
		}	
	}
	
	
	if($_REQUEST['role']==2){
	 
	 $update2 = mysql_query("UPDATE representative SET rep_pwd='".$_REQUEST['n_pass']."',r_status='1',temp_password='' WHERE id='".$_REQUEST['aid']."'") or die(mysql_error());
	if($update2)
		{
		echo '<script language="javascript" type="text/javascript">alert("Your New Password Updated Sucessfully");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
		}	
	}
	
	
	if($_REQUEST['role']==3){
	 $update3 = mysql_query("UPDATE marketer SET mark_pwd='".$_REQUEST['n_pass']."',status='1',temp_password='' WHERE id='".$_REQUEST['aid']."'") or die(mysql_error());
	if($update3)
		{
		echo '<script language="javascript" type="text/javascript">alert("Your New Password Updated Sucessfully");location.href="index.php";</script>';
		}	
	  }	
	}
	
	
	$carry=0;
   if($_REQUEST['role']==1){
		$SQL=mysql_query("SELECT * FROM representative WHERE rep_id='0' AND id = '".$_REQUEST['aid']."' AND reset_date_time + INTERVAL 20 MINUTE > NOW() AND r_status!='1' AND temp_password='".$_REQUEST['temp_id']."'");
		$CNT=mysql_num_rows($SQL);
		if($CNT>1)
		{ 
	  $carry=1;
	  }
			
	}
	
	
	if($_REQUEST['role']==2){
		$SQL=mysql_query("SELECT * FROM representative WHERE rep_id>0 AND id = '".$_REQUEST['aid']."' AND reset_date_time + INTERVAL 20 MINUTE > NOW() AND r_status!='1' AND temp_password='".$_REQUEST['temp_id']."'");
		$CNT=mysql_num_rows($SQL);
		if($CNT>0)
		{
		$carry=1;
	    }
	
	}
	
	
	if($_REQUEST['role']==3){
		$SQL=mysql_query("SELECT * FROM marketer WHERE id = '".$_REQUEST['aid']."' AND reset_date_time + INTERVAL 20 MINUTE > NOW() AND status!='1' AND temp_password='".$_REQUEST['temp_id']."'"); 
		$CNT=mysql_num_rows($SQL);
	if($CNT>0)
		{
		$carry=1;
		}	
	
	  }		
    
 ?>
    
   <?php if($carry==1) { ?>  
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
   <input type="password" id="n_pass" name="n_pass" class="register-input" placeholder="New Password">
   <input type="password" id="r_pass" name="r_pass" class="register-input" placeholder="Confirm Password" onBlur="pswcheck();" >
   <input type="hidden" id="comp_id" name="comp_id" class="register-input" value="<?php echo $_REQUEST['comp_id'];?>">
    <input type="submit" name="submit" id="Submit" value="Submit" class="register-button">
  </form>

  <div class="about">   
    <p class="about-author">
      Powered By <a href="http://micandmac.in" target="_blank">mic&amp;Mac Solutions Pvt Ltd</a>
    </p>
  </div>
  
    
</body>      

   <?php 
			} 
			else 
			{ ?>
			<body style="background-image:url('css/sales.jpg'); background-size:1280px; 400px;">
             <h1 class="register-title" style="margin-left:60%;">Welcome to Sales Enchancement Planner</h1>
            
        <div class="about" style="margin-left:65%;margin-top:75%;">   
    <p class="about-author">
      Powered By <a href="http://micandmac.in" target="_blank">mic&amp;Mac Solutions Pvt Ltd</a>
    </p>
  </div>    
</body>      

            <?php 
			echo '<script language="javascript" type="text/javascript">setTimeout(function(){alert("Your Email Link will be Expired"); window.top.location.href="index.php"; }, 1000);</script>';
			/*echo'<script language="javascript">window.top.location.href="index.php";</script>';*/
			?>
 <?php 
	 } 
	
	} 
	
	?>
	</html>