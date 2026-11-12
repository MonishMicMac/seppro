<?php
include('connect1.php');


$farename1=$_REQUEST['farename'];
$fareamount1=$_REQUEST['fareamount'];
$expenses2=$_REQUEST['expenses'];


$farename= explode(",",$farename1);
$fareamount= explode(",",$fareamount1);
$expenses1= explode(",",$expenses2);

$img = $_REQUEST['imgg'];




for($i=0;$i< count($fareamount);$i++)
{
	$code = md5(time());  

	$name ='img'.$i.'_'.$code.'.jpg';

mysql_query("INSERT INTO expenses(repid,farename,fareamount,remarks,reporteddate,reportedtime,claimed,approvedby,img)VALUES('".$_REQUEST['repid']."','$farename[$i]','$fareamount[$i]','$expenses1[$i]','".$_REQUEST['scheduleddate']."','".$_REQUEST['scheduledtime']."','0','0','".$name."')")or die(mysql_error());

file_put_contents('uploads/'.$name, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img)));

}


?>