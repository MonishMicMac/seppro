<?php

require("class.phpmailer.php");
require("class.smtp.php");
$mail = new PHPMailer();
$subject="Reports";
$message="Reports";

$mail->PluginDir='./';
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPDebug = 1;
$mail->SMTPSecure = 'ssl';
$mail->Host = "smtp.gmail.com"; 
$mail->Port = 465; 
$mail->From = "harish10010@gmail.com";
$mail->FromName  =  "EXPORT"; 
$mail->Addaddress("harish10010@gmail.com");
$mail->SMTPAuth = true;
$mail->Username = "harish10010@gmail.com";
$mail->Password = "steve-rogers007";
$mail->Subject = $subject;
$mail->Body = $message;

// $path_and_file=str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__);

// $mail->AddAttachment($path_and_file);

$mail->WordWrap = 500;
$mail->IsHTML(true);
if($mail->Send()){
	echo "success";
} else {
	echo $mail->ErrorInfo();
}

?>