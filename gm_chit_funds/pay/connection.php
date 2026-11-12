<?php
//$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//echo $hostname;
//echo nslookup($_SERVER['REMOTE_ADDR']);
/*$ip = $_SERVER['REMOTE_ADDR'];
    $fullhost = gethostbyaddr($ip);
    $host = preg_replace("/^[^.]+./", "*.", $fullhost);
echo $host; */
  //echo $_SERVER["HTTP_HOST"];  //.$_SERVER['REQUEST_URI']);


			$filename="HostName.ini";
			$handle=fopen($filename,'r');
			$contents = fread($handle, filesize($filename));
			//echo $contents;
			$pos1=strpos($contents , ",");
			//echo $pos1;
			$length=strlen($contents);
			$ip=strtok ($contents , ",");

			$contents=substr($contents,$pos1+1,$length);
			$length=strlen($contents);
			//echo "ip".$ip;
			$db=strtok ($contents , ",");
			$pos1=strpos($contents , ",");
			$contents=substr($contents,$pos1+1,$length);
			$length=strlen($contents);
			//echo "db".$db;
			$username=strtok ($contents , ",");
			$pos1=strpos($contents , ",");
			$contents=substr($contents,$pos1+1,$length);
			$length=strlen($contents);
			//echo "uname".$username;
			$pswd=strtok ($contents , ",");
			$pos1=strpos($contents , ",");
			$contents=substr($contents,$pos1+1,$length);
			$length=strlen($contents);
			$pswd	=trim($pswd);
			//echo"pswd".$pswd;
			$port=strtok ($contents , ",");
			$pos1=strpos($contents , ",");
			$contents=substr($contents,$pos1+1,$length);
			$length=strlen($contents);
			$port	=trim($port);
			//echo"PORT".$port;
define("HOST", $ip);
define("USERNAME", $username);
define("PASSWORD", $pswd);
/*define("HOST", "localhost");
define("USERNAME", "root");
define("PASSWORD", "root");
*/
define("DB", $db); 
define("PORT", $port); 

$con = mysqli_connect(HOST,USERNAME,PASSWORD,DB,PORT);
if(!$con)
{
		echo "connectin closed". mysql_error();
}

mysqli_select_db($con,DB);
?>