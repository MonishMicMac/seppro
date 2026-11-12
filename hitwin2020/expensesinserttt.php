<?php
include('connect.php');


$farename1=$_REQUEST['farename'];
$fareamount1=$_REQUEST['fareamount'];
$expenses2=$_REQUEST['expenses'];
$images=$_REQUEST['images'];


$farename= explode(",",$farename1);
$fareamount= explode(",",$fareamount1);
$expenses1= explode(",",$expenses2);

//$upload_file=$_FILES['upload_file'];
$filename=$images; 
//move_uploaded_file($upload_file['tmp_name'], 'expenses_images/'.$filename);
//echo $upload_file;
//echo $filename;



for($i=0;$i< count($fareamount);$i++)
{

mysql_query("INSERT INTO expenses(repid,farename,fareamount,remarks,images,reporteddate,reportedtime,claimed,approvedby)VALUES('".$_REQUEST['repid']."','$farename[$i]','$fareamount[$i]','$expenses1[$i]','".$filename."','".$_REQUEST['scheduleddate']."','".$_REQUEST['scheduledtime']."','0','0')")or die(mysql_error());
}


?>