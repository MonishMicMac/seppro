<?php
//Code using fopen



//Change your configurations here.
//---------------------------------
$username="micandmac";
$api_password="micandmac1";
$sender="MICMAC";
$domain="sms.dial4sms.com";
$priority="11";// 1-Normal,2-Priority,3-Marketing
$method="POST";

//---------------------------------

if(isset($_REQUEST['send']))
{

	$mobile=$_REQUEST['mobile'];

	$message=$_REQUEST['message'];

	$username=urlencode($username);
	$password=urlencode($password);
	$sender=urlencode($sender);
	$message=urlencode($message);
	
	$parameters="username=$username&password=$api_password&sender=$sender&to=$mobile&message=$message&priority=$priority";
	
	

	if($method=="POST")
	{
		$opts = array(
		  'http'=>array(
			'method'=>"$method",
			'content' => "$parameters",
			'header'=>"Accept-language: en\r\n" .
					  "Cookie: foo=bar\r\n"
		  )
		);

		$context = stream_context_create($opts);

echo "http://$domain/pushsms.php?$parameters";


		$fp = fopen("http://$domain/pushsms.php", "r", false, $context);
	}
	else
	{
		$fp = fopen("http://$domain/pushsms.php?$parameters", "r");
	}

	$response = stream_get_contents($fp);
	fpassthru($fp);
	fclose($fp);


	if($response=="")
	echo "Process Failed, Please check domain, username and password.";
	else
	echo "$response";

}


echo "<form name='f1' method='post'>";

echo "<p> Mobile: <input name='mobile' > </p>";

echo "<p> Message: <textarea name='message' ></textarea> </p>";

echo "<p> <input type='submit' value='Send' name='send'></p>";

echo "</form";

?>