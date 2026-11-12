<?php
include("connectpon2.php");



$stud_name=$_REQUEST['stud_name'];
$stud_std=$_REQUEST['stud_std'];
$stud_sec=$_REQUEST['stud_sec'];
$stud_mobile=$_REQUEST['stud_mobile'];

$stud_email_id = $_REQUEST['stud_email_id'];
$stud_status=$_REQUEST['stud_status'];

$av=mysql_query("select temp_email_id from `temp_student_profile` where temp_email_id='$stud_email_id'")or die(mysql_error());
if(mysql_num_rows($av)==1) {

	$stud_random = sprintf("%06d", mt_rand(1, 999999));
	$a=mysql_query("UPDATE `temp_student_profile` SET `temp_status`='$stud_status',temp_stud_rand='$stud_random' WHERE `temp_email_id`= '$stud_email_id'")or die(mysql_error());


	require("class.phpmailer.php");
	require("class.smtp.php");

       $mail = new PHPMailer();
       $email=$_REQUEST['stud_email_id'];
       $subj="Test Mail";
       $message="Your OTP Password is :".$stud_random;
       $mail->PluginDir='./';
       $mail->IsSMTP();
       $mail->Mailer = "smtp";
	   $mail->SMTPDebug = 1;
	   $mail->SMTPSecure = 'ssl';
       $mail->Host = "smtp.gmail.com"; 
       $mail->Port = 465; 
	$mail->From = "micandmacsolutions@gmail.com";
       $mail->FromName  =  "micandmacsolutions";
       $mail->AddAddress($email);
       $mail->SMTPAuth = true;
       $mail->Username = "raguvaran2404@gmail.com";
       $mail->Password = "9789829350";
       $mail->Subject = $subj;
       $mail->Body = $message;
       $mail->WordWrap = 500;
       $mail->IsHTML(true);
       if(!$mail->Send())
       {
               
               echo 'failed';
       }
       else
       {
	
               echo 'Email';
       }
}
else
{
echo 'ff';
}

?>
