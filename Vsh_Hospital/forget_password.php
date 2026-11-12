<?php
session_start();
error_reporting(0);
if(isset($_REQUEST['submit'])){
if(isset($_REQUEST['company_name'])){
    //echo $_REQUEST['company_name']; exit;
	mysql_connect("localhost","root","$3pp60@2016");mysql_select_db("adsouq_masterblaster");
	$COMPANY=mysql_query("SELECT * FROM mst_seppro WHERE seppro_companyid='".addslashes($_REQUEST['company_name'])."'");
	$COMP_CNT=mysql_num_rows($COMPANY);
	if($COMP_CNT>0){$C=mysql_fetch_object($COMPANY);$_SESSION["HOST"]=$C->seppro_host;$_SESSION["CID"]=$C->seppro_companyid;$_SESSION["CNAME"]=$C->seppro_companyname;$_SESSION["DBUSR"]=$C->seppro_dbuser;$_SESSION["DBNAME"]=$C->seppro_dbname;$_SESSION["DBPWD"]=$C->seppro_dbpwd;$_SESSION["STATUS"]=$C->seppro_status;$_SESSION["LABEL"]=$C->session_label;$_SESSION["LABEL1"]=$C->session_label1;$flag=1;}
}else{$flag=0;}

if(@$flag==1){
	include("autosearch-y/connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	
	$d_sql=mysql_query("SELECT * FROM doctors");
	$d_num=mysql_num_rows($d_sql);
	$c_sql=mysql_query("SELECT * FROM tbl_customer_master");
	$c_num=mysql_num_rows($c_sql);
	
	if($_REQUEST['info_id']==1){
		$SQL=mysql_query("SELECT * FROM representative WHERE rep_id='0' AND email = '".$_REQUEST['emailid']."'");
		$row=mysql_fetch_array($SQL);
		$representativeid=$row['id'];  
		$email=$row['email'];
		//echo $email;
		$CNT=mysql_num_rows($SQL);
		if($CNT==1)
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

	$insert1 = mysql_query("INSERT INTO adsouq_masterblaster.sent_email_details(company_id,email_id,ip_address,date,time,role)VALUES('".$_SESSION["CID"]."','$email','$ipaddress','".date('Y-m-d')."','".date('H:i:s')."','".$_REQUEST['info_id']."')")or die(mysql_error());
	$last_id =mysql_insert_id();
	function GeraHash($qtd){ 
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
        $Caracteres = '1234567890'; 
        $QuantidadeCaracteres = strlen($Caracteres); 
        $QuantidadeCaracteres--; 
        $Hash=NULL; 
        for($x=1;$x<=$qtd;$x++){ 
        $Posicao = rand(0,$QuantidadeCaracteres); 
        $Hash .= substr($Caracteres,$Posicao,1); 
        } 
      return $Hash; 
      } 
//Here you specify how many characters the returning string must have 
     $randon_number=GeraHash(5); 
     $date = date_create();
     $ran_id=date_timestamp_get($date)+$randon_number;
	 $random_id=$ran_id;
	 
	 $update1 = mysql_query("UPDATE representative SET temp_password='$random_id',reset_date_time=NOW() WHERE id='$representativeid'") or die(mysql_error());
	if($update1)
	 {
	 
	 require("class.phpmailer.php");
    require("class.smtp.php");

   $mail = new PHPMailer();
       
   $subj="Reset Password";

  $message.="Click here to change password,"."<br>"."<br>";
    
  $message.="http://www.seppro.net/brinton-v2/reset_password.php?temp_id=".$random_id."&comp_id=".$_SESSION["CID"]."&aid=".$representativeid."&email=".$email."&role=".$_REQUEST['info_id']."&last_id=".$last_id."<br>"."<br>";
  
  $message.="If you are not requested to change password, Click here,"."<br>"."<br>";
  $message.="http://www.seppro.net/brinton-v2/unlink_reset_password.php?temp_id=".$random_id."&comp_id=".$_SESSION["CID"]."&aid=".$representativeid."&email=".$email."&role=".$_REQUEST['info_id']."&last_id=".$last_id;
  
       $mail->PluginDir='./';
       $mail->IsSMTP();
       $mail->Mailer = "smtp";
	   $mail->SMTPDebug = 1;
	   $mail->SMTPSecure = 'ssl';
//     $mail->Host = "localhost";

       $mail->Host = "smtp.gmail.com"; 
       
//    $mail->Host = "email.metropolisindia.com"; 
       $mail->Port = 465; 
       
//       $mail->From = "it.support@metropolisindia.com";
	   $mail->From = "micandmacsolutions@gmail.com";
	   
       $mail->FromName  =  "Reset Password";
       
       $mail->AddAddress($email);
       
       $mail->SMTPAuth = true;
       
       $mail->Username = "micandmacsolutions@gmail.com";
       
       $mail->Password = "Y@v@nik@";
       
       $mail->Subject = $subj;
       $mail->Body = $message;
       
       $mail->WordWrap = 500;
       $mail->IsHTML(true);
       if(!$mail->Send())
       {
	     echo '<script language="javascript" type="text/javascript">alert("Email was not Send Sucessfully");</script>';
		 echo'<script language="javascript">window.top.location.href="index.php";</script>';
              
       }
       else
       {
	    echo '<script language="javascript" type="text/javascript">alert("Forget Password Request Sent to Your Email. If you dont see this email in your inbox within 20 minutes, otherwise your password will be expired.");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
       }
	  /* echo"<script>window.top.location.href='mail.php?temp_id=$random_id&comp_id=".$_SESSION["CID"]."&aid=$representativeid&email=$email&role=".$_REQUEST['info_id']."&last_id=$last_id';</script>";*/
  }
	}
		
		if($CNT==0)
		{
		echo '<script language="javascript" type="text/javascript">alert("Invalid Email Id??? OR Contact us 9841700038");</script>';
		}	
	}
	
	
	
	
	
	if($_REQUEST['info_id']==2){
		$SQL=mysql_query("SELECT * FROM representative WHERE email = '".$_REQUEST['emailid']."' AND rep_id>0 ");
		$row=mysql_fetch_array($SQL);
		$managerid=$row['id']; 
		$email=$row['email'];
		$CNT=mysql_num_rows($SQL);
		if($CNT==1){
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

	$insert2 = mysql_query("INSERT INTO adsouq_masterblaster.sent_email_details(company_id,email_id,ip_address,date,time,role)VALUES('".$_SESSION["CID"]."','$email','$ipaddress','".date('Y-m-d')."','".date('H:i:s')."','".$_REQUEST['info_id']."')")or die(mysql_error());
	$last_id =mysql_insert_id();	
		function GeraHash($qtd){ 
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
        $Caracteres = '1234567890'; 
        $QuantidadeCaracteres = strlen($Caracteres); 
        $QuantidadeCaracteres--; 
        $Hash=NULL; 
        for($x=1;$x<=$qtd;$x++){ 
        $Posicao = rand(0,$QuantidadeCaracteres); 
        $Hash .= substr($Caracteres,$Posicao,1); 
        } 
      return $Hash; 
      } 
//Here you specify how many characters the returning string must have 
     $randon_number=GeraHash(5); 
     $date = date_create();
     $ran_id=date_timestamp_get($date)+$randon_number;
	 $random_id=$ran_id;
	 
	 $update2 = mysql_query("UPDATE representative SET temp_password='$random_id',reset_date_time=NOW() WHERE id='$managerid'") or die(mysql_error());
	if($update2)
	 {
	require("class.phpmailer.php");
    require("class.smtp.php");

   $mail = new PHPMailer();
       
   $subj="Reset Password";

  $message.="Click here to change password,"."<br>"."<br>";
    
  $message.="http://www.seppro.net/brinton-v2/reset_password.php?temp_id=".$random_id."&comp_id=".$_SESSION["CID"]."&aid=".$managerid."&email=".$email."&role=".$_REQUEST['info_id']."&last_id=".$last_id."<br>"."<br>";
  
  $message.="If you are not requested to change password, Click here,"."<br>"."<br>";
  $message.="http://www.seppro.net/brinton-v2/unlink_reset_password.php?temp_id=".$random_id."&comp_id=".$_SESSION["CID"]."&aid=".$managerid."&email=".$email."&role=".$_REQUEST['info_id']."&last_id=".$last_id;
  
       $mail->PluginDir='./';
       $mail->IsSMTP();
       $mail->Mailer = "smtp";
	   $mail->SMTPDebug = 1;
	   $mail->SMTPSecure = 'ssl';
//     $mail->Host = "localhost";

       $mail->Host = "smtp.gmail.com"; 
       
//    $mail->Host = "email.metropolisindia.com"; 
       $mail->Port = 465; 
       
//       $mail->From = "it.support@metropolisindia.com";
	   $mail->From = "micandmacsolutions@gmail.com";
	   
       $mail->FromName  =  "Reset Password";
       
       $mail->AddAddress($email);
       
       $mail->SMTPAuth = true;
       
       $mail->Username = "micandmacsolutions@gmail.com";
       
       $mail->Password = "Y@v@nik@";
       
       $mail->Subject = $subj;
       $mail->Body = $message;
       
       $mail->WordWrap = 500;
       $mail->IsHTML(true);
       if(!$mail->Send())
       {
	     echo '<script language="javascript" type="text/javascript">alert("Email was not Send Sucessfully");</script>';
		 echo'<script language="javascript">window.top.location.href="index.php";</script>';
              
       }
       else
       {
	    echo '<script language="javascript" type="text/javascript">alert("Forget Password Request Sent to Your Email. If you dont see this email in your inbox within 20 minutes, otherwise your password will be expired.");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
       }
	 
	 
	 /* echo"<script>window.top.location.href='mail.php?temp_id=$random_id&comp_id=".$_SESSION["CID"]."&aid=$managerid&email=$email&role=".$_REQUEST['info_id']."&last_id=$last_id';</script>";*/
	}
	
	}
	
	if($CNT==0)
		{
		 echo '<script language="javascript" type="text/javascript">alert("Invalid Email Id??? OR Contact us 9841700038");</script>';
		}	
	}
	
	
	
	
	if($_REQUEST['info_id']==3){
		$SQL=mysql_query("SELECT * FROM marketer WHERE email = '".$_REQUEST['emailid']."'"); 
		$row=mysql_fetch_array($SQL);
		$adminid=$row['id'];
		$email=$row['email'];
		$CNT=mysql_num_rows($SQL);
		if($CNT==1){
		
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

	$insert3 = mysql_query("INSERT INTO adsouq_masterblaster.sent_email_details(company_id,email_id,ip_address,date,time,role)VALUES('".$_SESSION["CID"]."','$email','$ipaddress','".date('Y-m-d')."','".date('H:i:s')."','".$_REQUEST['info_id']."')")or die(mysql_error());
	$last_id =mysql_insert_id();	
	function GeraHash($qtd){ 
//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
        $Caracteres = '1234567890'; 
        $QuantidadeCaracteres = strlen($Caracteres); 
        $QuantidadeCaracteres--; 
        $Hash=NULL; 
        for($x=1;$x<=$qtd;$x++){ 
        $Posicao = rand(0,$QuantidadeCaracteres); 
        $Hash .= substr($Caracteres,$Posicao,1); 
        } 
      return $Hash; 
      } 
//Here you specify how many characters the returning string must have 
     $randon_number=GeraHash(5); 
     $date = date_create();
     $ran_id=date_timestamp_get($date)+$randon_number;
	 $random_id=$ran_id;
	 $update3 = mysql_query("UPDATE marketer SET temp_password='$random_id',reset_date_time=NOW() WHERE id='$adminid'") or die(mysql_error());
	if($update3)
	 {
    require("class.phpmailer.php");
    require("class.smtp.php");

   $mail = new PHPMailer();
          
   $subj="Reset Password";

  $message.="Click here to change password,"."<br>"."<br>";
    
  $message.="http://www.seppro.net/brinton-v2/reset_password.php?temp_id=".$random_id."&comp_id=".$_SESSION["CID"]."&aid=".$adminid."&email=".$email."&role=".$_REQUEST['info_id']."&last_id=".$last_id."<br>"."<br>";
  
  $message.="If you are not requested to change password, Click here,"."<br>"."<br>";
  $message.="http://www.seppro.net/brinton-v2/unlink_reset_password.php?temp_id=".$random_id."&comp_id=".$_SESSION["CID"]."&aid=".$adminid."&email=".$email."&role=".$_REQUEST['info_id']."&last_id=".$last_id;
  
       $mail->PluginDir='./';
       $mail->IsSMTP();
       $mail->Mailer = "smtp";
	   $mail->SMTPDebug = 1;
	   $mail->SMTPSecure = 'ssl';
//     $mail->Host = "localhost";

       $mail->Host = "smtp.gmail.com"; 
       
//    $mail->Host = "email.metropolisindia.com"; 
       $mail->Port = 465; 
       
//       $mail->From = "it.support@metropolisindia.com";
	   $mail->From = "micandmacsolutions@gmail.com";
	   
       $mail->FromName  =  "Reset Password";
       
       $mail->AddAddress($email);
       
       $mail->SMTPAuth = true;
       
       $mail->Username = "micandmacsolutions@gmail.com";
       
       $mail->Password = "Y@v@nik@";
       
       $mail->Subject = $subj;
       $mail->Body = $message;
       
       $mail->WordWrap = 500;
       $mail->IsHTML(true);
       if(!$mail->Send())
       {
	     echo '<script language="javascript" type="text/javascript">alert("Email was not Send Sucessfully");</script>';
		 echo'<script language="javascript">window.top.location.href="index.php";</script>';
             
       }
       else
       {
	    echo '<script language="javascript" type="text/javascript">alert("Forget Password Request Sent to Your Email. If you dont see this email in your inbox within 20 minutes, otherwise your password will be expired.");</script>';
		echo'<script language="javascript">window.top.location.href="index.php";</script>';
       }
	}
	}
	
	if($CNT==0)
		{
		echo '<script language="javascript" type="text/javascript">alert("Invalid Email Id??? OR Contact us 9841700038");</script>';
		}	
	  }	
	
	
	}
     }
  ?>

<!DOCTYPE html> 
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Welcome to Sales Enchancement Planner</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <h1 class="register-title">Welcome to Sales Enchancement Planner</h1>
  <form class="register" name="Login" method="post" action=""> 
  <div class="register-switch">
  <?php if($_REQUEST['info_id']==1){?>
      <input type="radio" name="sex" value="1" id="sex_r" class="register-switch-input" checked>
      <label for="sex_r" class="register-switch-label" style="width: 100%;">Representative</label>
      <?php } if($_REQUEST['info_id']==2){ ?>
      <input type="radio" name="sex" value="2" id="sex_m" class="register-switch-input" checked>
      <label for="sex_m" class="register-switch-label" style="width: 100%;">Manager</label>
      <?php } if($_REQUEST['info_id']==3){ ?>
      <input type="radio" name="sex" value="3" id="sex_a" class="register-switch-input" checked>
      <label for="sex_a" class="register-switch-label" style="width: 100%;">Admininstrator</label>
      <?php } ?>
    </div>
   <input type="text" id="company_name" name="company_name" class="register-input" placeholder="Company Id" required>
   <input type="email" id="emailid" name="emailid" class="register-input" placeholder="Email Id" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
    <input type="submit" name="submit" id="Submit" value="Submit" class="register-button"><a href="index.php" style="color:#2672f0;">Login</a>
  </form>

  <div class="about">   
    <p class="about-author">
      Powered By <a href="http://micandmac.in" target="_blank">mic&amp;Mac Solutions Pvt Ltd</a>
    </p>
  </div>
    
</body>
</html>
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>







